@extends('shared.main')

@section('content')
    <main class="flex justify-center flex-grow overflow-y-auto h-screen custom-scrollbar bg-gray-50">
        <div class="max-w-7xl w-full mx-auto p-6">
            <!-- Title -->
            <h2 class="text-3xl font-bold mb-8 text-center text-gray-800 tracking-tight">
                Silakan Pilih Poli Antrian
            </h2>

            <!-- Grid Poli -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($polis as $poli)
                    <div
                        class="bg-white rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1 transform transition-all duration-300 flex flex-col overflow-hidden">

                        <!-- Header -->
                        <div
                            class="flex flex-col items-center bg-gradient-to-r from-indigo-500 to-purple-600 p-6 text-white">
                            <span class="text-5xl mb-2">🩺</span>
                            <h3 class="text-lg font-bold tracking-wide">{{ Str::upper($poli->name) }}</h3>
                        </div>

                        <!-- Body -->
                        <div class="flex flex-col flex-grow items-center p-5 text-center">
                            <p class="text-gray-700 text-sm mb-2">
                                No terakhir: <span class="font-semibold">{{ $poli->current_queue ?? '-' }}</span>
                            </p>
                            <p class="text-gray-700 text-sm">
                                Lantai: <span class="font-semibold">{{ $poli->lantai }}</span>
                            </p>
                        </div>

                        <!-- Footer -->
                        <div class="grid grid-cols-2 gap-3 p-4 bg-gray-50 border-t border-gray-100">
                            <a href="{{ route('poli.generateView', $poli->id) }}"
                                class="px-4 py-2 rounded-lg bg-blue-500 text-white text-sm font-medium text-center shadow hover:bg-blue-600 transition">
                                Loket Staff
                            </a>
                            <a href="{{ route('poli.showQueueByRoom', $poli->id) }}"
                                class="px-4 py-2 rounded-lg bg-green-500 text-white text-sm font-medium text-center shadow hover:bg-green-600 transition">
                                Antrian Customer
                            </a>
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div
                        class="bg-white border-2 border-red-500 rounded-2xl shadow-sm p-10 flex flex-col items-center justify-center text-center">
                        <span class="text-5xl mb-4">❌</span>
                        <h3 class="text-xl font-bold text-red-600 mb-2">Tidak ada Poli yang tersedia</h3>
                        <p class="text-gray-600 text-sm">Silakan hubungi admin untuk menambahkan poli baru.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
@endsection
