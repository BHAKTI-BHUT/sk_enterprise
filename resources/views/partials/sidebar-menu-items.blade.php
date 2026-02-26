@php
    $isUserManagementActive = request()->routeIs('user.*') || request()->routeIs('role.*');
    $isProductManagementActive = request()->routeIs('product.*');
    $isSystemSettingActive = request()->routeIs('settings.*') || request()->routeIs('profile.*');
@endphp

<ul class="main-menu" id="all-menu-items" role="menu">
    <li class="menu-title" role="presentation" data-lang="hr-title-main">Main</li>
    <li class="slide">
        <a href="{{ route('dashboard') }}" class="side-menu__item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
            role="menuitem">
            <span class="side_menu_icon"><i class="ri-home-2-line"></i></span>
            <span class="side-menu__label" data-lang="hr-dashboards">Dashboards</span>
        </a>
    </li>


    {{-- inventory start --}}
    <li class="menu-title" role="presentation" data-lang="hr-title-inventory">Inventory Management</li>

    @can('view product')
        <li class="slide {{ $isProductManagementActive ? 'active' : '' }}">
            <a href="#!" class="side-menu__item {{ $isProductManagementActive ? 'active' : '' }}" role="menuitem">
                <span class="side_menu_icon"><i class="ri-shopping-basket-2-line"></i></span>
                <span class="side-menu__label" data-lang="hr-products">Inventory Management</span>
                <i class="ri-arrow-down-s-line side-menu__angle"></i>
            </a>

            <ul class="slide-menu" role="menu">

                {{-- Product --}}
                @can('view product')
                    <li class="slide">
                        <a href="{{ route('product.index') }}"
                            class="side-menu__item {{ request()->routeIs('product.*') ? 'active' : '' }}" role="menuitem">
                            Product Manage
                        </a>
                    </li>
                @endcan

                {{-- Brand --}}
                @can('view brand')
                    <li class="slide">
                        <a href="{{ route('brand.index') }}"
                            class="side-menu__item {{ request()->routeIs('brand.*') ? 'active' : '' }}" role="menuitem">
                            Brand Manage
                        </a>
                    </li>
                @endcan

                {{-- Category --}}
                @can('view category')
                    <li class="slide">
                        <a href="{{ route('category.index') }}"
                            class="side-menu__item {{ request()->routeIs('category.*') ? 'active' : '' }}" role="menuitem">
                            Category Manage
                        </a>
                    </li>
                @endcan

            </ul>
        </li>
    @endcan
    {{-- inventory end --}}

    {{-- applications start --}}
    <li class="menu-title" role="presentation" data-lang="hr-title-applications">Applications</li>
    <li class="slide {{ $isUserManagementActive ? 'active' : '' }}">
        <a href="#!" class="side-menu__item {{ $isUserManagementActive ? 'active' : '' }}" role="menuitem">
            <span class="side_menu_icon"><i class="ri-gallery-view-2"></i></span>
            <span class="side-menu__label" data-lang="hr-apps">User Management</span>
            <i class="ri-arrow-down-s-line side-menu__angle"></i>
        </a>
        <ul class="slide-menu" role="menu">
            <li class="slide">
                <a href="{{ route('user.index') }}"
                    class="side-menu__item {{ request()->routeIs('user.index') ? 'active' : '' }}" role="menuitem"
                    data-lang="hr-apps-calendar">User
                    Manage</a>
            </li>

            <li class="slide">
                <a href="{{ route('role.index') }}"
                    class="side-menu__item {{ request()->routeIs('role.index') ? 'active' : '' }}" role="menuitem"
                    data-lang="hr-apps-calendar">Role
                    Manage</a>
            </li>

        </ul>
    </li>
    {{-- applications end --}}

    {{-- system setting --}}
    <li class="menu-title" role="presentation" data-lang="hr-title-tables">Settings</li>
    <li class="slide {{ $isSystemSettingActive ? 'active' : '' }}">
        <a href="#!" class="side-menu__item {{ $isSystemSettingActive ? 'active' : '' }}" role="menuitem">
            <span class="side_menu_icon"><i class="ri-settings-3-line"></i></span>
            <span class="side-menu__label" data-lang="hr-tables">System Setting</span>
            <i class="ri-arrow-down-s-line side-menu__angle"></i>
        </a>
        <ul class="slide-menu" role="menu">

            <li class="slide">
                <a href="{{ route('settings.edit') }}"
                    class="side-menu__item {{ request()->routeIs('settings.edit') ? 'active' : '' }}" role="menuitem"
                    data-lang="hr-basic-table">General Settings</a>
            </li>

            <li class="slide">
                <a href="{{ route('profile.edit') }}"
                    class="side-menu__item {{ request()->routeIs('profile.edit') ? 'active' : '' }}" role="menuitem"
                    data-lang="hr-basic-table">Profile Settings</a>
            </li>

        </ul>   
    </li>
    {{-- end system setting --}}
</ul>
