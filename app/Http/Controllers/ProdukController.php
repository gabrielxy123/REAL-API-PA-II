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


    public function store(Request $request)
    {
        //memastikan user login
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'nullable|numeric',
            'id_kategori' => 'required|exists:kategoris,id'
        ]);

        $userId = Auth::id();

        // Dapatkan toko milik pengguna
        $toko = Toko::where('userID', $userId)->first();

        // Jika pengguna tidak memiliki toko, kembalikan error
        if (!$toko) {
            return response()->json(['message' => 'Pengguna ini tidak memiliki toko.'], 404);
        }

        //Menyimpan produk
        $produks = Produk::create([
            'nama' => $validated['nama'],
            'harga' => $validated['harga'] ?? null,
            'id_user' => $userId,
            'id_toko' => $toko->id,
            'id_kategori' => $validated['id_kategori'],
        ]);

        return response()->json([
            'message' => 'Produk berhasil dibuat',  
            'data' => [
                'id' => $produks->id,
                'nama' => $produks->nama,
                'harga' => $produks->harga,
                'id_user' => $produks->id_user,
                'id_toko' => $produks->id_toko,
                'id_kategori' => $produks->id_kategori,
                'kategori' => $produks->kategori->kategori, // Asumsi ada kolom 'kategori' di tabel kategoris
                'updated_at' => $produks->updated_at,
                'created_at' => $produks->created_at,
            ],
        ], 201);
    }
}
