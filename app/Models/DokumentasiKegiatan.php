<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DokumentasiKegiatan extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $table = 'dokumentasi_kegiatans';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $casts = [
        'id' => 'string',
    ];
    protected $fillable = [
        'user_id',
        'judul',
        'cover',
        'foto',
    ];

    public function image()
    {
        // return $this->hasMany(ImageUpload::class, 'dokumentasi_id', 'id');
    }
}
