<!-- START SIDEBAR -->
<aside class="app-sidebar">
    <!-- START BRAND LOGO -->
    @php
        $sidebarLogo = \App\Models\Setting::get('logo', 'assets/images/light-logo.png');
        $sidebarFavicon = \App\Models\Setting::get('favicon', 'assets/images/Favicon.png');
    @endphp
    <div class="app-sidebar-logo px-6">
        <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-decoration-none">
            <img height="35" class="me-2" alt="Logo" src="{{ asset($sidebarFavicon) }}">
            {{-- <span class="fs-4 fw-bold app-sidebar-logo-default">
                <span style="color: #ed1c24;">SK</span> <span style="color: #212529;">Enterprise</span>
            </span> --}}
        </a>
    </div>
    <!-- END BRAND LOGO -->
    <nav class="app-sidebar-menu nav nav-pills flex-column fs-6" id="sidebarMenu" aria-label="Main navigation">
        @include('partials.sidebar-menu-items')
    </nav>
</aside>
<!-- END SIDEBAR -->
<div class="horizontal-overlay"></div>

<!-- START SMALL SCREEN SIDEBAR -->
<div class="offcanvas offcanvas-md offcanvas-start small-screen-sidebar" data-bs-scroll="true" tabindex="-1"
    id="smallScreenSidebar" aria-labelledby="smallScreenSidebarLabel">
    <div class="offcanvas-header hstack border-bottom">
        <!-- START BRAND LOGO -->
        <div class="app-sidebar-logo px-6">
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-decoration-none">
                <img height="35" class="me-2" alt="Logo" src="{{ asset($sidebarFavicon) }}">
                <span class="fs-4 fw-bold app-sidebar-logo-default">
                    <span style="color: #ed1c24;">SK</span> <span style="color: #212529;">Enterprise</span>
                </span>
            </a>
        </div>
        <button type="button" class="btn-close bg-transparent" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="ri-close-line"></i>
        </button>
    </div>
    <div class="offcanvas-body p-0">
        <!-- START SIDEBAR -->
        <aside class="app-sidebar">
            <!-- END BRAND LOGO -->
            <nav class="app-sidebar-menu nav nav-pills flex-column fs-6" aria-label="Main navigation">
                @include('partials.sidebar-menu-items')

            </nav>
        </aside>
    </div>
</div>
