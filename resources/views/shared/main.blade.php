<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/icon.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loket Antrian Puskesmas</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/locket.css') }}">
    <!-- Custom Fonts -->
    <link href="{{ asset('css/startmin/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" /> --}}
    <!-- jQuery -->
    <script src="{{ asset('js/startmin/js/jquery.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="server-date" content="{{ now()->toDateString() }}">
    <meta name="base-url" content="{{ url('/') }}">
    <meta name="company-name" content="{{ Config::get('mysite.company_name', 'KOSONG') }}">
    <meta name="address-name" content="{{ Config::get('mysite.company_adress', 'KOSONG') }}">
    <style>
        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: url('{{ asset('images/bg.png') }}');
            background-size: cover;
            background-position: center;
            filter: blur(90px);
            z-index: -1;
        }
    </style>
</head>

<body class="bg-green-200 flex flex-col min-h-screen">

    @if (!isset($noHeader) || $noHeader === false)
        @include('shared.header')
    @endif

    <!-- Main Content -->
    @yield('content')

    @if (!isset($noFooter) || $noFooter === false)
        @include('shared.footer')
    @endif

    @if (isset($walkFooter))
        @if ($walkFooter === true)
            @include('shared.marque')
        @endif
    @endif
    <script>
        let lastHistoryDate = document
            .querySelector('meta[name="server-date"]')
            .getAttribute('content');

        setInterval(() => {
            $.get("{{ route('refreshToken') }}", function(data) {
                document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.csrf_token);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': data.csrf_token
                    }
                });
            });
        }, 5 * 60 * 1000);
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
