<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerLedger extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'transaction_date',
        'transaction_type',
        'reference_no',
        'debit',
        'credit',
        'balance',
        'description'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
