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
        <div class="flex-grow grid grid-rows-[75%_20%] gap-4 p-6">

            <!-- Baris 1: Video (70%) + Loket kanan -->
            <div class="grid grid-cols-[80%_20%] gap-4">
                <!-- Left: Video -->
                <div id="container_adds" class="rounded-2xl overflow-hidden">
                    <div class="swiper swiper absolute inset-0 w-full h-full">
                        <div class="swiper-wrapper">
                            @forelse ($iklanVideos as $video)
                                @if ($loop->first)
                                    <div class="swiper-slide w-full h-full flex items-center justify-center">
                                        <video class="object-contain" playsinline muted controls>
                                            <source
                                                src="{{ url('/') }}/{{ $video->getPath() }}/{{ $video->getFilename() }}"
                                                type="video/mp4">
                                        </video>
                                    </div>
                                @else
                                    <div class="swiper-slide w-full h-full flex items-center justify-center">
                                        <video class="object-contain" playsinline muted controls>
                                            <source
                                                src="{{ url('/') }}/{{ $video->getPath() }}/{{ $video->getFilename() }}"
                                                type="video/mp4">
                                        </video>
                                    </div>
                                @endif
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right: Loket utama -->
                <div class="grid grid-cols-1 gap-4 content-start">
                    @foreach ($calledListright as $queue)
                        <div id="{{ $queue['type'] }}-{{ $queue['staff']['id'] }}"
                            class="bg-green-900 text-center text-white rounded-2xl p-4 flex flex-col justify-center"
                            style="width:330px; height:160px;">

                            <h3
                                class="bg-white text-green-700 rounded px-1 mx-auto mb-1 text-[clamp(1rem,1.4vw,2.2rem)] font-black">
                                {{ $queue['name'] }}
                            </h3>

                            <p class="text-[clamp(3rem,4vw,5rem)] font-extrabold">
                                @if (isset($queue['queue']))
                                    <input type="hidden" id="nomor-antrian"
                                        value="{{ $queue['queue']['number_code'] }}{{ $queue['queue']['number_queue'] }}">
                                    <span id="current-call">
                                        <span
                                            class="text-yellow-500">{{ $queue['queue']['number_code'] }}</span><span>{{ $queue['queue']['number_queue'] }}</span>
                                    </span>
                                @else
                                    <input type="hidden" id="nomor-antrian" value="">
                                    <span id="current-call">
                                        --
                                    </span>
                                @endif
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Baris 2: Loket tambahan -->
            <div class="flex flex-wrap gap-4">
                @foreach ($calledListbottom as $queue)
                    <div id="{{ $queue['type'] }}-{{ $queue['staff']['id'] }}"
                        class="bg-green-900 text-center text-white rounded-2xl p-4 flex flex-col justify-center"
                        style="width:330px; height:160px;">

                        <h3
                            class="bg-white text-green-700 rounded px-1 mx-auto mb-1 text-[clamp(1rem,1.4vw,2.2rem)] font-black">
                            {{ $queue['name'] }}
                        </h3>
                        <p class="text-[clamp(3rem,4vw,5rem)] font-extrabold">
                            @if (isset($queue['queue']))
                                <input type="hidden" id="nomor-antrian"
                                    value="{{ $queue['queue']['number_code'] }}{{ $queue['queue']['number_queue'] }}">

                                <span id="current-call">
                                    <span
                                        class="text-yellow-500">{{ $queue['queue']['number_code'] }}</span><span>{{ $queue['queue']['number_queue'] }}</span>
                                </span>
                            @else
                                <input type="hidden" id="nomor-antrian" value="">
                                <span id="current-call">
                                    --
                                </span>
                            @endif
                        </p>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

    <script>
        window.addEventListener("resize", resizeContent);
        window.addEventListener("load", resizeContent);

        let isRequesting = false; // flag untuk API
        let isSpeaking = false; // flag untuk suara
        let lastCallId = null;
        let lantai = document.getElementById('lantai').value;
        let swiper;
        const volume = {{ config('mysite.video_volume', 7) }};
        const audioCache = {};
        // let soundEnabled = false;
        let baseUrl = document
            .querySelector('meta[name="base-url"]')
            .getAttribute('content');

        setInterval(updateAntrian, 3000);

        function resizeVideosImages() {
            container = document.getElementById('container_adds');
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
                image.style.width = width + 'px';
                image.style.height = height + 'px';
            });
        }

        // Jalankan saat load & resize
        window.addEventListener('load', resizeVideosImages);
        window.addEventListener('resize', resizeVideosImages);

        document.addEventListener("DOMContentLoaded", function() {
            const allVideos = document.querySelectorAll(".swiper-slide video");
            allVideos.forEach(v => {
                v.pause();
                v.currentTime = 0;
                v.muted = true; // optional
            });

            const slides = document.querySelectorAll(".swiper-slide");
            const loopEnabled = slides.length > 1;
            swiper = new Swiper(".swiper", {
                loop: loopEnabled,
            });

            playActiveSlideVideo();
            swiper.on("slideChangeTransitionEnd", playActiveSlideVideo);
        });

        function playActiveSlideVideo() {
            const activeSlide = swiper.slides[swiper.activeIndex];
            const video = activeSlide.querySelector("video");
            // Pause all others
            const allVideos = document.querySelectorAll(".swiper-slide video");
            allVideos.forEach(v => {
                if (v !== video) v.pause();
            });
            if (video) {
                video.currentTime = 0;
                video.muted = false; // optional for sound
                video.volume = volume;
                video.play().catch(err => console.warn("Play error", err));
                video.onended = () => {
                    swiper.slideNext();
                };
            }
        }


        function getCurrentVideo() {
            if (!swiper) {
                console.warn("Swiper is not initialized yet!");
                return null;
            }
            const activeSlide = swiper.slides[swiper.activeIndex];
            if (!activeSlide) return null;
            return activeSlide.querySelector("video") || null;
        }

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

        function updateAntrian() {
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
                            let input;
                            if (data.type == 'locket') {
                                input = document.querySelector(
                                    `#${data.type}-${data.owner_id} #nomor-antrian`);
                            } else {
                                input = document.querySelector(`#poli-${data.owner_id} #nomor-antrian`);
                            }

                            if (!input) return;
                            const currentVideo = getCurrentVideo();
                            if (currentVideo) {
                                // Optional: play it or mute
                                currentVideo.muted = true;
                                currentVideo.play();
                            }
                            const parent = input.parentElement; // ambil parent container
                            const spanFromParent = parent.querySelector("#current-call");
                            spanFromParent.innerHTML =
                                `<span
                                        class="text-yellow-700">${data.number_code}</span><span>${data.number_queue}</span>`;
                            input.value = data.number_code + data.number_queue ?? "-";
                            const parentDiv = input.parentElement.parentElement;
                            parentDiv.classList.add("animate-infinite-pulse-glow");
                            isSpeaking = true;
                            soundCallerLocal(data, parentDiv);
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

        function soundCallerLocal(data, objectToAnimate) {
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
                const currentVideo = getCurrentVideo();
                if (currentVideo) {
                    console.log("Current video:", currentVideo.src);
                    // Optional: play it or mute
                    currentVideo.muted = false;
                    currentVideo.play();
                }
                objectToAnimate.classList.remove("animate-infinite-pulse-glow");
                setTimeout(() => {
                    isSpeaking = false;
                }, 2000);
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
    </script>
@endsection
