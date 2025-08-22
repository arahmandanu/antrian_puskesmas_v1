@extends('shared.main')

@section('content')
    <main class="flex-grow overflow-y-auto h-screen custom-scrollbar relative p-6">
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

        <!-- Modal Antrian -->
        <div id="queue-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-80 relative">
                <button onclick="closeModal()"
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">&times;</button>
                <h2 class="text-xl font-bold mb-4" id="modal-poli-name">Poli XYZ</h2>
                <p class="text-3xl font-bold mb-6 text-center" id="modal-queue-number">001</p>
                <button onclick="printQueue()" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">
                    Print Nomor Antrian
                </button>
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
        let companyName = document
            .querySelector('meta[name="company-name"]')
            .getAttribute('content');
        // Modal elements
        const modal = document.getElementById("queue-modal");
        const modalQueueNumber = document.getElementById("modal-queue-number");
        const modalPoliName = document.getElementById("modal-poli-name");

        poliList.forEach((poli, index) => {
            const btn = document.createElement("button");
            btn.setAttribute("onclick", `pilihPoli('${poli.code}', '${poli.nama}', '${poli.nomor}')`);
            btn.className =
                `poli-btn btn-touch flex flex-col justify-center items-center w-full py-6 rounded-lg ${warna[index % warna.length]} text-white shadow-md hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300`;
            btn.innerHTML = `
            <span class="block text-lg font-semibold">${poli.nama}</span>
            <span class="block text-4xl font-bold mt-1">${poli.nomor}</span>
        `;
            container.appendChild(btn);
        });

        function pilihPoli(roomCode, poliName, queueNumber) {
            // Show loading
            loadingScreen.classList.remove("hidden");

            // Disable all buttons
            document.querySelectorAll(".poli-btn").forEach(btn => {
                btn.disabled = true;
                btn.classList.add("opacity-50", "cursor-not-allowed");
            });

            safeAjax({
                type: "POST",
                url: "{{ route('loket_antrian.createPoliQueue') }}",
                data: {
                    room_code: roomCode,
                },
                dataType: "json",
                success: function(response) {
                    loadingScreen.classList.add("hidden");

                    queue = response.data
                    // Set modal content
                    modalQueueNumber.innerText = `${queue.room_code}${queue.number_queue}`;
                    modalPoliName.innerText = poliName;

                    // Show modal
                    modal.classList.remove("hidden");
                },
                error: function(response) {
                    loadingScreen.classList.add("hidden");
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
                            window.location.href = "{{ route('loket_antrian.generateView', '') }}/" +
                                locketNumber;
                        }
                    });
                }
            });
        }

        function closeModal() {
            modal.classList.add("hidden");
            // Enable buttons again
            document.querySelectorAll(".poli-btn").forEach(btn => {
                btn.disabled = false;
                btn.classList.remove("opacity-50", "cursor-not-allowed");
            });
        }

        function printQueue() {
            const poliName = modalPoliName.innerText;
            const queueNumber = modalQueueNumber.innerText;
            const now = new Date();
            const jam = now.getHours().toString().padStart(2, '0');
            const menit = now.getMinutes().toString().padStart(2, '0');
            const detik = now.getSeconds().toString().padStart(2, '0');
            const tanggalWaktu = `${jam}:${menit}:${detik}`;
            const printWindow = window.open('', '_blank');

            const content = `
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <title>Nomor Antrian</title>
            <style>
                * { box-sizing: border-box; }
                body {
                    margin:10px;
                    padding:0;
                    width:74mm; /* sesuaikan lebar printer 76mm */
                    font-family: monospace;
                }
                #container {
                    display:inline-block;
                    width:100%;
                    text-align:center;
                    padding:0;
                    margin:0;
                }
                h1 { margin:2px 0; font-size:25px; }
                .poli-name { margin:2px 0; font-weight:bold; font-size:20px; }
                .queue-number { margin:2px 0; font-weight:bold; font-size:25px; }
                p { margin:1px 0; font-size:20px; }
                .separator { border-top:1px solid #000; margin:2px 0; }
                @media print {
                    @page {
                        size:76mm auto;
                        margin:0;
                    }
                    body { width:76mm; }
                }
            </style>
        </head>
        <body>
            <div id="container">
                <h1>Puskesmas</h1>
                <h1>${companyName}</h1>
                <div class="separator"></div>
                </br></br>
                <p class="poli-name">${poliName}</p>
                </br></br>
                <p class="queue-number">${queueNumber}</p>
                <div class="separator"></div>
                </br></br></br>
                <p id="jam-sekarang">Jam: ${tanggalWaktu}</p>
            </div>
            <script>
                window.onload = function(){ window.print(); };
            <\/script>
        </body>
        </html>
    `;

            printWindow.document.write(content);
            printWindow.document.close();
            printWindow.focus();

            window.location.href = "{{ route('loket_antrian.generateView', '') }}/" +
                locketNumber;
        }
    </script>
@endsection
