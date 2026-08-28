<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuidV7;

class BranchStock extends Model
{
    use HasFactory, HasUuidV7;

    protected $fillable = [
        'branch_id',
        'stockable_id',
        'stockable_type',
        'stock',
    ];

    protected $casts = [
        'stock' => 'float',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function stockable()
    {
        return $this->morphTo();
    }
}
