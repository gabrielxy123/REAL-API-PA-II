<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PesananKiloan;
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
                ->with(['layananTambahan', 'pesananKiloan', 'produk']) // Tambahkan relasi produk
                ->get();

            // Filter hanya item dengan id_kategori = 1
            $filteredItems = $items->filter(function ($item) {
                return $item->produk->id_kategori == 1; // Cek kategori produk
            });

            // Total produk (hanya dari item dengan id_kategori = 1)
            $totalProduk = $filteredItems->sum('subtotal');

            // Total layanan tambahan
            $layananTambahan = $items->first()?->layananTambahan ?? collect();
            $totalLayanan = $layananTambahan->sum('harga');

            // Total kiloan
            $totalKiloan = 0;
            $firstPesanan = $items->first();

            if ($firstPesanan && $firstPesanan->id_pesanan_kiloan) {
                $kiloan = $firstPesanan->pesananKiloan;
                if ($kiloan && $kiloan->jumlah_kiloan && $kiloan->harga_kiloan) {
                    $totalKiloan = $kiloan->jumlah_kiloan * $kiloan->harga_kiloan;
                }
            }

            $grandTotal = $totalProduk + $totalLayanan + $totalKiloan;

            return [
                'kode_transaksi' => $group->kode_transaksi,
                'nama_toko' => $group->toko->nama ?? 'Tidak diketahui',
                'tanggal' => \Carbon\Carbon::parse($group->tanggal)->format('d-m-Y H:i'),
                'jumlah_item' => $filteredItems->sum('quantity'),
                'total_harga' => $grandTotal,
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

        // Filter hanya item dengan id_kategori = 1
        $filteredPesananList = $pesananList->filter(function ($pesanan) {
            return $pesanan->produk->id_kategori == 1; // Cek kategori produk
        });

        $first = $pesananList->first();
        $totalProduk = $filteredPesananList->sum('subtotal'); // Gunakan koleksi hasil filter
        $layananTambahan = $first->layananTambahan;
        $totalLayanan = $layananTambahan->sum('harga');
        $grandTotal = $totalProduk + $totalLayanan;

        // Cek apakah ini pesanan kiloan
        $pesananKiloanData = null;
        $totalKiloan = 0;

        if ($first->id_pesanan_kiloan) {
            $pesananKiloan = PesananKiloan::with('details')->find($first->id_pesanan_kiloan);

            if ($pesananKiloan) {
                if ($pesananKiloan->jumlah_kiloan !== null && $pesananKiloan->harga_kiloan !== null) {
                    $totalKiloan = $pesananKiloan->jumlah_kiloan * $pesananKiloan->harga_kiloan;
                    $grandTotal += $totalKiloan;
                }

                $pesananKiloanData = [
                    'jumlah_kiloan' => $pesananKiloan->jumlah_kiloan,
                    'harga_kiloan' => $pesananKiloan->harga_kiloan,
                    'total_kiloan' => $totalKiloan,
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

        return response()->json([
            'message' => 'Nota berhasil diambil',
            'data' => [
                'kode_transaksi' => $kodeTransaksi,
                'waktu' => $first->created_at->format('d-m-Y H:i'),
                'toko' => [
                    'nama' => $first->toko->nama ?? '-',
                    'kontak' => $first->toko->noTelp ?? '-',
                ],
                'items' => $filteredPesananList->map(function ($item) {
                    return [
                        'produk' => $item->nama_produk ?? 'Tidak diketahui',
                        'harga' => $item->harga,
                        'quantity' => $item->quantity,
                        'subtotal' => $item->subtotal,
                        'status' => $item->status
                    ];
                }),
                'layanan_tambahan' => $layananTambahan->map(function ($layanan) {
                    return [
                        'nama' => $layanan->nama,
                        'harga' => $layanan->harga
                    ];
                }),
                'pesanan_kiloan' => $pesananKiloanData,
                'total_produk' => $totalProduk,
                'total_layanan' => $totalLayanan,
                'total_kiloan' => $totalKiloan,
                'grand_total' => $grandTotal,
            ]
        ]);
    }
}
