<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layar Panggilan Antrian Poli Umum</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Tailwind CSS v4.1 CDN -->
    {{-- <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script> --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {},
            }
        }
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col bg-gray-50">

    <!-- Header -->
    <header class="py-6 text-center bg-green-700 text-white shadow-md">
        <img src="https://via.placeholder.com/100x100?text=Logo" alt="Logo Puskesmas"
            class="w-20 h-20 rounded-full border-4 border-white mb-3 mx-auto">
        <h1 class="text-3xl font-bold tracking-wide">PUSKESMAS SEHAT BERSAMA</h1>
        <h2 class="text-lg mt-1 text-green-100">Antrian Poli Umum</h2>
    </header>

    <!-- Konten -->
    <main class="flex-grow flex flex-col items-center justify-center p-6">
        <!-- Nomor Terpanggil -->
        <div class="text-center mb-12">
            <p class="text-gray-500 text-xl">Sedang Dipanggil</p>
            <div class="text-[140px] font-extrabold text-green-700 drop-shadow-lg" id="nomor-sekarang">A12</div>
        </div>

        <!-- Nomor Selanjutnya -->
        <div class="text-center">
            <p class="text-gray-500 text-xl">Nomor Berikutnya</p>
            <div class="text-[90px] font-bold text-gray-800" id="nomor-selanjutnya">A13</div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-4 text-center text-sm bg-white text-gray-500 border-t">
        &copy; 2025 PT Karya Wiguna. All rights reserved.
    </footer>

    <script>
        // Contoh data sementara, bisa diambil dari backend Laravel
        let nomorSekarang = 'A12';
        let nomorSelanjutnya = 'A13';

        const nomorSekarangEl = document.getElementById("nomor-sekarang");
        const nomorSelanjutnyaEl = document.getElementById("nomor-selanjutnya");

        // Fungsi update nomor (simulasi)
        function updateNomor(nomorNow, nomorNext) {
            nomorSekarangEl.textContent = nomorNow;
            nomorSelanjutnyaEl.textContent = nomorNext;
        }

        // Contoh simulasi update setiap 5 detik
        // setInterval(() => {
        //     let nowNum = parseInt(nomorSekarang.slice(1)) + 1;
        //     let nextNum = nowNum + 1;
        //     nomorSekarang = 'A' + nowNum;
        //     nomorSelanjutnya = 'A' + nextNum;
        //     updateNomor(nomorSekarang, nomorSelanjutnya);
        // }, 5000);
    </script>

</body>

</html>
