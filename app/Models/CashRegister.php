<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CashRegister extends Model
{
    use HasFactory, HasUuids, \App\Traits\Searchable;

    protected $fillable = [
        'name',
        'active',
        'description',
        'branch_id',
    ];

    public function sessions()
    {
        return $this->hasMany(CashSession::class);
    }

    public function currentSession()
    {
        return $this->hasOne(CashSession::class)
            ->where('status', 'open')
            ->whereHas('user', function($query) {
                $query->whereNull('deleted_at');
            });
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
