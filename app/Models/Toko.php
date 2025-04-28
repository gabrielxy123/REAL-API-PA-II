<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    protected $fillable = [
        'userID',
        'nama',
        'noTelp',
        'email',
        'deskripsi',
        'jalan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'waktuBuka',
        'waktuTutup',
        'status',
        'buktiBayar'
    ];

    //relasi ke tabel user
    public function user() {
        return $this->belongsTo(User::class, 'userID');
    }

    public function tokos() {
        return $this->hasMany(Produk::class, 'id');
    }

    //accessor untuk buktiBayar
    public function getBuktiBayarAttribute($value){
        if(!$value) return null;

        return filter_var($value, FILTER_VALIDATE_URL)
            ? $value
            : url('storage/bukti_pembayaran/' . $value);
    }
}
