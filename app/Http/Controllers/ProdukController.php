<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    //
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
        $produks = Produk::where('id_toko', $toko->id)->get();

        return response()->json([
            'message' => 'Produk berhasil diambil',
            'data' => $produks,
        ]);
    }

    public function getProdukByToko($toko_id)
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

    // Tambahkan di controller ProdukController atau controller lain
    public function cekHargaKiloan()
    {
        $userId = Auth::id();
        $toko = Toko::where('userID', $userId)->first();

        if (!$toko) {
            return response()->json(['message' => 'Pengguna tidak punya toko.'], 404);
        }

        $produkKiloan = Produk::where('id_kategori', 2)->where('id_toko', $toko->id)->first();

        if ($produkKiloan) {
            return response()->json(['exists' => true, 'harga' => (float) $produkKiloan->harga]);
        } else {
            return response()->json(['exists' => false]);
        }
    }



    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized || Kamu tidak memiliki hak untuk menambahkan produk!'], 401);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'nullable|numeric|min:0',
            'id_kategori' => 'required|exists:kategoris,id'
        ]);

        $userId = Auth::id();
        $toko = Toko::where('userID', $userId)->first();

        if (!$toko) {
            return response()->json(['message' => 'Pengguna ini tidak memiliki toko.'], 404);
        }

        // Logic khusus kategori kiloan
        $kategoriKiloanID = 2;

        if ((int) $validated['id_kategori'] === $kategoriKiloanID) {
            $produkKiloan = Produk::where('id_kategori', $kategoriKiloanID)
                ->where('id_toko', $toko->id)
                ->whereNotNull('harga')
                ->first();

            if (!$produkKiloan) {
                if (!isset($validated['harga']) || $validated['harga'] === null) {
                    return response()->json(['message' => 'Harga wajib diisi untuk kategori kiloan (pertama kali).'], 422);
                }
                $hargaKiloan = $validated['harga'];
            } else {
                $hargaKiloan = $produkKiloan->harga;
            }
        } else {
            // Bukan kategori kiloan, harga wajib diisi manual
            if (!isset($validated['harga'])) {
                return response()->json(['message' => 'Harga wajib diisi untuk kategori ini.'], 422);
            }

            $hargaKiloan = $validated['harga'];
        }

        // Simpan produk
        $produk = Produk::create([
            'nama' => $validated['nama'],
            'harga' => $hargaKiloan,
            'id_user' => $userId,
            'id_toko' => $toko->id,
            'id_kategori' => $validated['id_kategori'],
        ]);

        return response()->json([
            'message' => 'Produk berhasil ditambahkan.',
            'data' => [
                'id' => $produk->id,
                'nama' => $produk->nama,
                'harga' => $produk->harga,
                'id_user' => $produk->id_user,
                'id_toko' => $produk->id_toko,
                'id_kategori' => $produk->id_kategori,
                'kategori' => $produk->kategori->kategori,
                'updated_at' => $produk->updated_at,
                'created_at' => $produk->created_at,
            ]
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // Memastikan user login
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized || Kamu tidak memiliki hak untuk mengubah data ini !'], 401);
        }

        // Validasi input
        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'harga' => 'nullable|numeric',
            'id_kategori' => 'sometimes|required|exists:kategoris,id'
        ]);

        $userId = Auth::id();

        // Dapatkan toko milik pengguna
        $toko = Toko::where('userID', $userId)->first();

        // Jika pengguna tidak memiliki toko, kembalikan error
        if (!$toko) {
            return response()->json(['message' => 'Pengguna ini tidak memiliki toko.'], 404);
        }

        // Cari produk berdasarkan ID dan pastikan produk milik toko pengguna
        $produk = Produk::where('id', $id)->where('id_toko', $toko->id)->first();

        // Jika produk tidak ditemukan, kembalikan error
        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan atau bukan milik toko ini.'], 404);
        }

        // Perbarui data produk
        $produk->update($validated);

        return response()->json([
            'message' => 'Produk berhasil diperbarui',
            'data' => [
                'id' => $produk->id,
                'nama' => $produk->nama,
                'harga' => $produk->harga,
                'id_user' => $produk->id_user,
                'id_toko' => $produk->id_toko,
                'id_kategori' => $produk->id_kategori,
                'kategori' => $produk->kategori->kategori, // Asumsi ada relasi 'kategori' di model Produk
                'updated_at' => $produk->updated_at,
                'created_at' => $produk->created_at,
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

        // Cari produk berdasarkan ID dan pastikan produk milik toko pengguna
        $produk = Produk::where('id', $id)->where('id_toko', $toko->id)->first();

        // Jika produk tidak ditemukan, kembalikan error
        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan atau bukan milik toko ini.'], 404);
        }

        // Hapus produk
        $produk->delete();

        return response()->json(['message' => 'Produk berhasil dihapus'], 200);
    }



    public function getProdukToOrder($toko_id)
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
