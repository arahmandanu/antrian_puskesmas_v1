@extends('shared.main')

@section('content')
    <main class="flex-grow flex flex-col items-center justify-center p-6 space-y-12">

        <!-- Box Nomor Terpanggil -->
        <div class="bg-white rounded-2xl shadow-2xl p-12 w-full max-w-lg text-center">
            <p class="text-gray-500 text-xl mb-4">Sedang Dipanggil</p>
            <div class="text-9xl font-extrabold text-green-700" id="nomor-sekarang">
                @if ($poli->last_call_queue)
                    {{ $poli->code }}{{ $poli->last_call_queue ?? '-' }}
                @else
                    -
                @endif
            </div>
        </div>

        <!-- Box Nomor Berikutnya -->
        <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-lg text-center">
            <p class="text-gray-500 text-lg mb-2">Nomor Berikutnya</p>
            <div class="text-6xl font-bold text-gray-800" id="nomor-selanjutnya">
                @if ($poli->last_call_queue)
                    {{ $poli->code }}{{ sprintf('%03d', $poli->last_call_queue + 1) }}
                @else
                    -
                @endif
            </div>
        </div>

    </main>

    <script>
        // Contoh data sementara, bisa diambil dari backend Laravel
        let nomorSekarang = 'A12';
        let nomorSelanjutnya = 'A13';

        const nomorSekarangEl = document.getElementById("nomor-sekarang");
        const nomorSelanjutnyaEl = document.getElementById("nomor-selanjutnya");

        // Fungsi update nomor (simulasi)
        function updateNomor(nomorNow, nomorNext) {
            nomorSekarangEl.textContent = nomorNow;
            nomorSelanjutnyaEl.textContent = nomorNext;
        }

        // Contoh simulasi update setiap 5 detik
        // setInterval(() => {
        //     let nowNum = parseInt(nomorSekarang.slice(1)) + 1;
        //     let nextNum = nowNum + 1;
        //     nomorSekarang = 'A' + nowNum;
        //     nomorSelanjutnya = 'A' + nextNum;
        //     updateNomor(nomorSekarang, nomorSelanjutnya);
        // }, 5000);
    </script>
@endsection
