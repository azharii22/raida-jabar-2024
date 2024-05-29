<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'key',
        'value',
    ];


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'    => 'string',
        'key'   => 'string',
        'value' => 'string',
    ];

    public static function chargeConfig()
    {
        $settings = Cache::get('db_setting', []);

        if ($settings instanceof Collection) {
            collect($settings)
                ->each(fn ($setting) => app('config')
                    ->set(['settings.' . $setting->key => $setting->value]));
        }

        return $settings;
    }

    public static function refreshCache()
    {
        Cache::forget('db_setting');
        Cache::rememberForever('db_setting', fn () => static::query()->get()->toBase());

        return self::chargeConfig();
    }
}
