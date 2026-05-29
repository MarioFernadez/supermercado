<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuidV7;
use App\Traits\HasPygFormatting;

class Sale extends Model
{
    use HasFactory, HasUuidV7, HasPygFormatting;

    protected $fillable = [
        'customer_id',
        'user_id',
        'seller_id',
        'total',
        'subtotal_before_discount',
        'discount_amount',
        'tax_10',
        'tax_5',
        'tax_exempt',
        'status',
        'payment_condition',
        'web_order_id',
        'branch_id',
    ];

    /**
     * Get the fields that should be formatted as PYG.
     * 
     * @return array
     */
    protected function getPygFields(): array
    {
        return ['total', 'subtotal_before_discount', 'discount_amount', 'tax_10', 'tax_5', 'tax_exempt'];
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class)->withTrashed();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class)->withTrashed();
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function webOrder()
    {
        return $this->belongsTo(WebOrder::class);
    }

    /**
     * Virtual Invoice Number Accessor
     * Generates a sequential number based on ID sorting (since we use Ordered UUIDs)
     */
    public function getInvoiceNumberAttribute()
    {
        // Count how many sales exist with an ID 'smaller' (older) than this one
        // This effectively gives us the row number / sequence
        $count = static::where('id', '<', $this->id)->count() + 1;
        
        // Return 6-digit padded string (e.g., 000123)
        return str_pad($count, 6, '0', STR_PAD_LEFT);
    }
}
