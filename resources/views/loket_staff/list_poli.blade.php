@extends('shared.main')

@section('content')
    <!-- Main scrollable -->
    <main class="flex justify-center flex-grow overflow-y-auto h-screen custom-scrollbar">
        <div class="max-w-7xl w-full mx-auto p-6">
            <h2 class="text-2xl font-semibold mb-6 text-center text-gray-700">
                Silakan Pilih Poli Panggilan Antrian
            </h2>

            <!-- Grid 15 Poli dengan 4 kolom -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                @forelse ($polis as $poli)
                    <!-- Contoh Poli -->
                    <a href="{{ route('poli.generateView', $poli->id) }}"
                        class="cursor-pointer bg-white border-2 border-green-600 rounded-xl shadow-md
                 hover:shadow-xl hover:scale-105 transform transition-all duration-300
                 flex flex-col items-center justify-center p-6">
                        <span class="text-4xl mb-2">🩺</span>
                        <h3 class="text-lg font-bold text-green-700">{{ Str::upper($poli->name) }}</h3>
                        <p class="text-sm text-gray-800 mt-2">No terakhir: <span
                                class="font-semibold">{{ $poli->current_queue ?? '-' }}</span></p>

                        <p class="text-sm text-gray-800 mt-2">lantai: <span class="font-semibold">{{ $poli->lantai }}</span>
                        </p>
                    </a>
                @empty
                    <!-- Jika tidak ada poli -->
                    <div
                        class="bg-white border-2 border-red-600 rounded-xl shadow-md
                 flex flex-col items-center justify-center p-6">
                        <span class="text-4xl mb-2">❌</span>
                        <h3 class="text-lg font-bold text-red-700">Tidak ada Poli yang tersedia</h3>
                        <p class="text-gray-600 text-sm">Silahkan hubungi admin untuk menambahkan poli baru.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
@endsection
