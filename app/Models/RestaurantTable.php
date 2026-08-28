<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantTable extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status', 'current_sale_id'];

    public function currentSale()
    {
        return $this->belongsTo(Sale::class, 'current_sale_id');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
