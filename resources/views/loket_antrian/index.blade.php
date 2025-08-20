@extends('shared.main')

@section('content')
    <!-- Konten utama -->
    <main class="flex flex-1 overflow-hidden">
        <!-- Bagian Kiri (Swiper) -->
        <div class="w-4/5" id="all_iklan">
            <div class="swiper w-full h-full">
                <div class="swiper-wrapper">
                    <div class="swiper-slide flex items-center justify-center bg-grey">
                        <video class="w-full h-full" muted autoplay loop>
                            <source src="public/videos/tes.mp4" type="video/mp4">
                        </video>
                    </div>

                    <div class="swiper-slide">
                        <img src="https://picsum.photos/id/1015/1200/800" class="w-full h-full object-cover" alt="iklan 1">
                    </div>

                    <div class="swiper-slide">
                        <img src="https://picsum.photos/id/1024/1200/800" class="w-full h-full object-cover" alt="iklan 2">
                    </div>
                </div>
            </div>
        </div>
        <!-- Sidebar kanan (tombol) -->
        <div class="relative w-1/5 bg-gray-100 p-4 flex flex-col gap-8 justify-center items-center">
            <!-- Tombol -->
            <button onclick="panggilAntrian('PENDAFTARAN', '{{ $pendaftaran }}')"
                class="w-full py-8 rounded-2xl shadow-xl text-white text-3xl font-extrabold tracking-wide
               bg-gradient-to-r from-yellow-400 to-yellow-500
               hover:from-yellow-500 hover:to-yellow-400">
                📝 Pendaftaran
            </button>

            <button onclick="panggilAntrian('LABORATE',  '{{ $laborate }}')"
                class="w-full py-8 rounded-2xl shadow-xl text-white text-3xl font-extrabold tracking-wide
               bg-gradient-to-r from-blue-400 to-blue-500
               hover:from-blue-500 hover:to-blue-400">
                🔬 Laborate
            </button>

            <button onclick="panggilAntrian('LANSIA', '{{ $lansia }}')"
                class="w-full py-8 rounded-2xl shadow-xl text-white text-3xl font-extrabold tracking-wide
               bg-gradient-to-r from-pink-400 to-pink-500
               hover:from-pink-500 hover:to-pink-400">
                👵 Lansia
            </button>

            <!-- Loading overlay -->
            <div id="loading-overlay"
                class="hidden absolute inset-0 bg-green-900/70 backdrop-blur-sm flex items-center justify-center rounded-lg z-50">
                <div class="flex flex-col items-center">
                    <div class="w-14 h-14 border-4 border-white border-t-transparent rounded-full animate-spin"></div>
                    <p class="text-white text-lg mt-4">Memanggil antrian...</p>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const swiper = new Swiper(".swiper", {
                loop: true,
                autoplay: {
                    delay: 4000, // 4 detik untuk gambar
                    disableOnInteraction: true,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });

            swiper.on("slideChangeTransitionEnd", function() {
                const activeSlide = swiper.slides[swiper.activeIndex];
                const video = activeSlide.querySelector("video");

                // kalau slide ada video
                if (video) {
                    swiper.autoplay.stop(); // hentikan auto scroll
                    video.currentTime = 0;
                    video.play();

                    video.onended = () => {
                        swiper.slideNext(); // pindah slide setelah video selesai
                        swiper.autoplay.start(); // mulai lagi autoplay
                    };
                }
            });
        });

        function panggilAntrian(poli, code) {
            const overlay = document.getElementById('loading-overlay');
            overlay.classList.remove('hidden');

            // Disable semua tombol di sidebar kanan
            const buttons = overlay.parentElement.querySelectorAll('button');
            buttons.forEach(btn => btn.disabled = true);

            safeAjax({
                    type: "POST",
                    url: "{{ route('loket_antrian.createQueue') }}",
                    data: {
                        code: code,
                        poli: poli,
                    },
                    dataType: "JSON"
                })
                .fail(function(data, textStatus, xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: data.responseJSON.message,
                        icon: 'error',
                        confirmButtonText: 'Cool'
                    });
                })
                .always(function() {
                    overlay.classList.add('hidden');
                    buttons.forEach(btn => btn.disabled = false);
                });
        }
    </script>
@endsection
