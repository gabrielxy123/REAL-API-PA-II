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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->decimal('harga', 10, 2);
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_toko');
            $table->unsignedBigInteger('id_kategori');
            $table->timestamps();

            //Foreign Key
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_toko')->references('id')->on('tokos')->onDelete('cascade');
            $table->foreign('id_kategori')->references('id')->on('kategoris')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
