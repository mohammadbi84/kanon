<head>
    <style>
        /* General Styles */
        body {
            font-family: sans-serif;
            direction: rtl;
            background: #F3F3F9 !important;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> --}}
    <!-- BOOTSTRAP 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!--icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
    <!-- BOOTSTRAP 5 -->
    <!-- SLIDER LIBRARY (tiny slider) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>
    <!-- SLIDER LIBRARY (tiny slider) -->
    <!-- SLIDER LIBRARY (Splide) -->
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
    <!-- intersection extension for slider autoplay only when slider is visible in viewport -->
    <script
        src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-intersection@0.2.0/dist/js/splide-extension-intersection.min.js"
        integrity="sha256-JKADUEtliYhbM/9Tqt7qaeQb7T2XmLEKqJ068n6tcq0=" crossorigin="anonymous"></script>
    <!-- SLIDER LIBRARY (Splide) -->

    <link rel="stylesheet" href="{{ asset('site/src/style/styles.css') }}">
    <script src="{{ asset('site/src/js/utils.js') }}"></script>

    <!-- main menu -->
    <link rel="stylesheet" href="{{ asset('site/src/style/main-menu-full.css') }}">
    <script src="{{ asset('site/src/js/main-menu.js') }}"></script>
    <!-- main menu -->

    <!-- top slider -->
    <link rel="stylesheet" href="{{ asset('site/src/style/top-slider.css') }}">
    <script src="{{ asset('site/src/js/top-slider.js') }}"></script>
    <!-- top slider -->

    <!-- top ad -->
    <link rel="stylesheet" href="{{ asset('site/src/style/top-ad.css') }}">
    <script src="{{ asset('site/src/js/top-ad.js') }}"></script>
    <!-- top ad -->

    <!-- video popup -->
    <link rel="stylesheet" href="{{ asset('site/src/style/video-popup.css') }}">
    <script src="{{ asset('site/src/js/video-popup.js') }}"></script>
    <!-- video popup -->

    <!-- forms -->
    <link rel="stylesheet" href="{{ asset('site/src/style/forms.css') }}">
    <!-- forms -->

    <!-- btn-play with pulse -->
    <link rel="stylesheet" href="{{ asset('site/src/style/btn-play-pulse.css') }}">
    <!-- btn-play with pulse -->


    <!-- btn support -->
    <link rel="stylesheet" href="{{ asset('site/src/style/btn-support.css') }}">
    <script src="{{ asset('site/src/js/btn-support.js') }}"></script>
    <!-- btn go-to-top -->

    <!-- btn go-to-top -->
    <link rel="stylesheet" href="{{ asset('site/src/style/btn-go-to-top.css') }}">
    <script src="{{ asset('site/src/js/btn-go-to-top.js') }}"></script>
    <!-- btn go-to-top -->

    <!-- switch element -->
    <link rel="stylesheet" href="{{ asset('site/src/style/switch.css') }}">
    <!-- switch element -->


    <!-- wave overlay -->
    <script src="{{ asset('site/src/js/wave-overlay.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('site/src/style/wave-overlay.css') }}">
    <!-- wave overlay -->

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> --}}

    <script src="{{ asset('site/src/js/init.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" rel="stylesheet">

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/fbc05d3d5f.js" crossorigin="anonymous"></script>
    <!-- Leaflet Marker Cluster CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .wrapper {
            flex: 1;
            /* فضای باقی‌مانده رو پر می‌کنه */
        }

        .footer {
            background-color: #f1f1f1;
            /* به دلخواه */
            padding: 20px;
            text-align: center;
        }

        .container {
            padding-right: 20px !important;
            padding-left: 20px !important;
        }
    </style>
    @yield('head')
</head>
