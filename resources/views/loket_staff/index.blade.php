@extends('shared.main')

@section('content')
    <!-- Main Content -->
    @php
        use App\Enum\LocketList;
        $colorClasses = [
            'yellow' => 'bg-yellow-400 hover:bg-yellow-300 text-yellow-800',
            'blue' => 'bg-blue-400 hover:bg-blue-300 text-blue-800',
            'pink' => 'bg-pink-400 hover:bg-pink-300 text-pink-800',
        ];
    @endphp

    <main class="flex flex-col flex-grow items-center p-6 overflow-y-auto h-screen custom-scrollbar">
        <input type="hidden" value="{{ $loket->locket_number }}" id="loket_number">
        <input type="hidden" value="{{ $loket->id }}" id="id">

        <!-- Header -->
        <div class="w-full max-w-3xl mb-10 text-center">
            <h2 class="text-xl font-light">
                Selamat datang <span class="font-semibold">{{ $loket->staff_name }}</span>,
                Anda berada di <span class="font-semibold">Loket {{ $loket->locket_number }}</span>
            </h2>
            <p class="text-gray-600">Panel Panggilan Antrian Staff Loket</p>
        </div>

        <!-- Menu Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-3xl mb-8">
            @foreach ($menus as $menu)
                <div registeredMenu="{{ $menu['type'] }}"
                    class="rounded-2xl shadow-lg p-5 flex flex-col items-center gap-2 {{ $colorClasses[$menu['color']] }}">
                    <span class="text-3xl">{{ $menu['icon'] }}</span>
                    <h2 class="text-xl font-bold">{{ $menu['title'] }}</h2>
                    <span class="text-sm font-medium" id="sisa-{{ $menu['type'] }}">
                        Sisa antrian: {{ $locket_totals[$menu['type']->value] ?? 0 }}
                    </span>

                    <div class="flex gap-3 mt-3 w-full p-3">
                        <button onclick="panggilAntrian(this,'{{ $menu['type'] }}', '{{ $menu['type']->name }}')"
                            class="flex-1 py-2 rounded-xl font-semibold text-white {{ $menu['color'] === 'yellow' ? 'bg-yellow-600 hover:bg-yellow-700' : '' }}
                               {{ $menu['color'] === 'blue' ? 'bg-blue-600 hover:bg-blue-700' : '' }}
                               {{ $menu['color'] === 'pink' ? 'bg-pink-600 hover:bg-pink-700' : '' }}">
                            Panggil
                        </button>

                        <button onclick="recallAntrian(this,'{{ $menu['type'] }}', '{{ $menu['type']->name }}')"
                            class="flex-1 py-2 rounded-xl font-semibold
                               {{ $menu['color'] === 'yellow' ? 'bg-yellow-200 hover:bg-yellow-300 text-yellow-800' : '' }}
                               {{ $menu['color'] === 'blue' ? 'bg-blue-200 hover:bg-blue-300 text-blue-800' : '' }}
                               {{ $menu['color'] === 'pink' ? 'bg-pink-200 hover:bg-pink-300 text-pink-800' : '' }}">
                            Recall
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Tombol Pilih Poli -->
        <div class="col-span-full flex justify-center mb-10">
            <a href="{{ route('loket_antrian.showPoli', '') }}/{{ $loket->locket_number }}"
                class="mt-2 px-6 py-3 rounded-xl bg-green-600 text-white font-bold hover:bg-green-700 shadow-lg">
                Pilih Poli
            </a>
        </div>

        <!-- Riwayat Panggilan -->
        <div class="w-full max-w-3xl bg-white shadow-lg rounded-xl p-6">
            <h3 class="text-xl font-semibold mb-4">Riwayat Panggilan</h3>
            <ul id="riwayat" class="space-y-2 text-lg text-gray-800">
                @forelse ($histories as $history)
                    <li>{{ $history->locket_code . $history->number_queue }} -
                        {{ LocketList::from($history->locket_code)->name }}</li>
                @empty
                    <li class="text-gray-500">Belum ada panggilan</li>
                @endforelse
            </ul>
        </div>
    </main>

    <script>
        let historiesData = @json($histories);
        const locketQueue = "pendaftaran";
        const allButtons = document.querySelectorAll('button');
        const recallUrlTemplate =
            "{{ route('loket_antrian.recall', ['locket_code' => ':code', 'locket_number' => ':number']) }}";
        let locketNumber = document.getElementById('loket_number').value;
        const riwayatEl = document.getElementById("riwayat");
        const allSisaAntrian = document.querySelectorAll('[id^="sisa-"]');

        $(document).ready(function() {
            setInterval(() => {
                updateSisaAntrian();
            }, 3000);

            setInterval(() => {
                resetRiwayatIfNewDay();
            }, 60000);
        });

        function updateSisaAntrian() {
            safeAjax({
                url: "{{ route('loket_antrian.sisaAntrian') }}",
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.hasOwnProperty('data')) {
                        let codeFromResponse = Object.keys(data.data);
                        allSisaAntrian.forEach(el => {
                            let key = el.id.replace("sisa-", "");
                            if (!codeFromResponse.includes(key)) {
                                $(`#sisa-${key}`).text(`Sisa antrian: 0`);
                            }
                        });
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

        function panggilAntrian(btn, prefix, poli) {
            allButtons.forEach(btn => btn.disabled = true);
            const originalText = btn.textContent;
            btn.textContent = "Memanggil...";

            safeAjax({
                type: "POST",
                url: "{{ route('loket_antrian.nextQueue') }}",
                data: {
                    locket_code: prefix,
                    poli: poli,
                    locket_number: locketNumber,
                },
                dataType: "JSON",
                success: function(response) {
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
                statusCode: {
                    422: function(response) {
                        Swal.fire({
                            title: response.responseJSON.message,
                            icon: "error",
                            didOpen: () => {
                                document.body.removeAttribute('style');
                                document.body.classList.remove('swal2-height-auto');
                            }
                        });
                        allButtons.forEach(btn => btn.disabled = false);
                        btn.textContent = originalText;
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status !== 422) {
                        alert("Gagal memanggil antrian. Silakan coba lagi.");
                        allButtons.forEach(btn => btn.disabled = false);
                        btn.textContent = originalText;
                    }
                },
                complete: function() {
                    updateSisaAntrian();
                }
            });
        }

        function recallAntrian(btn, prefix, poli) {
            const originalText = btn.textContent;
            btn.textContent = "Memanggil...";

            let url = recallUrlTemplate
                .replace(':code', prefix)
                .replace(':number', locketNumber);
            safeAjax({
                type: "GET",
                url: url,
                data: {},
                dataType: "json",
                success: function(response) {
                    if (response.hasOwnProperty('data')) {
                        if (response.data?.number_queue && response.data?.locket_number && response.data
                            ?.poli) {
                            tampilkanNomor(btn, response.data?.locket_code + response.data?.number_queue,
                                response.data
                                ?.poli, originalText, response.data?.locket_code, false);
                        } else {
                            alert('Data Antrian Kosong!');
                            allButtons.forEach(btn => btn.disabled = false);
                            btn.textContent = originalText;
                        }
                    } else {
                        allButtons.forEach(btn => btn.disabled = false);
                        btn.textContent = originalText;
                    }
                },
                statusCode: {
                    422: function(response) {
                        Swal.fire({
                            title: response.responseJSON.message,
                            icon: "error",
                            didOpen: () => {
                                document.body.removeAttribute('style');
                                document.body.classList.remove('swal2-height-auto');
                            }
                        });
                        allButtons.forEach(btn => btn.disabled = false);
                        btn.textContent = originalText;
                    }
                },
            });
        }

        function tampilkanNomor(btn, prefix, poli, originalText, locket_code, update_riwayat = true) {
            let nomor = prefix;

            if (update_riwayat) {
                let item = document.createElement("li");
                item.textContent = `${nomor} - ${poli}`;
                riwayatEl.prepend(item);
            }

            while (riwayatEl.children.length > 5) {
                riwayatEl.removeChild(riwayatEl.lastChild);
            }

            if (riwayatEl.firstElementChild.textContent.includes("Belum ada")) {
                riwayatEl.firstElementChild.remove();
            }

            allButtons.forEach(btn => btn.disabled = false);
            btn.textContent = originalText;
        }

        function ejaanNomor(nomor) {
            return nomor.split("").join(" ");
        }

        function resetRiwayatIfNewDay() {
            if (todayLocal() !== lastHistoryDate) {
                lastHistoryDate = todayLocal();

                riwayatEl.innerHTML = "";
                let li = document.createElement("li");
                li.textContent = "Belum ada panggilan";
                li.classList.add("text-gray-500");
                riwayatEl.appendChild(li);

                if (typeof historyList !== "undefined") {
                    historyList = [];
                }
            }
        }
    </script>
@endsection
