@extends('partials.layouts.master')

@section('title', 'Add New Role | Herozi')

@section('sub-title', 'Add Role')
@section('pagetitle', 'Dashboard')

@section('content')

    <div class="row g-4">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Roles</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Role</li>
                </ol>
            </nav>
        </div>
        <div class="col-12">
            <div class="card h-100 mb-0">
                <div class="card-header">
                    <h5 class="card-title mb-0">Add New Role</h5>
                </div>
                <div class="card-body">
                    <form id="addRoleForm" class="needs-validation" novalidate>
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Role Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="e.g. Sales Manager" required>
                                <div class="invalid-feedback">Please enter a role name.</div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">Save Role</button>
                            <a href="{{ route('role.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Form Submission
            $('#addRoleForm').on('submit', function(e) {
                e.preventDefault();
                if (this.checkValidity()) {
                    $.ajax({
                        url: '{{ route('role.store') }}',
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            showToast(response.message);
                            setTimeout(function() {
                                window.location.href = '{{ route('role.index') }}';
                            }, 1000);
                        },
                        error: function(xhr) {
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                var errors = xhr.responseJSON.errors;
                                Object.keys(errors).forEach(function(key) {
                                    showToast(errors[key][0], 'danger');
                                });
                            } else {
                                showToast('An error occurred.', 'danger');
                            }
                        }
                    });
                }
                $(this).addClass('was-validated');
            });
        });
    </script>
@endsection
