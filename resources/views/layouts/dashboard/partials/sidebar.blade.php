<div class="sidebar-wrapper active">
    <div class="sidebar-header position-relative">
        <div class="d-flex justify-content-evenly align-items-center">
            <div class="logo">
                <a href="#">
                    <img src="{{ asset('assets/images/logo-siajaib.png') }}">
                </a>
            </div>
        </div>
    </div>
    <div class="sidebar-menu">
        <ul class="menu">
            <li class="sidebar-title">Menu</li>

            <li class="sidebar-item {{ (request()->routeIs('dashboard*') || auth()->user()->is_public) && !request()->routeIs('profile*') ? 'active' : '' }}">
                <a class="sidebar-link"
                   href="{{ route('dashboard') }}">
                    <i class="isax isax-element-4"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>
    </div>
</div>
