@extends('partials.Layouts.master3')

@section('title',
    'Online Course Dashboard | Herozi - The Worlds Best Selling Bootstrap Admin & Dashboard Template by
    SRBThemes')
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
        <div class="col-lg-4">
            <div class="card card-hover overflow-hidden">
                <div class="card-body hstack gap-2">
                    <div class="avatar avatar-item rounded-2">
                        <i class="ri-group-line"></i>
                    </div>
                    <div>
                        <span class="mb-2 fs-12 text-muted">Number of Students</span>
                        <h5 class="fw-medium mb-1">1,200</h5>
                    </div>
                </div>
                <div class="card-body bg-light py-2 bg-opacity-40 hstack justify-content-between gap-3">
                    <div class="hstack gap-3">
                        <h6 class="mb-0 fw-semibold">Active Students:</h6>
                        <p class="fs-12 text-muted mb-0">1,000</p>
                    </div>
                    <div class="vr h-30px align-self-center bg-light"></div>
                    <div class="hstack gap-3">
                        <h6 class="mb-0 fw-semibold">New Students:</h6>
                        <p class="fs-12 text-muted mb-0">200</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Courses Card -->
        <div class="col-lg-4">
            <div class="card card-hover overflow-hidden">
                <div class="card-body hstack gap-2">
                    <div class="avatar avatar-item rounded-2">
                        <i class="ri-book-line"></i>
                    </div>
                    <div>
                        <span class="mb-2 fs-12 text-muted">Total Courses</span>
                        <h5 class="fw-medium mb-1">30</h5>
                    </div>
                </div>
                <div class="card-body bg-light py-2 bg-opacity-40 hstack justify-content-between gap-3">
                    <div class="hstack gap-3">
                        <h6 class="mb-0 fw-semibold">Active Courses:</h6>
                        <p class="fs-12 text-muted mb-0">25</p>
                    </div>
                    <div class="vr h-30px align-self-center bg-light"></div>
                    <div class="hstack gap-3">
                        <h6 class="mb-0 fw-semibold">Archived:</h6>
                        <p class="fs-12 text-muted mb-0">5</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Instructor Performance Card -->
        <div class="col-lg-4">
            <div class="card card-hover overflow-hidden">
                <div class="card-body hstack gap-2">
                    <div class="avatar avatar-item rounded-2">
                        <i class="ri-user-star-line"></i>
                    </div>
                    <div>
                        <span class="mb-2 fs-12 text-muted">Instructor Performance</span>
                        <h5 class="fw-medium mb-1">John Doe - 4.8/5</h5>
                    </div>
                </div>
                <div class="card-body bg-light py-2 bg-opacity-40 hstack justify-content-between gap-3">
                    <div class="hstack gap-3">
                        <h6 class="mb-0 fw-semibold">Completion Rate:</h6>
                        <p class="fs-12 text-muted mb-0">85%</p>
                    </div>
                    <div class="vr h-30px align-self-center bg-light"></div>
                    <div class="hstack gap-3">
                        <h6 class="mb-0 fw-semibold">New Reviews:</h6>
                        <p class="fs-12 text-muted mb-0">15</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Leave Application Column -->
        <div class="col-md-6 col-xl-4">
            <div class="card h-100">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <h6 class="card-title mb-0">Leave Application</h6>
                </div>
                <div class="card-body">
                    <div class="full-picker full-picker-scrollable">
                        <input type="text" class="form-control d-none" id="inline-date-picker"
                            placeholder="Select a date">
                    </div>
                </div>
                <!-- Swiper for Leave Applications -->
                <div class="swiper leave-application-swiper mt-3">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="card mb-0 border-0 shadow-none">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="hstack gap-2 overflow-hidden">
                                            <img class="avatar-lg avatar-item rounded-2"
                                                src="{{ asset('assets/images/avatar/avatar-1.jpg') }}" alt="James">
                                            <div class="overflow-hidden">
                                                <h6 class="mb-1 text-truncate"><a href="#!">James</a> <span
                                                        class="badge bg-danger-subtle text-danger">Emergency</span></h6>
                                                <p class="text-muted fs-13 mb-0">Physics Teacher</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <p class="mb-0 text-muted fs-12">Leave: <span class="fw-semibold text-body">12-13
                                                May</span></p>
                                        <p class="mb-0 text-muted fs-12">Apply: <span class="fw-semibold text-body">12
                                                May</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Weekly Activity Overview -->
        <div class="col-md-6 col-xl-4">
            <div class="card h-100">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <h5 class="card-title mb-0">Weekly Activity Overview</h5>
                </div>
                <div class="card-body">
                    <div id="orderAnalyticsDashboard" class="apexcharts-container apexcharts-white"></div>
                    <p class="text-muted fs-13 mt-3">Activity tracking for the entire week, with hours logged each day.</p>
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="p-3 rounded bg-light bg-opacity-40">
                                <span class="text-muted fs-12">Total Active Hours</span>
                                <h6 class="mt-1 mb-0">35 hrs</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded bg-light bg-opacity-40">
                                <span class="text-muted fs-12">Active Days</span>
                                <h6 class="mt-1 mb-0">5 Days</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Categories -->
        <div class="col-md-6 col-xl-4">
            <div class="card h-100">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <h5 class="card-title mb-0">Top Categories</h5>
                </div>
                <div class="card-body p-0 online-course-scroll" data-simplebar>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action border-0">
                            <div class="hstack">
                                <span
                                    class="avatar avatar-item border-0 rounded-3 flex-shrink-0 text-primary bg-primary-subtle">
                                    <i class="ri-dashboard-line fs-20"></i>
                                </span>
                                <div class="ms-3 flex-grow-1">
                                    <h6 class="fw-semibold mb-0">UI / UX Design</h6>
                                    <p class="fs-12 text-muted mb-0">10,000 + Courses</p>
                                </div>
                                <span class="fs-14 fw-medium">$199.99</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Mentors Table -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <h5 class="card-title mb-0">Top Mentors</h5>
                    <a href="#!" class="btn btn-light btn-sm">View All</a>
                </div>
                <div class="card-body h-500px" data-simplebar>
                    <table class="table align-middle table-borderless table-centered table-nowrap mb-0">
                        <thead class="text-muted bg-light bg-opacity-40">
                            <tr>
                                <th scope="col">Mentor Name</th>
                                <th scope="col">Expertise</th>
                                <th scope="col">Course</th>
                                <th scope="col">Experience</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex gap-2 align-items-center">
                                        <img src="{{ asset('assets/images/avatar/avatar-2.jpg') }}" alt="Mentor"
                                            class="avatar rounded-2">
                                        <p class="mb-0 fw-medium">Caleb Riv</p>
                                    </div>
                                </td>
                                <td>Web Designer</td>
                                <td>110</td>
                                <td>12 Years</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Top Courses -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <h5 class="card-title mb-0">Top Courses</h5>
                    <a href="#!" class="link-primary">View All <i class="ri-arrow-right-line"></i></a>
                </div>
                <div class="card-body h-500px" data-simplebar>
                    <ul class="vstack gap-4 list-unstyled mb-0">
                        <li class="hstack gap-3">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('assets/images/small/img-3.jpg') }}" alt="Course"
                                    class="img-fluid rounded avatar-lg">
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <p class="mb-0 text-primary fw-semibold fs-12">UX Design</p>
                                    <p class="mb-0 text-muted fs-12">By Richardino Gueva</p>
                                </div>
                                <a href="#!" class="d-block mb-1 fw-semibold text-body text-truncate">Mastering CSS
                                    Pseudo-classes</a>
                                <div class="d-flex flex-wrap align-items-center gap-2 fs-12 text-muted">
                                    <p class="mb-0"><i class="ri-eye-line me-1"></i>2,189 Views</p>
                                    <p class="mb-0"><i class="ri-star-fill text-warning"></i> 4.2</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="module" src="{{ asset('assets/js/pages/countup.init.js') }}"></script>
    <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/air-datepicker/air-datepicker.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/charts/apexcharts-config.init.js') }}"></script>
    <script src="{{ asset('assets/js/dashboards/dashboard-online-course.init.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/app.js') }}"></script>
@endsection
