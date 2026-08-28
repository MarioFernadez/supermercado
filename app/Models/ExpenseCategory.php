<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuidV7;

class ExpenseCategory extends Model
{
    use HasFactory, HasUuidV7;

    protected $fillable = ['name', 'description', 'is_active'];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
