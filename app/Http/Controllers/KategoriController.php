<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index() {
        $kategori = Kategori::all();
        return response()->json([
            'message'=>'Kategori berhasil diambil',
            'data' => $kategori,
        ], 200);
    }
}
