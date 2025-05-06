<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AkunUserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\UserController;

// User authentication routes
Route::post("/register", [AuthController::class, 'register']);
Route::post("/login", [AuthController::class, 'login']);
Route::get("/index-toko-user", [TokoController::class, 'indexUser']);
Route::get("/index-dashboard-user", [TokoController::class, 'indexUser']);
Route::get("/detail-toko-user/{id_toko}", [AkunUserController::class, 'getTokoPublic']);
Route::get("/produks-user/{id_toko}", [ProdukController::class, 'getProdukByToko']);
Route::get("/order-kategoris", [KategoriController::class, 'indexToOrder']);
Route::get("/order-produks/{id_toko}", [ProdukController::class, 'getProdukToOrder']);


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
});

// Test routes for Postman
Route::get("/index", [AuthController::class, 'index']);
Route::get("/show/{id}", [AuthController::class, 'show']);
