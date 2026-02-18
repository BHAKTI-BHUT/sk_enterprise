@extends('partials.layouts.master')

@section('title', 'User Management | Herozi')

@section('sub-title', 'User Manage')
@section('pagetitle', 'Users')

@section('content')

    <div class="row g-4">
        <div class="col-12">
            <div class="card mb-0 h-100">
                <table id="user-table" class="table-hover align-middle table table-nowrap w-100">
                    <thead class="bg-light bg-opacity-30">
                        <tr>
                            <th>ID</th>
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
            ]);

            // Set head label title and add button
            var headLabel = $('#user-table').closest('.card').find('.head-label');
            if (headLabel.length) {
                headLabel.html('<h5 class="card-title text-nowrap mb-0">User List</h5>');
            }
            var addBtnContainer = $('#user-table').closest('.card').find('.add_button');
            if (addBtnContainer.length) {
                addBtnContainer.html(
                    '<a href="{{ route('user.create') }}" class="btn btn-primary">Add User</a>'
                );
            }

            // Delete User
            $(document).on('submit', '.delete-form', function(e) {
                e.preventDefault();
                var form = $(this);
                if (confirm('Are you sure you want to delete this user?')) {
                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: form.serialize(),
                        success: function(response) {
                            table.ajax.reload();
                            showToast(response.message);
                        },
                        error: function(xhr) {
                            showToast('Failed to delete user.', 'danger');
                        }
                    });
                }
            });

            @if (session('success'))
                showToast('{{ session('success') }}');
            @endif
        });
    </script>
@endsection
