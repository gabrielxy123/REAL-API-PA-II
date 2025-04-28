<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    //
    public function index() {
        $produks =  Produk::all();
        return response()->json($produks);
    }

    public function store(Request $request){
        //memastikan user login
        if(!Auth::check()){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $userId = Auth::id();

        //Menyimpan produk
        $produks = Produk::create([
            'nama' => $validated['nama'],
            'harga' => $validated['harga'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'id_user' => $userId,
            'id_toko' => $userId,
        ]);

        return response()->json([
            'message' => 'Produk berhasil dibuat',
            'data' => $produks,
        ], 201);
    }
}
