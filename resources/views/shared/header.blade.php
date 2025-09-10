<!-- Header -->
<header class="bg-green-600 text-white py-4 flex items-center justify-center shadow-lg px-6 gap-6">
    <!-- Logo -->
    <img src="{{ asset('images/logo.png') }}" alt="Logo Puskesmas"
        class="w-24 h-24 rounded-full border-4 border-white shadow-lg mr-4">

    <!-- Text -->
    <div class="flex flex-col items-center justify-center">
        <h1 class="text-2xl font-bold tracking-wide">
            {{ Config::get('mysite.company_name', 'KOSONG') }}
        </h1>
        <h2 class="text-lg font-bold tracking-wide">
            {{ Config::get('mysite.company_adress', 'KOSONG') }}
        </h2>
    </div>
</header>
