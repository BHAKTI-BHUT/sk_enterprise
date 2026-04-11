@extends('partials.layouts.master')

@section('title', 'Supplier Ledger | Herozi')

@section('sub-title', 'Supplier View')
@section('pagetitle', 'Suppliers')

@section('content')

    <div class="row g-4">
        <!-- Supplier Profile Summary -->
        <div class="col-xl-4 col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="avatar-lg mx-auto mb-3">
                            <div class="avatar-title bg-soft-primary text-primary rounded-circle fs-24 fw-bold">
                                {{ substr($supplier->name, 0, 1) }}
                            </div>
                        </div>
                        <h5 class="mb-1 fw-bold">{{ $supplier->name }}</h5>
                        <p class="text-muted mb-0">{{ $supplier->supplier_code }}</p>
                        <span class="badge {{ $supplier->status == 'active' ? 'bg-success' : 'bg-danger' }} mt-2">
                            {{ ucfirst($supplier->status) }}
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-borderless table-sm mb-0">
                            <tbody>
                                <tr>
                                    <th class="ps-0" scope="row">Contact:</th>
                                    <td class="text-muted">{{ $supplier->contact_person ?: '—' }}</td>
                                </tr>
                                <tr>
                                    <th class="ps-0" scope="row">Mobile:</th>
                                    <td class="text-muted">{{ $supplier->mobile }}</td>
                                </tr>
                                <tr>
                                    <th class="ps-0" scope="row">Email:</th>
                                    <td class="text-muted">{{ $supplier->email ?: '—' }}</td>
                                </tr>
                                <tr>
                                    <th class="ps-0" scope="row">GST:</th>
                                    <td class="text-muted">{{ $supplier->gst_number ?: '—' }}</td>
                                </tr>
                                <tr>
                                    <th class="ps-0" scope="row">Address:</th>
                                    <td class="text-muted">{{ $supplier->address ?: '—' }}, {{ $supplier->city }},
                                        {{ $supplier->state }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <hr class="my-4">

                    <h6 class="fs-14 mb-3 fw-semibold text-uppercase">Financial Summary</h6>
                    <div class="row g-3">
                        <div class="col-6">
                            <p class="text-muted mb-1 fs-12">Credit Limit</p>
                            <h6 class="mb-0">₹{{ number_format($supplier->credit_limit, 2) }}</h6>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-1 fs-12">Payment Terms</p>
                            <h6 class="mb-0">{{ $supplier->payment_terms }} Days</h6>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="p-3 bg-light rounded-3 border">
                                <p class="text-muted mb-1 fs-12">Current Outstanding</p>
                                <h4 class="mb-0 {{ $supplier->current_outstanding > 0 ? 'text-danger' : 'text-success' }}">
                                    ₹{{ number_format(abs($supplier->current_outstanding), 2) }}
                                    <small
                                        class="fs-12 text-muted fw-normal">({{ $supplier->current_outstanding >= 0 ? 'Payable' : 'Receivable' }})</small>
                                </h4>
                            </div>
                        </div>
                    </div>

                    @if ($supplier->bank_name)
                        <hr class="my-4">
                        <h6 class="fs-14 mb-3 fw-semibold text-uppercase">Bank Details</h6>
                        <div class="table-responsive">
                            <table class="table table-borderless table-sm mb-0">
                                <tbody>
                                    <tr>
                                        <th class="ps-0" scope="row">Bank:</th>
                                        <td class="text-muted">{{ $supplier->bank_name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">A/C No:</th>
                                        <td class="text-muted">{{ $supplier->account_number }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">IFSC:</th>
                                        <td class="text-muted">{{ $supplier->ifsc_code }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Supplier Ledger -->
        <div class="col-xl-8 col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0 fw-bold"><i class="ri-FileList-line align-bottom me-1 text-primary"></i>
                        Transaction Ledger</h5>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-soft-secondary" type="button"><i
                                class="ri-printer-line align-bottom"></i> Print</button>
                        <a href="{{ route('supplier.index') }}" class="btn btn-sm btn-outline-secondary"><i
                                class="ri-arrow-left-line align-bottom"></i> Back</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-nowrap align-middle mb-0">
                            <thead class="bg-light bg-opacity-50">
                                <tr>
                                    <th class="ps-4">Date</th>
                                    <th>Ref. No</th>
                                    <th>Type</th>
                                    <th class="text-end">Debit (Dr)</th>
                                    <th class="text-end">Credit (Cr)</th>
                                    <th class="text-end pe-4">Running Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ledgers as $ledger)
                                    <tr>
                                        <td class="ps-4">{{ date('d-m-Y', strtotime($ledger->transaction_date)) }}</td>
                                        <td><span class="text-muted">#{{ $ledger->reference_no ?: 'N/A' }}</span></td>
                                        <td>
                                            @php
                                                $badgeClass =
                                                    [
                                                        'opening_balance' => 'bg-soft-info text-info',
                                                        'purchase' => 'bg-soft-primary text-primary',
                                                        'payment' => 'bg-soft-success text-success',
                                                        'purchase_return' => 'bg-soft-warning text-warning',
                                                    ][$ledger->transaction_type] ?? 'bg-soft-secondary text-secondary';
                                            @endphp
                                            <span class="badge {{ $badgeClass }} text-uppercase fs-10">
                                                {{ str_replace('_', ' ', $ledger->transaction_type) }}
                                            </span>
                                        </td>
                                        <td class="text-end text-danger">
                                            {{ $ledger->debit > 0 ? '₹' . number_format($ledger->debit, 2) : '—' }}</td>
                                        <td class="text-end text-success">
                                            {{ $ledger->credit > 0 ? '₹' . number_format($ledger->credit, 2) : '—' }}</td>
                                        <td class="text-end pe-4 fw-medium">
                                            ₹{{ number_format(abs($ledger->running_balance), 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">No transactions found for
                                            this supplier.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
