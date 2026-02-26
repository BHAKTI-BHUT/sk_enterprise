@extends('partials.layouts.master')

@section('title', 'User Management | Herozi')

@section('sub-title', 'User Manage')
@section('pagetitle', 'Users')
@section('buttonTitle', '+ New User')
@section('buttonLink', route('user.create'))
@section('buttonDrawer', 'true')
@section('buttonDrawerTitle', 'Add New User')

@section('content')

    <div class="row g-4">
        <div class="col-12">
            <div class="card mb-0 h-100">
                <table id="user-table" class="table-hover align-middle table table-nowrap w-100">
                    <thead class="bg-light bg-opacity-30">
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = initDataTable('#user-table', '{{ route('user.index') }}', [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'first_name',
                    name: 'first_name',
                    defaultContent: '—'
                },
                {
                    data: 'last_name',
                    name: 'last_name',
                    defaultContent: '—'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'roles',
                    name: 'roles',
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
                buttonHtml: `<a href="{{ route('user.create') }}" class="btn btn-primary btn-sm" data-drawer="true" data-drawer-title="Add New User">+ New User</a>`,
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
