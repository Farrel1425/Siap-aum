<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0"
          name="viewport">
    <meta content="ie=edge"
          http-equiv="X-UA-Compatible">
    <title>E-Perijinan Buleleng</title>
    @vite(['resources/sass/app.scss'])
    <link href="{{ asset('assets/vendors/iconsax/style.css') }}"
          rel="stylesheet">
    <link href="{{ asset('assets/images/logo.png') }}"
          rel="shortcut icon"
          type="image/x-icon">
    {!! ReCaptcha::htmlScriptTagJsApi() !!}
</head>

<body id="app">
    <div class="loader-container">
        <div class="loader"></div>
    </div>
    <section class="header">
        <div class="row h-100">
            <div class="col-md-6 h-100 position-relative">
                <a class="back-button text-decoration-none rounded-circle position-relative bg-danger text-white py-3 px-3"
                   href="/"><span class="isax-bold isax-arrow-left"></span></a>
                @yield('content-header')
            </div>
        </div>
    </section>
    @stack('scripts')
    @vite(['resources/js/app.js', 'resources/js/landing/landing.js'])
    <script src="{{ asset('assets/vendors/jquery/jquery-3.4.1.min.js') }}"></script>
    @include('components.toastr')
</body>

</html>
