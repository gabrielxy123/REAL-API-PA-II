<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Toko;
use Illuminate\Support\Facades\DB;

class NotaController extends Controller
{
    //Menampilkan Nota pemesanan kepada user yang login
    public function indexNota()
    {
        $userId = Auth::id();

        $groupedPesanan = Pesanan::where('id_user', $userId)
            ->with('toko')
            ->select('kode_transaksi', 'id_toko', 'status', DB::raw('MAX(created_at) as tanggal'))
            ->groupBy('kode_transaksi', 'id_toko', 'status')
            ->orderByDesc('tanggal')
            ->get();

        if ($groupedPesanan->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada nota ditemukan',
                'data' => []
            ], 404);
        }

        $result = $groupedPesanan->map(function ($group) use ($userId) {
            $items = Pesanan::where('kode_transaksi', $group->kode_transaksi)
                ->where('id_user', $userId)
                ->get();

            return [
                'kode_transaksi' => $group->kode_transaksi,
                'nama_toko' => $group->toko->nama ?? 'Tidak diketahui',
                'tanggal' => \Carbon\Carbon::parse($group->tanggal)->format('d-m-Y H:i'),
                'jumlah_item' => $items->sum('quantity'),
                'total_harga' => $items->sum('subtotal'),
                'status' => $group->status ?? 'Menunggu'
            ];
        });

        return response()->json([
            'message' => 'Daftar nota berhasil diambil',
            'data' => $result
        ]);
    }


    public function detailNota($kodeTransaksi)
    {
        $userId = Auth::id();

        $pesananList = Pesanan::where('kode_transaksi', $kodeTransaksi)
            ->where('id_user', $userId)
            ->with(['produk', 'toko', 'layananTambahan'])
            ->get();

        if ($pesananList->isEmpty()) {
            return response()->json([
                'message' => 'Transaksi tidak ditemukan atau bukan milik Anda',
                'data' => []
            ], 404);
        }

        $first = $pesananList->first();
        $totalProduk = $pesananList->sum('subtotal');
        $layananTambahan = $first->layananTambahan;
        $totalLayanan = $layananTambahan->sum('harga');
        $grandTotal = $totalProduk + $totalLayanan;

        return response()->json([
            'message' => 'Nota berhasil diambil',
            'data' => [
                'kode_transaksi' => $kodeTransaksi,
                'waktu' => $first->created_at->format('d-m-Y H:i'),
                'toko' => [
                    'nama' => $first->toko->nama ?? '-',
                    'kontak' => $first->toko->noTelp ?? '-',
                ],
                'items' => $pesananList->map(function ($item) {
                    return [
                        'produk' => $item->nama_produk,
                        'harga' => $item->harga,
                        'quantity' => $item->quantity,
                        'subtotal' => $item->subtotal
                    ];
                }),
                'layanan_tambahan' => $layananTambahan->map(function ($layanan) {
                    return [
                        'nama' => $layanan->nama,
                        'harga' => $layanan->harga
                    ];
                }),
                'total_produk' => $totalProduk,
                'total_layanan' => $totalLayanan,
                'grand_total' => $grandTotal
            ]
        ]);
    }
}
