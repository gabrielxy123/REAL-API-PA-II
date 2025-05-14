<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananKiloan extends Model
{
    protected $table = 'pesanan_kiloan';
    protected $fillable = ['jumlah_kiloan', 'harga_kiloan'];

    public function details()
    {
        return $this->hasMany(PesananKiloanDetail::class, 'id_pesanan_kiloan');
    }

    public function pesanan()
    {
        return $this->hasOne(Pesanan::class, 'id_pesanan_kiloan');
    }

    public function layananTambahan()
    {
        return $this->belongsToMany(Layanan::class, 'pesanan_layanan_tambahan');
    }
}
