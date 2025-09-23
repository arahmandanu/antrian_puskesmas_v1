@extends('shared.main')

@php($noHeader = false)

@php($noFooter = true)

@php($walkFooter = true)

@section('content')
    <input type="hidden" id='lantai' value="{{ $lantai }}">

    <!-- Loading Screen -->
    <div id="loading-screen" class="fixed inset-0 bg-white flex flex-col items-center justify-center z-50">
        <div class="w-80 bg-gray-200 rounded-full h-4 overflow-hidden">
            <div id="progress-bar" class="bg-green-600 h-4 w-0 transition-all duration-300 ease-in-out"></div>
        </div>
        <p id="progress-text" class="mt-4 text-gray-600 font-semibold">0%</p>
        <p class="text-sm text-gray-400 mt-2">Memuat asset...</p>
    </div>

    <!-- Main Content -->
    <main id="app-content" class="flex-grow flex flex-col items-center p-6">
        <!-- Grid semua poli -->
        <section id="grid-all"
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-5 gap-3 w-full p-3">
            @forelse ($calledList as $queue)
                @include('components.queue-card', ['queue' => $queue])
            @empty
                <div class="col-span-full text-center text-gray-400 py-8">Tidak ada antrian yang sedang dipanggil.</div>
            @endforelse
        </section>
    </main>

    <!-- Overlay popup panggilan -->
    <div id="call-overlay"
        class="hidden fixed inset-0 backdrop-blur-md bg-green-500/30 flex items-center justify-center z-50">
        <div id="call-popup"
            class="bg-white/90 text-green-700 font-extrabold rounded-2xl
                shadow-xl px-16 py-12 opacity-0 scale-90 transition-all duration-500 text-center">
            <div id="call-number" class=" leading-none">
                <span class="text-[12vw] text-yellow-500" id="call-number-code"></span>
                <span class="text-[12vw]" id="call-number-queue"></span>
            </div>
            <div id="call-destination" class="mt-6 text-[4vw] text-gray-800 font-bold tracking-tight leading-tight">Menuju
                Poli Umum</div>
        </div>
    </div>

    <script>
        let isRequesting = false; // flag untuk API
        let isSpeaking = false; // flag untuk suara
        let lastCallId = null;
        let lantai = document.getElementById('lantai').value;
        const audioCache = {};
        // let soundEnabled = false;
        let baseUrl = document
            .querySelector('meta[name="base-url"]')
            .getAttribute('content');

        setInterval(updateAntrian, 3000);

        // document.getElementById('enable-sound').addEventListener('click', () => {
        //     soundEnabled = true;

        // Test suara awal (agar browser mengizinkan speechSynthesis)
        // const testUtter = new SpeechSynthesisUtterance("Suara berhasil diaktifkan");
        // testUtter.lang = "id-ID";
        // speechSynthesis.speak(testUtter);

        // Hilangkan tombol setelah diklik
        // document.getElementById('sound-container').style.display = "none";
        // });

        function updateAntrian() {
            // Jika sedang request atau sedang speaking, skip
            // if (!soundEnabled) return;
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
                            box.classList.remove("animate-pulse");

                            showCallOverlay(data.number_code, String(data.number_queue).padStart(3, '0'), data
                                .called_to);

                            // if (soundEnabled) {
                            isSpeaking = true;
                            soundCallerLocal(data);
                            // }
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
            let arrNumberQ = data.number_queue.split("").map(Number);
            let front = [
                "{{ asset('/sound/nomor_antrian.mp3') }}",
                `{{ asset('/sound/${data.number_code}.mp3') }}`,
            ];
            let middle = [];
            arrNumberQ.forEach(element => {
                middle.push(`{{ asset('/sound/${element}.mp3') }}`)
            });
            let end = [
                `{{ asset('/sound/silahkan_menuju.mp3') }}`
            ]
            let allSound = [...front, ...middle, ...end, ...data.sound];
            // NEW
            playSequential(allSound, () => {
                closeCallOverlay();
            });

            // const utter = new SpeechSynthesisUtterance(
            //     `Nomor antrian ${data.number_code}${String(data.number_queue).padStart(3,'0')}, silakan menuju  ${data.called_to}.`
            // );

            // utter.lang = "id-ID";
            // utter.rate = 0.9;
            // utter.onend = () => {
            //     closeCallOverlay();
            // };
            // speechSynthesis.speak(utter);
        }

        function preloadSounds(sounds) {
            sounds.forEach(url => {
                if (!audioCache[url]) {
                    const audio = new Audio(url);
                    audio.preload = "auto";
                    audioCache[url] = audio;
                }
            });
        }

        function playSequential(sounds, onFinish) {
            preloadSounds(sounds); // pastikan semua sudah ada di cache
            let index = 0;

            function playNext() {
                if (index >= sounds.length) {
                    if (onFinish) onFinish();
                    return;
                }

                const audio = audioCache[sounds[index]];
                index++;

                if (!audio) {
                    playNext(); // skip kalau tidak ada
                    return;
                }

                // reset agar bisa diputar ulang
                audio.currentTime = 0;

                audio.onended = playNext;
                audio.onerror = playNext; // kalau error, lanjut aja
                audio.play().catch(err => {
                    console.warn("Audio play error:", err);
                    playNext();
                });
            }

            playNext();
        }

        if ("serviceWorker" in navigator) {
            navigator.serviceWorker.register(baseUrl + "/sound_cache.js?baseUrl=" + baseUrl, {
                    scope: './'
                })
                .then(reg => {
                    console.log("SW terdaftar", reg, navigator.serviceWorker.controller);

                    if (navigator.serviceWorker.controller) {
                        navigator.serviceWorker.controller.postMessage({
                            type: "CHECK_CACHE"
                        });
                    } else {
                        navigator.serviceWorker.addEventListener('controllerchange', () => {
                            navigator.serviceWorker.controller?.postMessage({
                                type: "CHECK_CACHE"
                            });
                        });
                    }
                });

            navigator.serviceWorker.addEventListener("message", event => {
                if (event.data.type === "CACHE_PROGRESS") {
                    const {
                        loaded,
                        total
                    } = event.data;
                    const percent = Math.round((loaded / total) * 100);
                    document.getElementById("progress-bar").style.width = percent + "%";
                    document.getElementById("progress-text").innerText = percent + "%";
                }
                if (event.data.type === "CACHE_DONE") {
                    document.getElementById("loading-screen").style.display = "none";
                    document.getElementById("app-content").classList.remove("hidden");
                }
            });
        }

        function showCallOverlay(code, number, destination) {
            const overlay = document.getElementById("call-overlay");
            const popup = document.getElementById("call-popup");
            // const numberEl = document.getElementById("call-number");
            const numberElCode = document.getElementById("call-number-code");
            const numberElNumber = document.getElementById("call-number-queue");

            const destEl = document.getElementById("call-destination");
            numberElCode.innerText = code;
            numberElNumber.innerText = number;
            // numberEl.textContent = numberText;
            destEl.textContent = destination;

            overlay.classList.remove("hidden");

            requestAnimationFrame(() => {
                popup.classList.remove("opacity-0", "scale-90");
                popup.classList.add("opacity-100", "scale-100");
            });
        }

        function closeCallOverlay() {
            const overlay = document.getElementById("call-overlay");
            const popup = document.getElementById("call-popup");

            popup.classList.remove("opacity-100", "scale-100");
            popup.classList.add("opacity-0", "scale-90");

            setTimeout(() => {
                isSpeaking = false;
                overlay.classList.add("hidden");
            }, 500); // tunggu animasi keluar
        }
    </script>
@endsection
