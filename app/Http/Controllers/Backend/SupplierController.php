<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\SupplierRequest;
use App\Models\Supplier;
use App\Services\SupplierService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    protected $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $suppliers = $this->supplierService->getAll($request);

            return DataTables::of($suppliers)
                ->editColumn('status', function ($supplier) {
                    $badge = $supplier->status === 'active' ? 'bg-success' : 'bg-danger';
                    return '<span class="badge ' . $badge . '">' . ucfirst($supplier->status) . '</span>';
                })
                ->addColumn('action', function ($supplier) {
                    return view('partials.action-buttons', [
                        'id' => $supplier->id,
                        'edit_route' => route('supplier.edit', $supplier->id),
                        'delete_route' => route('supplier.destroy', $supplier->id),
                        'view_route' => route('supplier.show', $supplier->id),
                        'edit_in_drawer' => false,
                        'view_in_drawer' => false
                    ])->render();
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('Backend.Supplier.Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Backend.Supplier.Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request)
    {
        $this->supplierService->store($request->validated());

        if ($request->ajax()) {
            return response()->json(['message' => 'Supplier created successfully!']);
        }

        return redirect()->route('supplier.index')->with('success', 'Supplier created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        $ledgers = $this->supplierService->getLedgers($supplier->id);
        return view('Backend.Supplier.Show', compact('supplier', 'ledgers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('Backend.Supplier.Edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $this->supplierService->update($supplier, $request->validated());

        if ($request->ajax()) {
            return response()->json(['message' => 'Supplier updated successfully!']);
        }

        return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $this->supplierService->delete($supplier);

        if (request()->ajax()) {
            return response()->json(['message' => 'Supplier deleted successfully!']);
        }

        return redirect()->route('supplier.index')->with('success', 'Supplier deleted successfully!');
    }

    /**
     * Display a listing of all supplier transactions.
     */
    public function ledger(Request $request)
    {
        if ($request->ajax()) {
            $ledgers = $this->supplierService->getAllLedgers();

            return DataTables::of($ledgers)
                ->editColumn('transaction_date', function ($ledger) {
                    return $ledger->transaction_date ? \Carbon\Carbon::parse($ledger->transaction_date)->format('d-m-Y') : '—';
                })
                ->addColumn('supplier_name', function ($ledger) {
                    return $ledger->supplier->name ?? '—';
                })
                ->editColumn('debit', function ($ledger) {
                    return '₹' . number_format($ledger->debit, 2);
                })
                ->editColumn('credit', function ($ledger) {
                    return '₹' . number_format($ledger->credit, 2);
                })
                ->editColumn('running_balance', function ($ledger) {
                    $color = $ledger->running_balance > 0 ? 'text-danger' : 'text-success';
                    return '<span class="' . $color . '">₹' . number_format(abs($ledger->running_balance), 2) . '</span>';
                })
                ->rawColumns(['running_balance'])
                ->make(true);
        }

        return view('Backend.Supplier.Ledger');
    }

    /**
     * Toggle status of the supplier.
     */
    public function toggleStatus(Supplier $supplier)
    {
        $this->supplierService->toggleStatus($supplier);

        return response()->json([
            'message' => 'Supplier status updated!',
            'status' => $supplier->status
        ]);
    }
}
