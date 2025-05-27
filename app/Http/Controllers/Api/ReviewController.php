<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TransaksiController;
use App\Models\Pesanan;
use App\Models\Review;
use App\Models\Transaksi;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Submit a new review for an order
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'kode_transaksi' => 'required|string|exists:pesanan,kode_transaksi',
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();
            $kodeTransaksi = $request->kode_transaksi;

            // Find transaction by kode_transaksi and check ownership
            $transaksi = Pesanan::where('kode_transaksi', $kodeTransaksi)
                ->where('id_user', $user->id)
                ->where('status', 'selesai') // Only allow reviews for completed orders
                ->first();

            if (!$transaksi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi tidak ditemukan atau belum selesai'
                ], 404);
            }

            // Check if user already reviewed this order using transaksi_id
            $existingReview = Review::where('user_id', $user->id)
                ->where('transaksi_id', $transaksi->id)
                ->first();

            if ($existingReview) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah memberikan ulasan untuk pesanan ini'
                ], 409);
            }

            // Create the review
            $review = Review::create([
                'user_id' => $user->id,
                'toko_id' => $transaksi->id_toko,
                'transaksi_id' => $transaksi->id, // Menggunakan ID transaksi
                'kode_transaksi' => $kodeTransaksi, // Menyimpan kode untuk referensi
                'rating' => $request->rating,
                'review' => $request->review,
            ]);

            // Load relationships for response
            $review->load(['user:id,name', 'toko:id,nama']);

            return response()->json([
                'success' => true,
                'message' => 'Ulasan berhasil dikirim',
                'data' => [
                    'review' => $review,
                    'toko_stats' => [
                        'average_rating' => round(Review::getAverageRating($transaksi->id_toko), 1),
                        'total_reviews' => Review::getTotalReviews($transaksi->id_toko)
                    ]
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan ulasan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get reviews for a specific toko
     */
    public function getTokoReviews($tokoId, Request $request)
    {
        try {
            $validator = Validator::make(['toko_id' => $tokoId], [
                'toko_id' => 'required|exists:tokos,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Toko tidak ditemukan'
                ], 404);
            }

            $perPage = $request->get('per_page', 10);
            $rating = $request->get('rating'); // Filter by specific rating

            $query = Review::with(['user:id,name', 'transaksi:id,kode_transaksi'])
                ->where('toko_id', $tokoId)
                ->orderBy('created_at', 'desc');

            if ($rating) {
                $query->where('rating', $rating);
            }

            $reviews = $query->paginate($perPage);

            // Get toko statistics
            $stats = [
                'average_rating' => round(Review::getAverageRating($tokoId), 1),
                'total_reviews' => Review::getTotalReviews($tokoId),
                'rating_distribution' => Review::getRatingDistribution($tokoId)
            ];

            return response()->json([
                'success' => true,
                'message' => 'Reviews retrieved successfully',
                'data' => [
                    'reviews' => $reviews,
                    'stats' => $stats
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil ulasan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get review for a specific transaction by kode_transaksi
     */
    public function getTransactionReview($kodeTransaksi)
    {
        try {
            $user = Auth::user();

            // Find transaksi first
            $transaksi = Pesanan::where('kode_transaksi', $kodeTransaksi)
                ->where('user_id', $user->id)
                ->first();

            if (!$transaksi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi tidak ditemukan'
                ], 404);
            }

            $review = Review::with(['user:id,name', 'toko:id,nama'])
                ->where('transaksi_id', $transaksi->id)
                ->where('user_id', $user->id)
                ->first();

            if (!$review) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ulasan tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Review retrieved successfully',
                'data' => $review
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil ulasan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update an existing review
     */
    public function update(Request $request, $reviewId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();

            $review = Review::where('id', $reviewId)
                ->where('user_id', $user->id)
                ->first();

            if (!$review) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ulasan tidak ditemukan atau bukan milik Anda'
                ], 404);
            }

            $review->update([
                'rating' => $request->rating,
                'review' => $request->review,
            ]);

            $review->load(['user:id,name', 'toko:id,nama']);

            return response()->json([
                'success' => true,
                'message' => 'Ulasan berhasil diperbarui',
                'data' => $review
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui ulasan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a review
     */
    public function destroy($reviewId)
    {
        try {
            $user = Auth::user();

            $review = Review::where('id', $reviewId)
                ->where('user_id', $user->id)
                ->first();

            if (!$review) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ulasan tidak ditemukan atau bukan milik Anda'
                ], 404);
            }

            $review->delete();

            return response()->json([
                'success' => true,
                'message' => 'Ulasan berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus ulasan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if user can review a transaction
     */
    public function canReview($kodeTransaksi)
    {
        try {
            $user = Auth::user();

            // Find transaction by kode_transaksi
            $transaksi = Pesanan::where('kode_transaksi', $kodeTransaksi)
                ->where('id_user', $user->id)
                ->where('status', 'selesai')
                ->first();

            if (!$transaksi) {
                return response()->json([
                    'success' => false,
                    'can_review' => false,
                    'message' => 'Transaksi tidak ditemukan atau belum selesai'
                ]);
            }

            // Check if already reviewed using transaksi_id
            $existingReview = Review::where('user_id', $user->id)
                ->where('transaksi_id', $transaksi->id)
                ->first();

            return response()->json([
                'success' => true,
                'can_review' => !$existingReview,
                'has_review' => !!$existingReview,
                'transaksi_id' => $transaksi->id,
                'message' => $existingReview ? 'Sudah memberikan ulasan' : 'Dapat memberikan ulasan'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's reviews (all reviews made by authenticated user)
     */
    public function getUserReviews(Request $request)
    {
        try {
            $user = Auth::user();
            $perPage = $request->get('per_page', 10);

            $reviews = Review::with(['toko:id,nama', 'transaksi:id,kode_transaksi'])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'User reviews retrieved successfully',
                'data' => $reviews
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil ulasan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}