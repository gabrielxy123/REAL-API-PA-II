<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PesananKiloan;
use App\Models\Produk;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function store(Request $request)
    {
        $userId = Auth::id();

        try {
            // Validasi umum
            $request->validate([
                'toko_id' => 'required|exists:tokos,id',
                'items' => 'required|array',
                'items.*.produk_id' => 'required|exists:produks,id',
                'items.*.quantity' => 'required|integer|min:1',
                'pesanan_kiloan.jumlah_kiloan' => 'nullable|numeric|min:0.1',
                'pesanan_kiloan.harga_kiloan' => 'nullable|numeric|min:0',
                'pesanan_kiloan.details' => 'nullable|array',
                'pesanan_kiloan.details.*.id_produk' => 'required|exists:produks,id',
                'pesanan_kiloan.details.*.nama_barang' => 'required|string',
            ]);

            $kodeTransaksi = 'TRX-' . strtoupper(uniqid());
            $pesananList = [];

            // Buat pesanan kiloan jika ada
            $pesananKiloan = null;

            if (!empty($request->pesanan_kiloan)) {
                $pesananKiloan = PesananKiloan::create([

                    'jumlah_kiloan' => $request->pesanan_kiloan['jumlah_kiloan'],
                    'harga_kiloan' => $request->pesanan_kiloan['harga_kiloan'],
                ]);

                foreach ($request->pesanan_kiloan['details'] as $detail) {
                    $produk = Produk::find($detail['id_produk']);

                    if (!$produk || $produk->id_kategori != 2) {
                        continue; // Hanya izinkan produk kategori kiloan
                    }

                    $pesananKiloan->details()->create([
                        'id_produk' => $produk->id,
                        'nama_barang' => $detail['nama_barang'],
                        'quantity' => $detail['quantity']
                    ]);
                }
            }

            // Buat pesanan per produk (satuan / kiloan)
            foreach ($request->items as $item) {
                $produk = Produk::where('id', $item['produk_id'])
                    ->where('id_toko', $request->toko_id)
                    ->first();

                if (!$produk) {
                    continue;
                }

                $subtotal = $produk->harga * $item['quantity'];

                $pesanan = Pesanan::create([
                    'kode_transaksi' => $kodeTransaksi,
                    'id_produk' => $produk->id,
                    'id_user' => $userId,
                    'id_toko' => $request->toko_id,
                    'nama_produk' => $produk->nama,
                    'harga' => $produk->harga,
                    'kategori' => $produk->kategori->kategori,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                    'id_pesanan_kiloan' => $pesananKiloan ? $pesananKiloan->id : null,
                    'catatan' => $request->catatan ?? null,
                ]);

                $pesananList[] = $pesanan;
            }

            if (empty($pesananList)) {
                return response()->json([
                    'message' => 'Tidak ada produk valid yang diproses',
                    'data' => [],
                ], 400);
            }

            return response()->json([
                'message' => 'Pesanan berhasil dibuat',
                'kode_transaksi' => $kodeTransaksi,
                'data' => $pesananList,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal membuat pesanan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function riwayatTransaksi()
    {
        $userId = Auth::id();

        $transactions = Pesanan::where('id_user', $userId)
            ->select('kode_transaksi', 'id_toko', DB::raw('MAX(created_at) as latest_created_at'))
            ->groupBy('kode_transaksi', 'id_toko')
            ->orderByDesc(DB::raw('MAX(created_at)'))
            ->get()
            ->map(function ($item) use ($userId) {
                $toko = Toko::find($item->id_toko);

                $latestOrder = Pesanan::where('kode_transaksi', $item->kode_transaksi)
                    ->where('id_user', $userId)
                    ->orderByDesc('updated_at')
                    ->first();

                $orderItems = Pesanan::where('kode_transaksi', $item->kode_transaksi)
                    ->where('id_user', $userId)
                    ->get();

                $totalItems = $orderItems->sum('quantity');
                $totalAmount = $orderItems->sum('subtotal');

                // Ambil salah satu pesanan untuk melihat apakah terkait dengan pesanan kiloan
                $firstPesanan = $orderItems->first();
                $pesananKiloanData = null;

                if ($firstPesanan && $firstPesanan->id_pesanan_kiloan) {
                    $pesananKiloan = PesananKiloan::with('details')->find($firstPesanan->id_pesanan_kiloan);
                    if ($pesananKiloan) {
                        $pesananKiloanData = [
                            'jumlah_kiloan' => $pesananKiloan->jumlah_kiloan,
                            'harga_kiloan' => $pesananKiloan->harga_kiloan,
                            'details' => $pesananKiloan->details->map(function ($detail) {
                                return [
                                    'id_produk' => $detail->id_produk,
                                    'nama_barang' => $detail->nama_barang,
                                    'quantity' => $detail->quantity,
                                ];
                            }),
                        ];
                    }
                }

                return [
                    'kode_transaksi' => $item->kode_transaksi ?? '',
                    'nama_toko' => $toko ? $toko->nama : 'Tidak diketahui',
                    'kontak_toko' => $toko ? $toko->noTelp : '-',
                    'status' => $latestOrder ? $latestOrder->status : 'Menunggu',
                    'id_toko' => $item->id_toko ?? 0,
                    'created_at' => $item->latest_created_at ?? now()->toDateTimeString(),
                    'is_completed' => ($latestOrder && $latestOrder->status === 'Selesai'),
                    'total_items' => $totalItems ?? 0,
                    'total_amount' => $totalAmount ?? 0,
                    'pesanan_kiloan' => $pesananKiloanData, // ← bagian tambahan
                ];
            });

        return response()->json($transactions);
    }
}
