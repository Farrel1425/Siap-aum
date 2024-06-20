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
          <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon">
</head>

<body id="app">
    <section class="header">
        <div class="row h-100">
            <div class="col-md-6 h-100 position-relative">
                <a href="/" class="back-button text-decoration-none rounded-circle position-relative bg-danger text-white py-3 px-3"><span class="isax-bold isax-arrow-left"></span></a>
                @yield('content-header')
            </div>
        </div>
    </section>
    @vite(['resources/js/app.js'])
    <script src="{{ asset('assets/vendors/jquery/jquery-3.4.1.min.js') }}"></script>
</body>

</html>
