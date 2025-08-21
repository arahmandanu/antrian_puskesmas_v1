<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loket Antrian Puskesmas</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/locket.css') }}">
    <!-- Custom Fonts -->
    <link href="{{ asset('css/startmin/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- jQuery -->
    <script src="{{ asset('js/startmin/js/jquery.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="server-date" content="{{ now()->toDateString() }}">
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">
    <input type="hidden" id='lantai' value="{{ $lantai }}">
    <!-- Main Content -->
    <main class="flex-grow flex flex-col items-center  p-6 bg-gray-50">

        <h2 class="text-2xl font-semibold text-gray-600 mb-8 text-center">
            Nomor Sedang Dipanggil di Semua Poli
        </h2>

        <!-- Tombol Aktifkan Suara -->
        <div class="mb-6" id="sound-container">
            <button id="enable-sound"
                class="px-6 py-3 bg-green-600 text-white font-semibold rounded-xl shadow-lg hover:bg-green-700">
                🔊 Aktifkan Suara
            </button>
        </div>

        <!-- Grid semua poli -->
        <div id="grid-all"
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8 w-full p-8">
            @forelse ($calledList as $queue)
                <div id="{{ $queue['type'] }}-{{ $queue['staff']['id'] }}"
                    class="bg-white rounded-3xl shadow-2xl border border-gray-200
            flex flex-col items-center justify-between text-center px-8 py-6 w-fit h-fit mx-auto">

                    <!-- Header Poli -->
                    <p
                        class="text-white font-bold mb-2 px-4 py-1 rounded-full
    bg-gradient-to-r from-blue-500 to-blue-700 shadow-lg
    text-[clamp(0.8rem,1.2vw,1.5rem)] leading-tight
    text-center break-words max-w-100 max-h-[2.5em] overflow-hidden">
                        {{ $queue['name'] }}
                    </p>

                    <!-- Nomor Antrian -->
                    <span
                        class="font-extrabold text-green-700 drop-shadow-xl nomor-antrian
                text-[clamp(1.5rem,3vw,3.5rem)] leading-tight tracking-wider text-center break-words">
                        @if (isset($queue['queue']))
                            {{ $queue['queue']['number_code'] }}{{ $queue['queue']['number_queue'] }}
                        @else
                            -
                        @endif
                    </span>
                </div>
            @empty
            @endforelse

            {{-- @for ($i = 1; $i <= 20; $i++)
                <div id="poli-{{ $i }}"
                    class="bg-white rounded-3xl shadow-2xl border border-gray-200
            flex flex-col items-center justify-between text-center px-8 py-6 w-fit h-fit mx-auto">

                    <!-- Header Poli -->
                    <p
                        class="text-white font-bold mb-2 px-4 py-1 rounded-full
    bg-gradient-to-r from-blue-500 to-blue-700 shadow-lg
    text-[clamp(0.8rem,1.2vw,1.5rem)] leading-tight
    text-center break-words max-w-[90%] max-h-[2.5em] overflow-hidden">
                        POLI Kulit & Kelamin
                    </p>

                    <!-- Nomor Antrian -->
                    <span
                        class="font-extrabold text-green-700 drop-shadow-xl nomor-antrian
                text-[clamp(1.5rem,3vw,3.5rem)] leading-tight tracking-wider text-center break-words">
                        -
                    </span>
                </div>
            @endfor --}}

        </div>
    </main>

    <script>
        let isRequesting = false; // flag untuk API
        let isSpeaking = false; // flag untuk suara
        let lastCallId = null;
        let lantai = document.getElementById('lantai').value;
        let soundEnabled = false;

        document.getElementById('enable-sound').addEventListener('click', () => {
            soundEnabled = true;

            // Test suara awal (agar browser mengizinkan speechSynthesis)
            const testUtter = new SpeechSynthesisUtterance("Suara berhasil diaktifkan");
            testUtter.lang = "id-ID";
            speechSynthesis.speak(testUtter);

            // Hilangkan tombol setelah diklik
            document.getElementById('sound-container').style.display = "none";
        });

        function updateAntrian() {
            // Jika sedang request atau sedang speaking, skip
            if (!soundEnabled) return;
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
                                // lastCallId = data.id;

                                // Update current call
                                let box;
                                if (data.type == 'locket') {
                                    box = document.querySelector(
                                        `#${data.type}-${data.owner_id} .nomor-antrian`);
                                } else {
                                    box = document.querySelector(`#poli-${data.owner_id} .nomor-antrian`);
                                }

                                if (!box) return;
                                if (box.textContent == data.number_code + data.number_queue) return;

                                box.textContent = data.number_code + data.number_queue ?? "-";
                                // animasi
                                box.classList.add("animate-pulse");
                                setTimeout(() => box.classList.remove("animate-pulse"), 1000);
                                if (soundEnabled) {
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

        setInterval(updateAntrian, 5000);
    </script>

    @include('shared.footer')

    <script>
        let lastHistoryDate = document
            .querySelector('meta[name="server-date"]')
            .getAttribute('content');

        setInterval(() => {
            $.get("{{ route('refreshToken') }}", function(data) {
                document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.csrf_token);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': data.csrf_token
                    }
                });
            });
        }, 5 * 60 * 1000);
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
