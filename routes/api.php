<?php

use App\Http\Controllers\NotaController;
use App\Http\Controllers\NotaPengusahaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AkunUserController;
use App\Http\Controllers\FcmTokenController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LayananContrroller;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\TransaksiController;
use App\Models\Layanan;

// User authentication routes
Route::post("/register", [AuthController::class, 'register']);
Route::post("/login", [AuthController::class, 'login']);
Route::get("/index-toko-user", [TokoController::class, 'indexUser']);
Route::get("/index-dashboard-user", [TokoController::class, 'indexUser']);
Route::get("/detail-toko-user/{id_toko}", [AkunUserController::class, 'getTokoPublic']);
Route::get("/produks-user/{id_toko}", [ProdukController::class, 'getProdukByToko']);
Route::get("/order-kategoris", [KategoriController::class, 'indexToOrder']);
Route::get("/order-produks/{id_toko}", [ProdukController::class, 'getProdukToOrder']);
Route::get("/layanan-produks/{id_toko}", [LayananContrroller::class, 'getLayananToOrder']);
Route::get("/layanan-user/{id_toko}", [LayananContrroller::class, 'getLayananToToko']);



// Protected routes requiring authentication
Route::middleware('auth:sanctum')->group(function () {
    // User profile routes
    Route::get('/user-profil', [AkunUserController::class, 'getUserProfile']);
    Route::post('/update-profile', [AkunUserController::class, 'updateProfile']);
    Route::post('/update-profile-image', [AkunUserController::class, 'updateProfileImage']);
    Route::post('/update-profile-image-url', [AkunUserController::class, 'updateProfileImageUrl']);

    // Default user route
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Profile Image Upload Route
    Route::post('/upload-profile-image', [UserController::class, 'uploadProfileImage']);

    // Route untuk mendaftar toko 
    Route::post("/store", [TokoController::class, 'store']);
    Route::post("/update-store", [TokoController::class, 'update']);

    // ADMIN //

    // Route untuk daftar toko
    Route::get("/index-toko", [TokoController::class, 'index']);
    Route::get('/tokos/{id}/bukti-bayar', [TokoController::class, 'getBuktiBayar']);

    //--------//

    //Route untuk mengupload bukti pembayaran
    Route::post('/upload-bukti-bayar', [TokoController::class, 'uploadBuktiPembayaran']);

    //Route untuk approve dan reject
    Route::put('/{id}/approve', [TokoController::class, 'approve']);
    Route::put('/{id}/reject', [TokoController::class, 'reject']);


    //Route untuk menampilkan detail toko milik user
    Route::get("/toko-saya", [AkunUserController::class, 'getTokoByUser']);

    //Route untuk CRUD Produk
    Route::post("/tambah-produk", [ProdukController::class, 'store']);
    Route::get("/kategoris", [KategoriController::class, 'index']);
    Route::get("/produks", [ProdukController::class, 'index']);
    Route::put("/edit-produk/{id}", [ProdukController::class, 'update']);
    Route::delete("/delete-produk/{id}", [ProdukController::class, 'destroy']);


    //Pemesanan
    Route::post("/pesanan/{id}", [PemesananController::class, 'store']);

    //Notifikasi
    

    //Tes Transaksi
    Route::post("/transaksi", [TransaksiController::class, 'store']);
    Route::get('/transaksi/riwayat', [TransaksiController::class, 'riwayatTransaksi']);

    //Nota
    Route::get("/nota", [NotaController::class, 'indexNota']);
    Route::get("/nota/{id}", [NotaController::class, 'detailNota']);

    Route::get('/pengusaha/transaksi', [NotaPengusahaController::class, 'index']);
    Route::get('/pengusaha/transaksi/{kodeTransaksi}', [NotaPengusahaController::class, 'detail']);
    Route::post('/pengusaha/transaksi/{kodeTransaksi}/proses', [NotaPengusahaController::class, 'prosesPesanan']);
    Route::post('/pengusaha/transaksi/{kodeTransaksi}/update-kiloan', [NotaPengusahaController::class, 'updatePesananKiloan']);
    Route::post('/pengusaha/transaksi/{kodeTransaksi}/tolak', [NotaPengusahaController::class, 'tolakPesanan']);


    

    //Route layanan tambahana
    Route::post("/tambah-layanan", [LayananContrroller::class, 'store']);
    Route::get("/layanan", [LayananContrroller::class, 'index']);
    Route::put("/edit-layanan/{id}", [LayananContrroller::class, 'update']);
    Route::delete("/delete-layanan/{id}", [LayananContrroller::class, 'destroy']);



    //Notifikasi
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'delete']);
});

// Test routes for Postman
Route::get("/produk_toko/{id}", [PemesananController::class, 'produkToko']);
Route::get("/index", [AuthController::class, 'index']);
Route::get("/show/{id}", [AuthController::class, 'show']);
