<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasUuidV7;
use App\Traits\HasPygFormatting;

class CashSession extends Model
{
    use HasFactory, HasUuidV7, HasPygFormatting;

    protected $fillable = [
        'user_id',
        'cash_register_id',
        'opening_amount',
        'closing_amount',
        'calculated_amount',
        'difference',
        'opened_at',
        'closed_at',
        'status',
        'opening_notes',
        'notes',
    ];

    public function register()
    {
        return $this->belongsTo(CashRegister::class, 'cash_register_id');
    }

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
        'opening_amount' => 'integer',
        'closing_amount' => 'integer',
        'calculated_amount' => 'integer',
        'difference' => 'integer',
    ];

    protected function getPygFields(): array
    {
        return ['opening_amount', 'closing_amount', 'calculated_amount', 'difference'];
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function movements()
    {
        return $this->hasMany(CashMovement::class);
    }
}
