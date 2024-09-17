<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0"
          name="viewport">
    <meta content="ie=edge"
          http-equiv="X-UA-Compatible">
    <title>Si Ajaib - E-Perijinan Buleleng</title>
    @vite(['resources/sass/app.scss'])
    <link href="{{ asset('assets/vendors/iconsax/style.css') }}"
          rel="stylesheet">
    <link href="{{ asset('assets/images/logo.png') }}"
          rel="shortcut icon"
          type="image/x-icon">
</head>

<body id="app">
    <div class="loader-container">
        <div class="loader"></div>
    </div>
    <div class="min-vh-100 d-flex flex-column">
        <div class="{{ request()->routeIs('user-guide', 'check-application') ? 'position-static' : 'position-absolute' }} d-none d-lg-block"
             style="z-index: 999;">
            @include('layouts.landing.partials.navbar-dekstop')
        </div>
        @include('layouts.landing.partials.navbar-mobile')
        @yield('content')
        <div class="mt-auto">
            @include('layouts.landing.partials.footer')
        </div>
    </div>
    <script src="{{ asset('assets/vendors/jquery/jquery-3.4.1.min.js') }}"></script>
    @vite(['resources/js/app.js', 'resources/js/landing/landing.js'])
    @include('components.toastr')
</body>

</html>
