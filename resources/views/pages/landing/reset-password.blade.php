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
                <form action="{{ route('password.update', $token) }}"
                      method="POST">
                    @csrf
                    <h3 class="title text-main">Reset Password</h3>
                    <p class="caption text-main">Masukkan password baru anda untuk akun <span class="fw-bold">{{ $email }}</span></p>
                    <input name="token"
                           type="hidden"
                           value="{{ $token }}">
                    <input name="email"
                           type="hidden"
                           value="{{ $email }}">
                    <x-landing.input-password :required=True
                                              name="password"
                                              placeholder="Password" />
                    <x-landing.input-password :required=True
                                              name="password_verify"
                                              placeholder="Masukkan password kembali" />
                    <button class="btn btn-danger d-block w-100 fw-bold"
                            type="submit">Ubah Password</button>
                </form>
            </div>
        </div>
    </x-landing.hero>

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
@endsection

@vite(['resources/js/pages/register.js'])
