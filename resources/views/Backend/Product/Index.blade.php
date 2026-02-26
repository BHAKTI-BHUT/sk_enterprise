@extends('partials.layouts.master')

@section('title', 'Product Management | Herozi')

@section('sub-title', 'Product Manage')
@section('pagetitle', 'Products')
@section('buttonTitle', '+ New Product')
@section('buttonLink', route('product.create'))

@section('content')

    <div class="row g-4">
        <div class="col-12">
            <div class="card mb-0 h-100">
                <div class="card-body">
                    <table id="product-table" class="table-hover align-middle table table-nowrap w-100">
                        <thead class="bg-light bg-opacity-30">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
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
            var table = initDataTable('#product-table', '{{ route('product.index') }}', [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'image',
                    name: 'image',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'brand.name',
                    name: 'brand.name',
                    defaultContent: '—'
                },
                {
                    data: 'category.name',
                    name: 'category.name',
                    defaultContent: '—'
                },
                {
                    data: 'selling_price',
                    name: 'selling_price',
                    render: function(data) {
                        return '₹' + parseFloat(data || 0).toFixed(2);
                    }
                },
                {
                    data: 'stock_quantity',
                    name: 'stock_quantity',
                    render: function(data, type, row) {
                        var badge = (data || 0) <= (row.min_stock_alert || 0) ? 'bg-danger' : 'bg-info';
                        return '<span class="badge ' + badge + '">' + (data || 0) + '</span>';
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
                buttonHtml: `<a href="{{ route('product.create') }}" class="btn btn-primary btn-sm">+ New Product</a>`,
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
