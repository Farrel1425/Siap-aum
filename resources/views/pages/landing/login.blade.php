@extends('layouts.landing.auth-base')

@section('content-header')
    <div class="content-header">
        <div class="d-flex align-items-center gap-3 flex-row-reverse">
            <img alt=""
                 class="img-logo-auth"
                 src="{{ asset('assets/images/logo-siajaib.png') }}">
            <img alt=""
                 class="img-logo-auth"
                 src="{{ asset('assets/images/logo-kabupaten.png') }}">
        </div>
        <div class="text-center my-3 w-75">
            <h3 class="title text-main">Selamat Datang</h3>
            <p class="caption text-main">Masuk ke akun anda</p>
            <form action="" method="POST">
                @csrf
                <x-landing.input-text placeholder="Username"/>
                <x-landing.input-password placeholder="Password" />
                <a href="" class="fw-bold d-block mb-2 text-danger text-end">Lupa Password?</a>
                <button type="submit" class="btn btn-danger d-block w-100 fw-bold">Masuk</button>
                <p class="mt-2 text-main">Belum Punya Akun? <a href="" class="text-danger">Daftar Akun</a></p>
            </form>
        </div>
    </div>
@endsection
