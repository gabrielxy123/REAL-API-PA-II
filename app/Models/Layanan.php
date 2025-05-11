<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $fillable = [
        'nama',
        'harga',
        'id_user',
        'id_toko',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'layanan_tambahan');
    }
    public function pesanan()
    {
        return $this->belongsToMany(Pesanan::class, 'pesanan_layanan_tambahan', 'id_layanan', 'id_pesanan');
    }
}
