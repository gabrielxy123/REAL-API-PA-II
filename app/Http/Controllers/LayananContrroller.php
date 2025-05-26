<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LayananContrroller extends Controller
{

    public function index()
    {
        // Dapatkan pengguna yang sedang login
        $userId = Auth::id();

        // Ambil toko yang dimiliki oleh pengguna
        $toko = Toko::where('userID', $userId)->first();

        // Jika pengguna tidak memiliki toko, kembalikan respons error
        if (!$toko) {
            return response()->json([
                'message' => 'Pengguna ini tidak memiliki toko.',
                'data' => []
            ], 404);
        }

        // Ambil semua produk yang sesuai dengan toko pengguna
        $produks = Layanan::where('id_toko', $toko->id)->get();

        return response()->json([
            'message' => 'Produk berhasil diambil',
            'data' => $produks,
        ]);
    }



    public function store(Request $request)
    {
        //memastikan user login
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'nullable|numeric',
        ]);

        $userId = Auth::id();

        // Dapatkan toko milik pengguna
        $toko = Toko::where('userID', $userId)->first();

        // Jika pengguna tidak memiliki toko, kembalikan error
        if (!$toko) {
            return response()->json(['message' => 'Pengguna ini tidak memiliki toko.'], 404);
        }

        //Menyimpan produk
        $produks = Layanan::create([
            'nama' => $validated['nama'],
            'harga' => $validated['harga'] ?? null,
            'id_user' => $userId,
            'id_toko' => $toko->id,
        ]);

        return response()->json([
            'message' => 'Produk berhasil dibuat',
            'data' => [
                'id' => $produks->id,
                'nama' => $produks->nama,
                'harga' => $produks->harga,
                'id_user' => $produks->id_user,
                'id_toko' => $produks->id_toko,
                'updated_at' => $produks->updated_at,
                'created_at' => $produks->created_at,
            ],
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // Memastikan user login
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Validasi input
        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'harga' => 'nullable|numeric',
        ]);

        $userId = Auth::id();

        // Dapatkan toko milik pengguna
        $toko = Toko::where('userID', $userId)->first();

        // Jika pengguna tidak memiliki toko, kembalikan error
        if (!$toko) {
            return response()->json(['message' => 'Pengguna ini tidak memiliki toko.'], 404);
        }

        // Cari layanan berdasarkan ID dan pastikan layanan milik toko pengguna
        $layanan = Layanan::where('id', $id)->where('id_toko', $toko->id)->first();

        // Jika layanan tidak ditemukan, kembalikan error
        if (!$layanan) {
            return response()->json(['message' => 'Layanan tidak ditemukan atau bukan milik toko ini.'], 404);
        }

        // Perbarui data layanan
        $layanan->update($validated);

        return response()->json([
            'message' => 'Layanan berhasil diperbarui',
            'data' => [
                'id' => $layanan->id,
                'nama' => $layanan->nama,
                'harga' => $layanan->harga,
                'id_user' => $layanan->id_user,
                'id_toko' => $layanan->id_toko,
                'updated_at' => $layanan->updated_at,
                'created_at' => $layanan->created_at,
            ],
        ]);
    }


    public function destroy($id)
    {
        // Memastikan user login
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $userId = Auth::id();

        // Dapatkan toko milik pengguna
        $toko = Toko::where('userID', $userId)->first();

        // Jika pengguna tidak memiliki toko, kembalikan error
        if (!$toko) {
            return response()->json(['message' => 'Pengguna ini tidak memiliki toko.'], 404);
        }

        // Cari layanan berdasarkan ID dan pastikan layanan milik toko pengguna
        $layanan = Layanan::where('id', $id)->where('id_toko', $toko->id)->first();

        // Jika layanan tidak ditemukan, kembalikan error
        if (!$layanan) {
            return response()->json(['message' => 'Layanan tidak ditemukan atau bukan milik toko ini.'], 404);
        }

        // Hapus layanan
        $layanan->delete();

        return response()->json(['message' => 'Layanan berhasil dihapus'], 200);
    }


    public function getLayananToOrder($toko_id)
    {
        try {
            // Cek apakah toko ada
            $toko = Toko::find($toko_id);

            if (!$toko) {
                return response()->json([
                    'message' => 'Toko tidak ditemukan',
                    'data' => []
                ], 404);
            }

            // Ambil semua produk yang sesuai dengan toko pengguna
            $layanan = Layanan::where('id_toko', $toko->id)->get();

            return response()->json([
                'message' => 'Layanan berhasil diambil',
                'data' => $layanan,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil produk',
                'data' => [],
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getLayananToToko($toko_id)
    {
        try {
            // Cek apakah toko ada
            $toko = Toko::find($toko_id);

            if (!$toko) {
                return response()->json([
                    'message' => 'Toko tidak ditemukan',
                    'data' => []
                ], 404);
            }

            // Ambil semua produk yang sesuai dengan toko pengguna
            $layanan = Layanan::where('id_toko', $toko->id)->get();

            return response()->json([
                'message' => 'Layanan berhasil diambil',
                'data' => $layanan,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil layanan',
                'data' => [],
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
