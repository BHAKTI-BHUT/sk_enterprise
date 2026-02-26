@extends('partials.layouts.master')

@section('title', 'Customer Management | Herozi')

@section('sub-title', 'Customer Manage')
@section('pagetitle', 'Customers')
@section('buttonTitle', '+ New Customer')
@section('buttonLink', route('customer.create'))

@section('content')

    <div class="row g-4">
        <div class="col-12">
            <div class="card mb-0 h-100">
                <div class="card-body">
                    <table id="customer-table" class="table-hover align-middle table table-nowrap w-100">
                        <thead class="bg-light bg-opacity-30">
                            <tr>
                                <th>ID</th>
                                <th>Customer Name</th>
                                <th>Mobile</th>
                                <th>City</th>
                                <th>Credit Limit</th>
                                <th>Outstanding</th>
                                <th>Status</th>
                                <th>Action</th>
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
            var table = initDataTable('#customer-table', '{{ route('customer.index') }}', [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'mobile',
                    name: 'mobile'
                },
                {
                    data: 'city',
                    name: 'city',
                    defaultContent: '—'
                },
                {
                    data: 'credit_limit',
                    name: 'credit_limit',
                    render: function(data) {
                        return '₹' + parseFloat(data || 0).toFixed(2);
                    }
                },
                {
                    data: 'current_outstanding',
                    name: 'current_outstanding',
                    render: function(data) {
                        var color = parseFloat(data || 0) > 0 ? 'text-danger' : 'text-success';
                        return '<span class="' + color + '">₹' + parseFloat(data || 0).toFixed(2) + '</span>';
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ], {
                buttonHtml: `<a href="{{ route('customer.create') }}" class="btn btn-primary btn-sm">+ New Customer</a>`,
                fixedColumns: {
                    left: 0,
                    right: 1
                }
            });

            @if (session('success'))
                showToast('{{ session('success') }}');
            @endif
        });
    </script>
@endsection
