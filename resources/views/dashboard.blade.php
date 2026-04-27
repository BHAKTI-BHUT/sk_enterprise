@extends('partials.Layouts.master3')

@section('title', 'Dashboard | Shree Krishna Enterprise - Design & Developed by ❤️Bhakti.')
@section('sub-title', 'Dashboard Details')
@section('pagetitle', 'Dashboard')
@section('buttonTitle', 'Share')
@section('link', '#!')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/libs/air-datepicker/air-datepicker.css') }}">
    <link href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="row">
        <!-- Total Customers Card -->
        <div class="col-lg-4">
            <div class="card card-hover overflow-hidden">
                <div class="card-body hstack gap-2">
                    <div class="avatar avatar-item rounded-2">
                        <i class="ri-group-line"></i>
                    </div>
                    <div>
                        <span class="mb-2 fs-12 text-muted">Total Customers</span>
                        <h5 class="fw-medium mb-1">{{ number_format($totalCustomers) }}</h5>
                    </div>
                </div>
                <div class="card-body bg-light py-2 bg-opacity-40 hstack justify-content-between gap-3">
                    <div class="hstack gap-3">
                        <h6 class="mb-0 fw-semibold">Active:</h6>
                        <p class="fs-12 text-muted mb-0">{{ number_format($activeCustomers) }}</p>
                    </div>
                    <div class="vr h-30px align-self-center bg-light"></div>
                    <div class="hstack gap-3">
                        <h6 class="mb-0 fw-semibold">New (30d):</h6>
                        <p class="fs-12 text-muted mb-0">{{ number_format($newCustomers) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Products Card -->
        <div class="col-lg-4">
            <div class="card card-hover overflow-hidden">
                <div class="card-body hstack gap-2">
                    <div class="avatar avatar-item rounded-2">
                        <i class="ri-book-line"></i>
                    </div>
                    <div>
                        <span class="mb-2 fs-12 text-muted">Total Products</span>
                        <h5 class="fw-medium mb-1">{{ number_format($totalProducts) }}</h5>
                    </div>
                </div>
                <div class="card-body bg-light py-2 bg-opacity-40 hstack justify-content-between gap-3">
                    <div class="hstack gap-3">
                        <h6 class="mb-0 fw-semibold">Active:</h6>
                        <p class="fs-12 text-muted mb-0">{{ number_format($activeProducts) }}</p>
                    </div>
                    <div class="vr h-30px align-self-center bg-light"></div>
                    <div class="hstack gap-3">
                        <h6 class="mb-0 fw-semibold">Out of Stock:</h6>
                        <p class="fs-12 text-muted mb-0">{{ number_format($outOfStock) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Sales Card -->
        <div class="col-lg-4">
            <div class="card card-hover overflow-hidden">
                <div class="card-body hstack gap-2">
                    <div class="avatar avatar-item rounded-2">
                        <i class="ri-money-dollar-circle-line"></i>
                    </div>
                    <div>
                        <span class="mb-2 fs-12 text-muted">Total Revenue</span>
                        <h5 class="fw-medium mb-1">₹{{ number_format($totalSalesAmount, 2) }}</h5>
                    </div>
                </div>
                <div class="card-body bg-light py-2 bg-opacity-40 hstack justify-content-between gap-3">
                    <div class="hstack gap-3">
                        <h6 class="mb-0 fw-semibold">Total Invoices:</h6>
                        <p class="fs-12 text-muted mb-0">{{ number_format($totalSalesCount) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Sales and Chart -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Sales Trends (Last 6 Months)</h4>
                </div>
                <div class="card-body">
                    <div id="sales_trend_chart" class="apex-charts"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Quick Statistics</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <p class="text-muted mb-1">Total Sales Count</p>
                        <h4 class="mb-0">{{ number_format($totalSalesCount) }}</h4>
                    </div>
                    <div class="mb-3">
                        <p class="text-muted mb-1">Total Revenue</p>
                        <h4 class="mb-0">₹{{ number_format($totalSalesAmount, 2) }}</h4>
                    </div>
                    <div>
                        <p class="text-muted mb-1">Avg. Sale Value</p>
                        <h4 class="mb-0">₹{{ $totalSalesCount > 0 ? number_format($totalSalesAmount / $totalSalesCount, 2) : 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Recent Sales</h4>
                    <a href="{{ route('sales.index') }}" class="btn btn-sm btn-soft-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Invoice No</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentSales as $sale)
                                    <tr>
                                        <td><a href="{{ route('sales.show', $sale->id) }}" class="fw-medium">{{ $sale->invoice_no }}</a></td>
                                        <td>{{ $sale->customer->name ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d M, Y') }}</td>
                                        <td>₹{{ number_format($sale->total_amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $sale->payment_status == 'Paid' ? 'success' : ($sale->payment_status == 'Partial' ? 'warning' : 'danger') }}-subtle text-{{ $sale->payment_status == 'Paid' ? 'success' : ($sale->payment_status == 'Partial' ? 'warning' : 'danger') }}">
                                                {{ $sale->payment_status }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-light">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No sales found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var options = {
                series: [{
                    name: 'Sales',
                    data: {!! json_encode($monthlySales->pluck('total')) !!}
                }],
                chart: {
                    height: 350,
                    type: 'area',
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3,
                },
                xaxis: {
                    categories: {!! json_encode($monthlySales->pluck('month')) !!},
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            return "₹" + value.toLocaleString();
                        }
                    }
                },
                colors: ['#0ab39c'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.3,
                        stops: [0, 90, 100]
                    }
                },
            };

            var chart = new ApexCharts(document.querySelector("#sales_trend_chart"), options);
            chart.render();
        });
    </script>
    <script type="module" src="{{ asset('assets/js/app.js') }}"></script>
@endsection
