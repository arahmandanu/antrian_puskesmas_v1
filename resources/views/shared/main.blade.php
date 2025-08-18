<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loket Antrian Puskesmas</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/locket.css') }}">
    <!-- Custom Fonts -->
    <link href="{{ asset('css/startmin/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- jQuery -->
    <script src="{{ asset('js/startmin/js/jquery.min.js') }}"></script>
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">

    @include('shared.header')

    <!-- Main Content -->
    @yield('content')

    @include('shared.footer')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
