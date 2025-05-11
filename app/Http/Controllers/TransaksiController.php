<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Toko;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
                'layanan_tambahan' => 'nullable|exists:layanans,id', // ← ini tambahan
            ]);

            $toko = Toko::find($request->toko_id);

            if (!$toko) {
                return response()->json([
                    'message' => 'Toko tidak ditemukan'
                ], 404);
            }

            $pesananList = [];
            $kodeTransaksi = 'TRX-' . strtoupper(uniqid());

            foreach ($request->items as $item) {
                $produk = Produk::where('id', $item['produk_id'])
                    ->where('id_toko', $toko->id)
                    ->first();

                if (!$produk) {
                    continue; // Skip produk yang tidak valid
                }

                $quantity = $item['quantity'];
                $hargaSatuan = $produk->harga;
                $subtotal = $hargaSatuan * $quantity;

                // Membuat pesanan
                $pesanan = Pesanan::create([
                    'kode_transaksi' => $kodeTransaksi,
                    'id_produk' => $produk->id,
                    'id_user' => $userId,
                    'id_toko' => $toko->id,
                    'nama_produk' => $produk->nama,
                    'harga' => $hargaSatuan,
                    'kategori' => $produk->kategori->kategori,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                    'catatan' => $request->catatan ?? null,
                ]);

                // Menambahkan layanan tambahan ke pesanan jika ada
                if (!empty($request->layanan_tambahan)) {
                    $pesanan->layananTambahan()->attach($request->layanan_tambahan);
                }

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
                'data' => $pesanan->load('layanan')
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal membuat pesanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function riwayatTransaksi()
    {
        $userId = Auth::id();

        // Get all transactions for the user grouped by kode_transaksi
        $transactions = Pesanan::where('id_user', $userId)
            ->select('kode_transaksi', 'id_toko', DB::raw('MAX(created_at) as latest_created_at'))
            ->groupBy('kode_transaksi', 'id_toko')
            ->orderByDesc(DB::raw('MAX(created_at)'))
            ->get()
            ->map(function ($item) {
                // Get the toko (laundry shop) details
                $toko = Toko::find($item->id_toko);

                // Get the latest status for this transaction
                $latestOrder = Pesanan::where('kode_transaksi', $item->kode_transaksi)
                    ->where('id_user', Auth::id())
                    ->orderByDesc('updated_at')
                    ->first();

                // Calculate total items and amount
                $orderItems = Pesanan::where('kode_transaksi', $item->kode_transaksi)
                    ->where('id_user', Auth::id())
                    ->get();

                $totalItems = $orderItems->sum('quantity');
                $totalAmount = $orderItems->sum('subtotal');

                return [
                    'kode_transaksi' => $item->kode_transaksi ?? '',
                    'nama_toko' => $toko ? $toko->nama : 'Tidak diketahui',
                    'kontak_toko' => $toko ? $toko->noTelp : '-',
                    'status' => $latestOrder ? $latestOrder->status : 'Menunggu',
                    'id_toko' => $item->id_toko ?? 0, // Ensure id_toko is never null
                    'created_at' => $item->latest_created_at ?? now()->toDateTimeString(),
                    'is_completed' => ($latestOrder && $latestOrder->status === 'Selesai') ? true : false,
                    'total_items' => $totalItems ?? 0,
                    'total_amount' => $totalAmount ?? 0
                ];
            });

        return response()->json($transactions);
    }
}
