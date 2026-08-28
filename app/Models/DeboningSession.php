<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasUuidV7;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeboningSession extends Model
{
    use HasFactory, HasUuidV7;
    
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'raw_material_product_id',
        'user_id',
        'total_weight_start',
        'total_weight_yield',
        'waste_weight',
        'status',
        'notes',
    ];

    public function rawMaterial(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'raw_material_product_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(DeboningItem::class, 'deboning_session_id');
    }
}
