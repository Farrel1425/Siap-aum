<div class="sidebar-wrapper active">
    <div class="sidebar-header position-relative">
        <div class="sa-dashboard-brand d-flex align-items-center">
            <div class="logo">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('assets/images/siap-aum/siap-aum-mark.svg') }}" alt="SIAP AUM">
                </a>
            </div>
            <div><strong>SIAP AUM</strong><span>Perizinan Tabanan</span></div>
        </div>
    </div>
    <div class="sidebar-menu">
        <ul class="menu">
            <li class="sidebar-title">MENU UTAMA</li>

            <li
                class="sidebar-item {{ (request()->routeIs('dashboard*') || auth()->user()->is_public) && !request()->routeIs('profile*') ? 'active' : '' }}">
                <a class="sidebar-link"
                   href="{{ route('dashboard') }}">
                    <i class="isax isax-element-4"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            @if (auth()->user()->is_admin)
                <li class="sidebar-item {{ request()->routeIs('admin.permohonan.*') ? 'active' : '' }}">
                    <a class="sidebar-link"
                       href="{{ route('admin.permohonan.index') }}">
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
                        <li class="submenu-item {{ request()->routeIs('admin.master-data.user.*') ? 'active' : '' }}">
                            <a class="submenu-link"
                               href="{{ route('admin.master-data.user.index') }}">
                                User</a>
                        </li>
                        <li
                            class="submenu-item {{ request()->routeIs('admin.master-data.jenis-izin.*') ? 'active' : '' }}">
                            <a class="submenu-link"
                               href="{{ route('admin.master-data.jenis-izin.index') }}">
                                Jenis Ijin</a>
                        </li>
                        <li
                            class="submenu-item {{ request()->routeIs('admin.master-data.sektor-izin.*') ? 'active' : '' }}">
                            <a class="submenu-link"
                               href="{{ route('admin.master-data.sektor-izin.index') }}">
                                Sektor Ijin</a>
                        </li>
                        <li
                            class="submenu-item {{ request()->routeIs('admin.master-data.kategori-izin.*') ? 'active' : '' }}">
                            <a class="submenu-link"
                               href="{{ route('admin.master-data.kategori-izin.index') }}">
                                Kategori Ijin</a>
                        </li>
                        <li
                            class="submenu-item {{ request()->routeIs('admin.master-data.layanan-skm.*') ? 'active' : '' }}">
                            <a class="submenu-link"
                               href="{{ route('admin.master-data.layanan-skm.index') }}">
                                Layanan SKM</a>
                        </li>
                        <li
                            class="submenu-item {{ request()->routeIs('admin.master-data.survey.*') ? 'active' : '' }}">
                            <a class="submenu-link"
                               href="{{ route('admin.master-data.survey.index') }}">
                                Survey</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-sub {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                    <a class="sidebar-link"
                       href="#">
                        <i class="isax isax-task-square"></i>
                        <span>Laporan</span>
                    </a>
                    <ul class="submenu">
                        <li
                            class="submenu-item {{ request()->routeIs('admin.laporan.ijin-terbit-bulanan.*') ? 'active' : '' }}">
                            <a class="submenu-link"
                               href="{{ route('admin.laporan.ijin-terbit-bulanan.index') }}">
                                Ijin Terbit Bulanan</a>
                        </li>
                        <li
                            class="submenu-item {{ request()->routeIs('admin.laporan.rekap-permohonan.*') ? 'active' : '' }}">
                            <a class="submenu-link"
                               href="{{ route('admin.laporan.rekap-permohonan.index') }}">
                                Detail Permohonan</a>
                        </li>
                        <li
                            class="submenu-item {{ request()->routeIs('admin.laporan.survey-layanan.*') ? 'active' : '' }}">
                            <a class="submenu-link"
                               href="{{ route('admin.laporan.survey-layanan.index') }}">
                                Survey Layanan</a>
                        </li>
                        <li
                            class="submenu-item {{ request()->routeIs('admin.laporan.buku-tamu.*') ? 'active' : '' }}">
                            <a class="submenu-link"
                               href="{{ route('admin.laporan.buku-tamu.index') }}">
                                Buku Tamu</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-sub {{ request()->routeIs('admin.log-sistem.*') ? 'active' : '' }}">
                    <a class="sidebar-link"
                       href="#">
                        <i class="isax isax-radar"></i>
                        <span>Log Sistem</span>
                    </a>
                    <ul class="submenu">
                        <li
                            class="submenu-item {{ request()->routeIs('admin.log-sistem.otp-gagal.*') ? 'active' : '' }}">
                            <a class="submenu-link"
                               href="{{ route('admin.log-sistem.otp-gagal.index') }}">
                                Otp Gagal</a>
                        </li>
                        <li
                            class="submenu-item {{ request()->routeIs('admin.log-sistem.otp-sukses.*') ? 'active' : '' }}">
                            <a class="submenu-link"
                               href="{{ route('admin.log-sistem.otp-sukses.index') }}">
                                Otp Sukses</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (auth()->user()->is_verifikator)
                <li class="sidebar-item {{ request()->routeIs('verifikator.permohonan.*') ? 'active' : '' }}">
                    <a class="sidebar-link"
                       href="{{ route('verifikator.permohonan.index') }}">
                        <i class="isax isax-receipt"></i>
                        <span>Permohonan</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('verifikator.verifikasi.*') ? 'active' : '' }}">
                    <a class="sidebar-link"
                       href="{{ route('verifikator.verifikasi.index') }}">
                        <i class="isax isax-receipt"></i>
                        <span>Verifikasi</span>
                    </a>
                </li>
                <li class="sidebar-item has-sub {{ request()->routeIs('verifikator.laporan.*') ? 'active' : '' }}">
                    <a class="sidebar-link"
                       href="#">
                        <i class="isax isax-task-square"></i>
                        <span>Laporan</span>
                    </a>
                    <ul class="submenu">
                        <li class="submenu-item actives">
                            <a class="submenu-link"
                               href="{{ route('verifikator.laporan.rekap-permohonan.index') }}">
                                Detail Permohonan</a>
                        </li>
                    </ul>
                </li>
                {{-- <li
                    class="sidebar-item actives">
                    <a class="sidebar-link"
                       href="#">
                        <i class="isax isax-document-1"></i>
                        <span>Surat Permohonan</span>
                    </a>
                </li> --}}
            @endif
        </ul>
    </div>
</div>
