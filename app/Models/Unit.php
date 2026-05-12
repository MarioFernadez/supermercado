<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuidV7;

class Unit extends Model
{
    use HasFactory, HasUuidV7;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'abbreviation', 'is_active'];
}
