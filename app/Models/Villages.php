<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Villages extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $table = 'villages';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'regency_id',
        'name',
    ];

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }
    
    public function peserta()
    {
        return $this->hasMany(Peserta::class, 'villages_id', 'id');
    }
}
