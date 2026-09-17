@extends('layouts.landing.auth-base')

@section('content')
<main class="sa-login-page sa-forgot-page">
    <section class="sa-login-visual">
        <a class="sa-login-back" href="{{ route('login.index') }}" aria-label="Kembali ke halaman login"><i class="isax isax-arrow-left-2"></i></a>
        <div class="sa-login-visual__wash"></div>
        <div class="sa-login-visual__content">
            <div class="sa-register-logos" aria-label="Pemerintah Kabupaten Tabanan dan SIAP AUM">
                <span><img src="{{ asset('assets/images/siap-aum/figma-raw-3.png') }}" alt="Lambang Kabupaten Tabanan"></span>
                <span><img src="{{ asset('assets/images/siap-aum/siap-aum-mark.svg') }}" alt="Logo SIAP AUM"></span>
            </div>
            <h1>Lupa password?<br>Tenang saja</h1>
            <p>Kami akan mengirimkan tautan pemulihan agar Anda dapat membuat password baru dengan aman.</p>
        </div>
    </section>

    <section class="sa-login-panel">
        <div class="sa-login-card sa-forgot-card">
            <div class="sa-login-card__heading">
                <span class="sa-eyebrow"><i></i>Pemulihan akun</span>
                <h2>Atur ulang password</h2>
                <p>Masukkan email yang terdaftar. Tautan untuk membuat password baru akan dikirimkan ke email tersebut.</p>
            </div>

            <form action="{{ route('forgot-password.store') }}" method="POST">
                @csrf
                <div class="sa-login-field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="Masukkan email terdaftar" autocomplete="email" required>
                    @error('email')<span>{{ $message }}</span>@enderror
                </div>

                @if (config('recaptcha.enabled'))
                    <div class="sa-login-captcha">{!! htmlFormSnippet() !!}</div>
                    @error('g-recaptcha-response')<span class="sa-form-error">{{ $message }}</span>@enderror
                @endif

                <button class="sa-login-submit" type="submit">Kirim Tautan Pemulihan</button>
                <p class="sa-login-register">Ingat password Anda? <a href="{{ route('login.index') }}">Kembali ke Login</a></p>
                <div class="sa-login-partners"><img src="{{ asset('assets/images/maiharta.png') }}" alt="Maiharta"><img src="{{ asset('assets/images/bsre.png') }}" alt="BSrE"></div>
            </form>
        </div>
    </section>
</main>
@endsection
