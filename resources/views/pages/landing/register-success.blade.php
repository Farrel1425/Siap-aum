@extends('layouts.landing.auth-base')

@section('content')
    <x-landing.hero>
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
                <h3 class="title text-main">Daftar Akun Berhasil</h3>
                <p class="caption text-main">Akun anda sudah berhasil didaftarkan, Untuk Masuk Ke akun anda silahkan akun anda diaktifkan oleh staff kami. Akun anda anda <span class="text-primary fw-bold">diaktifkan</span> jika data sudah sesuai dan pemberitahuannya akan dikirimkan melalui <span class="text-primary fw-bold">email</span></p>
                <button class="btn btn-danger d-block w-100 fw-bold"
                        type="button">Kembali</button>
            </div>
        </div>
    </x-landing.hero>
@endsection

@vite(['resources/js/pages/register.js'])
