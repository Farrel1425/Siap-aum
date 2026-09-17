<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0"
          name="viewport">
    <meta content="ie=edge"
          http-equiv="X-UA-Compatible">
    <title>SIAP AUM - Perizinan Kabupaten Tabanan</title>
    @vite(['resources/sass/app.scss'])
    <link href="{{ asset('assets/vendors/iconsax/style.css') }}"
          rel="stylesheet">
    <link href="{{ asset('assets/images/siap-aum/figma-raw-3.png') }}"
          rel="shortcut icon"
          type="image/x-icon">
    {!! ReCaptcha::htmlScriptTagJsApi() !!}
    @stack('styles')
</head>

<body id="app">
    <div class="loader-container">
        <div class="loader"></div>
    </div>
    @yield('content')
    @stack('scripts')
    @vite(['resources/js/app.js', 'resources/js/landing/landing.js'])
    <script src="{{ asset('assets/vendors/jquery/jquery-3.4.1.min.js') }}"></script>
    @include('components.toastr')
</body>

</html>
