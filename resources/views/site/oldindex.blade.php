<!doctype html>
<html lang="fa" dir="rtl">

<head>


    <style>
        /* General Styles */
        body {
            font-family: sans-serif;
        }

        .search-button {
            background-color: #e69926;
            color: white;
            border: none;
            padding-top: 0.8rem;
            padding-bottom: 0.8rem;
        }

        .map-button {
            background-color: #b3d7ff;
            color: white;
            border: 2px solid white;
            padding-top: 0.8rem;
            padding-bottom: 0.8rem;
            box-shadow: 0 0 0 2px #b3d7ff;
        }

        .map-button span {
            color: #333;
        }

        .map-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 999;
            display: none;
            /* Initially hidden */
        }

        .map-fullscreen {
            overflow: hidden;
        }

        /* --- Filter Box Styles (Draggable) --- */
        #filter-box {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            z-index: 1002;
            /* Above the map */
            min-width: 200px;
            cursor: grab;
            /* Initial cursor */
            overflow-y: auto;
            user-select: none;
            /* Prevent text selection */
        }

        #filter-box h4 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1rem;
            cursor: move;
            /* Cursor for the header */
        }

        #filter-box label {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            font-size: 0.9rem;
            cursor: pointer;
            flex-direction: row-reverse;
            /* Reverse the order */
            justify-content: flex-start;
            /* Align to the start (right in RTL) */
        }

        #filter-box input[type="checkbox"] {
            margin-left: 0;
            /*Remove margin Left */
            margin-right: 10px;
            /* Add margin to the right */
            order: 1;
            /* Checkbox first */

        }

        #filter-box .filter-icon {
            width: 24px;
            height: 24px;
            margin-left: 10px;
            /* Space between icon and text*/
            margin-right: 0;
            /*Remove margin Right */
            display: inline-flex;
            align-items: center;
            justify-content: center;
            order: 3;
            /* Icon last */
        }

        #filter-box label span:not(.filter-icon) {
            order: 2;
            /* Text in the middle */
        }

        /* Map Container Styles*/
        #map {
            position: fixed;
            height: 100%;
            width: 100%;
            /* Add z-index */
        }

        #search-bar {
            z-index: 10;
            /* Higher than the map*/
        }

        /*Coordinates display*/
        .coordinates-display {
            margin-top: 10px;
            z-index: 1001;
            position: relative;
        }

        .custom-marker {
            background-color: #4CAF50;
            color: white;
            padding: 5px;
            border-radius: 5px;
            font-size: 12px;
            border: 2px solid white;
        }

        /* Leaflet controls positioning */
        .leaflet-top.leaflet-right {
            position: absolute;
            /* Ensure absolute positioning */
            top: 0.5em;
            /* Adjust as needed for spacing */
            right: 0.5em;
            /* Adjust for spacing */
        }



        /* Style for the location chooser (if you add it back)*/
        .leaflet-control-choose-location {
            background-color: white;
            width: 26px;
            /* Match default Leaflet control size */
            height: 26px;
            line-height: 26px;
            /* Center the icon vertically */
            text-align: center;
            /* Center the icon horizontally */
            cursor: pointer;
            /* Change cursor on hover */
            border-radius: 4px;
            /* Rounded corners (Leaflet style) */
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.65);
            /* Leaflet-style shadow */
            display: block;
            /* Important for consistent sizing*/
            margin-bottom: 5px;
        }

        .leaflet-control-choose-location:hover {
            background-color: #f4f4f4;
        }

        .leaflet-control-choose-location i {
            font-size: 16px;
            /* Adjust icon size as needed */
            color: #333;
            /* A dark gray, like Leaflet's default */
            display: block;
            /* Fill the container */
        }

        /* Style for the close button */
        .leaflet-control-close-map {
            background-color: white;
            width: 26px;
            height: 26px;
            line-height: 26px;
            text-align: center;
            cursor: pointer;
            border-radius: 4px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.65);
            display: block;
            /* Important */
        }

        .leaflet-control-close-map:hover {
            background-color: #f4f4f4;
        }

        .leaflet-control-close-map i {
            font-size: 16px;
            color: #333;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <title>کانون</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
    <link rel="stylesheet" href="{{ asset('site/src/style/main-menu.css') }}">
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- input with floating-label -->
    <link rel="stylesheet" type="text/css" href="{{ asset('site/src/style/input-with-floating-label.css') }}"
        media="screen">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/src/style/input-with-floating-label-rtl-fix.css') }}"
        media="screen">
    <!-- input with floating-label -->

    <style>
        .countdown-timer {
            display: flex;
            /*  خیلی مهم: تایمر رو به یک فلکس‌باکس تبدیل می‌کنیم */
            justify-content: space-around;
            /* فاصله مساوی بین آیتم‌ها */
            /*  اختیاری: می‌تونید استایل‌های دیگه هم اضافه کنید */
            /*  مثلاً: */
            /* width: 80%; */
            /* margin: 0 auto;  */
            /* padding: 10px; */
            /* border: 1px solid #ccc; */
        }

        .timer-col {
            /*  اختیاری: استایل‌دهی به هر ستون تایمر */
            text-align: center;
            padding: 5px;
        }



        .btn-news {
            text-decoration: none;
            position: fixed;
            top: 50%;
            right: -20;
            transform: translateY(-50%);
            width: 35px;
            height: 120px;
            background: #fff;
            border: 1px solid #333;
            border-right: none;
            border-radius: 200px 0 0 200px;
            transition: background 0.4s ease-in-out, transform 0.4s ease-in-out;
            clip-path: polygon(0 0,
                    100% 0,
                    100% 50%,
                    100% 100%,
                    0 100%,
                    0 0);
            display: flex;
            justify-content: center;
            align-items: center;
            writing-mode: vertical-rl;
            text-align: center;
            font-family: sans-serif;
            font-size: 24px;
            color: #000;
        }

        .btn-news:hover {
            background: linear-gradient(to bottom, #e8e8e8, #e8e8e8);
            transform: translateY(-50%) scale(1.05);
        }

        .btn-news span {
            writing-mode: vertical-rl;
            text-align: center;
            text-orientation: mixed;
            transform: rotate(180deg);
        }

        .bottom-icons {
            display: flex;
            justify-content: space-around;
            padding-top: 10px;
        }

        .bottom-icons span {
            font-size: 14px;
            color: #555;
            display: flex;
            align-items: center;
        }

        .bottom-icons span i {
            margin-left: 5px;
            color: #e74c3c;
        }
    </style>
    <script src="{{ asset('site/src/js/init.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" rel="stylesheet">
    <style>
        /* Placeholder styles (optional, but recommended) */
        .lazy-placeholder {
            background-color: #f0f0f0;
            /* Light gray background */
            min-height: 50px;
            /* Minimum height for placeholders */
            /* Add other styles as needed (e.g., borders, animations) */
        }

        img.lazy-placeholder {
            min-height: 100px;
            /* Maybe a different min-height for images */
        }

        #close-map-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: var(--primary-color);
            color: #333;
            border: none;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            z-index: 1000;
            /* برای اطمینان از اینکه دکمه روی نقشه نمایش داده شود */
            border-radius: 5px;
        }

        #close-map-button:hover {
            background-color: var(--primary-color-hover);
        }
    </style>
    <style>
        /* پس‌زمینه تار برای زیبایی بیشتر */
        .modal-backdrop {
            background: rgba(0, 0, 0, 0.75);
        }

        /* افکت باز شدن پاپ‌آپ */
        .modal.fade .modal-dialog {
            transform: translateY(-50px);
            opacity: 0;
            transition: all 0.5s ease-in-out;
        }

        .modal.show .modal-dialog {
            transform: translateY(0);
            opacity: 1;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            direction: rtl;
            background: #f2f2f2;
            font-family: 'Tahoma', sans-serif;
        }

        .card-custom {
            width: 300px;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            background: #fff;
            position: relative;
        }

        .card-img-container {
            position: relative;
        }

        .card-img-top {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: block;
        }

        /* استایل روبان تخفیف */
        .discount-badge {
            position: absolute;
            top: 0;
            left: 0;
            width: 500px;
            height: 500px;
            overflow: hidden;
            pointer-events: none;
        }

        .discount-badge span {
            position: absolute;
            display: block;
            width: 154px;
            padding: 5px 0;
            background: rgba(235, 166, 7, 1);
            color: #fff;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            transform: rotate(313deg);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
            top: 30px;
            left: -35px;
        }

        .card-body {
            padding: 15px;
        }

        .card-title {
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .card-text {
            font-size: 13px;
            color: #777;
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .info-row .info-item {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #555;
        }

        .info-row .info-item i {
            margin-left: 5px;
            color: rgba(235, 166, 7, 1);
            padding: 5px;
        }

        .bottom-icons {
            display: flex;
            justify-content: space-around;
            padding-top: 10px;
        }

        .bottom-icons span {
            font-size: 14px;
            color: #555;
            display: flex;
            align-items: center;
        }

        .bottom-icons span i {
            margin-left: 5px;
            color: rgba(235, 166, 7, 1);
        }

        .discount-label {
            position: absolute;
            top: 0;
            right: 0;
            /* قرار گرفتن در سمت راست */
            width: 500px;
            height: 500px;
            overflow: hidden;
            pointer-events: none;
        }

        .discount-label span {
            position: absolute;
            display: block;
            width: 154px;
            padding: 5px 0;
            background: rgba(235, 166, 7, 1);
            color: #fff;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            transform: rotate(-313deg);
            /* تنظیم جهت چرخش */
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
            top: 30px;
            right: -35px;
            /* تنظیم موقعیت */
        }

        #show-map-button {
            width: 100%;
            height: 54px;
            /* میتونی با inspect ارتفاع دکمه جستجو رو دقیقا برداری و اینجا بذاری */
            padding: 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f0f0f0;
            background-image: url(https://tile.openstreetmap.org/0/0/0.png);
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s;
            overflow: hidden;
        }

        #show-map-button::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
        }

        #show-map-button span {
            position: relative;
            z-index: 1;
            color: #fff;
            font-size: 14px;
            font-weight: bold;
        }

        fieldset,
        legend {
            all: revert;
        }


















        .top-slider-thumbs::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: transparent;
            border-radius: 10px;
        }

        .top-slider-thumbs::-webkit-scrollbar {
            width: 6px;
            background-color: transparent;
        }


        .top-slider-thumbs::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background-color: none;
            background-image: -webkit-gradient(linear,
                    40% 0%,
                    75% 84%,
                    from(var(--primary-color)),
                    to(var(--primary-color)),
                    color-stop(.6, var(--primary-color)));
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Leaflet Marker Cluster CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

    <style>
        select:focus {
            border-top: none !important;
            /* border-color: #86b7fe; */
            box-shadow: 0 0.25rem .25rem rgba(13, 110, 253, .25) !important;
        }

        .nameInput {
            border-top-right-radius: 5px !important;
            border-bottom-right-radius: 5px !important;
        }
    </style>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .autocomplete {
            position: relative;
            /* width: 300px; */
        }

        .autocomplete input {
            width: 100%;
            padding: 10px 30px 10px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .autocomplete label {
            position: absolute;
            right: 30px;
            top: 27%;
            transition: 0.2s;
            pointer-events: none;
            color: #666;
        }

        .autocomplete input:focus+label,
        .autocomplete.filled label {
            top: 1px;
            right: 25px;
            background: white;
            padding: 0 5px;
            font-size: 0.75rem;
            color: #6c757d;
        }

        .autocomplete .clear-btn {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-weight: bold;
            color: #888;
        }

        .autocomplete .dropdown {
            padding-bottom: 50px;
            position: absolute;
            top: 100%;
            right: 0;
            left: 0;
            border: 1px solid #ccc;
            border-top: none;
            max-height: 150px;
            overflow-y: auto;
            background: white;
            z-index: 10;
        }

        .autocomplete .dropdown::-webkit-scrollbar {
            background-color: #ffffff;
            width: 6px;
        }

        .autocomplete .dropdown::-webkit-scrollbar-thumb {
            background-color: #666;
            border-radius: 10px;
            width: 6px;
        }

        .autocomplete .dropdown div {
            padding: 8px 10px;
            cursor: pointer;
        }

        .autocomplete .dropdown div:hover {
            background: #f0f0f0;
        }
    </style>

</head>

<body>

    <div class="modal fade" id="customModal" tabindex="-1" aria-labelledby="customModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content text-center">
                <div class="modal-header bg-primary text-white">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                    <h5 class="modal-title" id="customModalLabel">🎉 سورپرایز ویژه! 🎉</h5>
                </div>
                <div class="modal-body">
                    <h4>به سایت ما خوش آمدید! 🚀</h4>
                    <p>یک تجربه فوق‌العاده در انتظار شماست! همین حالا پیشنهادات ویژه ما را بررسی کنید.</p>
                    <img src="https://source.unsplash.com/600x300/?technology" class="img-fluid rounded shadow"
                        alt="تصویر تبلیغاتی">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">بستن</button>
                    <a href="#" class="btn btn-success">مشاهده پیشنهادات</a>
                </div>
            </div>
        </div>
    </div>

    @php
        // دریافت زمان حال با منطقه زمانی تنظیم شده در برنامه
        $now = \Carbon\Carbon::now();

        // دریافت تبلیغات فعال از دیتابیس
        $advs = App\Models\topadv::where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->orderBy('id', 'desc')
            ->get();
    @endphp

    @if ($advs->isNotEmpty())
        <div id="top-bar-container" style="width: 100%; position: sticky; top: 0; z-index: 2000;">
            @foreach ($advs as $adv)
                @php
                    // تبدیل تاریخ شروع و پایان به Carbon
                    $start_date_carbon = \Carbon\Carbon::parse($adv->start_date);
                    $end_date_carbon = \Carbon\Carbon::parse($adv->end_date);
                    $is_in_range = $now->isBetween($start_date_carbon, $end_date_carbon);
                @endphp

                @if ($is_in_range)
                    <div class="top-bar-item" id="top-bar-item-{{ $loop->index }}"
                        @if ($adv->page_link) onclick="handleLink('{{ $adv->page_link }}', '{{ $adv->page_link_type }}')"
                        style="cursor: pointer; display: none; min-height: var(--top-bar-height, 50px); padding-top: var(--top-bar-height, 50px); background-color: {{ $adv->background_color ?? 'var(--top-bar-color, #f0f0f0)' }};"
                    @else
                        style="display: none; min-height: var(--top-bar-height, 50px); padding-top: var(--top-bar-height, 50px); background-color: {{ $adv->background_color ?? 'var(--top-bar-color, #f0f0f0)' }};" @endif>
                        <div class="top-ad-container"
                            style="background-image: url('{{ asset($adv->background_image) }}'); background-size: cover; background-position: center; padding: 10px 20px; display: flex; justify-content: space-between; align-items: center; color: {{ $adv->text_color ?? '#333' }};">
                            <span
                                class="text {{ $adv->animation_type ? 'animate__animated ' . $adv->animation_type : '' }}">
                                <span class="mx-3">اطلاعیه!</span>
                                {{ $adv->text }}
                            </span>
                            <!-- دکمه ضربدر برای بستن تبلیغ -->
                            <button class="btn-close" onclick="event.stopPropagation(); closeTopBar()"
                                style="background: none; border: none; color: inherit; font-size: 1.5rem; cursor: pointer; opacity: 0.7; margin-left: 10px;">
                                ×
                            </button>
                        </div>
                    </div>
                @endif
            @endforeach




            <!-- نوار جایگزین (Fallback) که پس از بستن تبلیغ نمایش داده می‌شود -->
            <div id="top-bar-fallback"
                style="display: none; width: 100%; min-height: var(--top-bar-height); position: sticky; top: 0; z-index: 2000; padding-top: var(--top-bar-height); background-color: var(--top-bar-color)">
                <div class="top-ad-container-close"></div>
            </div>
        </div>

        <script>
            // تابع جهت هدایت لینک بر اساس page_link_type
            function handleLink(url, target) {
                if (target && target.trim() !== '') {
                    window.open(url, target);
                } else {
                    window.location.href = url;
                }
            }

            // تعریف یک متغیر برای نگهداری تایمر نمایش تبلیغات
            var adRotationTimeout;

            document.addEventListener('DOMContentLoaded', function() {
                var topBarContainer = document.getElementById('top-bar-container');
                var topBarItems = topBarContainer.querySelectorAll('.top-bar-item');
                var fallbackBar = document.getElementById('top-bar-fallback');
                var currentItemIndex = 0;
                var advsData = @json(
                    $advs->map(function ($adv) {
                        return ['duration' => $adv->duration];
                    }));

                function showNextAd() {
                    // اگر نوار fallback نمایش داده شده باشد، نمایش تبلیغات متوقف می‌شود
                    if (fallbackBar.style.display === 'block') return;

                    // مخفی کردن تمام تبلیغات
                    topBarItems.forEach(item => item.style.display = 'none');

                    if (currentItemIndex < topBarItems.length) {
                        topBarItems[currentItemIndex].style.display = 'block';
                        let duration = advsData[currentItemIndex]['duration'] * 1000;
                        adRotationTimeout = setTimeout(showNextAd, duration);
                        currentItemIndex++;
                    } else {
                        currentItemIndex = 0;
                        showNextAd();
                    }
                }

                if (topBarItems.length > 0) {
                    showNextAd();
                }
            });

            // تابع برای بستن تبلیغ و نمایش نوار fallback
            function closeTopBar() {
                clearTimeout(adRotationTimeout);
                var topBarItems = document.querySelectorAll('.top-bar-item');
                topBarItems.forEach(item => item.style.display = 'none');
                var fallback = document.getElementById('top-bar-fallback');
                fallback.style.display = 'block';
            }
        </script>
    @else
        <!-- در صورت عدم وجود تبلیغ فعال، نوار fallback به صورت پیش‌فرض نمایش داده می‌شود -->
        <div id="top-bar"
            style="width: 100%; min-height: var(--top-bar-height); position: sticky; top: 0; z-index: 2000; padding-top: var(--top-bar-height); background-color: var(--top-bar-color)">
            <div class="top-ad-container-close"></div>
        </div>
    @endif


    <header>
        <div class="main-menu">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand fw-bold" href="/">
                        <img src="{{ asset('site/public/img/logo-yazdskill2.png') }}" alt="website logo">
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
                        <ul class="navbar-nav mb-2 mb-lg-0 column-gap-2">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/">صفحه نخست</a>
                            </li>

                            <li class="nav-item btn-group">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    آموزشگاه ها
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @foreach ($organs as $organ)
                                        <li><a class="dropdown-item" href="#" disabled>{{ $organ->name }}</a>
                                        </li>
                                    @endforeach
                                    <li><a class="dropdown-item" href="#">آیتم 1</a></li>
                                    <li><a class="dropdown-item" href="#">آیتم 2</a></li>
                                </ul>
                            </li>

                            <li class="nav-item btn-group">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    دوره ها
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#special-offers">پیشنهاد ویژه</a></li>
                                    <li><a class="dropdown-item" href="#courses">جدیدترین ها</a></li>
                                </ul>
                            </li>

                            <li class="nav-item btn-group">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    خبر ها
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#annos">جدیدترین خبر ها</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#footer">درباره ما</a>
                            </li>
                        </ul>
                        <!--  بخشی از HTML که دکمه ها را شامل می شود.  -->
                        <div class="d-flex gap-2 align-items-stretch justify-content-center">
                            <a href="#search-bar" class="btn btn-icon">
                                <span class="bi bi-search"></span>
                            </a>
                            <a href="#" class="btn btn-icon"><span class="bi bi-basket"></span></a>
                            <div class="button-container">
                                <a href="/dashboard/login" class="btn btn-text">ورود</a>
                                <a href="/register" class="btn btn-icon btn-primary">ثبت نام</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div class="top-slider-container">
            <div class="top-slider">
                @foreach ($sliders as $slider)
                    @if ($slider->video)
                        <div class="item">
                            <div class="video h-100" id="video_slider">
                                <img src="{{ asset($slider->image) }}" id="preview-image" class="img"
                                    alt="">
                                <video id="preview-video" class="img-fluid rounded d-none" controls>
                                    <source src="{{ asset($slider->video) }}" type="video/mp4">
                                    مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.
                                </video>
                                <div class="btn-play-container" id="btn-play-container">
                                    <button class="btn-play" id="playButton">
                                        <span class="bi bi-play-fill"></span>
                                    </button>
                                </div>
                            </div>
                            {{-- @if ($slider->id != 14)
                                <div class="text-container">
                                    <span>{{ $slider->name }}</span>
                                    <a href="#" class="btn btn-primary">مشاهده جزئیات خبر</a>
                                </div>
                            @endif --}}
                        </div>
                    @else
                        <div class="item">
                            <img src="{{ asset($slider->image) }}" class="img" alt="">
                        </div>
                    @endif
                @endforeach
            </div>

            @if (count($sliders) > 1)
                <div class="container top-slider-thumbs-container">
                    <div class="top-slider-thumbs"
                        style="background-color: #111f4c;
                    @if (count($sliders) < 6) overflow:hidden; @endif
                    ">
                        <div class="title" style="background-color: #111f4c">
                            <span class="text text-bold-1" style="background-color: #111f4c">پست های ترند</span>
                            <div>
                                <button class="nav-btn prev">
                                    < </button>
                                        <span class="text-white" id="shomare">1</span>
                                        <button class="nav-btn next"> > </button>
                            </div>
                        </div>
                        @foreach ($sliders as $key => $slider)
                            <div class="item" data-index="{{ $key }}">
                                <img src="{{ asset($slider->image) }}" class="img" alt="">
                                <div>
                                    <span>{{ $slider->name }}</span>
                                    <br>
                                    <span style="font-size: 14px;color: #ffffffb2;">
                                        <svg fill="#ffffffb2" width="15px" height="15px" viewBox="0 0 24 24"
                                            id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12,6a.99974.99974,0,0,0-1,1v4H9a1,1,0,0,0,0,2h3a.99974.99974,0,0,0,1-1V7A.99974.99974,0,0,0,12,6Zm0-4A10,10,0,1,0,22,12,10.01146,10.01146,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8.00917,8.00917,0,0,1,12,20Z" />
                                        </svg>
                                        {{ $slider['time'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </header>

    <main>

        <!-- Map Container -->
        <div id="map-container" class="map-container" style="z-index: 1050;">
            <button id="close-map-button" class="close-map-button">x</button>

            <div id="map">

            </div>
        </div>

        <div id="search-bar" class="container mt-3">
            <form action="/schools" method="get" class="search-bar text-bold-2 align-content-center"
                autocomplete="false">
                @csrf
                <div class="row">
                    <style>
                        .floating-label-select {
                            height: 0 !important;
                        }
                    </style>
                    <div class="col pb-0 mb-0 px-1">
                        <div class="input-group form-label-group in-border" style="margin-bottom: 0px">
                            <input type="text" class="form-control nameInput" name="name" id="name"
                                placeholder="j" style="height: 100%;">
                            <label for="name">نام آموزشگاه</label>
                        </div>
                    </div>
                    <!-- استان -->
                    <div class="col pb-0 mb-0 px-1">


                        <div class="autocomplete" id="autocompleteBoxstate">
                            <input type="text" id="searchInputstate" oninput="filterOptions('state')"
                                onclick="showDropdown('state')">
                            <label for="searchInputstate">استان</label>
                            <span class="clear-btn" onclick="clearInput('state')">×</span>
                            <div class="dropdown" id="dropdownListstate" style="display: none;"></div>
                            <input type="hidden" name="selected_id" id="selectedId">
                        </div>



                        {{-- <div class="floating-label-select mb-4 position-relative">
                            <select id="city" name="state" class="form-select" style="width: 100%">
                                <option value="" disabled hidden></option>
                                @foreach ($citys as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == 31 ? 'selected' : '' }}>
                                        {{ $item->title }}</option>
                                @endforeach
                            </select>
                            <label class="floating-label categorySelectlable" id="cityLable"
                                for="city">استان</label>
                        </div> --}}
                    </div>
                    <div class="col pb-0 mb-0 px-1">
                        <div class="autocomplete" id="autocompleteBoxcity">
                            <input type="text" id="searchInputcity" oninput="filterOptions('city')"
                                onclick="showDropdown('city')">
                            <label for="searchInputcity">شهرستان</label>
                            <span class="clear-btn" onclick="clearInput('city')">×</span>
                            <div class="dropdown" id="dropdownListcity" style="display: none;"></div>
                            <input type="hidden" name="selected_id" id="selectedId">
                        </div>

                        {{-- <div class="floating-label-select mb-4 position-relative">
                            <select id="city" name="state" class="form-select" style="width: 100%">
                                <option value="" disabled hidden></option>
                                @foreach ($citys as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == 31 ? 'selected' : '' }}>
                                        {{ $item->title }}</option>
                                @endforeach
                            </select>
                            <label class="floating-label categorySelectlable" id="cityLable"
                                for="city">استان</label>
                        </div> --}}
                    </div>
                    {{-- <div class="col pb-0 mb-0 px-1">
                        <div class="floating-label-select mb-4 position-relative">
                            <select id="state" name="city" class="form-select" style="width: 100%">
                                <option value="" disabled></option>
                                @foreach ($states as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == 1149 ? 'selected' : '' }}>
                                        {{ $item->title }}</option>
                                @endforeach
                            </select>
                            <label class="floating-label categorySelectlable" id="stateLable"
                                for="state">شهرستان</label>
                        </div>
                    </div> --}}
                    <div class="col pb-0 mb-0 px-1">
                        <div class="floating-label-select mb-4 position-relative">
                            <select id="group" name="group" class="form-select" style="width: 100%">
                                <option value="" disabled selected hidden></option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                            <label class="floating-label categorySelectlable" id="groupLable" for="group"
                                style="background-color: transparent">رشته</label>
                        </div>
                    </div>
                    <div class="col pb-0 mb-0 px-1">
                        <div class="floating-label-select mb-4 position-relative">
                            <select id="herfe" name="herfe" class="form-select" style="width: 100%">
                                <option value="" disabled selected hidden></option>
                                @foreach ($herfes as $herfe)
                                    <option value="{{ $herfe->id }}">{{ $herfe->name }}</option>
                                @endforeach
                            </select>
                            <label class="floating-label categorySelectlable" id="herfeLable" for="herfe"
                                style="background-color: transparent">حرفه</label>
                        </div>
                    </div>
                    <div class="col pb-0 mb-0 px-1">
                        <button type="submit" class="btn btn-primary btn-sm d-block w-100 rounded-2 search-button">
                            جستجوی آموزشگاه
                        </button>
                    </div>
                    <div class="col pb-0 mb-0 px-1">
                        <a href="{{ route('map') }}" id="show-map-button"
                            class="btn btn-secondary btn-sm d-block w-100 rounded-2 map-button">
                            <span>آموزشگاه‌ها روی نقشه</span>
                        </a>
                        <input type="hidden" name="lat" id="lat">
                        <input type="hidden" name="lng" id="lng">
                    </div>
                </div>
            </form>
        </div>


        <div id="map-container"
            style="height: 500px; width: 100%; display: none; position: relative; margin-top: 15px;">
            <div id="map" style="height: 100%; width: 100%;"></div>
            <button id="close-map-button" class="leaflet-control-close-map leaflet-bar leaflet-control"
                style="position: absolute; top: 10px; right: 10px; z-index: 1000; background: white; border: 1px solid #ccc; border-radius: 4px; padding: 5px 8px; cursor: pointer; font-weight: bold;">x</button>
            <div id="selected-coordinates-container"
                style="position: absolute; bottom: 10px; left: 10px; background: rgba(255, 255, 255, 0.8); padding: 5px; border-radius: 3px; z-index: 1000; font-size: 0.8em;">
                مرکز نقشه: <span id="selected-coordinates"></span>
            </div>
            <!-- Filter boxes will be added here by JS -->
        </div>

        <style>
            /* Styles - بدون تغییر */
            .map-fullscreen {
                overflow: hidden;
            }

            #map-container {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 999;
                background-color: white;
            }

            .filter-box,
            .gender-filter-box {
                position: absolute;
                top: 50px;
                left: 10px;
                background-color: rgba(255, 255, 255, 0.95);
                padding: 10px 15px;
                border-radius: 5px;
                z-index: 1000;
                max-height: 200px;
                overflow-y: auto;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
                border: 1px solid #ccc;
                font-size: 0.9em;
            }

            .gender-filter-box {
                top: 265px;
                /* Adjust as needed */
            }

            .filter-box h4,
            .gender-filter-box h4 {
                margin-top: 0;
                margin-bottom: 10px;
                font-size: 1em;
                cursor: move;
                border-bottom: 1px solid #eee;
                padding-bottom: 5px;
            }

            .filter-box label,
            .gender-filter-box label {
                display: flex;
                align-items: center;
                margin-bottom: 5px;
                cursor: pointer;
            }

            .filter-box label input,
            .gender-filter-box label input {
                margin-left: 8px;
                /* RTL */
            }

            .filter-icon {
                margin-right: auto;
                /* RTL */
                display: inline-block;
                width: 24px;
                text-align: center;
            }

            .custom-marker i {
                vertical-align: middle;
            }

            .leaflet-control-close-map a {
                font-size: 18px;
                font-weight: bold;
                color: #333;
                text-decoration: none;
                padding: 0 6px;
                display: block;
            }

            .leaflet-control-close-map {
                background-color: white;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-shadow: 0 1px 5px rgba(0, 0, 0, 0.4);
            }

            .form-control-sm {
                font-size: 0.875rem;
            }

            .form-select-sm {
                font-size: 0.875rem;
                padding-top: 0.25rem;
                padding-bottom: 0.25rem;
            }

            .btn-sm {
                font-size: 0.875rem;
                padding: 0.25rem 0.5rem;
            }

            .noselect {
                -webkit-user-select: none;
                /* Safari */
                -moz-user-select: none;
                /* Firefox */
                -ms-user-select: none;
                /* IE/Edge */
                user-select: none;
                /* Standard syntax */
                cursor: move !important;
                /* Ensure move cursor overrides text cursor */
            }

            .province-filter-box {
                position: absolute;
                /* Adjust top position to be below other filters */
                top: 450px;
                /* Example: Adjust based on the height of the gender box */
                left: 10px;
                background-color: rgba(255, 255, 255, 0.95);
                padding: 10px 15px;
                border-radius: 5px;
                z-index: 1000;
                max-height: 200px;
                /* Or adjust as needed */
                overflow-y: auto;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
                border: 1px solid #ccc;
                font-size: 0.9em;
            }

            .province-filter-box h4 {
                margin-top: 0;
                margin-bottom: 10px;
                font-size: 1em;
                cursor: move;
                border-bottom: 1px solid #eee;
                padding-bottom: 5px;
            }

            .province-filter-box label {
                display: flex;
                align-items: center;
                margin-bottom: 5px;
                cursor: pointer;
            }

            .province-filter-box label input {
                margin-left: 8px;
                /* RTL */
            }
        </style>

        {{-- Load Leaflet ONLY --}}
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        {{-- REMOVE MarkerCluster JS and CSS includes --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


        <script>
            var map;
            var layerFilterBox;
            var genderFilterBox;
            var markers = []; // Holds all marker instances created
            var markersLayerGroup; // Simple LayerGroup to hold visible markers

            const defaultIcon = {
                class: 'bi bi-geo-alt-fill',
                color: 'blue'
            };

            // --- Function to Create Marker Instance (No change) ---
            function createMarker(position, layerName, gender, popupContent, icon) {
                const marker = L.marker(position, {
                    icon: L.divIcon({
                        className: 'custom-marker',
                        html: `<i class="${icon.class}" style="color: ${icon.color}; font-size: 24px;"></i>`,
                        iconSize: [24, 24],
                        iconAnchor: [12, 24],
                        popupAnchor: [0, -24]
                    }),
                    layer: layerName, // Store layer data on the marker itself
                    gender: gender // Store gender data on the marker itself
                });
                if (popupContent) {
                    marker.bindPopup(popupContent, {
                        maxWidth: 250
                    });
                }
                return marker;
            }

            // --- Function to Enable Dragging Filter Boxes (No change) ---
            function enableDragging(filterBoxElement) {
                let isDragging = false;
                let offsetX, offsetY;
                const header = filterBoxElement.querySelector('h4');
                const mapContainer = document.getElementById('map-container');

                if (header) {
                    header.addEventListener('mousedown', function(e) {
                        // Prevent dragging if clicking on form elements inside header (if any)
                        if (e.target.tagName === 'INPUT' || e.target.tagName === 'LABEL' || e.target.tagName ===
                            'SPAN') {
                            return;
                        }
                        e.preventDefault(); // Prevent text selection *starting* on the header itself

                        isDragging = true;
                        const boxRect = filterBoxElement.getBoundingClientRect();
                        const containerRect = mapContainer.getBoundingClientRect();
                        offsetX = e.clientX - (boxRect.left - containerRect.left);
                        offsetY = e.clientY - (boxRect.top - containerRect.top);

                        // Apply styles to prevent selection during drag
                        filterBoxElement.style.cursor = 'move';
                        document.body.classList.add('noselect'); // Apply noselect to body

                        // Attach mousemove and mouseup listeners to the document
                        // to capture mouse events even if the cursor leaves the header/box
                        document.addEventListener('mousemove', onMouseMove);
                        document.addEventListener('mouseup', onMouseUp);
                    });

                    function onMouseMove(e) {
                        if (isDragging) {
                            // e.preventDefault(); // Optional: Can sometimes help but might interfere elsewhere
                            const containerRect = mapContainer.getBoundingClientRect();
                            let newLeft = e.clientX - containerRect.left - offsetX;
                            let newTop = e.clientY - containerRect.top - offsetY;

                            // Keep the box within map container bounds
                            const boxWidth = filterBoxElement.offsetWidth;
                            const boxHeight = filterBoxElement.offsetHeight;
                            newLeft = Math.max(0, Math.min(newLeft, containerRect.width - boxWidth - 5)); // Added padding
                            newTop = Math.max(0, Math.min(newTop, containerRect.height - boxHeight - 5)); // Added padding

                            filterBoxElement.style.left = `${newLeft}px`;
                            filterBoxElement.style.top = `${newTop}px`;
                        }
                    }

                    function onMouseUp() {
                        if (isDragging) {
                            isDragging = false;

                            // Remove styles and listeners
                            filterBoxElement.style.cursor = 'default'; // Or 'grab' if you prefer
                            document.body.classList.remove('noselect'); // Remove noselect from body
                            document.removeEventListener('mousemove', onMouseMove);
                            document.removeEventListener('mouseup', onMouseUp);
                        }
                    }

                } else {
                    console.warn("Draggable header (h4) not found in filter box:", filterBoxElement);
                }
            }
            // --- Function to Apply Filters (Correct Logic for Independent Filtering) ---
            function applyFilters() {
                if (!map || !markersLayerGroup || !markers) {
                    console.log("Map, layer group, or markers not ready.");
                    return;
                }

                markersLayerGroup.clearLayers(); // Clear previous markers

                // --- Layer Filter Logic ---
                const selectedLayers = new Set();
                const layerCheckboxesSpecific = document.querySelectorAll('.layer-filter-item:not([data-layer="all"])');
                const allLayersCheckbox = document.querySelector('.layer-filter-item[data-layer="all"]');
                const allLayersChecked = allLayersCheckbox ? allLayersCheckbox.checked : false;
                let anySpecificLayerChecked = false;
                layerCheckboxesSpecific.forEach(cb => {
                    if (cb.checked) {
                        selectedLayers.add(cb.dataset.layer);
                        anySpecificLayerChecked = true;
                    }
                });
                const layerFilterActive = allLayersChecked || anySpecificLayerChecked;

                // --- Gender Filter Logic ---
                const selectedGenders = new Set();
                const genderCheckboxesSpecific = document.querySelectorAll('.gender-filter-item:not([data-gender="all"])');
                const allGendersCheckbox = document.querySelector('.gender-filter-item[data-gender="all"]');
                const allGendersChecked = allGendersCheckbox ? allGendersCheckbox.checked : false;
                let anySpecificGenderChecked = false;
                genderCheckboxesSpecific.forEach(cb => {
                    if (cb.checked) {
                        selectedGenders.add(cb.dataset.gender);
                        anySpecificGenderChecked = true;
                    }
                });
                const genderFilterActive = allGendersChecked || anySpecificGenderChecked;

                // --- Filtering and Adding Markers ---
                let visibleMarkerCount = 0;

                // If NEITHER filter has ANY selection (not even 'All'), show nothing.
                if (!layerFilterActive && !genderFilterActive) {
                    console.log("No active filters. Showing 0 markers.");
                    return; // Exit early, layer group is already cleared
                }

                markers.forEach(marker => {
                    // Evaluate Layer Match: True if filter inactive OR 'All' checked OR specific match
                    const layerMatch = !layerFilterActive || allLayersChecked || selectedLayers.has(marker.options
                        .layer);

                    // Evaluate Gender Match: True if filter inactive OR 'All' checked OR specific match
                    const genderMatch = !genderFilterActive || allGendersChecked || selectedGenders.has(marker.options
                        .gender);

                    // Add marker only if it passes BOTH effective filters
                    if (layerMatch && genderMatch) {
                        marker.addTo(markersLayerGroup);
                        visibleMarkerCount++;
                    }
                });

                console.log(`Showing ${visibleMarkerCount} markers out of ${markers.length}`);
            }


            async function initMap() {
                map = L.map('map').setView([31.88241, 54.37031], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors',
                    maxZoom: 18,
                    minZoom: 6,
                }).addTo(map);

                markersLayerGroup = L.layerGroup().addTo(map);

                // --- Sample Data (Passed from PHP) ---
                // Ensure this variable is correctly populated by your PHP code
                const sampleData = <?php echo !empty($organns) && is_array($organns) ? json_encode($organns) : '[]'; ?>;

                // --- Create Layer Filter Box ---
                layerFilterBox = L.DomUtil.create('div', 'filter-box');
                layerFilterBox.id = 'layer-filter-box';
                const uniqueLayers = [...new Set(sampleData.map(item => item.layer).filter(Boolean))];
                let layerHTML = `
                    <h4>رشته ها</h4>
                    <label>
                        <input type="checkbox" class="layer-filter-item" data-layer="all" checked>
                        <span>همه موارد</span>
                        <span class="filter-icon"><i class="${defaultIcon.class}" style="color: ${defaultIcon.color};"></i></span>
                    </label>`;
                uniqueLayers.forEach(layer => {
                    layerHTML += `
                    <label>
                        <input type="checkbox" class="layer-filter-item" data-layer="${layer}" checked>
                        <span>${layer}</span>
                        <span class="filter-icon"><i class="${defaultIcon.class}" style="color: ${defaultIcon.color};"></i></span>
                    </label>`;
                });
                layerFilterBox.innerHTML = layerHTML;
                document.getElementById('map-container').appendChild(layerFilterBox);
                enableDragging(layerFilterBox);

                // --- Create Gender Filter Box ---
                genderFilterBox = L.DomUtil.create('div', 'gender-filter-box');
                genderFilterBox.id = 'gender-filter-box';
                genderFilterBox.innerHTML = `
                    <h4>جنسیت</h4>
                    <label>
                         <input type="checkbox" class="gender-filter-item" data-gender="all" checked>
                         <span>همه جنسیت ها</span>
                     </label>
                    <label><input type="checkbox" class="gender-filter-item" data-gender="multi" checked><span>چند منظوره</span></label>
                    <label><input type="checkbox" class="gender-filter-item" data-gender="female" checked><span>خواهران</span></label>
                    <label><input type="checkbox" class="gender-filter-item" data-gender="male" checked><span>برادران</span></label>
                `;
                document.getElementById('map-container').appendChild(genderFilterBox);
                enableDragging(genderFilterBox);

                // --- Event Listeners for Filter Checkboxes (Corrected "All" Logic) ---

                // Layer Filters
                const layerCheckboxes = document.querySelectorAll('.layer-filter-item');
                const layerCheckboxesSpecific = document.querySelectorAll('.layer-filter-item:not([data-layer="all"])');
                const allLayersCheckbox = document.querySelector('.layer-filter-item[data-layer="all"]');

                if (allLayersCheckbox) {
                    layerCheckboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', function() {
                            const isTheAllCheckbox = this === allLayersCheckbox;
                            const isChecked = this.checked;

                            if (isTheAllCheckbox) {
                                // User clicked the "All" checkbox
                                layerCheckboxesSpecific.forEach(cb => {
                                    cb.checked = isChecked;
                                });
                            } else {
                                // User clicked a SPECIFIC checkbox
                                if (isChecked) {
                                    // Check if ALL specific checkboxes are now checked
                                    const allSpecificAreChecked = Array.from(layerCheckboxesSpecific).every(
                                        cb => cb.checked);
                                    allLayersCheckbox.checked = allSpecificAreChecked;
                                } else {
                                    // If a specific checkbox is unchecked, "All" MUST be unchecked
                                    allLayersCheckbox.checked = false;
                                }
                            }
                            applyFilters(); // Call applyFilters after any state change
                        });
                    });
                } else {
                    console.error("Could not find the 'All Layers' checkbox.");
                    // Fallback: Add listeners only to specific checkboxes if 'All' is missing
                    layerCheckboxesSpecific.forEach(checkbox => {
                        checkbox.addEventListener('change', applyFilters);
                    });
                }

                // Gender Filters
                const genderCheckboxes = document.querySelectorAll('.gender-filter-item');
                const genderCheckboxesSpecific = document.querySelectorAll('.gender-filter-item:not([data-gender="all"])');
                const allGendersCheckbox = document.querySelector('.gender-filter-item[data-gender="all"]');

                if (allGendersCheckbox) {
                    genderCheckboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', function() {
                            const isTheAllCheckbox = this === allGendersCheckbox;
                            const isChecked = this.checked;

                            if (isTheAllCheckbox) {
                                // User clicked "All Genders"
                                genderCheckboxesSpecific.forEach(cb => {
                                    cb.checked = isChecked;
                                });
                            } else {
                                // User clicked a specific gender
                                if (isChecked) {
                                    const allSpecificAreChecked = Array.from(genderCheckboxesSpecific)
                                        .every(cb => cb.checked);
                                    allGendersCheckbox.checked = allSpecificAreChecked;
                                } else {
                                    // If a specific checkbox is unchecked, "All" MUST be unchecked
                                    allGendersCheckbox.checked = false;
                                }
                            }
                            applyFilters(); // Call applyFilters after any state change
                        });
                    });
                } else {
                    console.error("Could not find the 'All Genders' checkbox.");
                    // Fallback: Add listeners only to specific checkboxes if 'All' is missing
                    genderCheckboxesSpecific.forEach(checkbox => {
                        checkbox.addEventListener('change', applyFilters);
                    });
                }

                // --- Map Movement Listener (No change) ---
                map.on('moveend', function() {
                    var center = map.getCenter();
                    const coordinatesElement = document.getElementById('selected-coordinates');
                    const latInput = document.getElementById('lat');
                    const lngInput = document.getElementById('lng');
                    if (coordinatesElement) {
                        coordinatesElement.textContent = center.lat.toFixed(5) + ', ' + center.lng.toFixed(5);
                    }
                    if (latInput) latInput.value = center.lat;
                    if (lngInput) lngInput.value = center.lng;
                });

                setInitialCoordinates(map.getCenter().lat, map.getCenter().lng);

                // --- Fetch Data and Create Markers (Initial Call) ---
                // Called after map and filters are initialized
                fetchDataAndCreateMarkers();

            } // End of initMap


            // --- Fetch Data and Create Markers (No change in creation logic) ---
            function fetchDataAndCreateMarkers() {
                markers = []; // Clear markers array
                if (!markersLayerGroup) {
                    console.error("Markers layer group not initialized");
                    return;
                }
                markersLayerGroup.clearLayers(); // Clear the group too

                // Use the globally defined sampleData (make sure it's available from PHP)
                const sampleData = <?php echo !empty($organns) && is_array($organns) ? json_encode($organns) : '[]'; ?>;

                try {
                    if (!Array.isArray(sampleData)) {
                        console.error("Sample data is not an array:", sampleData);
                        return;
                    }

                    sampleData.forEach(item => {
                        const lat = parseFloat(item.latitude);
                        const lng = parseFloat(item.longitude);
                        const name = item.name || "بدون نام";
                        const layer = item.layer;
                        const gender = item.gender;
                        const address = item.address;

                        if (!isNaN(lat) && !isNaN(lng) && layer && gender) {
                            const popupContent = `<b>${name}</b><br>${address || ''}`;
                            const icon = defaultIcon;
                            const marker = createMarker({
                                lat: lat,
                                lng: lng
                            }, layer, gender, popupContent, icon);
                            markers.push(marker); // Add to the main markers array
                        } else {
                            console.warn("Skipping item due to invalid/missing data (lat, lng, layer, or gender):",
                                item);
                        }
                    });

                    console.log("Total markers created:", markers.length);
                    // Apply filters AFTER all markers are created to show the initial state
                    // This uses the default 'checked' state of the HTML checkboxes
                    applyFilters();

                } catch (error) {
                    console.error("Error processing data or creating markers:", error);
                }
            }

            // --- Set Initial Coordinates Display (No change) ---
            function setInitialCoordinates(lat, lng) {
                const latInput = document.getElementById('lat');
                const lngInput = document.getElementById('lng');
                const coordinatesElement = document.getElementById('selected-coordinates');
                if (latInput) latInput.value = lat;
                if (lngInput) lngInput.value = lng;
                if (coordinatesElement) {
                    coordinatesElement.textContent = lat.toFixed(5) + ', ' + lng.toFixed(5);
                }
            }

            // --- Main Initialization Logic (No change) ---
            async function myInit() {
                const showMapButton = document.getElementById('show-map-button');
                const closeMapButton = document.getElementById('close-map-button');
                const mapContainer = document.getElementById('map-container');

                if (!showMapButton || !closeMapButton || !mapContainer) {
                    console.error("Essential map control elements not found.");
                    return;
                }

                showMapButton.addEventListener('click', async function(event) {
                    // event.preventDefault();
                    // if (mapContainer.style.display === 'none' || mapContainer.style.display === '') {
                    //     mapContainer.style.display = 'block';
                    //     document.body.classList.add('map-fullscreen');
                    //     if (!map) {
                    //         // Initialize map, filters, and markers ONCE
                    //         await initMap
                    //     (); // initMap now handles creating filters and calling fetchDataAndCreateMarkers
                    //     } else {
                    //         // Map already exists, just resize and re-apply filters
                    //         map.invalidateSize();
                    //         applyFilters();
                    //     }
                    //     const currentCenter = map.getCenter();
                    //     setInitialCoordinates(currentCenter.lat, currentCenter.lng);
                    // }
                });
                closeMapButton.addEventListener('click', function() {
                    mapContainer.style.display = 'none';
                    document.body.classList.remove('map-fullscreen');
                });
            }

            // --- DOM Ready Check (No change) ---
            if (document.readyState === "loading") {
                document.addEventListener("DOMContentLoaded", myInit);
            } else {
                myInit(); // Already loaded
            }
        </script>
        <div class="container">
            <div id="events-slider" class="splide">
                <div class="section-title-container">
                    <div class="section-title">
                        <img src="{{ asset('site/public/icon/vertical-line.svg') }}" aria-hidden="true"
                            class="vertical-line" alt="">
                        <span class="title">آگهی های ویژه</span>
                    </div>

                    <div class="section-options" style="margin-inline-end: -6px;">
                        <button class="nav-btn prev">
                            < </button>
                                <button class="nav-btn next"> > </button>
                    </div>
                </div>

                <div class="splide__track fix-shadow-margin">
                    <ul class="splide__list">
                        @foreach ($organs as $organ)
                            <li class="splide__slide">
                                <div class="event-card">
                                    <div class="img">
                                        @if (is_null($organ->file_logo))
                                            <img src="{{ asset('site/public/icon/vertical-line.svg') }}"
                                                alt="event image">
                                        @else
                                            <img src="{{ asset($organ->file_logo) }}" alt="event image">
                                        @endif
                                        <div class="discount-badge"><span>10% تخفیف</span></div>
                                    </div>

                                    <div class="details">
                                        <div class="top">
                                            <div class="d-flex align-items-center gap-1">
                                                <span class="bi bi-grid text-primary"></span>
                                                <span class="text-small-1">{{ $organ->ostan->title }}</span>
                                            </div>

                                            <div class="d-flex align-items-center gap-1">
                                                <span class="text-small-1">{{ $organ->tel }}</span>
                                                <span class="bi bi-telephone text-primary"></span>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <h3 class="text-title-3">{{ $organ->name }}</h3>
                                            <p class="text-justify text-normal">بهترین دوره‌های آموزشی برای ارتقاء
                                                مهارت‌های
                                                شما. </p>
                                        </div>
                                        <hr>
                                        <div class="bottom-icons">
                                            <span><i class="bi bi-eye"></i> 1.2k</span>
                                            <span><i class="bi bi-heart"></i> 250</span>
                                            <span><i class="bi bi-clock"></i> {{ $organ['time'] }}</span>
                                        </div>
                                    </div>
                                </div>

                            </li>
                        @endforeach
                    </ul>
                </div>

                <ul class="splide__pagination position-static mt-3 mb-2"></ul>
            </div>

            <div id="invite-instagram" class="mt-5">
                <div class="row m-0"
                    style="background: linear-gradient(270deg, #EE295F 0%, #9033C2 100%);
                 border-radius: var(--raduis); height: 80px;
                 align-items: center">
                    <div class="col-2">
                        <!-- empty for image place -->
                    </div>

                    <div class="col-8">
                        <p class="text-white text-center mb-0 text-bold-3">کلی مطلب آموزشی جالب در اینستاگرام کانون
                            منتظر
                            شماست!!!</p>
                    </div>

                    <div class="col-2">
                        <a class="btn btn-light w-100 text-blue" href="#">اینجا کلیک کنید</a>
                    </div>
                </div>

                <img src="{{ asset('site/public/img/invite-instagram.png') }}" alt=""
                    style="height: 160px; margin-top: -120px">
            </div>

            <div id="annos">
                <div class="section-title-container">
                    <div class="section-title">
                        <img src="{{ asset('site/public/icon/vertical-line.svg') }}" aria-hidden="true"
                            class="vertical-line" alt="">
                        <span class="title">جدیدترین آگهی‌ها</span>
                    </div>

                    <div class="section-options">
                        <span class="text-bold-2 text-title-3">داغ ترین ها</span>

                        <label class="switch">
                            <input type="checkbox" name="hot-annos" id="hot-annos">
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>

                <div class="row row-gap-3" id="hot-annos-list">
                    <!-- آگهی‌ها به صورت داینامیک بارگذاری خواهند شد -->
                </div>

                <div class="mt-4" style="text-align: end">
                    <a href="#" class="btn btn-primary">
                        <span>مشاهده بیشتر</span>
                        <span class="bi bi-arrow-left pe-2"></span>
                    </a>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function() {
                    // Function to fetch and display advertisements
                    function fetchAnnos(hot = 0) {
                        $.ajax({
                            url: '/', // Your route (should be fine as is)
                            method: 'GET',
                            data: {
                                hot: hot
                            },
                            success: function(response) {
                                let html = '';
                                response.forEach(item => {
                                    html += `
                            <div class="col-md-6">
                                <div class="row anno-card">
                                    <div class="col-6 details">


                                        <p class="text-title-3 text-bold-2 text-blue">${item.title}</p>
                                        <p>${item.text}</p>

                                        <div class="flex-center-between-space">
                                            <div class="d-flex align-items-center gap-1">
                                                <span class="bi bi-grid text-primary"></span>
                                                <span class="text-small-1">{{ $organ->ostan->title }}</span>
                                            </div>

                                            <div class="d-flex align-items-center gap-1">
                                                <span class="text-small-1">${item.tel}</span>
                                                <span class="bi bi-telephone text-primary"></span>
                                            </div>
                                        </div>
                                        <hr>
                                            <div class="bottom-icons">
                                                <span><i class="bi bi-eye"></i> 1.2k</span>
                                                <span><i class="bi bi-heart"></i> 250</span>
                                                <span><i class="bi bi-clock"></i> {{ $organ['time'] }}</span>
                                            </div>
                                    </div>

                                    <div class="col-6 img">
                                        <img src="${item.image}" alt="${item.title}" class="w-100 h-100">
                                    </div>
                                </div>
                            </div>
                        `;
                                });
                                $('#hot-annos-list').html(html);
                            },
                            error: function() {
                                alert('An error occurred!');
                            }
                        });
                    }

                    // Initial load
                    fetchAnnos(0);

                    // On checkbox change
                    $('#hot-annos').on('change', function() {
                        let isChecked = $(this).is(':checked');
                        fetchAnnos(isChecked ? 1 : 0);
                    });
                });
            </script>

        </div>

        <div class="container-fluid p-0 mt-5" id="full-width-video">
            <div class="video" style="height: 70vh">
                <img src="{{ asset('site/public/img/1.png') }}" class="img" alt="">
                <div class="btn-play-container">
                    <button class="btn-play pulse" onclick="openVideoPopup('/public/vid/1.mp4')">
                        <span class="bi bi-play-fill"></span>
                    </button>
                </div>
            </div>
        </div>

        <div class="container mb-5">
            <div id="advantages" class="mt-5">
                <div class="section-title-container">
                    <div class="section-title">
                        <img src="{{ asset('site/public/icon/vertical-line.svg') }}" aria-hidden="true"
                            class="vertical-line" alt="">
                        <span class="title">{{ $content_title->title }}</span>
                    </div>

                    <div class="section-options">
                    </div>
                </div>

                <div class="row row-gap-4 mx-0 fix-shadow-margin"
                    style="margin-left: -10px !important; margin-right: -10px !important">
                    @foreach ($contents as $content)
                        <div class="col-md-4">
                            <div class="advantage-card">
                                <p class="title text-title-3 text-bold-2">{{ $content['title'] }}</p>
                                <p class="text mb-0 text-normal">{{ $content['text'] }}</p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <div id="special-offers" class="splide mt-5">
                <div class="section-title-container">
                    <div class="section-title">
                        <img src="{{ asset('site/public/icon/vertical-line.svg') }}" aria-hidden="true"
                            class="vertical-line" alt="">
                        <span class="title">پیشنهاد ویژه (دوره های آموزشی)</span>
                    </div>
                    <div class="section-options">
                    </div>
                </div>
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($courses as $course)
                            <li class="splide__slide">
                                <a href="{{ route('course', ['id' => $course->id]) }}" class="text-reset">
                                    <div class="row offer-card m-0">

                                        <div class="col-5 p-3 text-center">
                                            <div class="discount-label"><span>{{ $course->off }}% تخفیف</span></div>
                                            <!-- تغییر نام کلاس -->

                                            <p class="title text-title-2 text-bold-2">دوره آموزشی {{ $course->name }}
                                            </p>

                                            <p class="text mb-0">{{ $course->description }}</p>

                                            {{-- نمایش گروه و حرفه --}}
                                            <p class="text mt-2">
                                                <strong>گروه:</strong> {{ $course->group->name ?? 'نامشخص' }}
                                            </p>
                                            <p class="text">
                                                <strong>حرفه:</strong> {{ $course->herfe->name ?? 'نامشخص' }}
                                            </p>

                                            <p class="text">
                                                <strong>مدت زمان :</strong>
                                                {{ $course->herfe->total_time ?? 'نامشخص' }}
                                            </p>
                                            <p class="text">
                                                <strong>شهریه حضوری :</strong> {{ $course['PriceIn'] ?? 'نامشخص' }}
                                            </p>
                                            <p class="text">
                                                <strong>شهریه مجازی :</strong> {{ $course['PriceOnline'] ?? 'نامشخص' }}
                                            </p>

                                            <div class="row m-0 mt-4 px-4" dir="ltr">
                                                {{-- تایمر شمارش معکوس --}}
                                                <div class="countdown-timer" id="countdown-{{ $course->id }}"
                                                    data-end-date="{{ $course->date->toIso8601String() }}">
                                                    <div class="timer-col">
                                                        <span class="timer-number days"></span>
                                                        <span class="timer-text">روز</span>
                                                    </div>
                                                    <div class="timer-col">
                                                        <span class="timer-number hours"></span>
                                                        <span class="timer-text">ساعت</span>
                                                    </div>
                                                    <div class="timer-col">
                                                        <span class="timer-number minutes"></span>
                                                        <span class="timer-text">دقیقه</span>
                                                    </div>
                                                    <div class="timer-col">
                                                        <span class="timer-number seconds"></span>
                                                        <span class="timer-text">ثانیه</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-7 p-0 position-relative">
                                            <img src="{{ asset($course->image) }}" class="w-100 h-100"
                                                alt="{{ $course->name }}" style="max-height:420px">

                                            <span class="school-name text-title-2 text-bold-2">آموزشکده
                                                @if ($course->organ_id)
                                                    {{ $course->organ?->name ?? '' }}
                                                @endif
                                            </span>

                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </div>
                <ul class="splide__pagination position-static mt-3 mb-2"></ul>
            </div>


            <div id="invite-newsletter" class="mt-5">
                <form action="#" method="post">
                    <div class="row m-0"
                        style="background: linear-gradient(270deg, #3376C4 0%, #2AC3EF 100%);
                     border-radius: var(--raduis); min-height: 80px;
                     align-items: center">
                        <div class="col-3">
                            <p class="mb-0 text-white text-title-2 text-bold-2">خبرنامه پیامکی</p>
                            <p class="mb-0 text-white-50 text-title-3">تاکنون 1926 نفر عضو شده اند.</p>
                        </div>

                        <div class="col-2">
                            <button type="submit" class="btn btn-primary w-100 text-bold-2" href="#"
                                style="padding: 20px">
                                درخواست عضویت
                            </button>
                        </div>

                        <div class="col-5">
                            <input type="text" name="mobile" id="mobile-for-newsletter"
                                class="text-title-3 text-bold-2" placeholder="شماره تماس خود را وارد کنید"
                                style="
                               background: none;
                               border: 2px solid white;
                               border-radius: 20px;
                               width: 100%;
                               padding: 20px;
                               color: white;
                               margin-top: 8px;
                               margin-bottom: 8px;
                        ">
                        </div>

                        <style>
                            #mobile-for-newsletter::placeholder {
                                color: white;
                                opacity: 1;
                                /* Firefox */
                            }

                            #mobile-for-newsletter ::-ms-input-placeholder {
                                /* Edge 12 -18 */
                                color: white;
                            }
                        </style>

                        <div class="col-2">
                            <!-- empty for image place -->
                        </div>
                    </div>
                </form>

                <div style="text-align: end">
                    <img src="{{ asset('site/public/img/invite-newsletter.png') }}" alt=""
                        style="height: 160px; margin-top: -130px; transform: scale(1.2)">
                </div>
            </div>

            <div id="courses">
                <div class="section-title-container">
                    <div class="section-title">
                        <img src="{{ asset('site/public/icon/vertical-line.svg') }}" aria-hidden="true"
                            class="vertical-line" alt="">
                        <span class="title">جدیدترین دوره های آموزشی</span>
                    </div>
                    <div class="section-options">
                    </div>
                </div>

                <div class="row row-gap-3">
                    @foreach ($newCourses as $item)
                        <div class="col-md-6 mt-3">
                            <div class="row course-card m-0">
                                <div class="col-4 p-0 img">
                                    <img src="{{ asset($item->image) }}" alt="" class="w-100 h-100">
                                </div>

                                <div class="col-8 d-flex details gap-3">
                                    <div>
                                        <p class="mb-0 text-title-2 text-bold-3 text-blue">{{ $item->name }}</p>
                                        <p class="mb-0">{{ $item->description }}</p>
                                        <p class="text-start mb-0 mt-2">{{ number_format($item->price / 10) }} تومان
                                        </p>

                                    </div>
                                    <div
                                        class="d-flex flex-column gap-2 align-items-center justify-content-center me-5">
                                        {{-- <a href="#" class="btn btn-icon"><span class="bi bi-floppy"></span></a> --}}
                                        <a href="{{ route('course', ['id' => $item->id]) }}"
                                            class="btn btn-icon"><span class="bi bi-eye"></span></a>
                                        {{-- <a href="#" class="btn btn-icon"><span class="bi bi-cart-plus"></span></a> --}}

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4" style="text-align: end">
                    <a href="/courses" class="btn btn-primary">
                        <span>مشاهده بیشتر</span>
                        <span class="bi bi-arrow-left pe-2"></span>
                    </a>
                </div>
            </div>
        </div>
    </main>

    <footer id="footer">
        <div class="crd crd-shadow" style="border-bottom-left-radius: 0; border-bottom-right-radius: 0">
            <div class="container px-0">
                <div class="row align-items-stretch mx-0 gx-5 py-3 fix-shadow-margin">
                    <div class="col-md-4 p-3 align-content-center">
                        <div class="crd crd-shadow crd-pad">
                            {{-- <p class="text-title-2 text-bold-2 text-blue">لوگو کانون آموزش</p> --}}
                            <img src="{{ asset('site/public/img/logo-yazdskill2.png') }}" alt="website logo">
                            <p class="mt-2">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و
                                با استفاده از طراحان
                                گرافیک
                                است.</p>
                            {{-- <div class="text-end">
                                <a href="#" class="btn btn-text">
                                    <span class="text-bold-3">مشاهده بیشتر</span>
                                    <span class="bi bi-arrow-left pe-2 text-bold-2"></span>
                                </a>
                            </div> --}}

                            <hr style="background-color: black; height: 2px; opacity: 1; margin: 20px 0">

                            <div class="row mt-2">
                                <div class="col">
                                    <a href="/schools" class="btn btn-text w-100 text-bold-2">اموزشگاه ها</a>
                                </div>
                                <div class="col">
                                    <a href="/register" class="btn btn-text w-100 text-bold-2">جذب مدرس</a>
                                </div>
                                <div class="col">
                                    <a href="#" class="btn btn-text w-100 text-bold-2">شهریه مصوب</a>
                                </div>
                                <div class="col">
                                    <a href="#" class="btn btn-text w-100 text-bold-2">درباره ما</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 align-content-center">
                        <div>
                            <div class="flex-center-between-space">
                                <span class="text-bold-2">به مشاوره نیاز دارید؟</span>
                                <a href="tel:03536284224" dir="ltr" class="btn btn-text text-bold-2">
                                    <span class="bi bi-telephone"></span>
                                    03536284224
                                </a>
                            </div>

                            <hr style="background-color: black; height: 2px; opacity: 1; margin: 20px 0">

                            <span class="text-bold-2 mt-3">
                                <span class="bi bi-geo-alt"></span>
                                خیابان کاشانی
                            </span>

                            <br>

                            <span class="text-bold-2">
                                <span class="bi bi-envelope"></span>
                                aaa@bbb.ccc
                            </span>

                            {{-- <div class="row mt-3">
                                <div class="col">
                                    <a href="#" class="btn btn-primary w-100 text-bold-2">ارسال تیکت</a>
                                </div>
                                <div class="col">
                                    <a href="#" class="btn btn-primary w-100 text-bold-2">عضویت در خبرنامه</a>
                                </div>
                            </div> --}}
                        </div>
                    </div>

                    <div class="col-md-4 p-3 align-content-center">
                        <div>
                            <p class="text-bold-2">نماد های اعتماد</p>

                            <div class="row m-0 gap-3">
                                <div class="col crd crd-shadow crd-pad">
                                    <a href="#">
                                        <img src="{{ asset('site/public/img/enamad.png') }}" alt=""
                                            class="w-100">
                                    </a>
                                </div>

                                <div class="col crd crd-shadow crd-pad">
                                    <a href="#">
                                        <img src="{{ asset('site/public/img/enamad.png') }}" alt=""
                                            class="w-100">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-blue">
            <div class="container flex-center-between-space py-3">
                <span class="text-white">تمامی حقوق محفوظ میباشد.</span>

                <div class="d-flex gap-2 align-items-center justify-content-center">
                    <a href="#" class="btn btn-icon"><span class="bi bi-whatsapp"></span></a>
                    <a href="#" class="btn btn-icon"><span class="bi bi-telegram"></span></a>
                    <a href="#" class="btn btn-icon"><span class="bi bi-instagram"></span></a>
                </div>
            </div>
        </div>
    </footer>

    <!--region: support button -->
    <a href="#" id="btn-support">
        <img src="{{ asset('site/public/img/1.png') }}" alt="contact support">
    </a>
    <!--endregion: support button -->

    <!--region: go to top button -->
    <a href="#" id="btn-go-to-top">
        <svg width="40" height="40" viewBox="0 0 131 131" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle class="outer_circle" cx="65.5" cy="65.5" r="64" stroke="red"></circle>
        </svg>

        <span class="bi bi-arrow-up"></span>
    </a>
    <!--endregion: go to top button -->

    <!--region: news button -->
    <svg width="0" height="0">
        <defs>
            <clipPath id="roundedClip">
                <!--
              شکل اصلی ما از نقاط زیر تشکیل می‌شد (بر اساس ابعاد 31px × 118px):
                A: (0,24)   - بالا-چپ
                B: (31,0)   - بالا-راست
                C: (31,118) - پایین-راست
                D: (0,94)   - پایین-چپ
              برای گرد کردن گوشه‌ها با شعاع 8px، نقاط به صورت زیر تغییر می‌کنند:
                برای گوشه بالا-چپ:
                  - نقطه روی لبه عمودی: A1 = (0,32)
                  - نقطه روی لبه مورب: A2 ≈ (6.32,19.12)
                برای گوشه بالا-راست:
                  - نقطه روی لبه مورب: B2 ≈ (24.68,4.88)
                  - نقطه روی لبه عمودی: B1 = (31,8)
                برای گوشه پایین-راست:
                  - نقطه روی لبه عمودی: C1 = (31,110)
                  - نقطه روی لبه مورب: C2 ≈ (24.68,113.12)
                برای گوشه پایین-چپ:
                  - نقطه روی لبه عمودی: D1 = (0,86)
                  - نقطه روی لبه مورب: D2 ≈ (6.32,98.88)
              مسیر از نقطه A2 شروع شده، به ترتیب به B2، سپس با arc به B1، خط مستقیم تا C1،
              با arc به C2، خط تا D1، با arc به D2، خط تا A1 و در نهایت با arc به A2 بسته می‌شود.
            -->
                <path d="M 6.32 19.12
                     L 24.68 4.88
                     A 8 8 0 0 1 31 8
                     L 31 110
                     A 8 8 0 0 1 24.68 113.12
                     L 0 86
                     A 8 8 0 0 1 6.32 98.88
                     L 0 32
                     A 8 8 0 0 1 6.32 19.12
                     Z" />
            </clipPath>
        </defs>
    </svg>
    <a href="#" id="btn-news" class="btn-news">

        <span>اخبار</span>
    </a>



    <style>
        .khabar-container {
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
            margin-bottom: 20px;
            padding: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .khabar-item {
            display: flex;
            gap: 15px;
        }

        .khabar-image-main img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
        }

        .khabar-content {
            flex: 1;
        }

        .khabar-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .khabar-text {
            font-size: 14px;
            color: #555;
        }

        .khabar-images-small {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .khabar-image-small img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .khabar-media-small {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .khabar-media-item {
            width: 60px;
            height: 60px;
            border-radius: 5px;
            border: 1px solid #ddd;
            overflow: hidden;
        }

        .khabar-media-item img,
        .khabar-media-item video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>

    <div class="overlay-container">

        <div class="svg-container">
            <svg width="100%" height="100%" id="svg" viewBox="0 0 1440 690"
                xmlns="http://www.w3.org/2000/svg">
                <path d="" stroke="none" stroke-width="0" fill="var(--overlay-1-back-color)" fill-opacity="1"
                    class="path" transform="rotate(-180 720 350)"
                    style="animation: 1s ease 0ms 1 normal both running pathAnim;">
                </path>
            </svg>
        </div>

        <div class="svg-container">
            <svg width="100%" height="100%" id="svg" viewBox="0 0 1440 690"
                xmlns="http://www.w3.org/2000/svg">
                <path d="" stroke="none" stroke-width="0" fill="var(--overlay-2-back-color)" fill-opacity="1"
                    class="path" transform="rotate(-180 720 350)"
                    style="animation: 1s ease 300ms 1 normal both running pathAnim;">
                </path>
            </svg>
        </div>

        <div class="svg-container">
            <svg width="100%" height="100%" id="svg" viewBox="0 0 1440 690"
                xmlns="http://www.w3.org/2000/svg">
                <path d="" stroke="none" stroke-width="0" fill="var(--overlay-3-back-color)" fill-opacity="1"
                    class="path" transform="rotate(-180 720 350)"
                    style="animation: 1s ease 700ms 1 normal both running pathAnim;">
                </path>
            </svg>
        </div>

        <div class="items-panel">
            <button class="btn btn-close" id="close-panel"></button>

            <br>
            <div class="news-list">
                @foreach ($news as $item)
                    <div class="khabar-container">
                        <div class="khabar-item">
                            @php
                                $media = json_decode($item->media, true) ?? [];
                                $firstImage = $media[0] ?? null;
                                $otherImages = array_slice($media, 1);
                            @endphp

                            <div class="khabar-image-main">
                                <a href="/{{ $item->cover ? $item->cover : $item->images()->first()->image_path }}"><img
                                        src="{{ asset($item->cover ? $item->cover : $item->images()->first()->image_path) }}"
                                        alt="تصویر خبر {{ $item->title }}"></a>
                            </div>
                            <div class="khabar-content">
                                <h2 class="khabar-title">{{ $item->title }}</h2>
                                <style>
                                    .khabar-text-box {
                                        border-radius: 8px;
                                        padding: 10px;
                                        overflow-wrap: break-word;
                                        max-width: 100%;
                                        word-break: break-word;
                                    }

                                    .khabar-text-box .full-text,
                                    .khabar-text-box .short-text {
                                        white-space: pre-wrap;
                                        overflow-wrap: break-word;
                                    }

                                    .khabar-actions {
                                        margin-top: 10px;
                                    }

                                    .khabar-actions .btn {
                                        margin-top: 5px;
                                        padding: 8px 15px;
                                        font-size: 14px;
                                        transition: background-color 0.3s ease;
                                    }

                                    .khabar-actions .btn:hover {
                                        background-color: #007bff;
                                        color: #fff;
                                    }

                                    .khabar-meta {
                                        display: flex;
                                        justify-content: space-between;
                                        margin-top: 10px;
                                        font-size: 14px;
                                        color: #6c757d;
                                    }

                                    .khabar-meta i {
                                        margin-right: 5px;
                                    }

                                    .copy-notification {
                                        position: fixed;
                                        top: 10px;
                                        right: 20px;
                                        background-color: #28a745;
                                        color: #fff;
                                        padding: 10px;
                                        border-radius: 5px;
                                        font-size: 14px;
                                        opacity: 0;
                                        transition: opacity 0.5s ease-in-out;
                                    }

                                    .copy-notification.show {
                                        opacity: 1;
                                    }

                                    .copy-notification span {
                                        font-weight: bold;
                                    }
                                </style>
                                @php
                                    $plainText = strip_tags($item->text);
                                    $words = explode(' ', $plainText);
                                    $shortText = implode(' ', array_slice($words, 0, 20));
                                    $publishDate = \Morilog\Jalali\Jalalian::fromDateTime($item->publish_at)->format(
                                        'H:i Y/m/d',
                                    );
                                    $shortUrl = route('home'); // Assuming a route to view the post
                                @endphp

                                <div class="khabar-text-box" id="khabar-{{ $item->id }}">
                                    <div class="short-text">{{ $item->short ?? $shortText }}...</div>
                                    <div class="full-text d-none">
                                        <div class="">
                                            {!! $item->text !!}
                                        </div>
                                        <div class="row border">
                                            @if (isset($item->media))
                                                <video width="100%" controls>
                                                    <source src="{{ asset($item->media) }}" type="video/mp4">
                                                    مرورگر شما از ویدیو پشتیبانی نمی‌کند.
                                                </video>
                                            @endif

                                            @foreach ($item->images as $images)
                                                <div class="col-md-4">
                                                    <a href="/{{ $images->image_path }}"><img
                                                            src="{{ asset($images->image_path) }}"
                                                            alt="تصویر خبر {{ $item->title }}" class="w-100"></a>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                    <a href="javascript:void(0);" class="toggle-btn text-primary"
                                        onclick="toggleText({{ $item->id }}, this)">بیشتر بخوانید</a>

                                    <div class="khabar-meta">
                                        <span class="views"><i class="bi bi-eye"></i> {{ $item->views_count }}
                                            بازدید</span>
                                        <span class="date"><i class="bi bi-clock"></i> {{ $publishDate }}</span>
                                    </div>

                                    <div class="khabar-actions">
                                        <button class="btn btn-outline-primary btn-sm"
                                            onclick="copyLink('{{ $shortUrl }}', {{ $item->id }})">
                                            <i class="bi bi-link"></i> کپی لینک
                                        </button>
                                    </div>

                                    <div class="copy-notification" id="copy-notification-{{ $item->id }}">
                                        <span>لینک کپی شد!</span>
                                    </div>
                                </div>
                                <script>
                                    function toggleText(id, btn) {
                                        const container = document.getElementById(`khabar-${id}`);
                                        const shortText = container.querySelector('.short-text');
                                        const fullText = container.querySelector('.full-text');

                                        const showingFull = !fullText.classList.contains('d-none');

                                        if (showingFull) {
                                            fullText.classList.add('d-none');
                                            shortText.classList.remove('d-none');
                                            btn.innerText = 'بیشتر بخوانید';
                                        } else {
                                            fullText.classList.remove('d-none');
                                            shortText.classList.add('d-none');
                                            btn.innerText = 'بستن';
                                        }
                                    }

                                    function copyLink(link, id) {
                                        // Create a temporary input element to copy the link to clipboard
                                        const tempInput = document.createElement('input');
                                        tempInput.value = link;
                                        document.body.appendChild(tempInput);
                                        tempInput.select();
                                        document.execCommand('copy');
                                        document.body.removeChild(tempInput);

                                        // Show the notification that the link is copied
                                        const notification = document.getElementById('copy-notification-' + id);
                                        notification.classList.add('show');

                                        // Hide the notification after 2 seconds
                                        setTimeout(() => {
                                            notification.classList.remove('show');
                                        }, 2000);
                                    }
                                </script>


                            </div>
                        </div>
                        @if (count($otherImages) > 0)
                            <div class="khabar-media-small">
                                @foreach ($otherImages as $mediaItem)
                                    <div class="khabar-media-item">
                                        @php
                                            $extension = pathinfo($mediaItem, PATHINFO_EXTENSION);
                                        @endphp

                                        @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                            <a href="/{{ $mediaItem }}"><img src="{{ asset($mediaItem) }}"
                                                    alt="تصویر خبر"></a>
                                        @elseif(in_array(strtolower($extension), ['mp4', 'webm', 'ogg']))
                                            <video controls>
                                                <source src="{{ asset($mediaItem) }}"
                                                    type="video/{{ $extension }}">
                                                مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.
                                            </video>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif


                    </div>
                @endforeach
            </div>
            <center>
                <a href="/" class="btn btn-archive ">مشاهده آرشیو</a>
            </center>

        </div>
        <script>
            $(document).ready(function() {
                $("#close-panel").click(function() {
                    // $(".items-panel").hide(); // Or use fadeOut(), slideUp(), etc.
                    // Optionally also hide the overlay container:
                    //$(".overlay-container").hide();
                });
            });
        </script>

    </div>
    <script>
        $(document).ready(function() {
            function updateCountdown() {
                $('.countdown-timer').each(function() { // برای هر تایمر شمارش معکوس
                    const endDateStr = $(this).data('end-date'); // تاریخ پایان
                    const endDate = new Date(endDateStr);
                    const now = new Date();
                    const timeLeft = endDate - now;

                    if (timeLeft > 0) {
                        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                        $(this).find('.days').text(days);
                        $(this).find('.hours').text(hours);
                        $(this).find('.minutes').text(minutes);
                        $(this).find('.seconds').text(seconds);

                    } else {
                        $(this).html('<p>زمان این دوره به پایان رسیده است.</p>');
                    }
                });
            }

            updateCountdown(); // اجرای اولیه
            setInterval(updateCountdown, 1000); // بروزرسانی هر ثانیه
        });
    </script>
    <!--endregion: wave overlay-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const options = {
                root: null,
                rootMargin: '100px', // Load a bit earlier
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const element = entry.target;

                        // Handle images:
                        if (element.tagName === 'IMG' && element.src) {
                            element.setAttribute('data-original-src', element.src);
                            element.src = ''; // Clear the src initially
                            element.classList.add('lazy-placeholder'); // Add placeholder class
                            // Set src after adding placeholder (important for correct display)
                            element.onload = () => {
                                element.classList.remove('lazy-placeholder');
                                element.removeAttribute('data-original-src');
                            };
                            element.src = element.dataset.originalSrc; // Load!
                        }
                        // Handle iframes:
                        else if (element.tagName === 'IFRAME' && element.src) {
                            element.setAttribute('data-original-src', element.src);
                            element.src = ''; // Clear src
                            element.classList.add('lazy-placeholder');
                            element.onload = () => {
                                element.classList.remove('lazy-placeholder');
                                element.removeAttribute('data-original-src');
                            }
                            element.src = element.dataset.originalSrc;

                        }
                        // Handle other elements (optional, for custom behavior)
                        else {
                            // You can add custom logic here if needed
                            // For example, remove a 'loading' class, fetch data, etc.
                            element.classList.add(
                                'lazy-placeholder'); // Add placeholder (if you have styles for it)
                            // If you have content in a data attribute:
                            if (element.dataset.content) {
                                element.innerHTML = element.dataset.content;
                                element.removeAttribute('data-content');
                            }
                            element.classList.remove('lazy-placeholder');
                        }

                        observer.unobserve(element);
                    }
                });
            }, options);

            // Observe ALL elements within the body
            const allElements = document.querySelectorAll('body *');
            allElements.forEach(element => {
                observer.observe(element);
            });
        });
        $(document).ready(function() {
            $('#city').change(function() { // به تغییرات در لیست *استان* گوش میدیم
                var cityId = $(this).val(); //  مقدار (ID) *استان* انتخاب شده
                if (cityId) {
                    $.ajax({
                        url: '/states/' + cityId, //  URL جدید
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#state').empty(); // لیست *شهرستان* ها رو خالی میکنیم
                            $('#state').append(
                                '<option value=""></option>'); // گزینه پیشفرض
                            $.each(data, function(key, value) {
                                $('#state').append('<option value="' + value.id + '">' +
                                    value.title + '</option>'); // گزینه های *شهرستان*
                            });
                        }
                    });
                } else {
                    $('#state').empty();
                    $('#state').append(
                        '<option value="">شهرستان</option>'); //اگر استانی انتخاب *نشد*، شهرستان ها خالی
                }
            });
        });
    </script>

    <script>
        // نمایش خودکار پاپ‌آپ بعد از لود صفحه
        document.addEventListener("DOMContentLoaded", function() {
            var myModal = new bootstrap.Modal(document.getElementById('customModal'));
            myModal.show();
        });
    </script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#city").select2({
                // placeholder: "یک دسته بندی انتخاب کنید",
                allowClear: false,
                width: "100%",
                dropdownAutoWidth: true,
            });
            $("#state").select2({
                // placeholder: "یک دسته بندی انتخاب کنید",
                allowClear: false,
                width: "100%",
                dropdownAutoWidth: true,
            });
            $("#group").select2({
                // placeholder: "یک دسته بندی انتخاب کنید",
                allowClear: false,
                width: "100%",
                dropdownAutoWidth: true,
            });

            $("#herfe").select2({
                // placeholder: "یک شهر انتخاب کنید",
                allowClear: false,
                width: "100%",
                dropdownAutoWidth: true,
            });

            function handleFloatingLabel(selectId) {
                let val = $(selectId).val();
                if (val && val !== "") {
                    $(selectId + "Lable").addClass("floating");
                } else {
                    $(selectId + "Lable").removeClass("floating");
                }
            }

            $("#city").on("change", function() {
                handleFloatingLabel("#city");
            });
            $("#state").on("change", function() {
                handleFloatingLabel("#state");
            });
            $("#group").on("change", function() {
                handleFloatingLabel("#group");
            });

            $("#herfe").on("change", function() {
                handleFloatingLabel("#herfe");
            });

            // اول صفحه بررسی کنه
            handleFloatingLabel("#city");
            handleFloatingLabel("#state");
            handleFloatingLabel("#group");
            handleFloatingLabel("#herfe");
        });


        document.getElementById('playButton').addEventListener('click', function() {
            // مخفی کردن عکس
            document.getElementById('preview-image').classList.add('d-none');

            // نمایش ویدیو
            var video = document.getElementById('preview-video');
            video.classList.remove('d-none');
            // document.getElementById('playButton').classList.add('d-none');
            document.getElementById('btn-play-container').classList.add('d-none');

            // شروع به پخش ویدیو
            video.play();
        });
    </script>

    <script>
     const citys = @json($citys);
     const items2 = @json($citys);
     const items3 = @json($citys);
     const items4 = @json($citys);
        function showDropdown(id) {
            filterOptions(id);
            const dropdown = document.getElementById("dropdownList" + id);
            dropdown.style.display = 'block';
        }

        function hideDropdown() {
            const dropdown = document.getElementById("dropdownList" + id);

            setTimeout(() => dropdown.style.display = 'none', 150);
        }

        function filterOptions(divId) {
            const dropdown = document.getElementById("dropdownList" + divId);
            const input = document.getElementById("searchInput" + divId);
            const box = document.getElementById("autocompleteBox" + divId);
            const value = input.value.toLowerCase();
            const filtered = citys.filter(item => item.title.toLowerCase().includes(value));
            dropdown.innerHTML = filtered.length ?
                filtered.map(item => `<div onclick="selectItem(${item.id}, '${item.title}','${divId}')">${item.title}</div>`)
                .join('') :
                '<div>نتیجه‌ای یافت نشد</div>';

            box.classList.toggle("filled", input.value.trim() !== "");
        }

        function selectItem(id, name, divId) {
            const input = document.getElementById("searchInput" + divId);
            const box = document.getElementById("autocompleteBox" + divId);
            const dropdown = document.getElementById("dropdownList" + divId);

            input.value = name;
            document.getElementById("selectedId").value = id;
            box.classList.add("filled");
            dropdown.style.display = 'none';
        }

        function clearInput(id) {
            const box = document.getElementById("autocompleteBox" + id);
            const input = document.getElementById("searchInput" + id);
            input.value = "";
            document.getElementById("selectedId").value = "";
            box.classList.remove("filled");
            filterOptions(id);
        }

        // بستن لیست با کلیک خارج از آن
        document.addEventListener("click", function(e) {
            const box = document.getElementById("autocompleteBox" + divId);
            const box = document.getElementById("autocompleteBox" + divId);
            const box = document.getElementById("autocompleteBox" + divId);
            const box = document.getElementById("autocompleteBox" + divId);

            if (!box.contains(e.target)) {
                const dropdown = document.getElementById("dropdownList" + id);

                dropdown.style.display = "none";
            }
        });
    </script>
</body>

</html>
