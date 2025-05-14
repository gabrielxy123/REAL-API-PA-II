<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananKiloanDetail extends Model
{
    protected $fillable = ['id_pesanan_kiloan', 'id_produk', 'nama_barang', 'quantity'];

    public function pesananKiloan()
    {
        return $this->belongsTo(PesananKiloan::class, 'id_pesanan_kiloan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
