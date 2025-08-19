@extends('shared.main')

@section('content')
    <!-- Main Content -->
    <main class="flex flex-col flex-grow items-center p-6 overflow-y-auto h-screen custom-scrollbar">
        <div class="flex justify-center items-center w-full max-w-3xl mb-10">
            <h2 class="text-lg font-light text-center">
                Panel Pemilihan Play Suara Lantai
            </h2>
        </div>

        <!-- Tombol Panggilan Lantai -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 w-full max-w-4xl mb-5">
            @foreach (range(1, config('mysite.total_lantai')) as $lantai)
                <a href="{{ Route('play_suara.choosedLantai', $lantai) }}" registeredMenu="LANTAI-{{ $lantai }}"
                    onclick="panggilAntrian(this,'LANTAI-{{ $lantai }}','Lantai {{ $lantai }}')"
                    class="flex flex-col items-center justify-center w-full aspect-square bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-3xl shadow-lg transform transition duration-300 hover:scale-105 hover:shadow-2xl active:scale-95 cursor-pointer p-6">
                    <span class="text-4xl mb-2">🔊</span>
                    <h2 class="text-2xl font-bold text-center">Lantai {{ $lantai }}</h2>
                </a>
            @endforeach
        </div>
    </main>
@endsection
