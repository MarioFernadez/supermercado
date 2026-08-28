<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuidV7;

class PaymentMethod extends Model
{
    use HasFactory, HasUuidV7;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'type', 'is_active'];

    protected static function booted()
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('active_payment_methods');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('active_payment_methods');
        });
    }
}
