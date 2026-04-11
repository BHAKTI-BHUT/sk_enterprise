@extends('partials.layouts.master')

@section('title', 'Sales Management | Shree Krushna Enterprise')

@section('sub-title', 'Sales Manage')
@section('pagetitle', 'Sales')

@section('content')

    <div class="row g-4">
        <div class="col-12">
            <div class="card mb-0 h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Sales</h5>
                    <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm">
                        <i class="ri-add-line align-bottom me-1"></i> Create Invoice
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="sales-table" class="table-hover align-middle table table-nowrap w-100">
                            <thead class="bg-light bg-opacity-30">
                                <tr>
                                    <th>Invoice No</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Payable Amount</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sales as $sale)
                                <tr>
                                    <td><span class="fw-bold">{{ $sale->invoice_no }}</span></td>
                                    <td>{{ date('d-m-Y', strtotime($sale->sale_date)) }}</td>
                                    <td>{{ $sale->customer->name }}</td>
                                    <td>₹{{ number_format($sale->payable_amount, 2) }}</td>
                                    <td>₹{{ number_format($sale->paid_amount, 2) }}</td>
                                    <td><span class="text-danger">₹{{ number_format($sale->due_amount, 2) }}</span></td>
                                    <td>
                                        @if($sale->payment_status == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($sale->payment_status == 'partial')
                                            <span class="badge bg-warning">Partial</span>
                                        @else
                                            <span class="badge bg-danger">Unpaid</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a href="{{ route('sales.show', $sale->id) }}" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View Detail</a></li>
                                                <li><a href="https://wa.me/{{ $sale->customer->mobile }}?text=Hi {{ $sale->customer->name }}, Invoice {{ $sale->invoice_no }} for ₹{{ $sale->payable_amount }} is generated. View details: {{ route('sales.show', $sale->id) }}" target="_blank" class="dropdown-item"><i class="ri-whatsapp-line align-bottom me-2 text-success"></i> Share WhatsApp</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#sales-table').DataTable({
                order: [[1, 'desc']],
                pageLength: 25,
            });

            @if (session('success'))
                showToast('{{ session('success') }}');
            @endif
        });
    </script>
@endsection
