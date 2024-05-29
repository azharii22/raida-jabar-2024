<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageUpload extends Model
{
    use HasFactory, SoftDeletes, Uuid;
    public $incrementing = false;
    protected $table = 'image_uploads';
    protected $keyType = 'string';
    protected $fillable = [
        'user_id',
        'dokumentasi_id',
        'original_filename',
        'filename',
    ];

    function dokumentasi()
    {
        return $this->belongsTo(DokumentasiKegiatan::class, 'dokumentasi_id', 'id');
    }
}
