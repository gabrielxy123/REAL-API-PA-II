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
        Schema::create('pesanan_kiloan_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pesanan_kiloan');
            $table->unsignedBigInteger('id_produk')->nullable(); // produk kiloan
            $table->string('nama_barang');
            $table->timestamps();

            $table->foreign('id_pesanan_kiloan')->references('id')->on('pesanan_kiloan')->onDelete('cascade');
            $table->foreign('id_produk')->references('id')->on('produks')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_kiloan');
    }
};
