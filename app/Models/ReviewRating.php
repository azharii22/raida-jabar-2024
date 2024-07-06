<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewRating extends Model
{
    use HasFactory, Uuid;
    public $incrementing = false;
    protected $table = 'review_ratings';
    protected $keyType = 'string';
    protected $fillable = [
        'dokumentasi_id',
        'artikel_id',
        'nama',
        'comments',
        'star_rating',
        'status'
    ];

    public function artikel()
    {
        return $this->belongsTo(Artikel::class);
    }
}
