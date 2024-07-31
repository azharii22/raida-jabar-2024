<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Regency extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $table = 'regencies';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'name',
    ];

    public function villages()
    {
        return $this->hasMany(Villages::class, 'regency_id', 'id');
    }

    public function peserta()
    {
        return $this->hasMany(Peserta::class, 'regency_id', 'id');
    }
}
