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
        <h2 class="text-lg font-light">Panel Panggilan Antrian Staff Loket</h2>
    </header>

    <!-- Main Content -->
    <main class="flex flex-col flex-grow items-center p-6">

        <!-- Tombol Panggilan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-3xl mb-10">
            <button onclick="panggilAntrian('P', 'Pendaftaran')"
                class="btn-touch w-full py-8 rounded-2xl shadow-xl text-white text-2xl font-extrabold tracking-wide
                       bg-gradient-to-r from-yellow-400 to-yellow-500
                       hover:from-yellow-500 hover:to-yellow-400">
                📝 Pendaftaran
            </button>

            <button onclick="panggilAntrian('L', 'Laborate')"
                class="btn-touch w-full py-8 rounded-2xl shadow-xl text-white text-2xl font-extrabold tracking-wide
                       bg-gradient-to-r from-blue-400 to-blue-500
                       hover:from-blue-500 hover:to-blue-400">
                🔬 Laborate
            </button>

            <button onclick="panggilAntrian('LA', 'Lansia')"
                class="btn-touch w-full py-8 rounded-2xl shadow-xl text-white text-2xl font-extrabold tracking-wide
                       bg-gradient-to-r from-pink-400 to-pink-500
                       hover:from-pink-500 hover:to-pink-400">
                👵 Lansia
            </button>
        </div>

        <!-- Riwayat Panggilan -->
        <div class="w-full max-w-3xl bg-white shadow-lg rounded-xl p-6">
            <h3 class="text-xl font-semibold mb-4">Riwayat Panggilan</h3>
            <ul id="riwayat" class="space-y-2 text-lg text-gray-800">
                <li class="text-gray-500">Belum ada panggilan</li>
            </ul>
        </div>

    </main>

    <script>
        // Load nomor terakhir dari localStorage
        let counter = {
            P: parseInt(localStorage.getItem("P") || 0),
            L: parseInt(localStorage.getItem("L") || 0),
            LA: parseInt(localStorage.getItem("LA") || 0)
        };

        const riwayatEl = document.getElementById("riwayat");

        function panggilAntrian(prefix, poli) {
            counter[prefix]++;
            localStorage.setItem(prefix, counter[prefix]);

            let nomor = prefix + String(counter[prefix]).padStart(3, "0");

            // Update riwayat
            let item = document.createElement("li");
            item.textContent = `${nomor} - Poli ${poli}`;
            riwayatEl.prepend(item);

            // Hapus teks default jika masih ada
            if (riwayatEl.children.length > 5) {
                riwayatEl.removeChild(riwayatEl.lastChild);
            }
            if (riwayatEl.firstElementChild.textContent.includes("Belum ada")) {
                riwayatEl.firstElementChild.remove();
            }

            // Panggilan suara
            let teksPanggilan = `Nomor antrian ${ejaanNomor(nomor)}, silakan menuju loket ${poli}`;
            speechSynthesis.cancel();
            let utter = new SpeechSynthesisUtterance(teksPanggilan);
            utter.lang = "id-ID";
            utter.rate = 0.9;
            speechSynthesis.speak(utter);
        }

        function ejaanNomor(nomor) {
            return nomor.split("").join(" ");
        }
    </script>

</body>

</html>
