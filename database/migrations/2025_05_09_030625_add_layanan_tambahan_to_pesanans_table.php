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
        Schema::table('pesanan', function (Blueprint $table) {
            $table->unsignedBigInteger('layanan_tambahan')->nullable()->after('catatan');

            $table->foreign('layanan_tambahan')
                ->references('id')
                ->on('layanans')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropForeign(['layanan_tambahan']);
            $table->dropColumn('layanan_tambahan');
        });
    }
};
