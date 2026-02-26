@extends('partials.layouts.master')

@section('title', 'Edit Product | Herozi')

@section('sub-title', 'Edit Product')
@section('pagetitle', 'Products')

@section('content')

    <div class="row g-4">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                </ol>
            </nav>
        </div>
        <div class="col-12">
            <div class="card h-100 mb-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Edit Product: {{ $product->name }}</h5>
                    <a href="{{ route('product.index') }}" class="btn btn-sm btn-secondary">
                        <i class="ri-arrow-left-line align-bottom me-1"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <div id="drawer-form-content">
                        <form id="editProductForm" action="{{ route('product.update', $product->id) }}" method="POST"
                            enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $product->name }}" placeholder="Enter product name" required>
                                    <div class="invalid-feedback">Please enter product name.</div>
                                </div>
                                <div class="col-md-3">
                                    <label for="brand_id" class="form-label">Brand</label>
                                    <select class="form-select select2" id="brand_id" name="brand_id" required>
                                        <option value="">Select Brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a brand.</div>
                                </div>
                                <div class="col-md-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select class="form-select select2" id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a category.</div>
                                </div>

                                <div class="col-md-4">
                                    <label for="purchase_price" class="form-label">Purchase Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" step="0.01" class="form-control" id="purchase_price"
                                            name="purchase_price" value="{{ $product->purchase_price }}" placeholder="0.00"
                                            required>
                                    </div>
                                    <div class="invalid-feedback">Please enter purchase price.</div>
                                </div>
                                <div class="col-md-4">
                                    <label for="selling_price" class="form-label">Selling Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" step="0.01" class="form-control" id="selling_price"
                                            name="selling_price" value="{{ $product->selling_price }}" placeholder="0.00"
                                            required>
                                    </div>
                                    <div class="invalid-feedback">Please enter selling price.</div>
                                </div>
                                <div class="col-md-4">
                                    <label for="gst_percentage" class="form-label">GST %</label>
                                    <input type="number" step="0.01" class="form-control" id="gst_percentage"
                                        name="gst_percentage" value="{{ $product->gst_percentage }}" placeholder="18"
                                        required>
                                    <div class="invalid-feedback">Please enter GST percentage.</div>
                                </div>

                                <div class="col-md-4">
                                    <label for="stock_quantity" class="form-label">Stock Quantity</label>
                                    <input type="number" class="form-control" id="stock_quantity" name="stock_quantity"
                                        value="{{ $product->stock_quantity }}" placeholder="0" required>
                                    <div class="invalid-feedback">Please enter stock quantity.</div>
                                </div>
                                <div class="col-md-4">
                                    <label for="min_stock_alert" class="form-label">Minimum Stock Alert</label>
                                    <input type="number" class="form-control" id="min_stock_alert"
                                        name="min_stock_alert" value="{{ $product->min_stock_alert }}" placeholder="5"
                                        required>
                                    <div class="invalid-feedback">Please enter minimum stock alert.</div>
                                </div>
                                <div class="col-md-4">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select select2" id="status" name="status" required>
                                        <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    <div class="invalid-feedback">Please select status.</div>
                                </div>

                                <div class="col-md-12">
                                    <label for="image" class="form-label">Product Image</label>
                                    <input type="file" class="form-control mb-2" id="image" name="image"
                                        accept="image/*">
                                    @if ($product->image)
                                        <div class="mt-2">
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                                class="img-thumbnail" width="150">
                                        </div>
                                    @endif
                                    <div class="form-text">Max size 2MB (JPG, PNG). Leave empty to keep current image.
                                    </div>
                                </div>

                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary px-4">Update Product</button>
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
            // Form Submission
            $('#editProductForm').on('submit', function(e) {
                e.preventDefault();

                // reset previous errors
                $('#editProductForm .is-invalid').removeClass('is-invalid');

                if (this.checkValidity()) {
                    var formData = new FormData(this);
                    $.ajax({
                        url: '{{ route('product.update', $product->id) }}',
                        method: 'POST', // Use POST with _method PUT for multipart form
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            showToast(response.message);
                            setTimeout(function() {
                                window.location.href = '{{ route('product.index') }}';
                            }, 1000);
                        },
                        error: function(xhr) {
                            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON
                                .errors) {
                                var errors = xhr.responseJSON.errors;
                                Object.keys(errors).forEach(function(key) {
                                    var field = $('#editProductForm').find('[name="' +
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
