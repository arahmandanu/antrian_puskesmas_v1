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

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-green-600 text-white py-5 flex flex-col items-center shadow-lg">
        <img src="https://via.placeholder.com/100x100?text=Logo" alt="Logo Puskesmas"
            class="w-24 h-24 rounded-full border-4 border-white shadow-lg mb-3">
        <h1 class="text-3xl font-extrabold tracking-wide text-center">PUSKESMAS SEHAT BERSAMA</h1>
        <h2 class="text-lg font-light text-center">Pilih Poli Tujuan</h2>
    </header>

    <!-- Konten -->
    <main class="flex-grow p-6">
        <div id="poli-container"
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
            <!-- Button poli akan di-generate oleh JS -->
        </div>
    </main>

    <script>
        // Daftar poli dan nomor terakhir
        const poliList = [{
                nama: "Poli Umum",
                warna: "from-yellow-400 to-yellow-500",
                nomor: 12
            },
            {
                nama: "Poli Gigi",
                warna: "from-blue-400 to-blue-500",
                nomor: 8
            },
            {
                nama: "Poli KIA",
                warna: "from-pink-400 to-pink-500",
                nomor: 5
            },
            {
                nama: "Poli Lansia",
                warna: "from-green-400 to-green-500",
                nomor: 3
            },
            {
                nama: "Poli Anak",
                warna: "from-purple-400 to-purple-500",
                nomor: 6
            },
            {
                nama: "Poli Mata",
                warna: "from-red-400 to-red-500",
                nomor: 9
            },
            {
                nama: "Poli Kulit",
                warna: "from-indigo-400 to-indigo-500",
                nomor: 7
            },
            {
                nama: "Poli THT",
                warna: "from-teal-400 to-teal-500",
                nomor: 10
            },
            {
                nama: "Poli Bedah",
                warna: "from-orange-400 to-orange-500",
                nomor: 4
            },
            {
                nama: "Poli Jantung",
                warna: "from-rose-400 to-rose-500",
                nomor: 11
            },
            {
                nama: "Poli Paru",
                warna: "from-cyan-400 to-cyan-500",
                nomor: 2
            },
            {
                nama: "Poli Saraf",
                warna: "from-lime-400 to-lime-500",
                nomor: 13
            },
            {
                nama: "Poli Ortopedi",
                warna: "from-emerald-400 to-emerald-500",
                nomor: 1
            },
            {
                nama: "Laboratorium",
                warna: "from-fuchsia-400 to-fuchsia-500",
                nomor: 15
            },
            {
                nama: "Poli Gizi",
                warna: "from-sky-400 to-sky-500",
                nomor: 14
            }
        ];

        const container = document.getElementById("poli-container");

        poliList.forEach(poli => {
            const btn = document.createElement("button");
            btn.className =
                `btn-touch flex flex-col justify-center items-center w-full py-8 rounded-2xl shadow-xl text-white text-center font-bold text-2xl bg-gradient-to-r ${poli.warna} hover:opacity-90`;
            btn.innerHTML = `
                <span class="block text-lg font-semibold">${poli.nama}</span>
                <span class="block text-5xl font-extrabold mt-2">${poli.nomor}</span>
            `;
            container.appendChild(btn);
        });
    </script>

</body>

</html>
