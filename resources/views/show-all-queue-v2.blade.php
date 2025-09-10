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

    <div id="app-content" class="flex flex-col h-full">
        <div class="flex-grow grid grid-rows-[76%_19%] gap-4 p-6">

            <!-- Baris 1: Video (70%) + Loket kanan -->
            <div class="grid grid-cols-[80%_20%] gap-4">
                <!-- Left: Video -->
                <div id="container_adds" class="rounded-2xl overflow-hidden">
                    <div class="swiper swiper absolute inset-0 w-full h-full">
                        <div class="swiper-wrapper">
                            @forelse ($iklanVideos as $video)
                                <div class="swiper-slide w-full h-full flex items-center justify-center">
                                    <video class="object-cover" muted autoplay loop>
                                        <source
                                            src="{{ url('/') }}/{{ $video->getPath() }}/{{ $video->getFilename() }}"
                                            type="video/mp4">
                                    </video>
                                </div>
                            @empty
                            @endforelse

                            @forelse ($iklanImages as $image)
                                <div class="swiper-slide">
                                    <img src="{{ url('/') }}/{{ $image->getPath() }}/{{ $image->getFilename() }}"
                                        class="object-cover" alt="iklan 1">
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right: Loket utama -->
                <div class="grid grid-cols-1 gap-4 content-start">
                    @foreach (range(1, 4) as $i)
                        <div class="bg-green-500 text-center text-white rounded-2xl p-4 flex flex-col justify-center"
                            style="width:330px; height:160px;">
                            <h3
                                class="bg-white text-green-700 rounded px-2 py-1 mx-auto mb-2 text-[clamp(0.8rem,1.2vw,2rem)] font-bold">
                                Loket {{ $i }}
                            </h3>
                            <p class="text-[clamp(3rem,4vw,5rem)] font-extrabold">
                                <span class="text-yellow-700">A</span><span class="text-white">999</span>
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Baris 2: Loket tambahan -->
            <div class="flex flex-wrap gap-4">
                @foreach (range(4, 8) as $i)
                    <div class="bg-green-500 text-center text-white rounded-2xl p-4 flex flex-col justify-center"
                        style="width:330px; height:160px;">
                        <h3
                            class="bg-white text-green-700 rounded px-2 py-1 mx-auto mb-2 text-[clamp(0.8rem,1.2vw,2rem)] font-bold">
                            Loket {{ $i }}
                        </h3>
                        <p class="text-[clamp(3rem,4vw,5rem)] font-extrabold">
                            <span class="text-yellow-700">B</span><span class="text-white">999</span>
                        </p>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

    <script>
        function resizeVideosImages() {
            const container = document.getElementById('container_adds');
            if (!container) return;

            const videos = container.querySelectorAll('video');
            const images = container.querySelectorAll('img');

            const width = container.clientWidth;
            const height = container.clientHeight;

            videos.forEach(video => {
                video.style.width = width + 'px';
                video.style.height = height + 'px';
            });

            images.forEach(image => {
                console.log(image);
                image.style.width = width + 'px';
                image.style.height = height + 'px';
            });
        }

        // Jalankan saat load & resize
        window.addEventListener('load', resizeVideosImages);
        window.addEventListener('resize', resizeVideosImages);

        document.addEventListener("DOMContentLoaded", function() {
            const swiper = new Swiper(".swiper", {
                loop: true,
                autoplay: {
                    delay: 4000, // 4 detik untuk gambar
                    disableOnInteraction: false,
                },
            });

            swiper.on("slideChangeTransitionEnd", function() {
                const activeSlide = swiper.slides[swiper.activeIndex];
                const video = activeSlide.querySelector("video");

                // Jika slide ada video
                if (video) {
                    swiper.autoplay.stop(); // hentikan autoplay swiper
                    video.currentTime = 0; // mulai dari awal
                    video.play();

                    // Hapus event sebelumnya biar tidak numpuk
                    video.onended = null;

                    video.onended = () => {
                        swiper.slideNext(); // pindah slide setelah video selesai
                        swiper.autoplay.start(); // aktifkan autoplay lagi
                    };
                } else {
                    // Kalau slide bukan video, pastikan autoplay tetap berjalan
                    swiper.autoplay.start();
                }
            });
        });

        function resizeContent() {
            const header = document.querySelector('header');
            const footer = document.querySelector('footer');
            const marque = document.getElementById('marque'); // kalau ada running text

            const content = document.querySelector('#app-content'); // kasih id di yield content

            const headerHeight = header ? header.offsetHeight : 0;
            const footerHeight = footer ? footer.offsetHeight : 0;
            const marqueHeight = marque ? marque.offsetHeight : 0;

            const availableHeight = window.innerHeight - (headerHeight + footerHeight + marqueHeight);
            content.style.minHeight = availableHeight + "px";
        }

        window.addEventListener("resize", resizeContent);
        window.addEventListener("load", resizeContent);

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

                            showCallOverlay(data.number_code + String(data.number_queue).padStart(3, '0'), data
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

        function showCallOverlay(numberText, destination) {
            const overlay = document.getElementById("call-overlay");
            const popup = document.getElementById("call-popup");
            const numberEl = document.getElementById("call-number");
            const destEl = document.getElementById("call-destination");

            numberEl.textContent = numberText;
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
