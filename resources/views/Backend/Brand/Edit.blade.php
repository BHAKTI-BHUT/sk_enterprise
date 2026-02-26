@extends('partials.layouts.master')

@section('title', 'Edit Brand | Herozi')

@section('sub-title', 'Edit Brand')
@section('pagetitle', 'Brands')

@section('content')

    <div class="row g-4">

        <div class="col-md-6 mx-auto">
            <div class="card h-100 mb-0">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Brand: {{ $brand->name }}</h5>
                </div>
                <div class="card-body">
                    <div id="drawer-form-content">
                        <form id="editBrandForm" action="{{ route('brand.update', $brand->id) }}" method="POST"
                            class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Brand Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $brand->name }}" placeholder="Enter brand name" required>
                                    <div class="invalid-feedback">Please enter brand name.</div>
                                </div>

                                <div class="col-md-12">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select select2" id="status" name="status" required>
                                        <option value="active" {{ $brand->status == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ $brand->status == 'inactive' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
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
            $('#editBrandForm').on('submit', function(e) {
                e.preventDefault();
                $('#editBrandForm .is-invalid').removeClass('is-invalid');

                if (this.checkValidity()) {
                    $.ajax({
                        url: '{{ route('brand.update', $brand->id) }}',
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            showToast(response.message);
                            setTimeout(function() {
                                window.location.href = '{{ route('brand.index') }}';
                            }, 1000);
                        },
                        error: function(xhr) {
                            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON
                                .errors) {
                                var errors = xhr.responseJSON.errors;
                                Object.keys(errors).forEach(function(key) {
                                    var field = $('#editBrandForm').find('[name="' +
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
