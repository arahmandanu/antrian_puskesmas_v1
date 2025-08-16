@extends('shared.main')

@section('content')
    <!-- Konten -->
    <main class="flex-grow overflow-y-auto h-screen custom-scrollbar">
        <div>
            <h1 class="text-2xl font-bold text-center mb-6">Daftar Poli</h1>
            <p class="text-center text-gray-600 mb-10">Pilih poli untuk membuat nomor antrian baru</p>
        </div>
        <div id="poli-container"
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 max-w-7xl mx-auto">
            <!-- Button poli akan di-generate oleh JS -->
        </div>
    </main>

    <script>
        const poliList = [{
                nama: "Poli Umum",
                nomor: 12,
                warna: "bg-blue-500"
            },
            {
                nama: "Poli Gigi",
                nomor: 8,
                warna: "bg-green-500"
            },
            {
                nama: "Poli KIA",
                nomor: 5,
                warna: "bg-teal-500"
            },
            {
                nama: "Poli Lansia",
                nomor: 3,
                warna: "bg-yellow-500"
            },
            {
                nama: "Poli Anak",
                nomor: 6,
                warna: "bg-pink-500"
            },
            {
                nama: "Poli Mata",
                nomor: 9,
                warna: "bg-indigo-500"
            },
            {
                nama: "Poli Kulit",
                nomor: 7,
                warna: "bg-orange-500"
            },
            {
                nama: "Poli THT",
                nomor: 10,
                warna: "bg-purple-500"
            },
            {
                nama: "Poli Bedah",
                nomor: 4,
                warna: "bg-red-500"
            },
            {
                nama: "Poli Jantung",
                nomor: 11,
                warna: "bg-rose-500"
            },
            {
                nama: "Poli Paru",
                nomor: 2,
                warna: "bg-lime-500"
            },
            {
                nama: "Poli Saraf",
                nomor: 13,
                warna: "bg-cyan-500"
            },
            {
                nama: "Poli Ortopedi",
                nomor: 1,
                warna: "bg-amber-500"
            },
            {
                nama: "Laboratorium",
                nomor: 15,
                warna: "bg-sky-500"
            },
            {
                nama: "Poli Gizi",
                nomor: 14,
                warna: "bg-emerald-500"
            },
            {
                nama: "Poli Saraf",
                nomor: 13,
                warna: "bg-cyan-500"
            },
            {
                nama: "Poli Ortopedi",
                nomor: 1,
                warna: "bg-amber-500"
            },
            {
                nama: "Laboratorium",
                nomor: 15,
                warna: "bg-sky-500"
            },
            {
                nama: "Poli Gizi",
                nomor: 14,
                warna: "bg-emerald-500"
            }
        ];

        const container = document.getElementById("poli-container");

        poliList.forEach(poli => {
            const btn = document.createElement("button");
            btn.className =
                `btn-touch flex flex-col justify-center items-center w-full py-6 rounded-lg ${poli.warna} text-white shadow-md hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300`;
            btn.innerHTML = `
                <span class="block text-lg font-semibold">${poli.nama}</span>
                <span class="block text-4xl font-bold mt-1">${poli.nomor}</span>
            `;
            container.appendChild(btn);
        });
    </script>
@endsection
