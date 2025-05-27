<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'toko_id',
        'transaksi_id',
        'kode_transaksi',
        'rating',
        'review',
    ];

    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who made the review
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the toko being reviewed
     */
    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    /**
     * Get the transaction being reviewed
     */
    public function transaksi()
    {
        return $this->belongsTo(Pesanan::class, 'transaksi_id', 'id');
    }

    /**
     * Scope for filtering by rating
     */
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Scope for filtering by toko
     */
    public function scopeByToko($query, $tokoId)
    {
        return $query->where('toko_id', $tokoId);
    }

    /**
     * Get average rating for a toko
     */
    public static function getAverageRating($tokoId)
    {
        return self::where('toko_id', $tokoId)->avg('rating');
    }

    /**
     * Get total reviews count for a toko
     */
    public static function getTotalReviews($tokoId)
    {
        return self::where('toko_id', $tokoId)->count();
    }

    /**
     * Get rating distribution for a toko
     */
    public static function getRatingDistribution($tokoId)
    {
        return self::where('toko_id', $tokoId)
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get();
    }
}