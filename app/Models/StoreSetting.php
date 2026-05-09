<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuidV7;

class StoreSetting extends Model
{
    use HasFactory, HasUuidV7;

    protected $fillable = [
        'key',
        'value',
        'description',
    ];
}
