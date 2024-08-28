<!--begin::Menu wrapper-->
<?php  $roles = Auth::user()->roles->first()->id; ?>
<div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true"
    data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
    data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end"
    data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
    data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
    data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
    <!--begin::Menu-->
    <div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0"
        id="kt_app_header_menu" data-kt-menu="true">
        <!--begin:Menu item-->
        <div class="menu-item menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
            <a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <span class="menu-title">Dashboard</span>
            </a>
        </div>
        @if($roles == 1)
        <div class="menu-item menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
            <a class="menu-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                <span class="menu-title">Users</span>
            </a>
        </div>
        @endif
    </div>
    <!--end::Menu-->
</div>
<!--end::Menu wrapper-->