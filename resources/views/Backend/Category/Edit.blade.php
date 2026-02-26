@extends('partials.layouts.master')

@section('title', 'Edit Category | Herozi')

@section('sub-title', 'Edit Category')
@section('pagetitle', 'Categories')

@section('content')

    <div class="row g-4">
        <div class="col-md-6 mx-auto">
            <div class="card h-100 mb-0">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Category: {{ $category->name }}</h5>
                </div>
                <div class="card-body">
                    <div id="drawer-form-content">
                        <form id="editCategoryForm" action="{{ route('category.update', $category->id) }}" method="POST"
                            class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $category->name }}" placeholder="Enter category name" required>
                                    <div class="invalid-feedback">Please enter category name.</div>
                                </div>

                                <div class="col-md-12">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select select2" id="status" name="status" required>
                                        <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    <div class="invalid-feedback">Please select status.</div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#editCategoryForm').on('submit', function(e) {
                e.preventDefault();
                $('#editCategoryForm .is-invalid').removeClass('is-invalid');

                if (this.checkValidity()) {
                    $.ajax({
                        url: '{{ route('category.update', $category->id) }}',
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            showToast(response.message);
                            setTimeout(function() {
                                window.location.href = '{{ route('category.index') }}';
                            }, 1000);
                        },
                        error: function(xhr) {
                            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON
                                .errors) {
                                var errors = xhr.responseJSON.errors;
                                Object.keys(errors).forEach(function(key) {
                                    var field = $('#editCategoryForm').find('[name="' +
                                        key + '"]');
                                    if (field.length) {
                                        field.addClass('is-invalid');
                                        field.siblings('.invalid-feedback').text(errors[
                                            key][0]);
                                    }
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
