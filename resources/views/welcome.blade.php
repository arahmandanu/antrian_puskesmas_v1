<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loket Antrian Puskesmas</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- <script src="https://cdn.jsdelivr.net/npm/tailwindcss@4.1.0/lib/index.min.js"></script> --}}
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
        <!-- Sidebar kiri (iklan) -->
        <div class="w-4/5 bg-white p-4 flex items-center justify-center">
            <img src="https://via.placeholder.com/900x600?text=Iklan+Puskesmas" alt="Iklan Puskesmas"
                class="max-h-full max-w-full object-contain rounded-lg shadow-lg">
        </div>

        <!-- Sidebar kanan (tombol) -->
        <div class="w-1/5 bg-gray-100 p-4 flex flex-col gap-8 justify-center items-center">
            <button
                class="btn-touch w-full py-8 rounded-2xl shadow-xl text-white text-3xl font-extrabold tracking-wide
                           bg-gradient-to-r from-yellow-400 to-yellow-500
                           hover:from-yellow-500 hover:to-yellow-400">
                📝 Pendaftaran
            </button>

            <button
                class="btn-touch w-full py-8 rounded-2xl shadow-xl text-white text-3xl font-extrabold tracking-wide
                           bg-gradient-to-r from-blue-400 to-blue-500
                           hover:from-blue-500 hover:to-blue-400">
                🔬 Laborate
            </button>

            <button
                class="btn-touch w-full py-8 rounded-2xl shadow-xl text-white text-3xl font-extrabold tracking-wide
                           bg-gradient-to-r from-pink-400 to-pink-500
                           hover:from-pink-500 hover:to-pink-400">
                👵 Lansia
            </button>
        </div>
        </div>
    </main>
</body>

</html>
