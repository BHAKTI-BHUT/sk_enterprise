@extends('partials.layouts.master')

@section('title', 'Customer Ledger | Herozi')

@section('sub-title', 'Customer Ledger')
@section('pagetitle', 'Customer Ledger')

@section('content')

    <div class="row g-4">
        <div class="col-12">
            <div class="card mb-0 h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">General Customer Ledger</h5>
                </div>
                <div class="card-body">
                    <table id="ledger-table" class="table-hover align-middle table table-nowrap w-100">
                        <thead class="bg-light bg-opacity-30">
                            <tr>
                                <th>Date</th>
                                <th>Customer Name</th>
                                <th>Type</th>
                                <th>Reference</th>
                                <th>Debit (Dr)</th>
                                <th>Credit (Cr)</th>
                                <th>Balance</th>
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
            var table = initDataTable('#ledger-table', '{{ route('customer.ledger') }}', [
                {
                    data: 'transaction_date',
                    name: 'transaction_date'
                },
                {
                    data: 'customer_name',
                    name: 'customer.name'
                },
                {
                    data: 'transaction_type',
                    name: 'transaction_type',
                    render: function(data) {
                        return data.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
                    }
                },
                {
                    data: 'reference_no',
                    name: 'reference_no',
                    defaultContent: '—'
                },
                {
                    data: 'debit',
                    name: 'debit'
                },
                {
                    data: 'credit',
                    name: 'credit'
                },
                {
                    data: 'balance',
                    name: 'balance'
                }
            ], {
                order: [[0, 'desc']]
            });
        });
    </script>
@endsection
