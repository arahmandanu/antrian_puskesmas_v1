@extends('shared.main')

@section('content')
    <main class="flex flex-grow">
        <!-- Sidebar kiri (iklan) -->
        <div class="w-4/5 bg-white p-4 flex items-center justify-center">
            <img src="https://via.placeholder.com/900x600?text=Iklan+Puskesmas" alt="Iklan Puskesmas"
                class="max-h-full max-w-full object-contain rounded-lg shadow-lg">
        </div>

        <!-- Sidebar kanan (tombol) -->
        <div class="w-1/5 bg-gray-100 p-4 flex flex-col gap-8 justify-center items-center">
            <button
                class="btn-touch w-full py-8 rounded-2xl shadow-xl text-white text-3xl font-extrabold tracking-wide
                           bg-gradient-to-r from-yellow-400 to-yellow-500
                           hover:from-yellow-500 hover:to-yellow-400">
                📝 Pendaftaran
            </button>

            <button
                class="btn-touch w-full py-8 rounded-2xl shadow-xl text-white text-3xl font-extrabold tracking-wide
                           bg-gradient-to-r from-blue-400 to-blue-500
                           hover:from-blue-500 hover:to-blue-400">
                🔬 Laborate
            </button>

            <button
                class="btn-touch w-full py-8 rounded-2xl shadow-xl text-white text-3xl font-extrabold tracking-wide
                           bg-gradient-to-r from-pink-400 to-pink-500
                           hover:from-pink-500 hover:to-pink-400">
                👵 Lansia
            </button>
        </div>
    </main>
@endsection
