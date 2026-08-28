<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuidV7;

class StoreSetting extends Model
{
    use HasFactory, HasUuidV7;

    protected $fillable = [
        'key',
        'value',
        'description',
    ];

    protected static function booted()
    {
        static::saved(function ($setting) {
            \Illuminate\Support\Facades\Cache::forget('store_setting_' . $setting->key);
            \Illuminate\Support\Facades\Cache::forget('store_business_type');
        });

        static::deleted(function ($setting) {
            \Illuminate\Support\Facades\Cache::forget('store_setting_' . $setting->key);
            \Illuminate\Support\Facades\Cache::forget('store_business_type');
        });
    }
}
