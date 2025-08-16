@extends('shared.main')

@section('content')
    <!-- Main -->
    <main class="flex justify-center flex-grow custom-scrollbar overflow-y-auto h-screen custom-scrollbar ">
        <div class="max-w-6xl w-full p-6">
            <h2 class="text-2xl font-semibold mb-10 text-center text-gray-700">
                Silakan Pilih Loket Antrian
            </h2>

            <!-- Grid Loket -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">

                <!-- Loket 1 -->
                <div onclick="pilihLoket('Loket 1')"
                    class="cursor-pointer bg-white border-2 border-green-600 rounded-xl shadow-lg
                 hover:shadow-2xl hover:scale-105 transform transition-all duration-300
                 flex flex-col items-center justify-center p-6">
                    <span class="text-5xl mb-3">🏢</span>
                    <h3 class="text-xl font-bold text-green-700">Loket 1</h3>
                    <p class="text-gray-600 text-sm mt-1">Staff: Budi Santoso</p>
                </div>

                <!-- Loket 2 -->
                <div onclick="pilihLoket('Loket 2')"
                    class="cursor-pointer bg-white border-2 border-blue-600 rounded-xl shadow-lg
                 hover:shadow-2xl hover:scale-105 transform transition-all duration-300
                 flex flex-col items-center justify-center p-6">
                    <span class="text-5xl mb-3">🏢</span>
                    <h3 class="text-xl font-bold text-blue-700">Loket 2</h3>
                    <p class="text-gray-600 text-sm mt-1">Staff: Siti Rahmawati</p>
                </div>

                <!-- Loket 3 -->
                <div onclick="pilihLoket('Loket 3')"
                    class="cursor-pointer bg-white border-2 border-yellow-600 rounded-xl shadow-lg
                 hover:shadow-2xl hover:scale-105 transform transition-all duration-300
                 flex flex-col items-center justify-center p-6">
                    <span class="text-5xl mb-3">🏢</span>
                    <h3 class="text-xl font-bold text-yellow-700">Loket 3</h3>
                    <p class="text-gray-600 text-sm mt-1">Staff: Andi Prasetyo</p>
                </div>

                <!-- Loket 4 -->
                <div onclick="pilihLoket('Loket 4')"
                    class="cursor-pointer bg-white border-2 border-red-600 rounded-xl shadow-lg
                 hover:shadow-2xl hover:scale-105 transform transition-all duration-300
                 flex flex-col items-center justify-center p-6">
                    <span class="text-5xl mb-3">🏢</span>
                    <h3 class="text-xl font-bold text-red-700">Loket 4</h3>
                    <p class="text-gray-600 text-sm mt-1">Staff: Dewi Lestari</p>
                </div>

                <!-- Loket 5 -->
                <div onclick="pilihLoket('Loket 5')"
                    class="cursor-pointer bg-white border-2 border-purple-600 rounded-xl shadow-lg
                 hover:shadow-2xl hover:scale-105 transform transition-all duration-300
                 flex flex-col items-center justify-center p-6">
                    <span class="text-5xl mb-3">🏢</span>
                    <h3 class="text-xl font-bold text-purple-700">Loket 5</h3>
                    <p class="text-gray-600 text-sm mt-1">Staff: Rina Wijaya</p>
                </div>

                <!-- Loket 1 -->
                <div onclick="pilihLoket('Loket 1')"
                    class="cursor-pointer bg-white border-2 border-green-600 rounded-xl shadow-lg
                 hover:shadow-2xl hover:scale-105 transform transition-all duration-300
                 flex flex-col items-center justify-center p-6">
                    <span class="text-5xl mb-3">🏢</span>
                    <h3 class="text-xl font-bold text-green-700">Loket 1</h3>
                    <p class="text-gray-600 text-sm mt-1">Staff: Budi Santoso</p>
                </div>

                <!-- Loket 2 -->
                <div onclick="pilihLoket('Loket 2')"
                    class="cursor-pointer bg-white border-2 border-blue-600 rounded-xl shadow-lg
                 hover:shadow-2xl hover:scale-105 transform transition-all duration-300
                 flex flex-col items-center justify-center p-6">
                    <span class="text-5xl mb-3">🏢</span>
                    <h3 class="text-xl font-bold text-blue-700">Loket 2</h3>
                    <p class="text-gray-600 text-sm mt-1">Staff: Siti Rahmawati</p>
                </div>

                <!-- Loket 3 -->
                <div onclick="pilihLoket('Loket 3')"
                    class="cursor-pointer bg-white border-2 border-yellow-600 rounded-xl shadow-lg
                 hover:shadow-2xl hover:scale-105 transform transition-all duration-300
                 flex flex-col items-center justify-center p-6">
                    <span class="text-5xl mb-3">🏢</span>
                    <h3 class="text-xl font-bold text-yellow-700">Loket 3</h3>
                    <p class="text-gray-600 text-sm mt-1">Staff: Andi Prasetyo</p>
                </div>

                <!-- Loket 4 -->
                <div onclick="pilihLoket('Loket 4')"
                    class="cursor-pointer bg-white border-2 border-red-600 rounded-xl shadow-lg
                 hover:shadow-2xl hover:scale-105 transform transition-all duration-300
                 flex flex-col items-center justify-center p-6">
                    <span class="text-5xl mb-3">🏢</span>
                    <h3 class="text-xl font-bold text-red-700">Loket 4</h3>
                    <p class="text-gray-600 text-sm mt-1">Staff: Dewi Lestari</p>
                </div>

                <!-- Loket 5 -->
                <div onclick="pilihLoket('Loket 5')"
                    class="cursor-pointer bg-white border-2 border-purple-600 rounded-xl shadow-lg
                 hover:shadow-2xl hover:scale-105 transform transition-all duration-300
                 flex flex-col items-center justify-center p-6">
                    <span class="text-5xl mb-3">🏢</span>
                    <h3 class="text-xl font-bold text-purple-700">Loket 5</h3>
                    <p class="text-gray-600 text-sm mt-1">Staff: Rina Wijaya</p>
                </div>
            </div>
        </div>
    </main>

    <script>
        function pilihLoket(loket) {
            alert("Anda memilih " + loket);
            // Bisa diarahkan ke halaman pemanggilan antrian
            // window.location.href = "/loket/" + loket.toLowerCase().replace(" ", "-");
        }
    </script>
@endsection
