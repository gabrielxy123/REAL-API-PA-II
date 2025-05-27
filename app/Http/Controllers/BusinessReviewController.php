<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Toko;
use Illuminate\Support\Facades\Auth;

class BusinessReviewController extends Controller
{
    /**
     * Get review statistics for business owner's store
     */
    public function getMyStoreReviewStats()
    {
        try {
            $user = Auth::user();

            // Get the store owned by the authenticated user
            $toko = Toko::where('userID', $user->id)->first();

            if (!$toko) {
                return response()->json([
                    'success' => false,
                    'message' => 'Toko tidak ditemukan'
                ], 404);
            }

            // Get review statistics for this store
            $reviews = Review::where('toko_id', $toko->id);

            $totalReviews = $reviews->count();
            $averageRating = $totalReviews > 0 ? $reviews->avg('rating') : 0;

            // Get rating distribution
            $ratingDistribution = [];
            for ($i = 1; $i <= 5; $i++) {
                $count = Review::where('toko_id', $toko->id)
                    ->where('rating', $i)
                    ->count();
                $ratingDistribution[$i] = $count;
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'stats' => [
                        'total_reviews' => $totalReviews,
                        'average_rating' => round($averageRating, 1),
                        'rating_distribution' => $ratingDistribution
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik ulasan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get detailed reviews for business owner's store
     */
    public function getMyStoreReviews(Request $request)
    {
        try {
            $user = Auth::user();

            // Get the store owned by the authenticated user
            $toko = Toko::where('userID', $user->id)->first();

            if (!$toko) {
                return response()->json([
                    'success' => false,
                    'message' => 'Toko tidak ditemukan'
                ], 404);
            }

            $perPage = $request->get('per_page', 10);
            $rating = $request->get('rating'); // Filter by rating if provided

            $query = Review::where('toko_id', $toko->id)
                ->with(['transaksi:id,kode_transaksi', 'user:id,name'])
                ->orderBy('created_at', 'desc');

            // Apply rating filter if provided
            if ($rating && in_array($rating, [1, 2, 3, 4, 5])) {
                $query->where('rating', $rating);
            }

            $reviews = $query->paginate($perPage);

            // Get statistics
            $totalReviews = Review::where('toko_id', $toko->id)->count();
            $averageRating = $totalReviews > 0 ? Review::where('toko_id', $toko->id)->avg('rating') : 0;

            // Get rating distribution
            $ratingDistribution = [];
            for ($i = 1; $i <= 5; $i++) {
                $count = Review::where('toko_id', $toko->id)
                    ->where('rating', $i)
                    ->count();
                $ratingDistribution[$i] = $count;
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'reviews' => $reviews->items(),
                    'pagination' => [
                        'current_page' => $reviews->currentPage(),
                        'last_page' => $reviews->lastPage(),
                        'per_page' => $reviews->perPage(),
                        'total' => $reviews->total(),
                    ],
                    'stats' => [
                        'total_reviews' => $totalReviews,
                        'average_rating' => round($averageRating, 1),
                        'rating_distribution' => $ratingDistribution
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil ulasan: ' . $e->getMessage()
            ], 500);
        }
    }
}
