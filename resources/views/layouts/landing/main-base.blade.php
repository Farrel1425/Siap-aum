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
    <section class="header">
        <div class="row h-100">
            <div class="col-md-6 h-100 position-relative">
                @include('layouts.landing.partials.navbar')
                @yield('content-header')
            </div>
        </div>
    </section>
    @vite(['resources/js/app.js'])
</body>

</html>
