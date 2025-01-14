<header>
    <nav class="navbar navbar-expand navbar-light navbar-top bg-white">
        <div class="container-fluid">
            <a class="burger-btn d-block"
               href="#">
                <span class="isax-bold isax-arrow-swap-horizontal fs-3"></span>
            </a>
            <button aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                    class="navbar-toggler"
                    data-bs-target="#navbarSupportedContent"
                    data-bs-toggle="collapse"
                    type="button">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse"
                 id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-lg-0 me-4">
                    {{-- <li class="nav-item dropdown me-1">
                        <a aria-expanded="false"
                           class="nav-link active dropdown-toggle text-main"
                           data-bs-toggle="dropdown"
                           href="#">
                             <i class="isax-bold isax-notification fs-4"></i>
                        </a>
                        <ul aria-labelledby="dropdownMenuButton"
                            class="dropdown-menu  dropdown-menu-lg-end">
                            <li>
                                <h6 class="dropdown-header">Mail</h6>
                            </li>
                            <li><a class="dropdown-item"
                                   href="#">No new mail</a></li>
                        </ul>
                    </li> --}}
                </ul>
                <div class="dropdown">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                            <div class="user-name text-end me-3">
                                <h6 class="mb-0 text-main">{{ auth()->user()->name ?? auth()->user()->email }}</h6>
                                <p class="mb-0 text-sm text-main">{{ auth()->user()->role->nama }}</p>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md border">
                                    <img src="{{ auth()->user()->photo_profile }}">
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                        style="min-width: 11rem;">
                        <li>
                            <h6 class="dropdown-header">Hello, {{ auth()->user()->name ?? 'Guest' }}</h6>
                            {{-- <h6 class="dropdown-header">Hello, Kambing</h6> --}}
                        </li>
                        <li><a class="dropdown-item" href="{{ route('profile.index') }}">
                                <i class="icon-mid bi bi-person me-2"></i> My Profile
                            </a>
                        </li>
                        <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item" href="#"><i
                                        class="icon-mid bi bi-box-arrow-left me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
