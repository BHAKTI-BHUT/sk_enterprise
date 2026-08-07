@extends('partials.layouts.master')

@section('title', 'Edit Customer | Herozi')

@section('sub-title', 'Edit Customer')
@section('pagetitle', 'Customers')

@section('content')

    <div class="row g-4">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Customers</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Customer</li>
                </ol>
            </nav>
        </div>
        <div class="col-12">
            <div class="card h-100 mb-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Edit Customer: {{ $customer->name }}</h5>
                    <a href="{{ route('customer.index') }}" class="btn btn-sm btn-secondary">
                        <i class="ri-arrow-left-line align-bottom me-1"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <div id="drawer-form-content">
                        <form id="editCustomerForm" action="{{ route('customer.update', $customer->id) }}" method="POST"
                            class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Customer Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $customer->name }}" placeholder="Enter customer name" required>
                                    <div class="invalid-feedback">Please enter customer name.</div>
                                </div>
                                <div class="col-md-3">
                                    <label for="mobile" class="form-label">Mobile Number</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile"
                                        value="{{ $customer->mobile }}" placeholder="Enter mobile number" required>
                                    <div class="invalid-feedback">Please enter unique mobile number.</div>
                                </div>
                                <div class="col-md-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $customer->email }}" placeholder="Enter email address">
                                    <div class="invalid-feedback">Please enter a valid email.</div>
                                </div>

                                <div class="col-md-4">
                                    <label for="gst_number" class="form-label">GST Number</label>
                                    <input type="text" class="form-control" id="gst_number" name="gst_number"
                                        value="{{ $customer->gst_number }}" placeholder="Enter GST number">
                                </div>
                                <div class="col-md-4">
                                    <label for="credit_limit" class="form-label">Credit Limit</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" step="0.01" class="form-control" id="credit_limit"
                                            name="credit_limit" value="{{ $customer->credit_limit }}" placeholder="0.00">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select select2" id="status" name="status" required>
                                        <option value="active" {{ $customer->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $customer->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <div class="invalid-feedback">Please select status.</div>
                                </div>

                                <div class="col-md-8">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="1" placeholder="Enter address">{{ $customer->address }}</textarea>
                                </div>
                                <div class="col-md-4">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" name="city"
                                        value="{{ $customer->city }}" placeholder="Enter city">
                                </div>

                                <div class="col-md-4">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" class="form-control" id="state" name="state"
                                        value="{{ $customer->state }}" placeholder="Enter state">
                                </div>
                                <div class="col-md-4">
                                    <label for="pincode" class="form-label">Pincode</label>
                                    <input type="text" class="form-control" id="pincode" name="pincode"
                                        value="{{ $customer->pincode }}" placeholder="Enter pincode">
                                </div>
                                <div class="col-md-4">
                                    <div class="row g-2">
                                        <div class="col-8">
                                            <label for="opening_balance" class="form-label">Opening Balance</label>
                                            <input type="number" step="0.01" class="form-control" id="opening_balance"
                                                name="opening_balance" value="{{ $customer->opening_balance }}" placeholder="0.00" readonly>
                                        </div>
                                        <div class="col-4">
                                            <label for="balance_type" class="form-label">Type</label>
                                            <input type="hidden" name="balance_type" value="{{ $customer->balance_type }}">
                                            <select class="form-select select2" id="balance_type" disabled>
                                                <option value="dr" {{ $customer->balance_type == 'dr' ? 'selected' : '' }}>Dr</option>
                                                <option value="cr" {{ $customer->balance_type == 'cr' ? 'selected' : '' }}>Cr</option>
                                            </select>
                                        </div>
                                    </div>
                                    <small class="text-muted">Opening balance cannot be changed after creation.</small>
                                </div>

                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary px-4">Update Customer</button>
                                    <a href="{{ route('customer.index') }}" class="btn btn-secondary px-4">Cancel</a>
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
            $('#editCustomerForm').on('submit', function(e) {
                e.preventDefault();

                // reset previous errors
                $('#editCustomerForm .is-invalid').removeClass('is-invalid');

                if (this.checkValidity()) {
                    var formData = new FormData(this);
                    $.ajax({
                        url: '{{ route('customer.update', $customer->id) }}',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            showToast(response.message);
                            setTimeout(function() {
                                window.location.href = '{{ route('customer.index') }}';
                            }, 1000);
                        },
                        error: function(xhr) {
                            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                                var errors = xhr.responseJSON.errors;
                                Object.keys(errors).forEach(function(key) {
                                    var field = $('#editCustomerForm').find('[name="' + key + '"]');
                                    if (field.length) {
                                        field.addClass('is-invalid');
                                        var feedback = field.siblings('.invalid-feedback');
                                        if (feedback.length) {
                                            feedback.text(errors[key][0]);
                                        } else {
                                            field.after('<div class="invalid-feedback">' + errors[key][0] + '</div>');
                                        }
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
