<?php

namespace App\Services;

use App\Models\Supplier;
use App\Repositories\SupplierRepository;
use Illuminate\Http\Request;

class SupplierService
{
    protected $supplierRepository;

    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function getAll(Request $request = null)
    {
        return $this->supplierRepository->getAll($request);
    }

    public function findById($id)
    {
        return $this->supplierRepository->findById($id);
    }

    public function store(array $data)
    {
        return $this->supplierRepository->store($data);
    }

    public function update(Supplier $supplier, array $data)
    {
        return $this->supplierRepository->update($supplier, $data);
    }

    public function delete(Supplier $supplier)
    {
        return $this->supplierRepository->delete($supplier);
    }

    public function toggleStatus(Supplier $supplier)
    {
        return $this->supplierRepository->toggleStatus($supplier);
    }

    public function getLedgers($supplierId)
    {
        return $this->supplierRepository->getLedgers($supplierId);
    }

    public function getAllLedgers()
    {
        return $this->supplierRepository->getAllLedgers();
    }

    public function calculateOutstanding(Supplier $supplier)
    {
        // Future logic for outstanding calculation.
        // Sum of all credits minus sum of all debits from all transactions.
        $totalCredit = $supplier->ledgers()->sum('credit');
        $totalDebit = $supplier->ledgers()->sum('debit');
        $outstanding = $totalCredit - $totalDebit;

        $supplier->update(['current_outstanding' => $outstanding]);
        return $outstanding;
    }
}
