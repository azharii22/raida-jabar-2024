<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalKegiatan extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    protected $table = 'jadwal_kegiatans';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $casts = [
        'id' => 'string',
    ];
    protected $fillable = [
        'user_id',
        'tanggal_giat',
        'file',
        'filename',
    ];
}
