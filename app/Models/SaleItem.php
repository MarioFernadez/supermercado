<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuidV7;
use App\Traits\HasPygFormatting;

class SaleItem extends Model
{
    use HasFactory, HasUuidV7, HasPygFormatting;

    protected $fillable = [
        'sale_id',
        'product_id',
        'product_variation_id',
        'product_name',
        'quantity',
        'price_unit',
        'subtotal',
    ];

    protected $casts = [
        'quantity' => 'float',
    ];

    protected function getPygFields(): array
    {
        return ['price_unit', 'subtotal'];
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variation()
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }
}
