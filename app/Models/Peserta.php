<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peserta extends Model
{
    use HasFactory, SoftDeletes, Uuid;
    protected $table = 'pesertas';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $casts = [
        'id' => 'string',
    ];
    protected $fillable = [
        'user_id',
        'kategori_id',
        'status_id',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'ukuran_kaos',
        'no_hp',
        'agama',
        'golongan_darah',
        'riwayat_penyakit',
        'foto',
        'KTA',
        'asuransi_kesehatan',
        'sertif_sfh',
        'catatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
    
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
}
