<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuidV7;
use App\Traits\HasPygFormatting;

class Payment extends Model
{
    use HasFactory, HasUuidV7, HasPygFormatting;

    protected $fillable = [
        'sale_id',
        'method',
        'amount',
        'bank_name',
        'cheque_number',
        'due_date',
    ];

    protected function getPygFields(): array
    {
        return ['amount'];
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
