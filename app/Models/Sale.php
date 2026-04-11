<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'customer_id',
        'sale_date',
        'total_amount',
        'tax_amount',
        'discount_amount',
        'payable_amount',
        'paid_amount',
        'due_amount',
        'payment_status',
        'payment_method',
        'notes',
        'created_by'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
