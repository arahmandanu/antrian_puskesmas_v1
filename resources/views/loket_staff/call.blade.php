@extends('shared.main')

@section('content')
    <!-- Konten -->
    <main class="flex-grow flex flex-col items-center overflow-y-auto h-screen custom-scrollbar p-6">
        <input type="hidden" id="poli_id" value="{{ $poli->id }}">
        <input type="hidden" id="poli_code" value="{{ $poli->code }}">
        <input type="hidden" id="poli_name" value="{{ $poli->name }}">

        <!-- Nomor terakhir -->
        <h2 class="text-2xl font-bold text-green-700 mb-6">{{ Str::upper($poli->name) }}</h2>
        <!-- Total antrian menunggu -->
        <div id="total-antrian" class="text-gray-600 mb-6 font-medium">
            Total belum terpanggil: <span id="number-total-antrian">{{ $totalQueueNotCalled }}</span>
        </div>
        <div id="nomor-antrian" class="text-[150px] font-bold text-gray-900 mb-10">
            {{ $lastCalled ?? '-' }}
        </div>

        <!-- Tombol aksi -->
        <div class="flex gap-6 mb-10">
            <button onclick="" id="btn-panggil"
                class="btn-touch flex items-center gap-3 bg-green-600 text-white text-2xl px-8 py-4 rounded-xl shadow-lg hover:bg-green-700 transition gap-x-3">
                <i class="fa fa-bullhorn"></i> Panggil
            </button>
            <button id="btn-recall"
                class="btn-touch flex items-center gap-3 bg-yellow-500 text-white text-2xl px-8 py-4 rounded-xl shadow-lg hover:bg-yellow-600 transition gap-x-3">
                <i class="fa fa-refresh"></i> Recall
            </button>
        </div>

        <!-- Daftar antrian belum dipanggil -->
        <div class="mt-6 w-full max-w-xl">
            <h3 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
                <i class="fa fa-users text-green-600"></i> Antrian Menunggu:
            </h3>

            <div id="daftar-antrian" class="flex flex-wrap gap-3">
                <!-- Nomor antrian menunggu akan muncul di sini -->
            </div>
        </div>

        <!-- Riwayat panggilan -->
        <div class="mt-10 w-full max-w-xl">
            <h3 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
                <i class="fa fa-history text-gray-600"></i> Riwayat Panggilan:
            </h3>
            <ul id="riwayat-panggilan" class="space-y-2 text-lg text-gray-800">
                <!-- Riwayat akan muncul di sini -->
            </ul>
        </div>
    </main>

    <script>
        let waitingList = @json($queueNotCalled);
        let historyList = @json($queuesCalled); // untuk riwayat
        let lastCalled = @json($lastCalled);

        const nomorEl = document.getElementById("nomor-antrian");
        const daftarEl = document.getElementById("daftar-antrian");
        const riwayatEl = document.getElementById("riwayat-panggilan");

        const btnPanggil = document.getElementById("btn-panggil");
        const btnRecall = document.getElementById("btn-recall");
        let poliId = document.getElementById("poli_id").value;
        let poliCode = document.getElementById("poli_code").value;
        let poliName = document.getElementById("poli_name").value;
        let numberTotal = document.getElementById("number-total-antrian");

        function renderWaitingList() {
            daftarEl.innerHTML = "";
            if (waitingList.length > 0) {
                waitingList.forEach(num => {
                    const badge = document.createElement("div");
                    badge.className =
                        "px-5 py-3 bg-green-100 text-green-800 font-bold rounded-lg shadow flex items-center gap-2";
                    badge.innerHTML = `<i class="fa fa-ticket text-green-600"></i> ${num}`;
                    daftarEl.appendChild(badge);
                });
            } else {
                const badge = document.createElement("div");
                badge.className =
                    "px-5 py-3 bg-yellow-100 text-black-800 font-bold rounded-lg shadow flex items-center gap-2";
                badge.innerHTML = `Tidak ada Antrian!`;
                daftarEl.appendChild(badge);
            }

        }

        function renderHistory() {
            riwayatEl.innerHTML = "";
            historyList.slice().forEach(num => {
                const li = document.createElement("li");
                li.className = "px-4 py-2 bg-gray-100 rounded-lg shadow flex items-center gap-2";
                li.innerHTML = `<i class="fa fa-check-circle text-blue-600"></i> Nomor ${num}`;
                riwayatEl.appendChild(li);
            });

            // Batasi maksimal 5 item
            while (riwayatEl.children.length > 5) {
                riwayatEl.removeChild(riwayatEl.lastChild);
            }
        }

        btnPanggil.addEventListener("click", () => {
            if (waitingList.length > 0) {
                let next = waitingList.shift();
                $.ajax({
                    type: "POST",
                    url: "{{ route('poli.callQueueByRoom', '') }}/" + poliId,
                    data: {
                        number_queue: next,
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: "JSON",
                    success: function(response) {
                        nomorEl.textContent = next;
                        lastCalled = next;
                        historyList.unshift(next);
                        callQueue(lastCalled)

                    },
                    error: function(response) {
                        Swal.fire({
                            title: response.message,
                            icon: "error"
                        });
                    },
                    complete: function() {
                        renderWaitingList();
                        renderHistory();
                    }
                });
            } else {
                if (historyList.length === 0) {
                    nomorEl.textContent = "-";
                }

                Swal.fire({
                    title: "Tidak ada antrian menunggu!",
                    icon: "error"
                });
                allButtons.forEach(btn => btn.disabled = false);
                btn.textContent = originalText;
            }
        });

        btnRecall.addEventListener("click", () => {
            if (lastCalled) {
                callQueue(lastCalled)
            } else {
                Swal.fire({
                    title: "Tidak ada antrian menunggu!",
                    icon: "error"
                });
                allButtons.forEach(btn => btn.disabled = false);
                btn.textContent = originalText;
            }
        });

        setInterval(() => {
            $.ajax({
                type: "GET",
                url: "{{ route('poli.getQueueByRoom', '') }}/" + poliId,
                data: {},
                dataType: "JSON",
                success: function(response) {
                    if (response.hasOwnProperty('data')) {
                        if (response.data.hasOwnProperty('total')) {
                            numberTotal.textContent = response?.data?.total;
                        }
                        if (response.data.pagination.length > 0) {
                            waitingList = response?.data?.pagination;

                            renderWaitingList();
                        }
                    }
                }
            });
        }, 1000);

        // Tampilkan awal
        renderWaitingList();
        renderHistory();

        function callQueue(queue) {
            setButtonsDisabled(true);
            let teksPanggilan = `Nomor antrian ${window.ejaanNomor(queue)}, silakan menuju ${poliName}`;
            speechSynthesis.cancel();
            let utter = new SpeechSynthesisUtterance(teksPanggilan);
            utter.lang = "id-ID";
            utter.rate = 0.9;
            speechSynthesis.speak(utter);

            utter.onend = () => {
                setButtonsDisabled(false);
            };
        }

        function setButtonsDisabled(state) {
            btnPanggil.disabled = state;
            btnRecall.disabled = state;

            if (state) {
                btnPanggil.classList.add('opacity-50', 'cursor-not-allowed');
                btnRecall.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                btnPanggil.classList.remove('opacity-50', 'cursor-not-allowed');
                btnRecall.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }
    </script>
@endsection
