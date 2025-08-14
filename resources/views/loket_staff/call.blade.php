@extends('shared.main')

@section('content')
    <!-- Konten -->
    <main class="flex-grow flex flex-col items-center justify-center p-6">
        <!-- Nomor terakhir -->
        <h2 class="text-2xl font-bold text-green-700 mb-6">Poli Umum</h2>
        <div id="nomor-antrian" class="text-[150px] font-bold text-gray-900 mb-10">-</div>

        <!-- Tombol panggil -->
        <button id="btn-panggil"
            class="btn-touch bg-green-600 text-white text-3xl px-12 py-6 rounded-xl shadow-lg hover:bg-green-700 transition">
            Panggil
        </button>

        <!-- Daftar antrian belum dipanggil -->
        <div class="mt-12 w-full max-w-xl">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Antrian Menunggu:</h3>
            <div id="daftar-antrian" class="flex flex-wrap gap-3">
                <!-- Nomor antrian menunggu akan muncul di sini -->
            </div>
        </div>
    </main>

    <script>
        let waitingList = [1, 2, 3, 4, 5]; // Contoh antrian awal
        const nomorEl = document.getElementById("nomor-antrian");
        const daftarEl = document.getElementById("daftar-antrian");
        const btn = document.getElementById("btn-panggil");

        function renderWaitingList() {
            daftarEl.innerHTML = "";
            waitingList.forEach(num => {
                const badge = document.createElement("div");
                badge.className = "px-5 py-3 bg-green-100 text-green-800 font-bold rounded-lg shadow";
                badge.textContent = num;
                daftarEl.appendChild(badge);
            });
        }

        btn.addEventListener("click", () => {
            if (waitingList.length > 0) {
                let next = waitingList.shift();
                nomorEl.textContent = next;
                renderWaitingList();
            } else {
                nomorEl.textContent = "-";
                alert("Tidak ada antrian menunggu");
            }
        });

        // Tampilkan awal
        renderWaitingList();
    </script>
@endsection
