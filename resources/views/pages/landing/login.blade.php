@extends('layouts.landing.auth-base')

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
                <form action="{{ route('login.store') }}"
                      method="POST">
                    @csrf
                    <x-landing.input-email name="email"
                                           placeholder="Email" />
                    <x-landing.input-password name="password"
                                              placeholder="Password" />
                    {!! htmlFormSnippet() !!}
                    <a class="fw-bold d-block mb-2 mt-2 text-danger text-end"
                       href="{{ route('forgot-password.index') }}">Lupa Password?</a>
                    <button class="btn btn-danger d-block w-100 fw-bold"
                            type="submit">Masuk</button>
                    <p class="mt-2 text-main">Belum Punya Akun? <a class="text-danger fw-bold"
                           href="{{ route('register.index') }}">Daftar Akun</a></p>
                </form>
            </div>
        </div>
    </x-landing.hero>
@endsection
