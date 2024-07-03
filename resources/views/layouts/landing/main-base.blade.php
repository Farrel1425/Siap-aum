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
</head>

<body id="app">
    <div class="loader-container">
        <div class="loader"></div>
    </div>
    <section class="header">
        <div class="row h-100">
            <div class="col-md-6 h-100 position-relative">
                @include('layouts.landing.partials.navbar')
                @yield('content-header')
            </div>
        </div>
    </section>
    <script src="{{ asset('assets/vendors/jquery/jquery-3.4.1.min.js') }}"></script>
    @vite(['resources/js/app.js','resources/js/landing/landing.js'])
</body>

</html>
