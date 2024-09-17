<nav class="navbar navbar-expand-md p-4">
    <a class="navbar-brand me-4"
        href="/"><img alt=""
                class="navbar-image"
                src="{{ asset('assets/images/logo-kabupaten.png') }}"></a>

    <ul class="navbar-nav w-100 mb-2 mb-lg-0 d-flex gap-1">
        <li class="nav-item fw-bold">
            <a aria-current="page"
                class="nav-link active"
                href="{{ route('home') }}">Home</a>
        </li>
        <li class="nav-item fw-bold">
            <a aria-current="page"
                class="nav-link active"
                href="{{ route('user-guide') }}">Panduan Pengguna</a>
        </li>
        <li class="nav-item fw-bold">
            <a aria-current="page"
                class="nav-link active"
                href="{{ route('cek-permohonan.index') }}">Cek Permohonan</a>
        </li>
    </ul>
</nav>
