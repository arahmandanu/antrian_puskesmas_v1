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
    <meta name="base-url" content="{{ url('/') }}">
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">
    <input type="hidden" id='lantai' value="{{ $lantai }}">

    <!-- Loading Screen -->
    {{-- <div id="loading-screen" class="fixed inset-0 bg-white flex flex-col items-center justify-center z-50">
        <div class="w-80 bg-gray-200 rounded-full h-4 overflow-hidden">
            <div id="progress-bar" class="bg-green-600 h-4 w-0 transition-all duration-300 ease-in-out"></div>
        </div>
        <p id="progress-text" class="mt-4 text-gray-600 font-semibold">0%</p>
        <p class="text-sm text-gray-400 mt-2">Memuat asset...</p>
    </div> --}}

    <!-- Main Content -->
    <main id="app-content" class="flex-grow flex flex-col items-center p-6 bg-gray-50">

        <h2 class="text-2xl font-semibold text-gray-600 mb-8 text-center">
            Nomor Terpanggil
        </h2>

        <!-- Tombol Aktifkan Suara -->
        <div class="mb-6" id="sound-container">
            <button id="enable-sound"
                class="px-6 py-3 bg-green-600 text-white font-semibold rounded-xl shadow-lg hover:bg-green-700">
                🔊 Aktifkan Suara
            </button>
        </div>

        <!-- Grid semua poli -->
        <section id="grid-all"
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-1 w-full p-3">
            @forelse ($calledList as $queue)
                @include('components.queue-card', ['queue' => $queue])
            @empty
                <div class="col-span-full text-center text-gray-400 py-8">Tidak ada antrian yang sedang dipanggil.</div>
            @endforelse
        </section>
    </main>

    <script>
        let isRequesting = false; // flag untuk API
        let isSpeaking = false; // flag untuk suara
        let lastCallId = null;
        let lantai = document.getElementById('lantai').value;
        let soundEnabled = false;
        let baseUrl = document
            .querySelector('meta[name="base-url"]')
            .getAttribute('content');

        document.getElementById('enable-sound').addEventListener('click', () => {
            soundEnabled = true;

            // Test suara awal (agar browser mengizinkan speechSynthesis)
            // const testUtter = new SpeechSynthesisUtterance("Suara berhasil diaktifkan");
            // testUtter.lang = "id-ID";
            // speechSynthesis.speak(testUtter);

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
                            // if (box.textContent == data.number_code + data.number_queue) return;

                            box.textContent = data.number_code + data.number_queue ?? "-";
                            // animasi
                            box.classList.add("animate-pulse");
                            setTimeout(() => box.classList.remove("animate-pulse"), 1000);

                            if (soundEnabled) {
                                isSpeaking = true;
                                soundCallerLocal(data);
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

        function soundCallerLocal(data) {
            // let arrNumberQ = data.number_queue.split("").map(Number);
            // let front = [
            //     "{{ asset('/sound/nomor_antrian.mp3') }}",
            //     `{{ asset('/sound/${data.number_code}.mp3') }}`,
            // ];
            // let middle = [];
            // arrNumberQ.forEach(element => {
            //     middle.push(`{{ asset('/sound/${element}.mp3') }}`)
            // });
            // let end = [
            //     `{{ asset('/sound/silahkan_menuju.mp3') }}`
            // ]
            // let allSound = [...front, ...middle, ...end];
            // console.log(allSound);
            // let index = 0;
            // let audio = new Audio(allSound[index]);

            // audio.onended = () => {
            //     index++;
            //     if (index < allSound.length) {
            //         audio.src = allSound[index];
            //         audio.play();
            //     } else {
            //         isSpeaking = false;
            //     }
            // };
            // audio.play();

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

        setInterval(updateAntrian, 3000);

        // if ("serviceWorker" in navigator) {
        //     navigator.serviceWorker.register(baseUrl + "/sound_cache.js?baseUrl=" + baseUrl, {
        //             scope: './'
        //         })
        //         .then(reg => {
        //             console.log("SW terdaftar", reg, navigator.serviceWorker.controller);

        //             if (navigator.serviceWorker.controller) {
        //                 navigator.serviceWorker.controller.postMessage({
        //                     type: "CHECK_CACHE"
        //                 });
        //             } else {
        //                 navigator.serviceWorker.addEventListener('controllerchange', () => {
        //                     navigator.serviceWorker.controller?.postMessage({
        //                         type: "CHECK_CACHE"
        //                     });
        //                 });
        //             }
        //         });

        //     navigator.serviceWorker.addEventListener("message", event => {
        //         if (event.data.type === "CACHE_PROGRESS") {
        //             const {
        //                 loaded,
        //                 total
        //             } = event.data;
        //             const percent = Math.round((loaded / total) * 100);
        //             document.getElementById("progress-bar").style.width = percent + "%";
        //             document.getElementById("progress-text").innerText = percent + "%";
        //         }
        //         if (event.data.type === "CACHE_DONE") {
        //             document.getElementById("loading-screen").style.display = "none";
        //             document.getElementById("app-content").classList.remove("hidden");
        //         }
        //     });
        // }
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
