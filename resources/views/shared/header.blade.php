<!-- Header -->
<header class="bg-green-600 text-white py-4 flex flex-col items-center shadow-lg">
    <img src="{{ asset('images/logo.png') }}" alt="Logo Puskesmas"
        class="w-24 h-24 rounded-full border-4 border-white shadow-lg mb-2">
    <h1 class="text-2xl font-bold tracking-wide">{{ Config::get('mysite.company_name', 'KOSONG') }}</h1>
    <h1 class="text-1xl font-bold tracking-wide">{{ Config::get('mysite.company_adress', 'KOSONG') }}</h1>
</header>
