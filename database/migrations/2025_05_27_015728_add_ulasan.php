<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('toko_id')->constrained()->onDelete('cascade');
            $table->foreignId('transaksi_id')->constrained('pesanan')->onDelete('cascade'); // Menggunakan ID transaksi sebagai FK
            $table->string('kode_transaksi'); // Menyimpan kode transaksi untuk referensi
            $table->integer('rating')->unsigned()->comment('Rating 1-5 bintang');
            $table->text('review')->nullable()->comment('Teks ulasan dari user');
            $table->timestamps();

            // Ensure one review per transaction per user
            $table->unique(['user_id', 'transaksi_id']);

            // Index for better performance
            $table->index(['toko_id', 'rating']);
            $table->index(['kode_transaksi']);
            $table->index(['transaksi_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
