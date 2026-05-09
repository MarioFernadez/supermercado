<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebOrder extends Model
{
    use HasFactory, \App\Traits\HasUuidV7;

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_address',
        'product_id',
        'total',
        'status',
        'payment_method',
        'items_json',
        'notes',
    ];

    protected $casts = [
        'items_json' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
