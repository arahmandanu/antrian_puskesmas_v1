<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Startmin - Bootstrap Admin Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('css/startmin/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ asset('css/startmin/css/metisMenu.min.css') }}" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="{{ asset('css/startmin/css/timeline.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/startmin/css/startmin.css') }}" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="{{ asset('css/startmin/css/morris.css') }}" rel="stylesheet">

    <!-- Custom CSS for DataTables -->
    <link href="{{ asset('css/startmin/css/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/startmin/css/dataTables/dataTables.responsive.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ asset('css/startmin/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="{{ asset('js/startmin/js/jquery.min.js') }}"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
            /* agar main menempati sisa tinggi layar */
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 15px 0;
            font-size: 14px;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <div id="wrapper">

        @include('admin.shared.header')

        @include('admin.shared.sidebar')

        <div id="page-wrapper">
            @yield('content')
        </div>
        <!-- /#page-wrapper -->
        <footer class="bg-black text-white mt-auto">
            &copy; 2025 by PT Karya Wiguna. Semua hak cipta dilindungi.
        </footer>
    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap datatable -->
    <script src="{{ asset('js/dataTables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables/dataTables.bootstrap.min.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('js/startmin/js/bootstrap.min.js') }}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ asset('js/startmin/js/metisMenu.min.js') }}"></script>

    <!-- Morris Charts JavaScript -->
    <script src="{{ asset('js/startmin/js/raphael.min.js') }}"></script>
    {{-- <script src="{{ asset('js/startmin/js/morris.min.js') }}"></script>
    <script src="{{ asset('js/startmin/js/morris-data.js') }}"></script> --}}

    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('js/startmin/js/startmin.js') }}"></script>
</body>

</html>
