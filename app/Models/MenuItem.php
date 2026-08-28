<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'type',
        'reference_id',
        'order',
        'is_active',
        'parent_id',
    ];

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }
    
    // Helper to get the actual URL based on type
    public function getUrlAttribute($value)
    {
        if ($this->type === 'category' && $this->reference_id) {
            // Needs the Category model, we'll assume it exists
            return route('shop.category', $this->reference_id); 
        }
        
        if ($this->type === 'route' && $value) {
            return route($value);
        }
        
        return $value ?? '#';
    }
}
