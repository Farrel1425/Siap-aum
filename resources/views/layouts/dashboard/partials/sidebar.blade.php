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

            <li
                class="sidebar-item {{ (request()->routeIs('dashboard*') || auth()->user()->is_public) && !request()->routeIs('profile*') ? 'active' : '' }}">
                <a class="sidebar-link"
                   href="{{ route('dashboard') }}">
                    <i class="isax isax-element-4"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            @if (auth()->user()->is_admin)
                <li
                    class="sidebar-item actives">
                    <a class="sidebar-link"
                       href="#">
                        <i class="isax isax-receipt"></i>
                        <span>Permohonan</span>
                    </a>
                </li>
                <li class="sidebar-item has-sub {{ request()->routeIs('admin.master-data.*') ? 'active' : '' }}">
                    <a class="sidebar-link"
                       href="#">
                        <i class="isax isax-folder-2"></i>
                        <span>Master Data</span>
                    </a>
                    <ul class="submenu">
                        <li class="submenu-item actives">
                            <a class="submenu-link"
                               href="#">
                                User</a>
                        </li>
                        <li class="submenu-item {{ request()->routeIs('admin.master-data.jenis-izin.index') ? 'active' : '' }}">
                            <a class="submenu-link"
                               href="{{ route('admin.master-data.jenis-izin.index') }}">
                                Jenis Ijin</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-sub actives">
                    <a class="sidebar-link"
                       href="#">
                        <i class="isax isax-task-square"></i>
                        <span>Laporan</span>
                    </a>
                    <ul class="submenu">
                        <li class="submenu-item actives">
                            <a class="submenu-link"
                               href="#">
                                Ijin Terbit Bulanan</a>
                        </li>
                        <li class="submenu-item actives">
                            <a class="submenu-link"
                               href="#">
                                Rekap Permohonan</a>
                        </li>
                        <li class="submenu-item actives">
                            <a class="submenu-link"
                               href="#">
                                Survey Layanan</a>
                        </li>
                    </ul>
                </li>
                <li
                    class="sidebar-item actives">
                    <a class="sidebar-link"
                       href="#">
                        <i class="isax isax-radar"></i>
                        <span>Log Aktivitas</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->is_verifikator)
                <li
                    class="sidebar-item actives">
                    <a class="sidebar-link"
                       href="#">
                        <i class="isax isax-receipt"></i>
                        <span>Verifikasi</span>
                    </a>
                </li>
                <li class="sidebar-item has-sub actives">
                    <a class="sidebar-link"
                       href="#">
                        <i class="isax isax-task-square"></i>
                        <span>Laporan</span>
                    </a>
                    <ul class="submenu">
                        <li class="submenu-item actives">
                            <a class="submenu-link"
                               href="#">
                                Detail Permohonan</a>
                        </li>
                    </ul>
                </li>
                <li
                    class="sidebar-item actives">
                    <a class="sidebar-link"
                       href="#">
                        <i class="isax isax-document-1"></i>
                        <span>Surat Permohonan</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
