@extends('layouts.landing.auth-base')

@section('content')
<main class="sa-login-page sa-reset-page">
    <section class="sa-login-visual">
        <a class="sa-login-back" href="{{ route('login.index') }}" aria-label="Kembali ke halaman login"><i class="isax isax-arrow-left-2"></i></a>
        <div class="sa-login-visual__wash"></div>
        <div class="sa-login-visual__content">
            <div class="sa-register-logos" aria-label="Pemerintah Kabupaten Tabanan dan SIAP AUM">
                <span><img src="{{ asset('assets/images/siap-aum/figma-raw-3.png') }}" alt="Lambang Kabupaten Tabanan"></span>
                <span><img src="{{ asset('assets/images/siap-aum/siap-aum-mark.svg') }}" alt="Logo SIAP AUM"></span>
            </div>
            <h1>Buat password<br>baru Anda</h1>
            <p>Gunakan password yang kuat dan mudah Anda ingat untuk menjaga keamanan akun.</p>
        </div>
    </section>
    <section class="sa-login-panel">
        <div class="sa-login-card sa-register-card">
            <div class="sa-login-card__heading">
                <span class="sa-eyebrow"><i></i>Keamanan akun</span>
                <h2>Reset password</h2>
                <p>Password baru akan digunakan untuk akun <strong>{{ $email }}</strong>.</p>
            </div>
            <form action="{{ route('password.update', $token) }}" method="POST">
                @csrf
                <input name="token" type="hidden" value="{{ $token }}">
                <input name="email" type="hidden" value="{{ $email }}">
                <div class="sa-login-field">
                    <label for="password">Password baru</label>
                    <div><input id="password" name="password" type="password" placeholder="Minimal 8 karakter" autocomplete="new-password" required><button class="btn-toggle-password isax isax-eye-slash" type="button" aria-label="Tampilkan password"></button></div>
                    @error('password')<span>{{ $message }}</span>@enderror
                </div>
                <div class="sa-login-field">
                    <label for="password_verify">Konfirmasi password</label>
                    <div><input id="password_verify" name="password_verify" type="password" placeholder="Masukkan kembali password" autocomplete="new-password" required><button class="btn-toggle-password isax isax-eye-slash" type="button" aria-label="Tampilkan konfirmasi password"></button></div>
                    @error('password_verify')<span>{{ $message }}</span>@enderror
                </div>
                <button class="sa-login-submit" type="submit">Simpan Password Baru</button>
                <p class="sa-login-register"><a href="{{ route('login.index') }}">Kembali ke Login</a></p>
                <div class="sa-login-partners"><img src="{{ asset('assets/images/maiharta.png') }}" alt="Maiharta"><img src="{{ asset('assets/images/bsre.png') }}" alt="BSrE"></div>
            </form>
        </div>
    </section>
</main>
@endsection
