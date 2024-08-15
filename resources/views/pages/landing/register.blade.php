@extends('layouts.landing.auth-base')

{{-- @section('content-header')
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
            <h3 class="title text-main">Daftar Akun</h3>
            <p class="caption text-main">Masuk ke akun anda</p>
            <input id="route_otp"
                   type="hidden"
                   value="{{ route('register.otp.generate') }}">
            <input id="route_register"
                   type="hidden"
                   value="{{ route('register.store') }}">
            <input id="csrf_token"
                   type="hidden"
                   value="{{ csrf_token() }}">
            <x-landing.input-email :required=True
                                   name="email"
                                   placeholder="Email" />
            <x-landing.input-password :required=True
                                      name="password"
                                      placeholder="Password" />
            <x-landing.input-password :required=True
                                      name="password_verify"
                                      placeholder="Masukkan password kembali" />
            <button class="btn btn-danger d-block w-100 fw-bold"
                    id="generate_otp"
                    type="button">Daftar</button>
            <p class="mt-2 text-main">Sudah Punya Akun? <a class="text-danger"
                   href="{{ route('login.index') }}">Masuk</a></p>
        </div>
    </div>

    <div aria-hidden="true"
         aria-labelledby="staticBackdropLabel"
         class="modal fade bg-transparent"
         data-bs-backdrop="static"
         data-bs-keyboard="false"
         id="staticBackdrop"
         tabindex="-1">
        <div class="modal-dialog modal-dialog-centered bg-transparent">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bold"
                        id="staticBackdropLabel">Verifikasi Email</h1>
                    <button aria-label="Close"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            type="button"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Masukkan kode otp yang dikirimkan ke email anda. Jangan bagikan kode OTP anda
                        kepada
                        siapapun.</p>
                    <div class="mb-3 mt-3">
                        <x-otp-input />
                    </div>
                    <p class="text-center mb-0"
                       id="countdown-container">(OTP Terakhir <span id="last_otp_at"></span>) Anda dapat melakukan kirim
                        ulang kode
                        OTP setelah <span class="fw-bold"
                              id="countdown">-:-</span></p>
                    <p class="text-center mb-0 d-none"
                       id="resend-otp-container">Tidak mendapatkan Kode Verifikasi? <button
                                class="fw-bold text-decoration-none text-primary bg-transparent border-0"
                                href="#"
                                id="resend-otp">Kirim Ulang</button></p>
                    <div class="form-group mt-3 d-flex justify-content-center">
                        {!! htmlFormSnippet() !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary w-100"
                            id="register"
                            type="button">Verifikasi</button>
                </div>
            </div>
        </div>
    </div>
@endsection --}}

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
                <h3 class="title text-main">Daftar Akun</h3>
                <p class="caption text-main">Masuk ke akun anda</p>
                <input id="route_otp"
                       type="hidden"
                       value="{{ route('register.otp.generate') }}">
                <input id="route_register"
                       type="hidden"
                       value="{{ route('register.store') }}">
                <input id="csrf_token"
                       type="hidden"
                       value="{{ csrf_token() }}">
                <x-landing.input-email :required=True
                                       name="email"
                                       placeholder="Email" />
                <x-landing.input-password :required=True
                                          name="password"
                                          placeholder="Password" />
                <x-landing.input-password :required=True
                                          name="password_verify"
                                          placeholder="Masukkan password kembali" />
                <button class="btn btn-danger d-block w-100 fw-bold"
                        id="generate_otp"
                        type="button">Daftar</button>
                <p class="mt-2 text-main">Sudah Punya Akun? <a class="text-danger"
                       href="{{ route('login.index') }}">Masuk</a></p>
            </div>
        </div>
    </x-landing.hero>
@endsection

@vite(['resources/js/pages/register.js'])
