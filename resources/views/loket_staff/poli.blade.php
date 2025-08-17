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
        const warna = ["bg-blue-500", "bg-green-500", "bg-teal-500", "bg-yellow-500", "bg-pink-500", "bg-indigo-500",
            "bg-orange-500", "bg-purple-500", "bg-red-500", "bg-rose-500", "bg-lime-500", "bg-cyan-500", "bg-amber-500",
            "bg-sky-500", "bg-emerald-500", "bg-cyan-500", "bg-amber-500", "bg-sky-500", "bg-emerald-500"
        ];

        const poliList = @json($polis);
        const container = document.getElementById("poli-container");

        poliList.forEach((poli, index) => {
            const btn = document.createElement("button");
            btn.setAttribute("onclick", `pilihPoli(${index}, '${poli.nama}')`);
            btn.className =
                `btn-touch flex flex-col justify-center items-center w-full py-6 rounded-lg ${warna[index]} text-white shadow-md hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300`;
            btn.innerHTML = `
                <span class="block text-lg font-semibold">${poli.nama}</span>
                <span class="block text-4xl font-bold mt-1">${poli.nomor}</span>
            `;
            container.appendChild(btn);
        });
    </script>
@endsection
