<style>
.dataTables_processing {
    display: none !important;
}
</style>
<?php  $roles = Auth::user()->roles->first()->id; ?>
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true"
        data-kt-scroll-activate="true" data-kt-scroll-height="auto"
        data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
        data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
        <div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="#kt_app_sidebar_menu"
            data-kt-menu="true" data-kt-menu-expand="false">
            <div class="menu-item">
                <a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <span class="menu-icon">{!! getIcon('abstract-10', 'fs-2') !!}</span>
                    <span class="menu-title">Dashboard</span>
                </a>
            </div>
            @if($roles == 1)
            <div class="menu-item">
                <a  class="menu-link {{ request()->routeIs('bot-settings') ? 'active' : '' }}" href="{{route('bot-settings')}}">
                    <span class="menu-icon">{!! getIcon('abstract-18', 'fs-2') !!}</span>
                    <span class="menu-title">BOT Setting</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ (request()->routeIs('global-user-setting')) ? 'active' : '' }}"
                    href="{{ route('global-user-setting') }}">
                    <span class="menu-icon">{!! getIcon('setting-2', 'fs-2') !!}</span>
                    <span class="menu-title">Global Setting</span>
                </a>
            </div>
            @else
                <div class="menu-item">
                    <a class="menu-link {{ (request()->routeIs('user_setting')) ? 'active' : '' }}"
                        href="{{ route('user_setting', auth()->user()->id) }}">
                        <span class="menu-icon">{!! getIcon('abstract-18', 'fs-2') !!}</span>
                        <span class="menu-title">Setting</span>
                    </a>
                </div>
            @endif
            <div class="menu-item">
                <a  class="menu-link {{ request()->routeIs('orders') ? 'active' : '' }}" href="{{route('orders')}}">
                    <span class="menu-icon">{!! getIcon('basket', 'fs-2') !!}</span>
                    <span class="menu-title">Orders</span>
                </a>
            </div>
        </div>
    </div>
</div>