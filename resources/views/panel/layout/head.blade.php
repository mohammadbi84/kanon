<head>
    <link href="https://v1.fontapi.ir/css/VazirFD" rel="stylesheet">

    <style>
        /* General Styles */
        body {
            font-family: 'Vazir FD', sans-serif !important;
            direction: rtl;
            background: #F2F2F2 !important;
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

    <!-- main menu -->
    <link rel="stylesheet" href="{{ asset('site/src/style/main-menu-full.css') }}">
    <script src="{{ asset('site/src/js/main-menu.js') }}"></script>
    <!-- main menu -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">


    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-fa-IR.js"></script>

    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

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



        /* inputs */
        .autocomplete {
            position: relative;
            /* width: 300px; */
        }

        .autocomplete input,
        .autocomplete textarea {
            outline: 0px solid transparent !important;
            width: 100%;
            padding: 10px 15px 10px 10px;
            padding-left: 24px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px
        }

        .autocomplete label {
            font-size: 15px;
            position: absolute;
            right: 15px;
            top: 21%;
            transition: 0.2s;
            pointer-events: none;
            color: #666;
        }

        .autocomplete .dropdown .active {
            background-color: #F2F9FF;
        }

        .autocomplete input:focus+label,
        .autocomplete.filled input+label,
        .autocomplete textarea:focus+label,
        .autocomplete.filled textarea+label {
            outline: none !important;
            border: none !important;
            top: -10px !important;
            right: 10px;
            background: white;
            padding: 0 5px;
            font-size: 0.75rem;
            color: #6c757d;
        }

        .autocomplete .clear-btn {
            display: none;
            position: absolute;
            left: 10px;
            top: 47%;
            transform: translateY(-50%);
            cursor: pointer;
            font-weight: bold;
            color: #888;
        }
    </style>
    @yield('head')
</head>
