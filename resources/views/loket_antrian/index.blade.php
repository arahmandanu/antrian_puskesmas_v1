@extends('shared.main')

@section('content')
    <main class="flex flex-grow">
        <!-- Sidebar kiri (iklan) -->
        <div class="w-4/5 bg-white p-4 flex items-center justify-center">
            <img src="https://via.placeholder.com/900x600?text=Iklan+Puskesmas" alt="Iklan Puskesmas"
                class="max-h-full max-w-full object-contain rounded-lg shadow-lg">
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
        function panggilAntrian(poli, code) {
            const overlay = document.getElementById('loading-overlay');
            overlay.classList.remove('hidden');

            // Disable semua tombol di sidebar kanan
            const buttons = overlay.parentElement.querySelectorAll('button');
            buttons.forEach(btn => btn.disabled = true);

            $.ajax({
                    type: "POST",
                    url: "{{ route('loket_antrian.createQueue') }}",
                    data: {
                        code: code,
                        poli: poli,
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: "JSON"
                })
                .fail(function(data, textStatus, xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Do you want to continue',
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
