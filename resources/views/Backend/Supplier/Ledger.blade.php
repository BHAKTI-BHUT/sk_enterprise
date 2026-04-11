@extends('partials.layouts.master')

@section('title', 'Supplier Ledger | Herozi')

@section('sub-title', 'Supplier Ledger')
@section('pagetitle', 'Supplier Ledger')

@section('content')

    <div class="row g-4">
        <div class="col-12">
            <div class="card mb-0 h-100 border-0 shadow-sm">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0 fw-bold"><i class="ri-file-list-3-line align-bottom me-1 text-primary"></i>
                        General Supplier Ledger</h5>
                </div>
                <div class="card-body">
                    <table id="supplier-ledger-table" class="table-hover align-middle table table-nowrap w-100">
                        <thead class="bg-light bg-opacity-30">
                            <tr>
                                <th>Date</th>
                                <th>Supplier Name</th>
                                <th>Type</th>
                                <th>Reference</th>
                                <th class="text-end">Debit (Dr)</th>
                                <th class="text-end">Credit (Cr)</th>
                                <th class="text-end">Running Balance</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = initDataTable('#supplier-ledger-table', '{{ route('supplier.ledger') }}', [{
                    data: 'transaction_date',
                    name: 'transaction_date'
                },
                {
                    data: 'supplier_name',
                    name: 'supplier.name'
                },
                {
                    data: 'transaction_type',
                    name: 'transaction_type',
                    render: function(data) {
                        var type = data.split('_').map(word => word.charAt(0).toUpperCase() + word
                            .slice(1)).join(' ');
                        var badgeClass = 'bg-soft-info text-info';
                        if (data === 'purchase') badgeClass = 'bg-soft-primary text-primary';
                        if (data === 'payment') badgeClass = 'bg-soft-success text-success';
                        if (data === 'purchase_return') badgeClass = 'bg-soft-warning text-warning';

                        return '<span class="badge ' + badgeClass + ' text-uppercase fs-10">' + type +
                            '</span>';
                    }
                },
                {
                    data: 'reference_no',
                    name: 'reference_no',
                    defaultContent: '—'
                },
                {
                    data: 'debit',
                    name: 'debit',
                    className: 'text-end text-danger'
                },
                {
                    data: 'credit',
                    name: 'credit',
                    className: 'text-end text-success'
                },
                {
                    data: 'running_balance',
                    name: 'running_balance',
                    className: 'text-end fw-medium'
                }
            ], {
                order: [
                    [0, 'desc']
                ]
            });
        });
    </script>
@endsection
