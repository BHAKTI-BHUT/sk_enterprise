@extends('partials.layouts.master')

@section('title', 'Category Management | Herozi')

@section('sub-title', 'Category Manage')
@section('pagetitle', 'Categories')
@section('buttonTitle', '+ New Category')
@section('buttonLink', route('category.create'))
@section('buttonDrawer', 'true')
@section('buttonDrawerTitle', 'Add New Category')

@section('content')

    <div class="row g-4">
        <div class="col-12">
            <div class="card mb-0 h-100">
                <div class="card-body">
                    <table id="category-table" class="table-hover align-middle table table-nowrap w-100">
                        <thead class="bg-light bg-opacity-30">
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
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
            var table = initDataTable('#category-table', '{{ route('category.index') }}', [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
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
                buttonHtml: `<a href="{{ route('category.create') }}" class="btn btn-primary btn-sm">+ New Category</a>`,
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
