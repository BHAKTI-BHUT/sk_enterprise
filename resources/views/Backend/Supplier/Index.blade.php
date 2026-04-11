@extends('partials.layouts.master')

@section('title', 'Supplier Management | Herozi')

@section('sub-title', 'Supplier Manage')
@section('pagetitle', 'Suppliers')
@section('buttonTitle', '+ New Supplier')
@section('buttonLink', route('supplier.create'))

@section('content')

    <div class="row g-4">
        <div class="col-12">
            <div class="card mb-0 h-100">
                <div class="card-body">
                    <table id="supplier-table" class="table-hover align-middle table table-nowrap w-100">
                        <thead class="bg-light bg-opacity-30">
                            <tr>
                                <th>Code</th>
                                <th>Supplier Name</th>
                                <th>Contact Person</th>
                                <th>Mobile</th>
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
            var table = initDataTable('#supplier-table', '{{ route('supplier.index') }}', [{
                    data: 'supplier_code',
                    name: 'supplier_code'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'contact_person',
                    name: 'contact_person',
                    defaultContent: '—'
                },
                {
                    data: 'mobile',
                    name: 'mobile'
                },
                {
                    data: 'current_outstanding',
                    name: 'current_outstanding',
                    render: function(data) {
                        var color = parseFloat(data || 0) > 0 ? 'text-danger' : 'text-success';
                        return '<span class="' + color + '">₹' + Math.abs(parseFloat(data || 0))
                            .toFixed(2) + '</span>';
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
                buttonHtml: `<a href="{{ route('supplier.create') }}" class="btn btn-primary btn-sm">+ New Supplier</a>`,
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
