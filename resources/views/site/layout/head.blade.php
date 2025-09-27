<head>
    <style>
        /* General Styles */
        body {
            direction: rtl;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('site/src/style/font-awesome.css')}}">
    <!-- BOOTSTRAP 5 -->
    <link href="{{asset('site/src/style/bootstrap.css')}}" rel="stylesheet">
    <script src="{{asset('site/src/js/bootstrap.js')}}"></script>
    <!--icons-->
    <link rel="stylesheet" href="{{asset('site/src/style/bootstrap-icons.css')}}" />
    <!-- BOOTSTRAP 5 -->
    <!-- SLIDER LIBRARY (tiny slider) -->
    <link rel="stylesheet" href="{{asset('site/src/style/tiny-slider.css')}}">
    <script src="{{asset('site/src/js/tiny-slider.js')}}"></script>
    <!-- SLIDER LIBRARY (tiny slider) -->
    <!-- SLIDER LIBRARY (Splide) -->
    <script src="{{asset('site/src/js/splide.js')}}"></script>
    <link rel="stylesheet" href="{{asset('site/src/style/splide.css')}}">
    <!-- intersection extension for slider autoplay only when slider is visible in viewport -->
    <script src="{{asset('site/src/js/splide-extension-intersection.js')}}"></script>
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

    <script src="{{ asset('site/src/js/init.js') }}"></script>
    <link href="{{asset('site/src/style/animate.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('site/src/style/leaflet.css')}}"/>
    <script src="{{asset('site/src/js/leaflet.js')}}"></script>

    <!-- Leaflet Marker Cluster CSS and JS -->
    <script src="{{asset('site/src/js/leaflet-markercluster.js')}}"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


    <link href="https://v1.fontapi.ir/css/VazirFD" rel="stylesheet">
    <style>
        body {
            font-family: 'Vazir FD', sans-serif !important;
            /* Or 'Vazirmatn', 'Vazir', depending on the CDN/version */
            background-color: #f2f2f2 !important;
        }
    </style>
    <style>
        html,
        body {
            height: 100% !important;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        body.swal2-height-auto{
            height: 100% !important;
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
