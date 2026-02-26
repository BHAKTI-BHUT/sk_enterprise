<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'gst_number',
        'address',
        'city',
        'state',
        'pincode',
        'credit_limit',
        'opening_balance',
        'balance_type',
        'current_outstanding',
        'status'
    ];

    public function ledgers()
    {
        return $this->hasMany(CustomerLedger::class);
    }
}
