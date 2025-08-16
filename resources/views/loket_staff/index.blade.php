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
                <span class="text-sm font-medium" id="sisa-{{ LocketList::PENDAFTARAN->value }}">Sisa antrian:
                    {{ $locket_totals[LocketList::PENDAFTARAN->value] ?? 0 }}</span>
                </span>

                <div class="flex gap-4 mt-2 w-full">
                    <button onclick="panggilAntrian('P', 'Pendaftaran')"
                        class="flex-1 py-2 rounded-xl bg-yellow-600 text-white font-bold hover:bg-yellow-700">
                        Panggil
                    </button>
                    <button onclick="recallAntrian('P', 'Pendaftaran')"
                        class="flex-1 py-2 rounded-xl bg-yellow-200 text-yellow-800 font-bold hover:bg-yellow-300">
                        Recall
                    </button>
                </div>
            </div>

            <!-- Laborate -->
            <div class="bg-blue-400 rounded-2xl shadow-xl p-4 flex flex-col items-center gap-2">
                <span class="text-3xl">🔬</span>
                <h2 class="text-xl font-bold">Laborate</h2>
                <span class="text-sm font-medium" id="sisa-{{ LocketList::LABORATE->value }}">Sisa antrian:
                    {{ $locket_totals[LocketList::LABORATE->value] ?? 0 }}</span>
                </span>

                <div class="flex gap-4 mt-2 w-full">
                    <button onclick="panggilAntrian('L', 'Laborate')"
                        class="flex-1 py-2 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700">
                        Panggil
                    </button>
                    <button onclick="recallAntrian('L', 'Laborate')"
                        class="flex-1 py-2 rounded-xl bg-blue-200 text-blue-800 font-bold hover:bg-blue-300">
                        Recall
                    </button>
                </div>
            </div>

            <!-- Lansia -->
            <div class="bg-pink-400 rounded-2xl shadow-xl p-4 flex flex-col items-center gap-2">
                <span class="text-3xl">👵</span>
                <h2 class="text-xl font-bold">Lansia</h2>
                <span class="text-sm font-medium" id="sisa-{{ LocketList::LANSIA->value }}">Sisa antrian:
                    {{ $locket_totals[LocketList::LANSIA->value] ?? 0 }}</span>
                </span>

                <div class="flex gap-4 mt-2 w-full">
                    <button onclick="panggilAntrian('LA', 'Lansia')"
                        class="flex-1 py-2 rounded-xl bg-pink-600 text-white font-bold hover:bg-pink-700">
                        Panggil
                    </button>
                    <button onclick="recallAntrian('LA', 'Lansia')"
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
            btn.disabled = true;
            btn.textContent = "Memanggil...";
            setTimeout(() => {
                counter[prefix]++;
                localStorage.setItem(prefix, counter[prefix]);
                tampilkanNomor(prefix, poli);
                btn.disabled = false;
                btn.textContent = btn.innerHTML; // restore
            }, 500);
        }

        function recallAntrian(prefix, poli) {
            console.log(prefix, poli);
            if (counter[prefix] === 0) {
                alert("Belum ada nomor untuk dipanggil ulang!");
                return;
            }
            tampilkanNomor(prefix, poli);
        }

        function tampilkanNomor(prefix, poli) {
            let nomor = prefix + String(counter[prefix]).padStart(3, "0");

            // Update riwayat
            let item = document.createElement("li");
            item.textContent = `${nomor} - Poli ${poli}`;
            riwayatEl.prepend(item);

            // Batasi maksimal 5 item
            while (riwayatEl.children.length > 5) {
                riwayatEl.removeChild(riwayatEl.lastChild);
            }

            // Hapus teks default jika ada
            if (riwayatEl.firstElementChild.textContent.includes("Belum ada")) {
                riwayatEl.firstElementChild.remove();
            }
            console.log(`Panggil ${nomor} untuk Poli ${poli}`);
            // Panggilan suara
            let teksPanggilan = `Nomor antrian ${ejaanNomor(nomor)}, silakan menuju loket ${poli}`;
            speechSynthesis.cancel();
            let utter = new SpeechSynthesisUtterance(teksPanggilan);
            utter.lang = "id-ID";
            utter.rate = 0.9;
            speechSynthesis.speak(utter);
        }

        function ejaanNomor(nomor) {
            return nomor.split("").join(" ");
        }
    </script>
@endsection
