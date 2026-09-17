@extends('layouts.landing.auth-base')

@section('content')
    <x-landing.hero showBackButton="true">
        <div class="content-header">
            <div class="d-flex align-items-center gap-3 flex-row-reverse">
                <img alt=""
                     class="img-logo-auth"
                     src="{{ asset('assets/images/siap-aum/siap-aum-mark.svg') }}">
                <img alt=""
                     class="img-logo-auth"
                     src="{{ asset('assets/images/siap-aum/figma-raw-3.png') }}">
            </div>
            <div class="text-center my-3 w-100 auth-header">
                <h3 class="title text-main">Verifikasi OTP</h3>
                <p class="caption text-main">Kode Sudah dikirikan ke alamat email anda <span class="text-primary fw-bold">gevinjanitto@gmail.com</span></p>
                <p class="text-primary fw-semibold my-4">02:32</p>
                <x-otp-input />
                <p class="mt-2 text-main">Belum Mendapatkan Kode? <a class="text-danger"
                    href="{{ route('login.index') }}">Kirim Ulang</a></p>
            </div>
        </div>
    </x-landing.hero>
@endsection

@vite(['resources/js/pages/register.js'])
