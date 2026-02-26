@extends('partials.layouts.master')

@section('title', 'Customer Details | Herozi')

@section('sub-title', 'Customer Details')
@section('pagetitle', 'Customers')

@section('content')

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 mb-0">
                <div class="card-body text-center mt-3">
                    <div class="avatar-xl mx-auto mb-3">
                        <span class="avatar-title rounded-circle bg-primary-subtle text-primary fs-1">
                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                        </span>
                    </div>
                    <h4 class="mb-1">{{ $customer->name }}</h4>
                    <p class="text-muted mb-3">{{ $customer->mobile }}</p>
                    <div class="d-flex justify-content-center gap-2">
                        <span class="badge {{ $customer->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($customer->status) }}
                        </span>
                    </div>
                    <hr class="my-4">
                    <div class="row text-start g-3">
                        <div class="col-12">
                            <label class="form-label text-muted mb-1">Email</label>
                            <p class="mb-0">{{ $customer->email ?? '—' }}</p>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted mb-1">GST Number</label>
                            <p class="mb-0">{{ $customer->gst_number ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card h-100 mb-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Customer Information</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('customer.index') }}" class="btn btn-sm btn-secondary">
                            <i class="ri-arrow-left-line align-bottom me-1"></i> Back to List
                        </a>
                        <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-sm btn-primary">Edit Customer</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th style="width: 30%;">Current Outstanding:</th>
                                    <td class="{{ $customer->current_outstanding > 0 ? 'text-danger' : 'text-success' }} font-weight-bold">
                                        ₹{{ number_format($customer->current_outstanding, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Opening Balance:</th>
                                    <td>₹{{ number_format($customer->opening_balance, 2) }} ({{ strtoupper($customer->balance_type) }})</td>
                                </tr>
                                <tr>
                                    <th>Credit Limit:</th>
                                    <td>₹{{ number_format($customer->credit_limit, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Address:</th>
                                    <td>{{ $customer->address ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>City/State:</th>
                                    <td>{{ $customer->city ?? '—' }}{{ $customer->state ? ', ' . $customer->state : '' }}</td>
                                </tr>
                                <tr>
                                    <th>Pincode:</th>
                                    <td>{{ $customer->pincode ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Created At:</th>
                                    <td>{{ $customer->created_at ? $customer->created_at->format('d M Y, h:i A') : '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated:</th>
                                    <td>{{ $customer->updated_at ? $customer->updated_at->format('d M Y, h:i A') : '—' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
