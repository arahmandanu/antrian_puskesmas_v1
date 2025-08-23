@extends('shared.main')

@section('content')
    <main class="flex-grow flex flex-col items-center justify-center p-6 bg-gray-50 space-y-10">

        <!-- Box Nomor Terpanggil -->
        <div
            class="bg-white rounded-2xl shadow-2xl p-12 w-full max-w-3xl flex flex-col items-center text-center transform transition duration-300 hover:scale-105">
            <p class="text-gray-500 text-2xl mb-6">Sedang Dipanggil</p>
            <div class="text-9xl font-extrabold text-green-700 tracking-wider drop-shadow-md" id="nomor-sekarang">
                {{ $currentQueue }}
            </div>
        </div>

        <!-- Box Nomor Berikutnya -->
        <div
            class="bg-white rounded-2xl shadow-xl p-12 w-full max-w-3xl flex flex-col items-center text-center transform transition duration-300 hover:scale-105">
            <p class="text-gray-500 text-xl mb-6">Nomor Berikutnya</p>
            <div class="text-7xl font-bold text-gray-800 tracking-wide" id="nomor-selanjutnya">
                {{ $nextQueue }}
            </div>
        </div>

    </main>

    <script>
        const nomorSekarangEl = document.getElementById("nomor-sekarang");
        const nomorSelanjutnyaEl = document.getElementById("nomor-selanjutnya");

        function updateNomor(nomorNow, nomorNext) {
            nomorSekarangEl.textContent = nomorNow ?? "-";
            nomorSelanjutnyaEl.textContent = nomorNext ?? "-";

            // Animasi highlight setiap kali update
            nomorSekarangEl.classList.add("animate-pulse");
            setTimeout(() => nomorSekarangEl.classList.remove("animate-pulse"), 1500);

            nomorSelanjutnyaEl.classList.add("animate-bounce");
            setTimeout(() => nomorSelanjutnyaEl.classList.remove("animate-bounce"), 1000);
        }

        // 🔹 Fungsi untuk ambil data dari API
        function fetchQueue() {
            if (todayLocal() !== lastHistoryDate) {
                currentDate = todayLocal();
                resetQueue(); // reset ke default kalau ganti hari
                return;
            }

            safeAjax({
                type: "GET",
                url: "{{ route('poli.getNextQueueByRoom', $poli->id) }}",
                dataType: "JSON",
                success: function(response) {
                    if (response.data) {
                        const nomorNow = response.data.room_code + response.data.number_queue;

                        const nomorNext = response.data.room_code + String(Number(response.data.number_queue) +
                                1)
                            .padStart({{ config('mysite.total_locket_queue') }}, "0");

                        if (nomorSekarangEl.textContent.trim() !== nomorNow) {
                            updateNomor(nomorNow, nomorNext);
                        }
                    }
                },
                error: function(xhr) {
                    console.error("Gagal ambil data:", xhr);
                }
            });
        }

        function resetQueue() {
            updateNomor("-", "-");
        }

        setInterval(fetchQueue, 5000);
    </script>
@endsection
