<?php

namespace App\Repositories;

use App\Models\Supplier;
use App\Models\SupplierLedger;
use Illuminate\Support\Facades\DB;

class SupplierRepository
{
    public function getAll($request = null)
    {
        $query = Supplier::orderBy('created_at', 'desc');

        if ($request) {
            if ($request->has('status') && !empty($request->status)) {
                $query->where('status', $request->status);
            }
        }

        return $query;
    }

    public function findById($id)
    {
        return Supplier::findOrFail($id);
    }

    public function generateSupplierCode()
    {
        $lastSupplier = Supplier::orderBy('id', 'desc')->first();
        if (!$lastSupplier) {
            return 'SUP-0001';
        }
        $lastId = $lastSupplier->id;
        $nextId = $lastId + 1;
        return 'SUP-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            $data['supplier_code'] = $this->generateSupplierCode();
            $supplier = Supplier::create($data);

            if (isset($data['opening_balance']) && $data['opening_balance'] > 0) {
                $debit = $data['balance_type'] === 'dr' ? $data['opening_balance'] : 0;
                $credit = $data['balance_type'] === 'cr' ? $data['opening_balance'] : 0;

                // For suppliers: Credit increases outstanding, Debit decreases it.
                // Outstanding = Total Credit - Total Debit
                $runningBalance = $credit - $debit;

                SupplierLedger::create([
                    'supplier_id' => $supplier->id,
                    'transaction_type' => 'opening_balance',
                    'debit' => $debit,
                    'credit' => $credit,
                    'running_balance' => $runningBalance,
                    'transaction_date' => now(),
                    'description' => 'Opening Balance'
                ]);

                $supplier->update(['current_outstanding' => $runningBalance]);
            }

            return $supplier;
        });
    }

    public function update(Supplier $supplier, array $data)
    {
        return DB::transaction(function () use ($supplier, $data) {
            $supplier->update($data);
            return $supplier;
        });
    }

    public function delete(Supplier $supplier)
    {
        return $supplier->delete();
    }

    public function toggleStatus(Supplier $supplier)
    {
        $supplier->status = $supplier->status === 'active' ? 'inactive' : 'active';
        $supplier->save();
        return $supplier;
    }

    public function getLedgers($supplierId)
    {
        return SupplierLedger::where('supplier_id', $supplierId)
            ->orderBy('transaction_date', 'asc')
            ->orderBy('id', 'asc')
            ->get();
    }

    public function getAllLedgers()
    {
        return SupplierLedger::with('supplier')->orderBy('transaction_date', 'desc');
    }
}
