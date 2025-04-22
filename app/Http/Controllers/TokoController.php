<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class TokoController extends Controller
{
    public function index()
    {
        $tokos = Toko::all();
        return response()->json([
            'message' => 'Data toko berhasil diambil',
            'data' => $tokos
        ], 200);
    }

    public function indexUser()
    {
        $tokos = Toko::where('status', 'Diterima')->get();
        return response()->json([
            'message' => 'Data toko berhasil diambil',
            'data' => $tokos
        ], 200);
    }

    public function approve($id)
    {
        try {
            $toko = Toko::findOrFail($id);

            // Validasi status
            if ($toko->status === 'Diterima') {
                return response()->json([
                    'success' => false,
                    'message' => 'Toko sudah dalam status Diterima'
                ], 400);
            }

            // Update hanya status
            $toko->update([
                'status' => 'Diterima'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Toko berhasil disetujui',
                'data' => $toko
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyetujui toko',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Reject toko
    public function reject($id)
    {
        try {
            $toko = Toko::findOrFail($id);

            if ($toko->status === 'Ditolak') {
                return response()->json([
                    'success' => false,
                    'message' => 'Toko sudah dalam status Ditolak'
                ], 400);
            }

            // Update status saja tanpa menyimpan alasan
            $toko->update([
                'status' => 'Ditolak'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Toko berhasil ditolak'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menolak toko',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // Pastikan user login
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'noTelp' => 'required|string|regex:/^[0-9]{10,15}$/',
            'email' => 'required|email|unique:tokos,email|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'jalan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'waktuBuka' => 'required|date_format:H:i:s',
            'waktuTutup' => 'required|date_format:H:i:s|after:waktuBuka',
        ]);

        $userId = Auth::id();

        if (Toko::where('userID', $userId)->exists()) {
            return response()->json([
                'message' => 'User sudah memiliki toko'
            ], 422);
        }

        // Menyimpan data toko
        $toko = Toko::create([
            'userID' => $userId,
            'nama' => $validated['nama'],
            'noTelp' => $validated['noTelp'],
            'email' => $validated['email'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'jalan' => $validated['jalan'],
            'kecamatan' => $validated['kecamatan'],
            'kabupaten' => $validated['kabupaten'],
            'provinsi' => $validated['provinsi'],
            'waktuBuka' => $validated['waktuBuka'],
            'waktuTutup' => $validated['waktuTutup'],
        ]);

        return response()->json([
            'message' => 'Toko berhasil dibuat',
            'data' => $toko
        ], 201);
    }

    public function uploadBuktiPembayaran(Request $request)
    {
        try {
            // Validasi apakah file diunggah
            if (!$request->hasFile('buktiBayar')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No image file uploaded'
                ], 400);
            }

            $image = $request->file('buktiBayar');

            // Validasi tipe file
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!in_array($image->getMimeType(), $allowedTypes)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid file type. Only JPG, JPEG, and PNG are allowed.'
                ], 400);
            }

            // Validasi ukuran file (maksimum 5MB)
            if ($image->getSize() > 5 * 1024 * 1024) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File size too large. Maximum size is 5MB.'
                ], 400);
            }

            // Generate nama file unik
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

            // Simpan file ke storage publik
            $path = $image->storeAs('public/bukti_pembayaran', $filename);

            if (!$path) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to store image'
                ], 500);
            }

            // Dapatkan toko milik user yang sedang login
            $userId = Auth::id();
            $toko = Toko::where('userID', $userId)->first();

            if (!$toko) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Toko tidak ditemukan'
                ], 404);
            }

            // Hapus bukti bayar lama jika ada
            if ($toko->buktiBayar) {
                $oldPath = str_replace(url('/storage/'), 'public/', $toko->buktiBayar);
                if (Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }
            }

            // Update URL bukti bayar di database
            $toko->buktiBayar = url('/storage/bukti_pembayaran/' . $filename);
            $toko->save();

            return response()->json([
                'status' => 'success',
                'image_url' => $toko->buktiBayar,
                'message' => 'Bukti pembayaran uploaded successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error uploading bukti pembayaran: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }


    public function saveBuktiPembayaran($image, $path = 'public')
    {
        if ($image) {
            return null;
        }

        $filename = time() . '.png';
        //save image
        Storage::disk($path)->put($filename, base64_decode($image));

        //return URL
        return URL::to('/') . '/storage/' . $path . '/' . $filename;
    }

    public function show(Toko $toko)
    {
        return response()->json([
            'message' => 'Detail toko berhasil diambil',
            'data' => $toko
        ], 200);
    }

    public function update(Request $request, Toko $toko)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|required',
            'no_telp' => 'sometimes|required',
            'email' => 'sometimes|required|email|unique:tokos,email,' . $toko->id,
            'deskripsi' => 'nullable',
            'jalan' => 'sometimes|required',
            'kecamatan' => 'sometimes|required',
            'kabupaten' => 'sometimes|required',
            'provinsi' => 'sometimes|required',
            'waktu_buka' => 'sometimes|required',
            'waktu_tutup' => 'sometimes|required',
        ]);
        $toko->update($validated);
        return response()->json([
            'message' => 'Toko berhasil diperbarui',
            'data' => $toko
        ], 200);
    }

    public function destroy(Toko $toko)
    {
        $toko->delete();
        return response()->json([
            'message' => 'Toko berhasil dihapus',
            'data' => null
        ], 200);
    }
}
