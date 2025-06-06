<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $fillable = [
        'id_produk',
        'id_user',
        'id_toko',
        'nama_produk',
        'kategori',
        'status',
        'catatan',
        'harga',
        'quantity',
        'subtotal',
        'kode_transaksi',
        'id_pesanan_kiloan'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }

    public function layananTambahan()
    {
        return $this->belongsToMany(Layanan::class, 'pesanan_layanan_tambahan', 'id_pesanan', 'id_layanan');
    }

    public function pesananKiloan()
    {
        return $this->belongsTo(PesananKiloan::class, 'id_pesanan_kiloan');
    }
}
