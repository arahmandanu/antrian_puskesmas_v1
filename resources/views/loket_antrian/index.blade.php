<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loket Pengambilan Nomor Antrian - Puskesmas</title>
    <script src="{{ asset('css/app.css') }}"></script>
</head>

<body class="bg-slate-100 text-slate-900">

    <!-- Header -->
    <header class="bg-green-600 text-white p-4 flex items-center gap-4 shadow">
        <img src="https://placehold.co/80x80?text=Logo" alt="Logo Puskesmas"
            class="w-16 h-16 rounded-lg bg-white object-cover">
        <div>
            <h1 class="text-2xl font-bold">Puskesmas Sukamaju</h1>
            <p class="text-sm text-green-100">Loket Pengambilan Nomor Antrian</p>
        </div>
    </header>

    <!-- Main Layout -->
    <main class="flex flex-col lg:flex-row h-[calc(100vh-96px)]">
        <!-- Sidebar kiri (Iklan) -->
        <div class="w-full lg:w-4/5 bg-white border-r border-slate-200 p-4 overflow-auto">
            <div class="h-full flex items-center justify-center">
                <img src="https://placehold.co/800x600?text=Area+Iklan" alt="Iklan"
                    class="max-h-full rounded-lg shadow">
            </div>
        </div>

        <!-- Sidebar kanan (Tombol Layanan) -->
        <aside class="w-full lg:w-1/5 bg-slate-50 p-4 flex flex-col gap-4">
            <button
                class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow text-lg p-4">
                Pendaftaran
            </button>
            <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow text-lg p-4">
                Laborate
            </button>
            <button
                class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-lg shadow text-lg p-4">
                Lansia
            </button>
        </aside>
    </main>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
