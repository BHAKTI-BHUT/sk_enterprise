<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'supplier_code',
        'name',
        'contact_person',
        'mobile',
        'email',
        'gst_number',
        'pan_number',
        'address',
        'city',
        'state',
        'pincode',
        'status',
        'credit_limit',
        'payment_terms',
        'opening_balance',
        'balance_type',
        'current_outstanding',
        'bank_name',
        'account_number',
        'ifsc_code',
        'upi_id'
    ];

    public function ledgers()
    {
        return $this->hasMany(SupplierLedger::class);
    }

    // Since Purchases and Payments are mentioned as features to be implemented later (future-ready)
    // We can define the relations if the models exist, otherwise we'll skip for now.
    // Let's check if Purchase and Payment models exist.
}
