<!-- Header -->
<header class="bg-green-600 text-white py-4 flex items-center justify-center shadow-lg px-6 relative">
    <!-- Logo + Text (tetap di tengah) -->
    <div class="flex items-center gap-4">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Puskesmas"
            class="w-24 h-24 rounded-full border-4 border-white shadow-lg">

        <!-- Text -->
        <div class="flex flex-col justify-center">
            <h1 class="text-3xl font-bold tracking-wide">
                {{ Config::get('mysite.company_name', 'KOSONG') }}
            </h1>
            <h2 class="text-lg font-bold tracking-wide">
                {{ Config::get('mysite.company_adress', 'KOSONG') }}
            </h2>
        </div>
    </div>

    <!-- Tanggal di kanan, vertical tengah -->
    <div id="current-date"
        class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-gray-300 text-gray-800 px-3 py-1 rounded-md font-semibold text-xl shadow-md">
        <!-- JS akan mengisi tanggal -->
    </div>
</header>

<script>
    // Set tanggal sekarang
    const dateContainer = document.getElementById('current-date');
    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };
    const now = new Date();
    dateContainer.textContent = now.toLocaleDateString('id-ID', options);
</script>
