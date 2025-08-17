<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loket Antrian Puskesmas</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/locket.css') }}">
    <!-- Custom Fonts -->
    <link href="{{ asset('css/startmin/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <!-- jQuery -->
    <script src="{{ asset('js/startmin/js/jquery.min.js') }}"></script>
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">

    @include('shared.header')

    <!-- Flash Message -->
    <div class="max-w-4xl mx-auto mt-4 px-4">
        @if (session('success'))
            <div class="mb-4 p-4 rounded-lg bg-green-100 border border-green-400 text-green-700 flex items-center">
                <i class="fa fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 rounded-lg bg-red-100 border border-red-400 text-red-700 flex items-center">
                <i class="fa fa-exclamation-circle mr-2"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 rounded-lg bg-red-100 border border-red-400 text-red-700 flex items-center">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>
                            <i class="fa fa-exclamation-circle mr-2"></i>
                            <span>{{ $error }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    @yield('content')

    @include('shared.footer')
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
