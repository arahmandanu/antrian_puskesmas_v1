<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loket Antrian Puskesmas</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        html,
        body {
            height: 100%;
            overflow: auto;
        }

        body {
            overflow: hidden;
            font-family: 'Inter', sans-serif;
        }

        .btn-touch {
            transition: transform 0.15s ease-out;
        }

        .btn-touch:active {
            transform: scale(1.2);
            /* Membesar saat klik/touch */
        }

        /* Chrome, Edge, Safari */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            /* slate-100 */
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #16a34a;
            /* green-600 */
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #15803d;
            /* green-700 */
        }

        /* Firefox */
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #16a34a #f1f5f9;
        }
    </style>

    <!-- jQuery -->
    <script src="{{ asset('js/startmin/js/jquery.min.js') }}"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    @include('shared.header')

    <!-- Main Content -->
    @yield('content')

    @include('shared.footer')
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
