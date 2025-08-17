@extends('shared.main')

@section('content')
    <!-- Main -->
    <main class="flex justify-center flex-grow overflow-y-auto h-screen custom-scrollbar ">
        <div class="max-w-6xl w-full p-6">
            <h2 class="text-2xl font-semibold mb-10 text-center text-gray-700">
                Silakan Pilih Loket Antrian anda
            </h2>

            <!-- Grid Loket -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">

                @forelse ($lokets as $loket)
                    <!-- Loket 1 -->
                    <a href="{{ route('loket_antrian.generateView', $loket->locket_number) }}" onclick="pilihLoket('Loket 1')"
                        class="cursor-pointer bg-white border-2 border-green-600 rounded-xl shadow-lg
                 hover:shadow-2xl hover:scale-105 transform transition-all duration-300
                 flex flex-col items-center justify-center p-6">
                        <span class="text-5xl mb-3">🏢</span>
                        <h3 class="text-xl font-bold text-green-700">{{ $loket->locket_number }}</h3>
                        <p class="text-gray-600 text-sm mt-1">Staff: {{ $loket->staff_name }}</p>
                    </a>
                @empty
                    <!-- Loket 1 -->
                    <div
                        class="cursor-pointer bg-white border-2 border-green-600 rounded-xl shadow-lg
                 hover:shadow-2xl hover:scale-105 transform transition-all duration-300
                 flex flex-col items-center justify-center p-6">
                        <span class="text-5xl mb-3">🏢</span>
                        <h3 class="text-xl font-bold text-green-700">Tidak ada loket staff, silahkan buat dahulu di menu
                            admin anda</h3>
                    </div>
                @endforelse

            </div>
        </div>
    </main>
@endsection
