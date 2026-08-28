<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasUuidV7;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeboningItem extends Model
{
    use HasFactory, HasUuidV7;
    
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'deboning_session_id',
        'product_id',
        'weight',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(DeboningSession::class, 'deboning_session_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
