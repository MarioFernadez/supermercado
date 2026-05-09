<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuidV7;
use App\Traits\HasPygFormatting;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory, HasUuidV7, HasPygFormatting, \App\Traits\Searchable;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'description',
        'price_cost',
        'price_sale',
        'discount_percentage',
        'stock',
        'min_stock',
        'category_id',
        'supplier_id',
        'is_active',
        'unit_type',
        'manage_stock',
        'has_variations',
        'image_path',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'manage_stock' => 'boolean',
        'stock' => 'float',
        'min_stock' => 'float',
        'price_cost' => 'integer',
        'price_sale' => 'integer',
        'discount_percentage' => 'integer',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            if (empty($product->slug) || $product->isDirty('name')) {
                $slug = \Illuminate\Support\Str::slug($product->name);
                
                // Ensure uniqueness
                $originalSlug = $slug;
                $count = 1;
                while (static::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                    $slug = $originalSlug . '-' . $count;
                    $count++;
                }
                
                $product->slug = $slug;
            }
        });
    }

    /**
     * Get the fields that should be formatted as PYG.
     * 
     * @return array
     */
    protected function getPygFields(): array
    {
        return ['price_cost', 'price_sale'];
    }

    /**
     * Returns the effective sale price after applying the product discount.
     */
    public function getEffectivePriceAttribute(): int
    {
        if ($this->discount_percentage > 0) {
            return (int) round($this->price_sale * (1 - $this->discount_percentage / 100));
        }
        return $this->price_sale;
    }

    /*
     * Custom Accessors explicitly using the Trait helpers if needed, 
     * but the Trait toArray() handles serialization. 
     * However, for direct property access $product->price_sale_formatted,
     * we can add accessors.
     */

    protected function priceSale(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value, // Return raw integer when accessed directly
            set: fn ($value) => $this->parsePyg($value), // Clean input before saving
        );
    }

    protected function priceCost(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => $this->parsePyg($value),
        );
    }
    
    // Virtual attributes for formatted values
    protected function priceSaleFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->formatPyg($this->price_sale),
        );
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    /**
     * Get the total stock across all variations or the product stock if simple.
     */
    public function getTotalStockAttribute(): float
    {
        if ($this->has_variations) {
            return $this->variations()->where('is_active', true)->sum('stock');
        }
        return $this->stock;
    }
}
