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
                    @if (!$histories->isEmpty())
                        <span
                            class="text-8xl font-extrabold">{{ $histories[0]->number_code }}{{ $histories[0]->number_queue }}</span>
                        <h4 class="text-4xl font-semibold mt-4">{{ $histories[0]->called_to }}</h4>
                    @else
                        <span class="text-8xl font-extrabold">-</span>
                        <h4 class="text-4xl font-semibold mt-4">-</h4>
                    @endif
                </div>
            </div>

            <!-- Riwayat Antrian -->
            <div class="flex-1 bg-white shadow-2xl rounded-3xl p-8 flex flex-col">
                <h3 class="text-3xl font-bold mb-6 text-gray-800">Riwayat Antrian</h3>
                <ul id="history" class="flex-1 overflow-y-auto space-y-4 text-2xl text-gray-700">
                    @forelse ($histories as $history)
                        <li class="p-4 rounded-xl bg-gray-100">
                            {{ $history->number_code }}{{ $history->number_queue }} - {{ $history->initiator_name }}</li>
                    @empty
                        <li class="text-gray-500 text-center text-xl">Belum ada panggilan</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <button id="start-btn" class="p-4 bg-blue-500 text-white rounded-lg mb-4">
            Mulai Antrian
        </button>
    </main>

    <script>
        let isRequesting = false; // flag untuk API
        let isSpeaking = false; // flag untuk suara
        let lastCallId = null;
        let lantai = document.getElementById('lantai').value;

        const startBtn = document.getElementById('start-btn');

        startBtn.addEventListener('click', () => {
            // trigger speechSynthesis kosong dulu supaya browser mengizinkan
            const utter = new SpeechSynthesisUtterance('');
            speechSynthesis.speak(utter);

            // mulai polling
            updateAntrian();
            setInterval(updateAntrian, 5000);

            // sembunyikan tombol
            startBtn.style.display = 'none';
        });


        function updateAntrian() {
            // Jika sedang request atau sedang speaking, skip
            if (isRequesting || isSpeaking) return;

            isRequesting = true;

            safeAjax({
                type: "GET",
                url: "{{ route('play_suara.getNextCall', '') }}/" + lantai,
                data: {},
                dataType: "JSON",
                success: function(response) {
                    if (response.hasOwnProperty('data')) {
                        if (response.data !== null) {
                            if (!response) return;

                            // Cek jika ada panggilan baru
                            data = response.data;
                            if (lastCallId !== data.id) {
                                lastCallId = data.id;

                                // Update current call
                                const currentCallEl = document.getElementById('current-call');
                                currentCallEl.innerHTML = `
                                    <span class="text-8xl font-extrabold text-white">${data.number_code}${String(data.number_queue).padStart(3,'0')}</span>
                                    <h4 class="text-4xl font-semibold mt-4">${data.initiator_name}</h4>
                                `;

                                // Update riwayat
                                const historyEl = document.getElementById('history');
                                const li = document.createElement('li');
                                li.textContent =
                                    `${data.number_code}${String(data.number_queue).padStart(3,'0')} - ${data.initiator_name}`;
                                li.classList.add('p-4', 'rounded-xl', 'bg-gray-100');
                                historyEl.prepend(li);
                                while (historyEl.children.length > 5) {
                                    historyEl.removeChild(historyEl.lastChild);
                                }

                                // Panggilan suara
                                isSpeaking = true;
                                const utter = new SpeechSynthesisUtterance(
                                    `Nomor antrian ${data.number_code}${String(data.number_queue).padStart(3,'0')}, silakan menuju  ${data.called_to}.`
                                );
                                utter.lang = "id-ID";
                                utter.rate = 0.9;
                                utter.onend = () => {
                                    isSpeaking = false;
                                };
                                speechSynthesis.speak(utter);
                            }
                        }
                    }
                },
                error: function() {
                    console.error('Gagal mengambil data antrian:')
                },
                complete: function() {
                    isRequesting = false;
                }
            });
        }
    </script>
@endsection
