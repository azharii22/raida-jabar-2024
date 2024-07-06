<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tentang extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    protected $fillable = [
        'name',
        'user_id',
        'foto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
