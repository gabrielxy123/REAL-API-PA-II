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
}
