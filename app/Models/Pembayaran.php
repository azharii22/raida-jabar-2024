<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembayaran extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    protected $table = 'pembayarans';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $casts = [
        'id' => 'string',
    ];
    protected $fillable = [
        'user_id',
        'status_id',
        'tanggal_upload',
        'jumlah_terdaftar',
        'nominal',
        'file',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
}
