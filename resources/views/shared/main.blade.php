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

    <!-- Header -->
    <header class="bg-green-600 text-white py-4 flex flex-col items-center shadow-lg">
        <img src="https://via.placeholder.com/100x100?text=Logo" alt="Logo Puskesmas"
            class="w-24 h-24 rounded-full border-4 border-white shadow-lg mb-2">
        <h1 class="text-2xl font-bold tracking-wide">PUSKESMAS SEHAT BERSAMA</h1>
    </header>

    <!-- Main Content -->
    <main class="flex flex-grow">
        @yield('content')
    </main>
</body>

</html>
