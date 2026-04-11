@extends('partials.layouts.master')

@section('title', 'Add New Supplier | Herozi')

@section('sub-title', 'Add Supplier')
@section('pagetitle', 'Suppliers')

@section('content')

    <div class="row g-4">
        <div class="col-12">
            <div class="card h-100 mb-0 border-0 shadow-sm">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0 fw-bold"><i class="ri-user-add-line align-bottom me-1 text-primary"></i> Add
                        New Supplier</h5>
                    <a href="{{ route('supplier.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="ri-arrow-left-line align-bottom me-1"></i> Back to List
                    </a>
                </div>
                <div class="card-body p-0">
                    <form id="addSupplierForm" action="{{ route('supplier.store') }}" method="POST"
                        class="needs-validation" novalidate>
                        @csrf

                        <!-- Custom Tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified mb-3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#basic-info" role="tab">
                                    <i class="ri-user-line me-1 align-bottom"></i> Basic Info
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#financial-info" role="tab">
                                    <i class="ri-money-dollar-circle-line me-1 align-bottom"></i> Financial Info
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#bank-info" role="tab">
                                    <i class="ri-bank-line me-1 align-bottom"></i> Bank Details
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content p-4">
                            <!-- Basic Information -->
                            <div class="tab-pane active" id="basic-info" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label fw-medium">Supplier Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Enter supplier name" required>
                                        <div class="invalid-feedback">Please enter supplier name.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="contact_person" class="form-label fw-medium">Contact Person</label>
                                        <input type="text" class="form-control" id="contact_person" name="contact_person"
                                            placeholder="Enter contact person name">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="mobile" class="form-label fw-medium">Mobile Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="mobile" name="mobile"
                                            placeholder="Enter 10-digit mobile number" required pattern="[0-9]{10}">
                                        <div class="invalid-feedback">Please enter valid 10-digit mobile number.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-medium">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Enter email address">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="gst_number" class="form-label fw-medium">GST Number</label>
                                        <input type="text" class="form-control" id="gst_number" name="gst_number"
                                            placeholder="Enter GSTIN">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pan_number" class="form-label fw-medium">PAN Number</label>
                                        <input type="text" class="form-control" id="pan_number" name="pan_number"
                                            placeholder="Enter PAN">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="address" class="form-label fw-medium">Address</label>
                                        <textarea class="form-control" id="address" name="address" rows="2" placeholder="Enter street address"></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="city" class="form-label fw-medium">City</label>
                                        <input type="text" class="form-control" id="city" name="city"
                                            placeholder="City">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="state" class="form-label fw-medium">State</label>
                                        <input type="text" class="form-control" id="state" name="state"
                                            placeholder="State">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="pincode" class="form-label fw-medium">Pincode</label>
                                        <input type="text" class="form-control" id="pincode" name="pincode"
                                            placeholder="Pincode">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="status" class="form-label fw-medium">Status</label>
                                        <select class="form-select select2" id="status" name="status" required>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-4 text-end">
                                    <button type="button" class="btn btn-primary next-tab"
                                        data-next="#financial-info">Next <i
                                            class="ri-arrow-right-line align-bottom"></i></button>
                                </div>
                            </div>

                            <!-- Financial Information -->
                            <div class="tab-pane" id="financial-info" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="opening_balance" class="form-label fw-medium">Opening Balance</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₹</span>
                                            <input type="number" step="0.01" class="form-control"
                                                id="opening_balance" name="opening_balance" placeholder="0.00">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="balance_type" class="form-label fw-medium">Balance Type</label>
                                        <select class="form-select select2" id="balance_type" name="balance_type">
                                            <option value="cr">Credit (Payable)</option>
                                            <option value="dr">Debit (Receivable)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="credit_limit" class="form-label fw-medium">Credit Limit</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₹</span>
                                            <input type="number" step="0.01" class="form-control" id="credit_limit"
                                                name="credit_limit" placeholder="0.00">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="payment_terms" class="form-label fw-medium">Payment Terms
                                            (Days)</label>
                                        <input type="number" class="form-control" id="payment_terms"
                                            name="payment_terms" placeholder="No. of days">
                                    </div>
                                </div>
                                <div class="mt-4 d-flex justify-content-between">
                                    <button type="button" class="btn btn-light prev-tab" data-prev="#basic-info"><i
                                            class="ri-arrow-left-line align-bottom"></i> Previous</button>
                                    <button type="button" class="btn btn-primary next-tab" data-next="#bank-info">Next
                                        <i class="ri-arrow-right-line align-bottom"></i></button>
                                </div>
                            </div>

                            <!-- Bank Details -->
                            <div class="tab-pane" id="bank-info" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="bank_name" class="form-label fw-medium">Bank Name</label>
                                        <input type="text" class="form-control" id="bank_name" name="bank_name"
                                            placeholder="Enter bank name">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="account_number" class="form-label fw-medium">Account Number</label>
                                        <input type="text" class="form-control" id="account_number"
                                            name="account_number" placeholder="Enter account number">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="ifsc_code" class="form-label fw-medium">IFSC Code</label>
                                        <input type="text" class="form-control" id="ifsc_code" name="ifsc_code"
                                            placeholder="Enter IFSC code">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="upi_id" class="form-label fw-medium">UPI ID</label>
                                        <input type="text" class="form-control" id="upi_id" name="upi_id"
                                            placeholder="Enter UPI ID (e.g. user@bank)">
                                    </div>
                                </div>
                                <div class="mt-4 d-flex justify-content-between">
                                    <button type="button" class="btn btn-light prev-tab" data-prev="#financial-info"><i
                                            class="ri-arrow-left-line align-bottom"></i> Previous</button>
                                    <div>
                                        <button type="submit" class="btn btn-success px-4"><i
                                                class="ri-save-line align-bottom me-1"></i> Save Supplier</button>
                                        <a href="{{ route('supplier.index') }}" class="btn btn-light px-4">Cancel</a>
                                    </div>
                                </div>
                            </div>
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
            // Tab Navigation
            $('.next-tab').click(function() {
                var nextTab = $(this).data('next');
                $('[href="' + nextTab + '"]').tab('show');
            });

            $('.prev-tab').click(function() {
                var prevTab = $(this).data('prev');
                $('[href="' + prevTab + '"]').tab('show');
            });

            // Form Submission
            $('#addSupplierForm').on('submit', function(e) {
                e.preventDefault();

                // reset previous errors
                $('#addSupplierForm .is-invalid').removeClass('is-invalid');

                if (this.checkValidity()) {
                    var formData = new FormData(this);
                    $.ajax({
                        url: '{{ route('supplier.store') }}',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            showToast(response.message);
                            setTimeout(function() {
                                window.location.href = '{{ route('supplier.index') }}';
                            }, 1000);
                        },
                        error: function(xhr) {
                            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON
                                .errors) {
                                var errors = xhr.responseJSON.errors;
                                var firstErrorTab = null;

                                Object.keys(errors).forEach(function(key) {
                                    var field = $('#addSupplierForm').find('[name="' +
                                        key + '"]');
                                    if (field.length) {
                                        field.addClass('is-invalid');

                                        // Find the tab pane containing this field
                                        var tabPane = field.closest('.tab-pane');
                                        if (tabPane.length && !firstErrorTab) {
                                            firstErrorTab = '#' + tabPane.attr('id');
                                        }

                                        if (field.siblings('.invalid-feedback')
                                            .length === 0) {
                                            field.after(
                                                '<div class="invalid-feedback">' +
                                                errors[key][0] + '</div>');
                                        } else {
                                            field.siblings('.invalid-feedback').text(
                                                errors[key][0]);
                                        }
                                    }
                                });

                                // Switch to the first tab that has an error
                                if (firstErrorTab) {
                                    $('[href="' + firstErrorTab + '"]').tab('show');
                                }

                            } else {
                                showToast('An error occurred while saving.', 'danger');
                            }
                        }
                    });
                } else {
                    // If native validation fails, find the first invalid field and show its tab
                    var firstInvalid = $('#addSupplierForm').find(':invalid').first();
                    if (firstInvalid.length) {
                        var tabPane = firstInvalid.closest('.tab-pane');
                        if (tabPane.length) {
                            $('[href="#' + tabPane.attr('id') + '"]').tab('show');
                        }
                    }
                }
                $(this).addClass('was-validated');
            });
        });
    </script>
@endsection
