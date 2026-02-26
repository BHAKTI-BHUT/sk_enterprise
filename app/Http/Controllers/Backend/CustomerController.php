<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CustomerRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $customers = $this->customerService->getAll();

            return DataTables::of($customers)
                ->editColumn('status', function ($customer) {
                    $checked = $customer->status === 'active' ? 'checked' : '';
                    return '<div class="form-check form-switch card-switch d-flex align-items-center justify-content-center">
                                <input class="form-check-input update-status" type="checkbox" role="switch" 
                                    data-url="' . route('customer.toggle-status', $customer->id) . '" ' . $checked . '>
                            </div>';
                })
                ->addColumn('action', function ($customer) {
                    return view('partials.action-buttons', [
                        'id' => $customer->id,
                        'edit_route' => route('customer.edit', $customer->id),
                        'delete_route' => route('customer.destroy', $customer->id),
                        'view_route' => route('customer.show', $customer->id),
                        'edit_in_drawer' => false,
                        'view_in_drawer' => false
                    ])->render();
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('Backend.Customer.Index');
    }

    public function create()
    {
        return view('Backend.Customer.Create');
    }

    public function store(CustomerRequest $request)
    {
        $this->customerService->store($request->validated());

        if ($request->ajax()) {
            return response()->json(['message' => 'Customer created successfully!']);
        }

        return redirect()->route('customer.index')->with('success', 'Customer created successfully!');
    }

    public function show(Customer $customer)
    {
        return view('Backend.Customer.Show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('Backend.Customer.Edit', compact('customer'));
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $this->customerService->update($customer, $request->validated());

        if ($request->ajax()) {
            return response()->json(['message' => 'Customer updated successfully!']);
        }

        return redirect()->route('customer.index')->with('success', 'Customer updated successfully!');
    }

    public function destroy(Customer $customer)
    {
        $this->customerService->delete($customer);

        if (request()->ajax()) {
            return response()->json(['message' => 'Customer deleted successfully!']);
        }

        return redirect()->route('customer.index')->with('success', 'Customer deleted successfully!');
    }

    public function ledger(Request $request)
    {
        if ($request->ajax()) {
            $ledgers = $this->customerService->getAllLedgers();

            return DataTables::of($ledgers)
                ->editColumn('transaction_date', function ($ledger) {
                    return $ledger->transaction_date ? \Carbon\Carbon::parse($ledger->transaction_date)->format('d-m-Y') : '—';
                })
                ->addColumn('customer_name', function ($ledger) {
                    return $ledger->customer->name ?? '—';
                })
                ->editColumn('debit', function ($ledger) {
                    return '₹' . number_format($ledger->debit, 2);
                })
                ->editColumn('credit', function ($ledger) {
                    return '₹' . number_format($ledger->credit, 2);
                })
                ->editColumn('balance', function ($ledger) {
                    $color = $ledger->balance > 0 ? 'text-danger' : 'text-success';
                    return '<span class="' . $color . '">₹' . number_format($ledger->balance, 2) . '</span>';
                })
                ->rawColumns(['balance'])
                ->make(true);
        }

        return view('Backend.Customer.Ledger');
    }

    public function toggleStatus(Customer $customer)
    {
        $customer->status = $customer->status === 'active' ? 'inactive' : 'active';
        $customer->save();

        return response()->json(['message' => 'Customer status updated!', 'status' => $customer->status]);
    }
}
