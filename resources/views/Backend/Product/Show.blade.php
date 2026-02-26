@extends('partials.layouts.master')

@section('title', 'Product Details | Herozi')

@section('sub-title', 'Product Details')
@section('pagetitle', 'Products')

@section('content')

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card h-100 mb-0">
                <div class="card-body text-center mt-3">
                    <img src="{{ $product->image ? asset($product->image) : asset('assets/images/no-image.png') }}"
                        alt="{{ $product->name }}" class="img-fluid rounded mb-3" style="max-height: 250px;">
                    <h4 class="mb-1">{{ $product->name }}</h4>
                    <p class="text-muted mb-3">{{ $product->category->name ?? 'N/A' }} |
                        {{ $product->brand->name ?? 'N/A' }}</p>
                    <div class="d-flex justify-content-center gap-2">
                        <span class="badge {{ $product->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card h-100 mb-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Product Information</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('product.index') }}" class="btn btn-sm btn-secondary">
                            <i class="ri-arrow-left-line align-bottom me-1"></i> Back to List
                        </a>
                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit Product</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th style="width: 30%;">Purchase Price:</th>
                                    <td class="text-primary font-weight-bold">
                                        ₹{{ number_format($product->purchase_price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Selling Price:</th>
                                    <td class="text-success font-weight-bold">
                                        ₹{{ number_format($product->selling_price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>GST Percentage:</th>
                                    <td>{{ $product->gst_percentage }}%</td>
                                </tr>
                                <tr>
                                    <th>Stock Quantity:</th>
                                    <td>
                                        <span
                                            class="badge {{ $product->stock_quantity <= $product->min_stock_alert ? 'bg-danger' : 'bg-info' }}">
                                            {{ $product->stock_quantity }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Min Stock Alert:</th>
                                    <td>{{ $product->min_stock_alert }}</td>
                                </tr>
                                <tr>
                                    <th>Created By:</th>
                                    <td>{{ $product->creator->name ?? 'System' }}</td>
                                </tr>
                                <tr>
                                    <th>Created At:</th>
                                    <td>{{ $product->created_at ? $product->created_at->format('d M Y, h:i A') : '—' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Last Updated:</th>
                                    <td>{{ $product->updated_at ? $product->updated_at->format('d M Y, h:i A') : '—' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
