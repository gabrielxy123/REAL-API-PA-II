<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Toko;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{

    public function produkToko($toko_id)
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
            $produks = Produk::where('id_toko', $toko->id)->get();

            return response()->json([
                'message' => 'Produk berhasil diambil',
                'data' => $produks,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil produk',
                'data' => [],
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request, $toko_id)
    {
        $toko = Toko::find($toko_id);

        if (!$toko) {
            return response()->json([
                'message' => 'Toko tidak ditemukan',
                'data' => []
            ], 404);
        }

        $userId = Auth::id();

        try {
            $request->validate([
                'id_produk' => 'required|array',
                'id_produk.*' => 'exists:produks,id',
            ]);

            $pesananList = [];

            foreach ($request->id_produk as $produkId) {
                $produk = Produk::where('id', $produkId)
                    ->where('id_toko', $toko->id)
                    ->first();

                if (!$produk) {
                    continue; // Skip produk yang tidak valid di toko ini
                }

                $pesanan = Pesanan::create([
                    'id_produk' => $produk->id,
                    'id_user' => $userId,
                    'id_toko' => $toko->id,
                    'nama_produk' => $produk->nama,
                    'harga' => $produk->harga,
                    'kategori' => $produk->kategori->kategori,
                ]);

                $pesananList[] = $pesanan;
            }

            if (empty($pesananList)) {
                return response()->json([
                    'message' => 'Tidak ada produk valid dari toko ini yang diproses',
                    'data' => []
                ], 400);
            }

            return response()->json([
                'message' => 'Pesanan berhasil dibuat',
                'data' => $pesananList
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal membuat pesanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
