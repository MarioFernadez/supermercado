<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuidV7;

class CashMovement extends Model
{
    use HasFactory, HasUuidV7;

    protected $fillable = [
        'cash_session_id',
        'type', // in, out
        'category',
        'amount',
        'description',
        'reference'
    ];

    // Category constants
    const CATEGORIES = [
        'in' => [
            'devolución_préstamo' => 'Devolución de Préstamo',
            'otro' => 'Otro',
        ],
        'out' => [
            'préstamo' => 'Préstamo',
            'otro' => 'Otro',
        ],
    ];

    public function getCategoryLabel()
    {
        if (!$this->category) {
            return 'Sin categoría';
        }

        $categories = self::CATEGORIES[$this->type] ?? [];
        return $categories[$this->category] ?? ucfirst($this->category);
    }

    public function session()
    {
        return $this->belongsTo(CashSession::class, 'cash_session_id');
    }}
