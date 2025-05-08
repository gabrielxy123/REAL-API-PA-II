<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotaController extends Controller
{
    //Menampilkan Nota pemesanan kepada user yang login
    public function indexNota()
    {
        $userId = Auth::id();

        // Ambil semua pesanan milik user ini
        $pesanan = Pesanan::where('id_user', $userId)->get();

        if ($pesanan->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada pesanan ditemukan',
                'data' => []
            ], 404);
        }

        return response()->json([
            'message' => 'Data nota berhasil diambil',
            'data' => $pesanan
        ], 200);
    }

    public function detailNota($id)
{
    $userId = Auth::id();
    $pesanan = Pesanan::where('id', $id)->where('id_user', $userId)->first();

    if (!$pesanan) {
        return response()->json([
            'message' => 'Pesanan tidak ditemukan atau bukan milik Anda',
            'data' => []
        ], 404);
    }

    return response()->json([
        'message' => 'Detail nota berhasil diambil',
        'data' => $pesanan
    ], 200);
}

}
