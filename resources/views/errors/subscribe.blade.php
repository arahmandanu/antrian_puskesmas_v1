<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Subscribe | PT Karya Wiguna</title>
    <link href="{{ asset('css/startmin/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        footer {
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 15px 0;
            font-size: 14px;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <main>
        <div class="container bg-white">
            <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
                <h1>403</h1>
                <h2>Apakah anda sudah mensubscribe aplikasi ini?</h2>
                <h2>Silahkan hubungi developer anda!</h2>

                <img src="{{ asset('subscribe3.png') }}" class="img-fluid py-5" alt="Subscribe first!">
                <div class="credits">
                    <!-- All the links in the footer should remain intact. -->
                    <!-- You can delete the links only if you purchased the pro version. -->
                    <!-- Licensing information: https://bootstrapmade.com/license/ -->
                    <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                    {{-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> --}}
                </div>
            </section>

        </div>
    </main>



    <!-- Footer -->
    <footer class="mt-auto">
        &copy; 2025 by PT Karya Wiguna. Semua hak cipta dilindungi.
    </footer>

    <script src="{{ asset('js/startmin/js/jquery.min.js') }}"></script>
</body>

</html>
