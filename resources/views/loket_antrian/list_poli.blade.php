@extends('shared.main')

@section('content')
    <!-- Konten -->
    <main class="flex-grow overflow-y-auto h-screen custom-scrollbar relative">
        <input type="hidden" id="locket_number" value="{{ $locket_number }}">
        <div>
            <h1 class="text-2xl font-bold text-center mb-6">Daftar Poli</h1>
            <p class="text-center text-gray-600 mb-10">Pilih poli untuk membuat nomor antrian baru</p>
        </div>
        <div id="poli-container"
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 max-w-7xl mx-auto">
            <!-- Button poli akan di-generate oleh JS -->
        </div>

        <!-- Loading Overlay -->
        <div id="loading-screen" class="hidden absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center">
                <div class="animate-spin rounded-full h-12 w-12 border-4 border-blue-500 border-t-transparent mb-4"></div>
                <p class="text-gray-700 font-semibold">Loading, please wait...</p>
            </div>
        </div>
    </main>

    <script>
        const warna = [
            "bg-blue-500", "bg-green-500", "bg-teal-500", "bg-yellow-500", "bg-pink-500", "bg-indigo-500",
            "bg-orange-500", "bg-purple-500", "bg-red-500", "bg-rose-500", "bg-lime-500", "bg-cyan-500",
            "bg-amber-500", "bg-sky-500", "bg-emerald-500"
        ];

        const poliList = @json($polis);
        const container = document.getElementById("poli-container");
        const loadingScreen = document.getElementById("loading-screen");
        let locketNumber = document.getElementById('locket_number').value;

        poliList.forEach((poli, index) => {
            const btn = document.createElement("button");
            btn.setAttribute("onclick", `pilihPoli('${poli.code}')`);
            btn.className =
                `poli-btn btn-touch flex flex-col justify-center items-center w-full py-6 rounded-lg ${warna[index % warna.length]} text-white shadow-md hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300`;
            btn.innerHTML = `
                <span class="block text-lg font-semibold">${poli.nama}</span>
                <span class="block text-4xl font-bold mt-1">${poli.nomor}</span>
            `;
            container.appendChild(btn);
        });

        function pilihPoli(roomCode) {
            // Show loading
            loadingScreen.classList.remove("hidden");

            // Disable all buttons
            document.querySelectorAll(".poli-btn").forEach(btn => {
                btn.disabled = true;
                btn.classList.add("opacity-50", "cursor-not-allowed");
            });

            $.ajax({
                type: "POST",
                url: "{{ route('loket_antrian.createPoliQueue') }}",
                data: {
                    room_code: roomCode,
                    _token: "{{ csrf_token() }}",
                },
                dataType: "json",
                success: function(response) {
                    window.location.href = "{{ route('loket_antrian.generateView', '') }}/" + 1;
                },
                error: function(response) {
                    // Hide loading
                    loadingScreen.classList.add("hidden");

                    // Enable buttons again
                    document.querySelectorAll(".poli-btn").forEach(btn => {
                        btn.disabled = false;
                        btn.classList.remove("opacity-50", "cursor-not-allowed");
                    });

                    Swal.fire({
                        title: 'Error!',
                        text: response.responseJSON.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // This code executes when the user clicks the "OK" button
                            window.location.href = "{{ route('loket_antrian.generateView', '') }}/" +
                                locketNumber;
                        }
                    });
                }
            });
        }
    </script>
@endsection
