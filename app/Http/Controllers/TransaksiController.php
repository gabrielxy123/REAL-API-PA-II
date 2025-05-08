<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function store(Request $request)
    {
        $userId = Auth::id();

        try {
            // Validasi data request
            $request->validate([
                'toko_id' => 'required|exists:tokos,id',
                'items' => 'required|array',
                'items.*.produk_id' => 'required|exists:produks,id',
                'items.*.quantity' => 'required|integer|min:1',
            ]);

            $toko = Toko::find($request->toko_id);

            if (!$toko) {
                return response()->json([
                    'message' => 'Toko tidak ditemukan'
                ], 404);
            }

            $pesananList = [];

            foreach ($request->items as $item) {
                $produk = Produk::where('id', $item['produk_id'])
                    ->where('id_toko', $toko->id)
                    ->first();

                if (!$produk) {
                    continue; // Skip produk yang tidak valid
                }

                $quantity = $item['quantity'];
                $hargaSatuan = $produk->harga; // Harga satuan dari produk
                $subtotal = $hargaSatuan * $quantity; // Hitung subtotal

                $pesanan = Pesanan::create([
                    'id_produk' => $produk->id,
                    'id_user' => $userId,
                    'id_toko' => $toko->id,
                    'nama_produk' => $produk->nama,
                    'harga' => $hargaSatuan,
                    'kategori' => $produk->kategori->kategori,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal, // Tambahkan subtotal
                    'catatan' => $request->catatan ?? null,
                ]);
                $pesananList[] = $pesanan;
            }

            if (empty($pesananList)) {
                return response()->json([
                    'message' => 'Tidak ada produk valid yang diproses',
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
