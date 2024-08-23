@extends('layouts.landing.auth-base')

{{-- @section('content-header')
    <div class="content-header">
        <div class="d-flex align-items-center justify-content-center gap-3 flex-row-reverse">
            <img alt=""
                 class="img-logo-auth"
                 src="{{ asset('assets/images/logo-siajaib.png') }}">
            <img alt=""
                 class="img-logo-auth"
                 src="{{ asset('assets/images/logo-kabupaten.png') }}">
        </div>
        <div class="text-center my-3 w-100 w-md-75 auth-header">
            <h3 class="title text-main">Selamat Datang</h3>
            <p class="caption text-main">Masuk ke akun anda</p>
            <form action="{{ route('login.store') }}" method="POST">
                @csrf
                <x-landing.input-email placeholder="Email" name="email"/>
                <x-landing.input-password placeholder="Password" name="password" />
                <a href="" class="fw-bold d-block mb-2 text-danger text-end">Lupa Password?</a>
                <button type="submit" class="btn btn-danger d-block w-100 fw-bold">Masuk</button>
                <p class="mt-2 text-main">Belum Punya Akun? <a href="{{ route('register.index') }}" class="text-danger fw-bold">Daftar Akun</a></p>
            </form>
        </div>
    </div>
@endsection --}}

@section('content')
    <x-landing.hero showBackButton="true">
        <div class="content-header">
            <div class="d-flex align-items-center justify-content-center gap-3 flex-row-reverse">
                <img alt=""
                     class="img-logo-auth"
                     src="{{ asset('assets/images/logo-siajaib.png') }}">
                <img alt=""
                     class="img-logo-auth"
                     src="{{ asset('assets/images/logo-kabupaten.png') }}">
            </div>
            <div class="text-center my-3 w-100 auth-header">
                <h3 class="title text-main">Selamat Datang</h3>
                <p class="caption text-main">Masuk ke akun anda</p>
                <form action="{{ route('login.store') }}" method="POST">
                    @csrf
                    <x-landing.input-email placeholder="Email" name="email"/>
                    <x-landing.input-password placeholder="Password" name="password" />
                    <a href="" class="fw-bold d-block mb-2 text-danger text-end">Lupa Password?</a>
                    <button type="submit" class="btn btn-danger d-block w-100 fw-bold">Masuk</button>
                    <p class="mt-2 text-main">Belum Punya Akun? <a href="{{ route('register.index') }}" class="text-danger fw-bold">Daftar Akun</a></p>
                </form>
            </div>
        </div>
    </x-landing.hero>
@endsection
