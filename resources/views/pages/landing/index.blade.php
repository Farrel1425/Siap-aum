@extends('layouts.landing.main-base')

@section('content-header')
    <div class="content-header">
        <div class="d-flex align-items-center gap-3 flex-row-reverse">
            <img alt=""
                 class="img-logo"
                 src="{{ asset('assets/images/logo-siajaib.png') }}">
            <img alt=""
                 class="img-logo"
                 src="{{ asset('assets/images/logo-kabupaten.png') }}">
        </div>
        <p class="text-center my-3">
            <span class="fw-bold">SI AJAIB</span> adalah portal pelayanan perizinan online berbasis
            website yang dikembangkan oleh
            Pemerintah Kabupaten Buleleng yang bertujuan untuk memenuhi kebutuhan masyarakat dalam
            pengajuan
            izin yang transparans, inovatif, efektif, dan efisien. Sistem perizinan online ini
            diperuntukkan
            bagi pemohon yang ingin mengajukan permohonan perizinan secara online. Masyarakat dapat
            mengajukan permohonan izin secara mandiri kapan pun dan dimana pun tanpa harus datang
            langsung
            ke kantor DPMPTSP Kabupaten Buleleng.
        </p>
        @auth
            <a class="fw-bold btn btn-outline-danger"
               href="{{ route('dashboard') }}">
                <span class="isax-bold isax-login me-2"></span>Dashboard
            </a>
        @else
            <a class="fw-bold btn btn-outline-danger"
               href="{{ route('login.index') }}">
                <span class="isax-bold isax-login me-2"></span>Login
            </a>
        @endauth

    </div>
@endsection
