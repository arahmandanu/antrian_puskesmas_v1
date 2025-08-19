@extends('shared.main')

@section('content')
    <input type="hidden" id='lantai' value="{{ $lantai }}">
    <main class="flex flex-col flex-grow items-center justify-center p-6 h-screen bg-gray-50">
        <div class="w-full max-w-6xl h-full flex flex-col md:flex-row gap-6">
            <!-- Sedang Dipanggil -->
            <div
                class="flex-1 bg-purple-500 shadow-2xl rounded-3xl p-8 flex flex-col justify-center items-center text-white">
                <h3 class="text-3xl font-bold mb-6">Sedang Dipanggil</h3>
                <div id="current-call" class="flex flex-col items-center justify-center h-full">
                    <span class="text-8xl font-extrabold">-</span>
                    <h4 class="text-4xl font-semibold mt-4">-</h4>
                </div>
            </div>

            <!-- Riwayat Antrian -->
            <div class="flex-1 bg-white shadow-2xl rounded-3xl p-8 flex flex-col">
                <h3 class="text-3xl font-bold mb-6 text-gray-800">Riwayat Antrian</h3>
                <ul id="history" class="flex-1 overflow-y-auto space-y-4 text-2xl text-gray-700">
                    <li class="text-gray-500 text-center text-xl">Belum ada panggilan</li>
                </ul>
            </div>
        </div>
    </main>

    <script>
        let isRequesting = false; // flag untuk API
        let isSpeaking = false; // flag untuk suara
        let lastCallId = null;
        let lantai = document.getElementById('lantai').value;

        function updateAntrian() {
            // Jika sedang request atau sedang speaking, skip
            if (isRequesting || isSpeaking) return;

            isRequesting = true;

            fetch("{{ route('play_suara.getNextCall', '') }}/" + lantai)
                .then(res => res.json())
                .then(data => {
                    if (!data) return;

                    // Cek jika ada panggilan baru
                    if (lastCallId !== data.id) {
                        lastCallId = data.id;

                        // Update current call
                        const currentCallEl = document.getElementById('current-call');
                        currentCallEl.innerHTML = `
                    <span class="text-8xl font-extrabold text-white">${data.locket_code}${String(data.number_queue).padStart(3,'0')}</span>
                    <h4 class="text-4xl font-semibold mt-4">${data.poli_name}</h4>
                `;

                        // Update riwayat
                        const historyEl = document.getElementById('history');
                        const li = document.createElement('li');
                        li.textContent =
                            `${data.locket_code}${String(data.number_queue).padStart(3,'0')} - ${data.poli_name}`;
                        li.classList.add('p-4', 'rounded-xl', 'bg-gray-100');
                        historyEl.prepend(li);
                        while (historyEl.children.length > 10) {
                            historyEl.removeChild(historyEl.lastChild);
                        }

                        // Panggilan suara
                        isSpeaking = true;
                        const utter = new SpeechSynthesisUtterance(
                            `Nomor antrian ${data.locket_code}${String(data.number_queue).padStart(3,'0')}, silakan menuju lantai.`
                        );
                        utter.lang = "id-ID";
                        utter.rate = 0.9;
                        utter.onend = () => {
                            isSpeaking = false;
                        };
                        speechSynthesis.speak(utter);
                    }
                })
                .catch(err => console.error('Gagal mengambil data antrian:', err))
                .finally(() => {
                    isRequesting = false;
                });
        }

        // Polling setiap 5 detik
        setInterval(updateAntrian, 5000);
        updateAntrian();
    </script>
@endsection
