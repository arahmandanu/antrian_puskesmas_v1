@extends('shared.main')

@section('content')
    @php
        use App\Enum\LocketList;
    @endphp

    <!-- Main Content -->
    <main class="flex flex-col flex-grow items-center p-6">
        <input type="hidden" value="{{ $loket->locket_number }}" id="loket_number">
        <input type="hidden" value="{{ $loket->id }}" id="id">

        <div class="flex justify-center items-center w-full max-w-3xl mb-10">
            <h2 class="text-lg font-light text-center">
                Selamat datang {{ $loket->staff_name }}, Anda berada di Loket {{ $loket->locket_number }}
                <br>
                Panel Panggilan Antrian Staff Loket
            </h2>
        </div>

        <!-- Tombol Panggilan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-3xl mb-10">

            <!-- Pendaftaran -->
            <div class="bg-yellow-400 rounded-2xl shadow-xl p-4 flex flex-col items-center gap-2">
                <span class="text-3xl">📝</span>
                <h2 class="text-xl font-bold">Pendaftaran</h2>
                <span class="text-sm font-medium" id="sisa-{{ LocketList::PENDAFTARAN }}">Sisa antrian:
                    {{ $locket_totals[LocketList::PENDAFTARAN->value] ?? 0 }}</span>
                </span>

                <div class="flex gap-4 mt-2 w-full">
                    <button onclick="panggilAntrian(this,'{{ LocketList::PENDAFTARAN }}', 'PENDAFTARAN')"
                        class="flex-1 py-2 rounded-xl bg-yellow-600 text-white font-bold hover:bg-yellow-700">
                        Panggil
                    </button>
                    <button onclick="recallAntrian(this, '{{ LocketList::PENDAFTARAN }}', 'PENDAFTARAN')"
                        class="flex-1 py-2 rounded-xl bg-yellow-200 text-yellow-800 font-bold hover:bg-yellow-300">
                        Recall
                    </button>
                </div>
            </div>

            <!-- Laborate -->
            <div class="bg-blue-400 rounded-2xl shadow-xl p-4 flex flex-col items-center gap-2">
                <span class="text-3xl">🔬</span>
                <h2 class="text-xl font-bold">Laborate</h2>
                <span class="text-sm font-medium" id="sisa-{{ LocketList::LABORATE }}">Sisa antrian:
                    {{ $locket_totals[LocketList::LABORATE->value] ?? 0 }}</span>
                </span>

                <div class="flex gap-4 mt-2 w-full">
                    <button onclick="panggilAntrian(this,'{{ LocketList::LABORATE }}', 'Laborate')"
                        class="flex-1 py-2 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700">
                        Panggil
                    </button>
                    <button onclick="recallAntrian(this, '{{ LocketList::LABORATE }}', 'Laborate')"
                        class="flex-1 py-2 rounded-xl bg-blue-200 text-blue-800 font-bold hover:bg-blue-300">
                        Recall
                    </button>
                </div>
            </div>

            <!-- Lansia -->
            <div class="bg-pink-400 rounded-2xl shadow-xl p-4 flex flex-col items-center gap-2">
                <span class="text-3xl">👵</span>
                <h2 class="text-xl font-bold">Lansia</h2>
                <span class="text-sm font-medium" id="sisa-{{ LocketList::LANSIA }}">Sisa antrian:
                    {{ $locket_totals[LocketList::LANSIA->value] ?? 0 }}</span>
                </span>

                <div class="flex gap-4 mt-2 w-full">
                    <button onclick="panggilAntrian(this,'{{ LocketList::LANSIA }}', 'Lansia')"
                        class="flex-1 py-2 rounded-xl bg-pink-600 text-white font-bold hover:bg-pink-700">
                        Panggil
                    </button>
                    <button onclick="recallAntrian(this, '{{ LocketList::LANSIA }}', 'Lansia')"
                        class="flex-1 py-2 rounded-xl bg-pink-200 text-pink-800 font-bold hover:bg-pink-300">
                        Recall
                    </button>
                </div>
            </div>

        </div>

        <!-- Riwayat Panggilan -->
        <div class="w-full max-w-3xl bg-white shadow-lg rounded-xl p-6">
            <h3 class="text-xl font-semibold mb-4">Riwayat Panggilan</h3>
            <ul id="riwayat" class="space-y-2 text-lg text-gray-800">
                <li class="text-gray-500">Belum ada panggilan</li>
            </ul>
        </div>

    </main>

    <script>
        const allButtons = document.querySelectorAll('button');
        let locketNumber = document.getElementById('loket_number').value;
        $(document).ready(function() {
            setInterval(() => {
                updateSisaAntrian();
            }, 5000);
        });

        function updateSisaAntrian() {
            $.ajax({
                url: "{{ route('loket_antrian.sisaAntrian') }}",
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.hasOwnProperty('data')) {
                        $.each(data.data, function(indexInArray, valueOfElement) {
                            $(`#sisa-${indexInArray}`).text(`Sisa antrian: ${valueOfElement}`);
                        });
                    }
                },
                error: function() {
                    console.error('Gagal mengambil data sisa antrian');
                }
            });
        }

        let counter = {
            P: parseInt(localStorage.getItem("P") || 0),
            L: parseInt(localStorage.getItem("L") || 0),
            LA: parseInt(localStorage.getItem("LA") || 0)
        };
        const riwayatEl = document.getElementById("riwayat");

        function panggilAntrian(btn, prefix, poli) {
            // Disable semua tombol di container yang sama
            allButtons.forEach(btn => btn.disabled = true);
            const originalText = btn.textContent;
            btn.textContent = "Memanggil...";

            $.ajax({
                type: "POST",
                url: "{{ route('loket_antrian.nextQueue') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    locket_code: prefix,
                    poli: poli,
                    locket_number: locketNumber,
                },
                dataType: "JSON",
                success: function(response) {
                    console.log(response);
                    if (response.hasOwnProperty('data')) {
                        if (response.data?.number_queue && response.data?.locket_number && response.data
                            ?.poli) {
                            tampilkanNomor(btn, response.data?.locket_code + response.data?.number_queue,
                                response.data
                                ?.poli, originalText, response.data?.locket_code);
                        } else {
                            allButtons.forEach(btn => btn.disabled = false);
                            btn.textContent = originalText;
                        }
                    } else {
                        allButtons.forEach(btn => btn.disabled = false);
                        btn.textContent = originalText;
                    }

                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    alert("Gagal memanggil antrian. Silakan coba lagi.");
                    allButtons.forEach(btn => btn.disabled = false);
                    btn.textContent = originalText;
                }
            });
        }

        function recallAntrian(btn, prefix, poli) {
            allButtons.forEach(btn => btn.disabled = true);

            if (counter[prefix] === 0) {
                alert("Belum ada nomor untuk dipanggil ulang!");
                container.querySelectorAll('button').forEach(b => b.disabled = false);
                return;
            }

            tampilkanNomor(prefix, poli);

            allButtons.forEach(btn => btn.disabled = false);
        }

        function tampilkanNomor(btn, prefix, poli, originalText, locket_code) {
            let nomor = prefix;

            // Update riwayat
            let item = document.createElement("li");
            item.textContent = `${nomor} - ${poli}`;
            riwayatEl.prepend(item);

            // Batasi maksimal 5 item
            while (riwayatEl.children.length > 5) {
                riwayatEl.removeChild(riwayatEl.lastChild);
            }

            // Hapus teks default jika ada
            if (riwayatEl.firstElementChild.textContent.includes("Belum ada")) {
                riwayatEl.firstElementChild.remove();
            }

            // Panggilan suara
            let teksPanggilan = `Nomor antrian ${ejaanNomor(nomor)}, silakan menuju loket ${locketNumber}`;
            speechSynthesis.cancel();
            let utter = new SpeechSynthesisUtterance(teksPanggilan);
            utter.lang = "id-ID";
            utter.rate = 0.9;
            speechSynthesis.speak(utter);

            utter.onend = () => {
                localStorage.setItem(locket_code, nomor);
                allButtons.forEach(btn => btn.disabled = false);
                btn.textContent = originalText;
            };
        }

        function ejaanNomor(nomor) {
            return nomor.split("").join(" ");
        }
    </script>
@endsection
