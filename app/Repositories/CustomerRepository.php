<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\CustomerLedger;
use Illuminate\Support\Facades\DB;

class CustomerRepository
{
    public function getAll()
    {
        return Customer::orderBy('created_at', 'desc');
    }

    public function findById($id)
    {
        return Customer::findOrFail($id);
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            $customer = Customer::create($data);

            if (isset($data['opening_balance']) && $data['opening_balance'] > 0) {
                $debit = $data['balance_type'] === 'dr' ? $data['opening_balance'] : 0;
                $credit = $data['balance_type'] === 'cr' ? $data['opening_balance'] : 0;
                $balance = $debit - $credit;

                CustomerLedger::create([
                    'customer_id' => $customer->id,
                    'transaction_date' => now(),
                    'transaction_type' => 'opening_balance',
                    'debit' => $debit,
                    'credit' => $credit,
                    'balance' => $balance,
                    'description' => 'Opening Balance'
                ]);

                $customer->update(['current_outstanding' => $balance]);
            }

            return $customer;
        });
    }

    public function update(Customer $customer, array $data)
    {
        return DB::transaction(function () use ($customer, $data) {
            $customer->update($data);
            // Future logic for outstanding calculation can be added here if needed
            return $customer;
        });
    }

    public function delete(Customer $customer)
    {
        return $customer->delete();
    }

    public function getAllLedgers()
    {
        return CustomerLedger::with('customer')->orderBy('transaction_date', 'desc');
    }
}
