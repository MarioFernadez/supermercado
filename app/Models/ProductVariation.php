<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuidV7;
use App\Traits\HasPygFormatting;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ProductVariation extends Model
{
    use HasFactory, HasUuidV7, HasPygFormatting;

    protected $fillable = [
        'product_id',
        'name',
        'sku',
        'price_cost',
        'price_sale',
        'stock',
        'is_active',
        'image_path'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'stock' => 'float',
        'price_cost' => 'integer',
        'price_sale' => 'integer',
    ];

    protected function getPygFields(): array
    {
        return ['price_cost', 'price_sale'];
    }

    protected function priceSale(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => $this->parsePyg($value),
        );
    }

    protected function priceCost(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => $this->parsePyg($value),
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
