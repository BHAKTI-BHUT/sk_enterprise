@extends('partials.layouts.master')

@section('title', 'Create Sales Invoice | Shree Krushna Enterprise')

@section('sub-title', 'Create Invoice')
@section('pagetitle', 'Sales')

@section('content')

    <form id="salesForm" action="{{ route('sales.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf
        <div class="row g-4">
            {{-- Horizontal Customer & Header Info --}}
            <div class="col-12">
                <div class="card h-100 mb-0">
                    <div class="card-header d-flex justify-content-between align-items-center bg-light bg-opacity-50">
                        <h5 class="card-title mb-0">Invoice Header</h5>
                        <div class="text-end">
                            <span class="badge bg-soft-primary text-primary fs-14 p-2">Invoice: <span id="display_invoice_no">{{ $invoiceNo }}</span></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <input type="hidden" name="invoice_no" value="{{ $invoiceNo }}">
                            <div class="col-md-4">
                                <label for="customer_id" class="form-label fw-semibold">Customer <span class="text-danger">*</span></label>
                                <select class="form-select select2" id="customer_id" name="customer_id" required>
                                    <option value="">Select Customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->mobile }})</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a customer.</div>
                            </div>
                            <div class="col-md-3">
                                <label for="sale_date" class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="sale_date" name="sale_date" value="{{ date('Y-m-d') }}" required>
                                <div class="invalid-feedback">Please select a date.</div>
                            </div>
                            <div class="col-md-5">
                                <label for="notes" class="form-label fw-semibold">Notes / Reference</label>
                                <input type="text" class="form-control" id="notes" name="notes" placeholder="Enter optional notes">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Selection & Grid --}}
            <div class="col-12">
                <div class="card h-100 mb-0">
                    <div class="card-header bg-light bg-opacity-50">
                        <h5 class="card-title mb-0">Product Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-nowrap align-middle" id="product_table">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 40%">Product <span class="text-danger">*</span></th>
                                        <th style="width: 10%">Available Stock</th>
                                        <th style="width: 10%">Quantity <span class="text-danger">*</span></th>
                                        <th style="width: 15%">Unit Price (₹) <span class="text-danger">*</span></th>
                                        <th style="width: 10%">GST (%)</th>
                                        <th style="width: 15%">Total (₹)</th>
                                        <th style="width: 5%"></th>
                                    </tr>
                                </thead>
                                <tbody id="product_rows">
                                    <tr class="product-row">
                                        <td>
                                            <select class="form-select product-select" name="products[0][id]" required data-row-idx="0">
                                                <option value="">Search Product...</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}" 
                                                        data-price="{{ $product->selling_price }}" 
                                                        data-gst="{{ $product->gst_percentage }}" 
                                                        data-stock="{{ $product->stock_quantity }}">
                                                        {{ $product->name }} {{ $product->brand ? '('.$product->brand->name.')' : '' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control stock-field" readonly disabled placeholder="0">
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" class="form-control qty-field" name="products[0][quantity]" placeholder="0" required data-row-idx="0">
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" class="form-control price-field" name="products[0][price]" placeholder="0.00" required data-row-idx="0">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control gst-field" readonly disabled placeholder="0">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control row-total" readonly disabled placeholder="0.00">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-outline-danger btn-sm remove-row"><i class="ri-delete-bin-line"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <button type="button" class="btn btn-soft-primary btn-sm" id="add_row_btn">
                                <i class="ri-add-line align-middle me-1"></i> Add Another Item
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Summary & Totals --}}
            <div class="col-12">
                <div class="card h-100 mb-0 shadow-sm border-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="payment_method" class="form-label fw-semibold">Payment Mode</label>
                                        <select class="form-select fw-medium border-primary border-opacity-50" name="payment_method">
                                            <option value="Cash">Cash</option>
                                            <option value="Bank">Bank Transfer</option>
                                            <option value="UPI">UPI / Google Pay</option>
                                            <option value="Cheque">Cheque</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="paid_amount" class="form-label fw-semibold">Paid Amount (₹)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">₹</span>
                                            <input type="number" step="0.01" class="form-control fw-bold text-success border-primary border-opacity-50" id="paid_amount" name="paid_amount" value="0.00">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-sm mb-0">
                                        <tbody>
                                            <tr>
                                                <td class="fw-medium">Sub Total</td>
                                                <td class="text-end fw-semibold">₹ <span id="sub_total_display">0.00</span></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium">GST Amount</td>
                                                <td class="text-end fw-semibold">₹ <span id="tax_amount_display">0.00</span></td>
                                            </tr>
                                            <tr class="border-bottom border-light">
                                                <td class="fw-medium">Discount (₹)</td>
                                                <td class="text-end" style="width: 120px;">
                                                    <input type="number" step="0.01" class="form-control form-control-sm text-end" id="discount_amount" name="discount_amount" value="0.00">
                                                </td>
                                            </tr>
                                            <tr class="fs-16 border-top">
                                                <td class="fw-bold">Payable Amount</td>
                                                <td class="text-end fw-bold text-primary">₹ <span id="payable_amount_display">0.00</span></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium text-danger">Due Balance</td>
                                                <td class="text-end fw-bold text-danger">₹ <span id="due_amount_display">0.00</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-top text-end">
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold" id="submitBtn">
                                <i class="ri-checkbox-circle-line align-middle me-1"></i> Finalize & Generate Invoice
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            let rowIdx = 1;

            // Add Row
            $('#add_row_btn').on('click', function() {
                const newRow = `
                    <tr class="product-row">
                        <td>
                            <select class="form-select product-select" name="products[${rowIdx}][id]" required data-row-idx="${rowIdx}">
                                <option value="">Search Product...</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                        data-price="{{ $product->selling_price }}" 
                                        data-gst="{{ $product->gst_percentage }}" 
                                        data-stock="{{ $product->stock_quantity }}">
                                        {{ $product->name }} {{ $product->brand ? '('.$product->brand->name.')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control stock-field" readonly disabled placeholder="0">
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control qty-field" name="products[${rowIdx}][quantity]" placeholder="0" required data-row-idx="${rowIdx}">
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control price-field" name="products[${rowIdx}][price]" placeholder="0.00" required data-row-idx="${rowIdx}">
                        </td>
                        <td>
                            <input type="text" class="form-control gst-field" readonly disabled placeholder="0">
                        </td>
                        <td>
                            <input type="text" class="form-control row-total" readonly disabled placeholder="0.00">
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-danger btn-sm remove-row"><i class="ri-delete-bin-line"></i></button>
                        </td>
                    </tr>
                `;
                $('#product_rows').append(newRow);
                rowIdx++;
            });

            // Remove Row
            $(document).on('click', '.remove-row', function() {
                if ($('.product-row').length > 1) {
                    $(this).closest('tr').remove();
                    calculateGrandTotal();
                } else {
                    showToast('At least one item is required.', 'warning');
                }
            });

            // Handle Product Selection
            $(document).on('change', '.product-select', function() {
                const row = $(this).closest('tr');
                const selected = $(this).find('option:selected');
                
                if (selected.val()) {
                    const price = selected.data('price');
                    const gst = selected.data('gst');
                    const stock = selected.data('stock');
                    
                    row.find('.price-field').val(price);
                    row.find('.gst-field').val(gst + '%');
                    row.find('.stock-field').val(stock);
                } else {
                    row.find('.price-field').val('');
                    row.find('.gst-field').val('');
                    row.find('.stock-field').val('');
                }
                calculateRowTotal(row);
            });

            // Handle Input Changes
            $(document).on('input', '.qty-field, .price-field', function() {
                const row = $(this).closest('tr');
                if ($(this).hasClass('qty-field')) {
                    const qty = parseFloat($(this).val()) || 0;
                    const stock = parseFloat(row.find('.stock-field').val()) || 0;
                    
                    if (qty > stock) {
                        showToast('Quantity (' + qty + ') cannot exceed available stock (' + stock + ').', 'warning');
                        $(this).val(stock);
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                }
                calculateRowTotal(row);
            });

            $(document).on('input', '#discount_amount, #paid_amount', function() {
                calculateGrandTotal();
            });

            function calculateRowTotal(row) {
                const qty = parseFloat(row.find('.qty-field').val()) || 0;
                const price = parseFloat(row.find('.price-field').val()) || 0;
                const rowTotal = qty * price;
                row.find('.row-total').val(rowTotal.toFixed(2));
                calculateGrandTotal();
            }

            function calculateGrandTotal() {
                let subTotal = 0;
                let taxTotal = 0;

                $('.product-row').each(function() {
                    const row = $(this);
                    const qty = parseFloat(row.find('.qty-field').val()) || 0;
                    const price = parseFloat(row.find('.price-field').val()) || 0;
                    const gstPer = parseFloat(row.find('.product-select option:selected').data('gst')) || 0;
                    
                    const rowSubtotal = qty * price;
                    const rowTax = (rowSubtotal * gstPer) / 100;

                    subTotal += rowSubtotal;
                    taxTotal += rowTax;
                });

                const discount = parseFloat($('#discount_amount').val()) || 0;
                const payable = (subTotal + taxTotal) - discount;
                const paid = parseFloat($('#paid_amount').val()) || 0;
                const due = payable - paid;

                $('#sub_total_display').text(subTotal.toLocaleString('en-IN', {minimumFractionDigits: 2}));
                $('#tax_amount_display').text(taxTotal.toLocaleString('en-IN', {minimumFractionDigits: 2}));
                $('#payable_amount_display').text(payable.toLocaleString('en-IN', {minimumFractionDigits: 2}));
                $('#due_amount_display').text(due.toLocaleString('en-IN', {minimumFractionDigits: 2}));
            }

            // Form Validation Style
            $('#salesForm').on('submit', function(e) {
                if (!this.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                    showToast('Please fill all required fields.', 'danger');
                }
                $(this).addClass('was-validated');
            });
        });
    </script>
@endsection
