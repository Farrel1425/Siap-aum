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
            {{-- @role('administrator') --}}
                <li class="sidebar-item {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
                    <a class="sidebar-link"
                       href="{{ route('dashboard') }}">
                        <i class="isax isax-element-4"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            {{-- @endrole --}}

            {{-- @role('operator')
                <li class="sidebar-item {{ request()->routeIs('pelaporan*') ? 'active' : '' }}">
                    <a class="sidebar-link"
                       href="{{ route('pelaporan.index') }}">
                        <i class="isax isax-receipt"></i>
                        <span>Pelaporan</span>
                    </a>
                </li>
            @endrole --}}
        </ul>
    </div>
</div>
