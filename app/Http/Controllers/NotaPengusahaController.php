<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PesananKiloan;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NotaPengusahaController extends Controller
{
    // Menampilkan semua transaksi dari toko milik user yang login
    public function index()
    {
        $userId = Auth::id();

        $toko = Toko::where('userId', $userId)->first();

        if (!$toko) {
            return response()->json([
                'message' => 'Toko tidak ditemukan untuk user ini',
                'data' => []
            ], 404);
        }

        $groupedPesanan = Pesanan::where('id_toko', $toko->id)
            ->with('user')
            ->select('kode_transaksi', 'id_user', 'status', DB::raw('MAX(created_at) as tanggal'))
            ->groupBy('kode_transaksi', 'id_user', 'status')
            ->orderByDesc('tanggal')
            ->get();

        if ($groupedPesanan->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada transaksi ditemukan untuk toko ini',
                'data' => []
            ], 404);
        }

        $result = $groupedPesanan->map(function ($group) {
            $items = Pesanan::where('kode_transaksi', $group->kode_transaksi)
                ->where('id_user', $group->id_user)
                ->with(['layananTambahan', 'pesananKiloan']) // tambahkan relasi
                ->get();

            // Total produk
            $totalProduk = $items->sum('subtotal');

            // Total layanan tambahan (dari satu pesanan saja karena shared per transaksi)
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
                'nama_pelanggan' => $group->user->name ?? 'Tidak diketahui',
                'tanggal' => \Carbon\Carbon::parse($group->tanggal)->format('d-m-Y H:i'),
                'jumlah_item' => $items->sum('quantity'),
                'total_harga' => $grandTotal,
                'status' => $group->status ?? 'Menunggu'
            ];
        });

        return response()->json([
            'message' => 'Daftar transaksi berhasil diambil',
            'data' => $result
        ]);
    }


    // Menampilkan detail transaksi berdasarkan kode_transaksi untuk toko milik user
    public function detail($kodeTransaksi)
    {
        $userId = Auth::id();

        $toko = Toko::where('userId', $userId)->first();

        if (!$toko) {
            return response()->json([
                'message' => 'Toko tidak ditemukan untuk user ini',
                'success' => false
            ], 404);
        }

        $pesananList = Pesanan::where('kode_transaksi', $kodeTransaksi)
            ->where('id_toko', $toko->id)
            ->with(['produk', 'toko', 'layananTambahan', 'user'])
            ->get();

        if ($pesananList->isEmpty()) {
            return response()->json([
                'message' => 'Transaksi tidak ditemukan atau bukan milik toko Anda',
                'success' => false
            ], 404);
        }

        $first = $pesananList->first();
        $totalProduk = $pesananList->sum('subtotal');
        $layananTambahan = $first->layananTambahan;
        $totalLayanan = $layananTambahan->sum('harga');
        $grandTotal = $totalProduk + $totalLayanan;

        // Cek apakah ini pesanan kiloan
        $pesananKiloanData = null;
        $totalKiloan = 0;

        if ($first->id_pesanan_kiloan) {
            $pesananKiloan = PesananKiloan::with('details')->find($first->id_pesanan_kiloan);

            if ($pesananKiloan) {
                // Calculate total kiloan if both values are set
                if ($pesananKiloan->jumlah_kiloan !== null && $pesananKiloan->harga_kiloan !== null) {
                    $totalKiloan = $pesananKiloan->jumlah_kiloan * $pesananKiloan->harga_kiloan;
                    $grandTotal += $totalKiloan;
                }

                $pesananKiloanData = [
                    'id' => $pesananKiloan->id,
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
                'status' => $first->status,
                'id_pesanan_kiloan' => $first->id_pesanan_kiloan,
                'toko' => [
                    'nama' => $first->toko->nama ?? '-',
                    'kontak' => $first->toko->noTelp ?? '-',
                ],
                'pelanggan' => [
                    'nama' => $first->user->name ?? 'Tidak diketahui',
                    'kontak' => $first->user->phone ?? '-',
                    'alamat' => $first->user->address ?? '-',
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
                'pesanan_kiloan' => $pesananKiloanData,
                'total_produk' => $totalProduk,
                'total_layanan' => $totalLayanan,
                'total_kiloan' => $totalKiloan,
                'grand_total' => $grandTotal
            ]
        ]);
    }

    // Memproses pesanan (mengubah status menjadi "Diproses")
    public function prosesPesanan(Request $request, $kodeTransaksi)
    {
        $userId = Auth::id();

        $toko = Toko::where('userId', $userId)->first();

        if (!$toko) {
            return response()->json([
                'message' => 'Toko tidak ditemukan untuk user ini',
                'success' => false
            ], 404);
        }

        // Cek apakah pesanan ada dan milik toko ini
        $pesanan = Pesanan::where('kode_transaksi', $kodeTransaksi)
            ->where('id_toko', $toko->id)
            ->first();

        if (!$pesanan) {
            return response()->json([
                'message' => 'Pesanan tidak ditemukan atau bukan milik toko Anda',
                'success' => false
            ], 404);
        }

        // Cek apakah pesanan kiloan sudah diisi jika ada
        if ($pesanan->id_pesanan_kiloan) {
            $pesananKiloan = PesananKiloan::find($pesanan->id_pesanan_kiloan);

            if ($pesananKiloan && ($pesananKiloan->jumlah_kiloan === null || $pesananKiloan->harga_kiloan === null)) {
                return response()->json([
                    'message' => 'Pesanan kiloan harus diisi jumlah dan harga per kilo sebelum diproses',
                    'success' => false,
                    'requires_kiloan_data' => true
                ], 422);
            }
        }

        // Update status semua pesanan dengan kode transaksi yang sama
        DB::beginTransaction();
        try {
            Pesanan::where('kode_transaksi', $kodeTransaksi)
                ->where('id_toko', $toko->id)
                ->update(['status' => 'Diproses']);

            DB::commit();

            return response()->json([
                'message' => 'Pesanan berhasil diproses',
                'success' => true
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal memproses pesanan: ' . $e->getMessage(),
                'success' => false
            ], 500);
        }
    }

    // Menolak pesanan (mengubah status menjadi "Ditolak")
    public function tolakPesanan($kodeTransaksi)
    {
        $userId = Auth::id();

        $toko = Toko::where('userId', $userId)->first();

        if (!$toko) {
            return response()->json([
                'message' => 'Toko tidak ditemukan untuk user ini',
                'success' => false
            ], 404);
        }

        // Cek apakah pesanan ada dan milik toko ini
        $pesanan = Pesanan::where('kode_transaksi', $kodeTransaksi)
            ->where('id_toko', $toko->id)
            ->get();

        if ($pesanan->isEmpty()) {
            return response()->json([
                'message' => 'Pesanan tidak ditemukan atau bukan milik toko Anda',
                'success' => false
            ], 404);
        }

        // Update status semua pesanan dengan kode transaksi yang sama
        DB::beginTransaction();
        try {
            Pesanan::where('kode_transaksi', $kodeTransaksi)
                ->where('id_toko', $toko->id)
                ->update(['status' => 'Ditolak']);

            DB::commit();

            return response()->json([
                'message' => 'Pesanan berhasil ditolak',
                'success' => true
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal menolak pesanan: ' . $e->getMessage(),
                'success' => false
            ], 500);
        }
    }

    // Update jumlah kiloan dan harga kiloan
    public function updatePesananKiloan(Request $request, $kodeTransaksi)
    {
        $userId = Auth::id();

        $toko = Toko::where('userId', $userId)->first();

        if (!$toko) {
            return response()->json([
                'message' => 'Toko tidak ditemukan untuk user ini',
                'success' => false
            ], 404);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'jumlah_kiloan' => 'required|numeric|min:0.1',
            'harga_kiloan' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
                'success' => false
            ], 422);
        }

        // Cek apakah pesanan ada dan milik toko ini
        $pesanan = Pesanan::where('kode_transaksi', $kodeTransaksi)
            ->where('id_toko', $toko->id)
            ->first();

        if (!$pesanan) {
            return response()->json([
                'message' => 'Pesanan tidak ditemukan atau bukan milik toko Anda',
                'success' => false
            ], 404);
        }

        // Cek apakah pesanan memiliki id_pesanan_kiloan
        if (!$pesanan->id_pesanan_kiloan) {
            return response()->json([
                'message' => 'Pesanan ini bukan pesanan kiloan',
                'success' => false
            ], 400);
        }

        // Update jumlah kiloan dan harga kiloan
        DB::beginTransaction();
        try {
            $pesananKiloan = PesananKiloan::find($pesanan->id_pesanan_kiloan);

            if (!$pesananKiloan) {
                throw new \Exception('Data pesanan kiloan tidak ditemukan');
            }

            $pesananKiloan->jumlah_kiloan = $request->jumlah_kiloan;
            $pesananKiloan->harga_kiloan = $request->harga_kiloan;
            $pesananKiloan->save();

            // Recalculate grand total
            $totalProduk = Pesanan::where('kode_transaksi', $kodeTransaksi)
                ->where('id_toko', $toko->id)
                ->sum('subtotal');

            $layananTambahan = $pesanan->layananTambahan;
            $totalLayanan = $layananTambahan->sum('harga');
            $totalKiloan = $pesananKiloan->jumlah_kiloan * $pesananKiloan->harga_kiloan;
            $grandTotal = $totalProduk + $totalLayanan + $totalKiloan;

            DB::commit();

            return response()->json([
                'message' => 'Jumlah kiloan dan harga berhasil diperbarui',
                'data' => [
                    'jumlah_kiloan' => $pesananKiloan->jumlah_kiloan,
                    'harga_kiloan' => $pesananKiloan->harga_kiloan,
                    'total_kiloan' => $totalKiloan,
                    'grand_total' => $grandTotal
                ],
                'success' => true
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal memperbarui data: ' . $e->getMessage(),
                'success' => false
            ], 500);
        }
    }
}
