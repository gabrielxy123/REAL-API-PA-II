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
    ];

    //relasi ke tabel user
    public function user() {
        return $this->belongsTo(User::class, 'userID');
    }
}
