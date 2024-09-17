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
                <form action="{{ route('forgot-password.store') }}"
                      method="POST">
                    @csrf
                    <h3 class="title text-main">Lupa Password</h3>
                    <p class="caption text-main">Masukkan Informasi dibawah ini untuk reset password</p>
                    <x-landing.input-email :required=True
                                           name="email"
                                           placeholder="Email" />
                    {!! htmlFormSnippet() !!}
                    <button class="btn btn-danger d-block w-100 fw-bold mt-2"
                            type="submit">Ganti Password</button>
                </form>
            </div>
        </div>
    </x-landing.hero>
@endsection

@vite(['resources/js/pages/register.js'])
