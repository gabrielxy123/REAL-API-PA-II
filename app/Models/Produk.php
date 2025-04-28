<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'nama',
        'harga',
        'deskripsi',
        'id_user',
        'id_toko',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function toko() {
        return $this->belongsTo(Toko::class, 'id_toko');
    }
}

