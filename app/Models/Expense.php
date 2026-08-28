<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuidV7;
use App\Traits\HasPygFormatting;

class Expense extends Model
{
    use HasFactory, HasUuidV7, HasPygFormatting;

    protected $fillable = [
        'expense_category_id',
        'user_id',
        'cash_session_id',
        'amount',
        'description',
        'date',
        'payment_method',
        'reference'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2'
    ];

    protected function getPygFields(): array
    {
        return ['amount'];
    }

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cashSession()
    {
        return $this->belongsTo(CashSession::class);
    }
}
