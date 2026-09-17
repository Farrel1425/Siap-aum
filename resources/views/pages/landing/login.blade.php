@extends('layouts.landing.auth-base')

@section('content')
<main class="sa-login-page">
    <section class="sa-login-visual">
        <a class="sa-login-back" href="{{ route('home') }}" aria-label="Kembali ke beranda"><i class="isax isax-arrow-left-2"></i></a>
        <div class="sa-login-visual__wash"></div>
        <div class="sa-login-visual__content">
            <span class="sa-login-logo"><img src="{{ asset('assets/images/siap-aum/siap-aum-mark.svg') }}" alt=""></span>
            <h1>Selamat datang<br>di SIAP AUM</h1>
            <p>Sistem Informasi Administrasi Perizinan Andal, Unggul, Nyaman, dan Gesit</p>
        </div>
    </section>
    <section class="sa-login-panel">
        <div class="sa-login-card">
            <div class="sa-login-card__heading"><span class="sa-eyebrow"><i></i>Login</span><h2>Masuk ke akun anda</h2><p>Silakan masukkan email dan password yang telah terdaftar.</p></div>
            <form action="{{ route('login.store') }}" method="POST">
                @csrf
                <div class="sa-login-field"><label for="email">Email</label><input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="Masukkan email" autocomplete="email" required>@error('email')<span>{{ $message }}</span>@enderror</div>
                <div class="sa-login-field"><label for="password">Password</label><div><input id="password" name="password" type="password" placeholder="Masukkan password" autocomplete="current-password" required><button class="btn-toggle-password isax isax-eye-slash" type="button" aria-label="Tampilkan password"></button></div></div>
                <div class="sa-login-captcha">{!! htmlFormSnippet() !!}</div>
                <a class="sa-login-forgot" href="{{ route('forgot-password.index') }}">Lupa Password?</a>
                <button class="sa-login-submit" type="submit">Masuk</button>
                <p class="sa-login-register">Belum Punya Akun? <a href="{{ route('register.index') }}">Daftar Akun</a></p>
                <div class="sa-login-partners"><img src="{{ asset('assets/images/maiharta.png') }}" alt="Maiharta"><img src="{{ asset('assets/images/bsre.png') }}" alt="BSrE"></div>
            </form>
        </div>
    </section>
</main>
@endsection
