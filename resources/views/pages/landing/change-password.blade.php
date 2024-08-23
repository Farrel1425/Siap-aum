@extends('layouts.landing.auth-base')

@section('content')
    <x-landing.hero showBackButton="true">
        <div class="content-header">
            <div class="d-flex align-items-center gap-3 flex-row-reverse">
                <img alt=""
                     class="img-logo-auth"
                     src="{{ asset('assets/images/logo-siajaib.png') }}">
                <img alt=""
                     class="img-logo-auth"
                     src="{{ asset('assets/images/logo-kabupaten.png') }}">
            </div>
            <div class="text-center my-3 w-100 auth-header">
                <h3 class="title text-main">Lupa Password</h3>
                <p class="caption text-main">Masukkan password baru Anda</p>
                <x-landing.input-password :required=True
                                          name="password"
                                          placeholder="Masukkan password baru Anda" />
                <x-landing.input-password :required=True
                                          name="password_verify"
                                          placeholder="Masukkan ulang password baru Anda" />
                <button class="btn btn-danger d-block w-100 fw-bold"
                        id="generate_otp"
                        type="button">Ganti Password</button>
            </div>
        </div>
    </x-landing.hero>
@endsection

@vite(['resources/js/pages/register.js'])
