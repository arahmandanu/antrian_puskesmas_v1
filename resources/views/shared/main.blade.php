<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loket Antrian Puskesmas</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            overflow: hidden;
            font-family: 'Inter', sans-serif;
        }

        .btn-touch {
            transition: transform 0.15s ease-out;
        }

        .btn-touch:active {
            transform: scale(1.2);
            /* Membesar saat klik/touch */
        }
    </style>
</head>

<body class="bg-gray-100 h-screen flex flex-col">

    @include('shared.header')

    <!-- Main Content -->
    @yield('content')

    @include('shared.footer')
</body>

</html>
