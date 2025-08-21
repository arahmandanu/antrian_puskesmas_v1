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

    <!-- Main Content -->
    <main class="flex-grow flex flex-col items-center justify-center p-6 bg-gray-50">

        <h2 class="text-2xl font-semibold text-gray-600 mb-8 text-center">
            Nomor Sedang Dipanggil di Semua Poli
        </h2>

        <!-- Grid semua poli -->
        <div id="grid-poli"
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8 w-full p-8">
            @for ($i = 1; $i <= 20; $i++)
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
            @endfor
        </div>


    </main>

    <script>
        function updatePoli(poliId, nomor) {
            const poliBox = document.querySelector(`#poli-${poliId} .nomor-antrian`);
            if (poliBox) {
                poliBox.textContent = nomor ?? "-";

                // animasi
                poliBox.classList.add("animate-pulse");
                setTimeout(() => poliBox.classList.remove("animate-pulse"), 1000);
            }
        }

        // 🔹 Dummy fetch function (acak nomor antrian tiap 5 detik)
        function fetchQueuesDummy() {
            for (let i = 1; i <= 15; i++) {
                const randomNomor = "P" + String(Math.floor(Math.random() * 1000) + 1).padStart(3, "0");
                updatePoli(i, randomNomor);
            }
        }

        setInterval(fetchQueuesDummy, 5000);
        fetchQueuesDummy(); // pertama kali jalan
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
