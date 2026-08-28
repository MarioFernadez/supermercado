<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waiter extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'active'];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
