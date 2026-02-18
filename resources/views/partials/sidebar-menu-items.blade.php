<ul class="main-menu" id="all-menu-items" role="menu">
    <li class="menu-title" role="presentation" data-lang="hr-title-main">Main</li>
    <li class="slide">
        <a href="{{ route('dashboard') }}" class="side-menu__item" role="menuitem">
            <span class="side_menu_icon"><i class="ri-home-2-line"></i></span>
            <span class="side-menu__label" data-lang="hr-dashboards">Dashboards</span>
        </a>
    </li>


    {{-- applications start --}}
    <li class="menu-title" role="presentation" data-lang="hr-title-applications">Applications</li>
    <li class="slide">
        <a href="#!" class="side-menu__item" role="menuitem">
            <span class="side_menu_icon"><i class="ri-gallery-view-2"></i></span>
            <span class="side-menu__label" data-lang="hr-apps">User Management</span>
            <i class="ri-arrow-down-s-line side-menu__angle"></i>
        </a>
        <ul class="slide-menu" role="menu">
            <li class="slide">
                <a href="{{ route('user.index') }}" class="side-menu__item" role="menuitem"
                    data-lang="hr-apps-calendar">User
                    Manage</a>
            </li>

            <li class="slide">
                <a href="{{ route('role.index') }}" class="side-menu__item" role="menuitem"
                    data-lang="hr-apps-calendar">Role
                    Manage</a>
            </li>

        </ul>
    </li>
    {{-- applications end --}}

    {{-- system setting --}}
    <li class="menu-title" role="presentation" data-lang="hr-title-tables">setting</li>
    <li class="slide">
        <a href="#!" class="side-menu__item" role="menuitem">
            <span class="side_menu_icon"><i class="ri-table-line"></i></span>
            <span class="side-menu__label" data-lang="hr-tables">System Setting</span>
            <i class="ri-arrow-down-s-line side-menu__angle"></i>
        </a>
        <ul class="slide-menu" role="menu">
            <li class="slide">
                <a href="system-setting" class="side-menu__item" role="menuitem" data-lang="hr-basic-table">Footer
                    Setting</a>
            </li>
            <li class="slide">
                <a href="system-setting" class="side-menu__item" role="menuitem" data-lang="hr-basic-table">Profile
                    Setting</a>
            </li>
        </ul>
    </li>
    {{-- end system setting --}}
</ul>
