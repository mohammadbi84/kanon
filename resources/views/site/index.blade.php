<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>کانون</title>

    {{-- <link rel="stylesheet" href="{{ asset('site/src/style/font-awesome.css') }}"> --}}
    <link href="https://v1.fontapi.ir/css/VazirFD" rel="stylesheet">
    <style>
        body {
            font-family: 'Vazir FD', sans-serif !important;
            /* Or 'Vazirmatn', 'Vazir', depending on the CDN/version */
        }
    </style>


    <!-- BOOTSTRAP 5 -->
    <link rel="stylesheet" href="{{ asset('site/src/style/bootstrap.css') }}">
    <script src="{{ asset('site/src/js/bootstrap.js') }}"></script>

    <!--icons-->
    <link rel="stylesheet" href="{{ asset('site/src/style/bootstrap-icons.css') }}" />
    <!-- BOOTSTRAP 5 -->


    <!-- SLIDER LIBRARY (tiny slider) -->
    <link rel="stylesheet" href="{{ asset('site/src/style/tiny-slider.css') }}">
    <script src="{{ asset('site/src/js/tiny-slider.js') }}"></script>
    <!-- SLIDER LIBRARY (tiny slider) -->

    <!-- SLIDER LIBRARY (Splide) -->
    <script src="{{ asset('site/src/js/splide.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('site/src/style/splide.css') }}">

    <!-- intersection extension for slider autoplay only when slider is visible in viewport -->
    <script src="{{ asset('site/src/js/splide-extension-intersection.js') }}"></script>
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
    <!-- input with floating-label -->
    <link rel="stylesheet" type="text/css" href="{{ asset('site/src/style/input-with-floating-label.css') }}"
        media="screen">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/src/style/input-with-floating-label-rtl-fix.css') }}"
        media="screen">
    <!-- input with floating-label -->

    <script src="{{ asset('site/src/js/init.js') }}"></script>
    <link href="{{ asset('site/src/style/animate.css') }}" rel="stylesheet">
    <!-- Leaflet Marker Cluster CSS and JS -->
    <link rel="stylesheet" href="{{asset('site/src/style/leaflet.css')}}"/>
    <script src="{{asset('site/src/js/leaflet.js')}}"></script>

    <!-- Leaflet Marker Cluster CSS and JS -->
    <script src="{{asset('site/src/js/leaflet-markercluster.js')}}"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />


    {{-- <link rel="stylesheet" href="{{asset('site/src/style/leaflet.css')}}" /> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('site/src/style/home_style.css') }}">
    <style>
        .modal-backdrop {
            background-color: #000000 !important;
            opacity: 0.7 !important;
        }

        html,
        body {
            height: 100% !important;
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
    </style>
    <script src="https://kit.fontawesome.com/fbc05d3d5f.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/tiny-slider@2.9.4/dist/min/tiny-slider.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tiny-slider@2.9.4/dist/tiny-slider.css">


    <style>
        .leaflet-popup-content{
    font-family: 'Vazir FD';
}
    </style>

</head>

<body>

    @php
        $popup = App\Models\popup::first();
    @endphp
    @if ($popup->status == 1)
        <div class="modal fade" id="customModal" tabindex="-1" aria-labelledby="customModalLabel" aria-hidden="true"
            dir="rtl">
            <div class="modal-dialog modal-dialog-centered modal-lg rounded-2">
                <div class="modal-content" style="border-radius: 12px !important">
                    <div class="modal-body p-0">
                        <!-- Slider section with close button and badge -->
                        <div class="position-relative">
                            <button type="button" class="btn btn-light position-absolute top-0 start-0 modal-close-btn"
                                data-bs-dismiss="modal"
                                style="border-radius: 0 0 12px 0 !important;padding: 0 !important;z-index: 2;width: 41px;height: 41px;">
                                <i class="bi bi-x-lg" style="font-size: x-large;position: relative;top: 2.5px;"></i>
                            </button>

                            <div class="splide" id="modal-slider" style="direction: ltr;">
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        <li class="splide__slide">
                                            <div class="modal-image-container">
                                                <img src="{{ asset('site/public/img/1.png') }}" class="img-fluid w-100"
                                                    alt="اسلایدر" style="height: 400px; object-fit: cover;">
                                            </div>
                                        </li>
                                        <li class="splide__slide">
                                            <img src="{{ asset('site/public/img/2.png') }}" class="img-fluid w-100"
                                                alt="اسلایدر" style="height: 400px; object-fit: cover;">
                                        </li>
                                        <li class="splide__slide">
                                            <img src="{{ asset('site/public/img/3.png') }}" class="img-fluid w-100"
                                                alt="اسلایدر" style="height: 400px; object-fit: cover;">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Content section -->
                        <div class="p-4 px-5" style="direction: ltr;">
                            <!-- Title -->
                            <h2 class="fw-bold mb-3 text-center" dir="rtl">{{ $popup->title }}</h2>

                            <!-- Description -->
                            <p class="text-muted text-center mb-4" dir="rtl">
                                {{ $popup->text }}
                            </p>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="button" class="btn btn-text-link px-4 py-2" data-bs-dismiss="modal">
                                    بعدا چک میکنم
                                </button>
                                <button type="button" class="btn btn-primary d-flex align-items-center px-4 py-2">
                                    دیدن پیشنهاد ویژه
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-arrow-right ms-2" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="modal fade" id="registermessageModal" tabindex="-1" dir="ltr">
        <div class="modal-dialog modal-lg">
            <div class="modal-content text-center">
                <div class="modal-header d-block p-0 bg-primary text-white">
                    <div class="row g-0 p-3" dir="rtl">
                        <div class="col" style="text-align: right;">
                            <h5 class="" id="customModalLabel">قبل از ثبت نام بخوانید</h5>
                        </div>
                        <div class="col" style="text-align: left;"> <button type="button" class="btn-close"
                                data-bs-dismiss="modal" aria-label="بستن"></button>
                        </div>
                    </div>
                </div>
                <div class="modal-body" dir="rtl">
                    <p class="text-start" style="text-align: justify;">{{ $register_message->text }}</p>
                </div>
                <div class="modal-footer d-flex justify-content-start">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">لغو</button>
                    <a href="{{ route('register') }}" class="btn btn-success"
                        onclick="closeModal('registermessageModal')">تایید</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function closeModal(modalId) {
            var modalElement = document.getElementById(modalId);
            var modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
            }
        }
    </script>


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
                style="display: none; width: 100%; min-height: var(--top-bar-height); position: fixed; top: 0; z-index: 2000; padding-top: var(--top-bar-height); background-color: var(--top-bar-color)">
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
            style="width: 100%; min-height: var(--top-bar-height); position: fixed; top: 0; z-index: 9999; padding-top: var(--top-bar-height); background-color: var(--top-bar-color)">
            <div class="top-ad-container-close"></div>
        </div>
    @endif

    <header style="position: relative;z-index:+50">
        <div class="main-menu">
            <nav class="navbar navbar-expand-lg">
                <div class="container">
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
                                        <li><a class="dropdown-item" href="{{route('school')}}" disabled>{{ $organ->name }}</a>
                                        </li>
                                    @endforeach
                                    <li><a class="dropdown-item" href="{{route('school')}}">آیتم 1</a></li>
                                    <li><a class="dropdown-item" href="{{route('school')}}">آیتم 2</a></li>
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
                            <li class="nav-item">
                                <a class="nav-link" href="#footer">فرصت های شغلی</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#footer">مدرس شوید</a>
                            </li>
                        </ul>
                        <!--  بخشی از HTML که دکمه ها را شامل می شود.  -->
                        {{-- <div class="d-flex gap-2 align-items-stretch justify-content-center">
                            <a href="#search-bar" class="btn btn-icon">
                                <span class="bi bi-search"></span>
                            </a>
                            <a href="#" class="btn btn-icon"><span class="bi bi-basket"></span></a>
                            <div class="button-container">
                                <a href="/dashboard/login" class="btn btn-text">ورود</a>
                                <a data-bs-toggle="modal" data-bs-target="#registermessageModal"
                                    class="btn btn-icon btn-primary">ثبت نام</a>
                            </div>
                        </div> --}}
                        <div class="d-flex gap-2 align-items-center justify-content-center position-relative">
                            <!-- دکمه سرچ -->
                            <button id="toggleSearch" class="btn btn-icon position-relative align-items-center"
                                type="button">
                                <span class="bi bi-search"></span>

                                <!-- اینپوت کنار آیکون (سمت راست باز میشه) -->
                                <div id="searchInputWrapper" class="search-box-horizontal p-0 ">
                                    <input type="text" class="input" placeholder="جستجو..." />
                                </div>
                            </button>

                            <!-- آیکون‌های دیگر -->
                            <a href="#" class="btn btn-icon"><span class="bi bi-basket"></span></a>
                            {{-- <div class="button-container">
                                <a href="/login" class="btn btn-text">ورود</a>
                                @if (isset($register_message) and $register_message->status == 1)
                                    <a data-bs-toggle="modal" data-bs-target="#registermessageModal"
                                        class="btn btn-icon btn-primary">ثبت نام</a>
                                @else
                                    <a href="{{ route('register') }}" class="btn btn-icon btn-primary">ثبت نام</a>
                                @endif
                            </div> --}}
                            {{-- <div class="button-container d-flex gap-3 align-items-center">
                                <a href="/login" class="btn btn-icon login-btn">ورود</a>
                                <a href="{{ route('register') }}" class="btn btn-icon btn-primary register-btn">ثبت
                                    نام</a>

                            </div> --}}
                            <div class="flex justify-center items-center">
                                <div class="button-container">
                                    <a href="/login" class="btn btn-icon login-btn">ورود</a>
                                    @if (isset($register_message) and $register_message->status == 1)
                                        <a data-bs-toggle="modal" data-bs-target="#registermessageModal"
                                            class="btn btn-icon register-btn">ثبت نام</a>
                                    @else
                                        <a href="{{ route('register') }}" class="btn btn-icon register-btn">ثبت
                                            نام</a>
                                    @endif
                                    <div class="background-slide"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <script>
            const searchBtn = document.getElementById('toggleSearch');
            const searchBox = document.getElementById('searchInputWrapper');

            searchBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                searchBox.classList.toggle('show');
                if (searchBox.classList.contains('show')) {
                    searchBox.querySelector('.input').focus();
                    searchBox.querySelector('.input').classList.add('focus');
                }
            });

            document.addEventListener('click', function(e) {
                if (!searchBox.contains(e.target) && !searchBtn.contains(e.target)) {
                    searchBox.classList.remove('show');
                }
            });
        </script>

    </header>
    {{-- slider --}}
    <header style="position: relative;z-index:-50">
        <div class="top-slider-wrapper d-flex gap-3">
            <!-- Main Slider -->
            <div class="top-slider-container flex-grow-1 position-relative">
                <div class="top-slider">
                    @foreach ($sliders as $slider)
                        <div class="item" data-duration="{{ $slider->show_time * 1000 }}">
                            @if ($slider->video)
                                <div class="video-container position-relative w-100 h-100">
                                    <img src="{{ asset($slider->image ?? 'no-image.png') }}"
                                        class="img-fluid video-cover w-100 h-100" style="object-fit: cover;"
                                        alt="">
                                        <video class="d-none w-100 h-100 slider-video" style="object-fit: cover;" preload="metadata">
                                            <source src="{{ asset($slider->video) }}" type="video/mp4">
                                        </video>
                                        <div
                                            class="video-overlay position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center">
                                            <button id="btn-stop" class="btn-stop">
                                                <span class="bi bi-pause-fill"></span>
                                            </button>
                                            <button class="btn btn-primary btn-play">
                                                <span class="bi bi-play-fill"></span>
                                            </button>
                                        </div>
                                </div>
                            @else
                                <img src="{{ asset($slider->image) }}" class="img-fluid w-100 h-100"
                                    style="object-fit: cover;" alt="">
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Vertical Thumbnails -->
            <div class="top-slider-thumbs-container" style="width: 100%;">
                <div class="top-slider-thumbs rounded-2 d-flex flex-column gap-0" style="left: var(--main-menu-margin);">
                    <div class="top-slider-thumbs-header d-flex justify-content-between align-items-center text-light">
                        <div class="slider-nav d-flex align-items-center gap-0">
                            <button class="btn btn-sm btn-light next-slide"><</button>
                            <span class="current-slide position-relative" style="bottom: 1px;">1</span>
                            <button class="btn btn-sm btn-light prev-slide">></button>
                        </div>
                        <h6 class="m-0">پست های ترند</h6>
                    </div>
                    <div class="top-slider-thumbs-body overflow-auto" style="max-height: calc(4 * (100px + 10px));">
                        @foreach ($sliders as $key => $slider)
                            <div class="thumb-item d-flex justify-content-between gap-2 align-items-center p-2"
                                data-index="{{ $key }}" dir="ltr">
                                <img src="{{ asset($slider->image ?? 'no-image.png') }}"
                                    class="img-thumbnail border-0 p-0"
                                    style="width: 80px; height: 80px; object-fit: cover;">
                                <div class="thumb-info d-flex flex-column text-end">
                                    <span class="thumb-title">{{ $slider->name }}</span>
                                    <span class="thumb-date" style="font-size: 12px;">{{ $slider->time }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- main --}}
    <main id="main">
        <div id="search-bar" class="container mt-3">
            <form action="/schools" method="get" onkeydown="return event.key != 'Enter';"
                class="search-bar text-bold-2 align-content-center" autocomplete="false">
                @csrf
                <div class="row">
                    <style>
                        .floating-label-select {
                            height: 0 !important;
                        }
                    </style>
                    <div class="col pb-0 mb-0 px-1">
                        {{-- <div class="input-group form-label-group in-border" style="margin-bottom: 0px">
                            <input type="text" class="form-control nameInput" name="name" id="name" placeholder="j"
                                style="height: 100%;">
                            <label for="name">نام آموزشگاه</label>
                            <span class="clear-btn" onclick="clearInput('state')">×</span>
                        </div> --}}
                        <div class="autocomplete" id="autocompleteBoxname">
                            <input type="text" id="searchInputname" class="only-persian" name="name"
                                oninput="nameinput()">
                            <label for="searchInputname">نام آموزشگاه</label>
                            <span class="clear-btn" id="clearBtn_name" onclick="clearInput('name')">×</span>
                        </div>
                    </div>
                    <!-- استان -->
                    <div class="col pb-0 mb-0 px-1">
                        <div class="autocomplete filled" id="autocompleteBoxstate">
                            <input type="text" id="searchInputstate" class="only-persian"
                                oninput="filterOptions('state',1)" onclick="dropdownshow('state')" value="یزد">
                            <label for="searchInputstate">استان</label>
                            <span class="clear-btn" style="display: block !important;" id="clearBtn_state"
                                onclick="clearInput('state')">×</span>
                            <div class="dropdown" id="dropdownListstate" style="display: none;"></div>
                            <input type="hidden" name="state" id="selectedIdstate" value="31">
                        </div>
                    </div>
                    <div class="col pb-0 mb-0 px-1">
                        <div class="autocomplete filled" id="autocompleteBoxcity">
                            <input type="text" id="searchInputcity" class="only-persian"
                                oninput="filterOptions('city',1)" onclick="dropdownshow('city')" value="یزد">
                            <label for="searchInputcity">شهرستان</label>
                            <span class="clear-btn" style="display: block !important;" id="clearBtn_city"
                                onclick="clearInput('city')">×</span>
                            <div class="dropdown" id="dropdownListcity" style="display: none;"></div>
                            <input type="hidden" name="city" id="selectedIdcity" value="1149">
                        </div>
                    </div>
                    <div class="col pb-0 mb-0 px-1">
                        <div class="autocomplete" id="autocompleteBoxgroup">
                            <input type="text" id="searchInputgroup" oninput="filterOptions('group',1)"
                                onclick="dropdownshow('group')">
                            <label for="searchInputgroup">رشته</label>
                            <span class="clear-btn" id="clearBtn_group" onclick="clearInput('group')">×</span>
                            <div class="dropdown" id="dropdownListgroup" style="display: none;"></div>
                            <input type="hidden" name="group" id="selectedIdgroup">
                        </div>

                    </div>
                    <div class="col pb-0 mb-0 px-1">
                        <div class="autocomplete" id="autocompleteBoxherfe">
                            <input type="text" id="searchInputherfe" oninput="filterOptions('herfe',1)"
                                onclick="dropdownshow('herfe')">
                            <label for="searchInputherfe">حرفه</label>
                            <span class="clear-btn" id="clearBtn_herfe" onclick="clearInput('herfe')">×</span>
                            <div class="dropdown" id="dropdownListherfe" style="display: none;"></div>
                            <input type="hidden" name="herfe" id="selectedIdherfe">
                        </div>

                    </div>
                    <div class="col pb-0 mb-0 px-1">
                        <button type="submit" style="height: 53px;"
                            class="btn btn-primary btn-sm border border-3 d-block w-100 rounded-2 search-button">
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
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

        <script>
            $(document).on("input", ".only-persian", function() {
                let value = $(this).val();
                // حذف هر چیزی که فارسی نیست
                let persianOnly = value.replace(/[^\u0600-\u06FF\s]/g, '');
                $(this).val(persianOnly);
                let name = $(this).attr('name');
                const box = document.getElementById("autocompleteBox" + name);
                const clearBtn = document.getElementById("clearBtn_" + name);
                let value2 = $(this).val();
                if (value2.length > 0) {
                    box.classList.add("filled");
                    clearBtn.style.display = 'block';
                } else {
                    box.classList.remove("filled");
                    clearBtn.style.display = 'none';
                }
            });
            const states = @json($citys);
            const reshtes = @json($groups);
            const herves = @json($herfes);

            function nameinput() {
                const input = document.getElementById("searchInputname");
                const box = document.getElementById("autocompleteBoxname");
                const clearBtn = document.getElementById("clearBtn_name");

                if (input.value.length > 0) {
                    box.classList.add("filled");
                    clearBtn.style.display = 'block';
                } else {
                    box.classList.remove("filled");
                    clearBtn.style.display = 'none';
                }
            }

            function dropdownshow(id) {
                filterOptions(id, 0);
                const dropdown = document.getElementById("dropdownList" + id);
                dropdown.style.display = 'block';
            }

            function hideDropdown() {
                const dropdown = document.getElementById("dropdownList" + id);

                setTimeout(() => dropdown.style.display = 'none', 150);
            }

            function filterOptions(divId, status) {
                const dropdown = document.getElementById("dropdownList" + divId);
                const input = document.getElementById("searchInput" + divId);
                const box = document.getElementById("autocompleteBox" + divId);
                const value = input.value.toLowerCase();
                if (divId == "city") {
                    city = document.getElementById("selectedIdstate").value;
                    $.ajax({
                        url: '/states/' + city, //  URL جدید
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {

                            if (status == 1) {
                                const filtered = data.filter(item => item.title.toLowerCase().startsWith(value));
                                dropdown.innerHTML = filtered.length ?
                                    filtered.map((item, index) =>
                                        `<div class="${index === 0 ? 'active' : ''}" onclick="selectItem(${item.id}, '${item.title}','${divId}')">${item.title}</div>`
                                    ).join('') :
                                    '<div>نتیجه‌ای یافت نشد</div>';
                            } else {
                                const filtered = data;
                                dropdown.innerHTML = filtered.length ?
                                    filtered.map((item, index) =>
                                        `<div class="${index === 0 ? 'active' : ''}" onclick="selectItem(${item.id}, '${item.title}','${divId}')">${item.title}</div>`
                                    ).join('') :
                                    '<div>نتیجه‌ای یافت نشد</div>';
                            }

                            box.classList.toggle("filled", input.value.trim() !== "");

                        }
                    });

                    box.classList.toggle("filled", input.value.trim() !== "");
                } else if (divId == "state") {

                    if (status == 1) {
                        const filtered = states.filter(item => item.title.toLowerCase().includes(value));
                        dropdown.innerHTML = filtered.length ?
                            filtered.map(item =>
                                `<div onclick="selectItem(${item.id}, '${item.title}','${divId}')">${item.title}</div>`)
                            .join('') :
                            '<div>نتیجه‌ای یافت نشد</div>';
                    } else {
                        const filtered = states;
                        dropdown.innerHTML = filtered.length ?
                            filtered.map(item =>
                                `<div onclick="selectItem(${item.id}, '${item.title}','${divId}')">${item.title}</div>`)
                            .join('') :
                            '<div>نتیجه‌ای یافت نشد</div>';
                    }
                    box.classList.toggle("filled", input.value.trim() !== "");
                } else if (divId == "group") {
                    if (status == 1) {
                        const filtered = reshtes.filter(item => item.name.toLowerCase().includes(value));
                        dropdown.innerHTML = filtered.length ?
                            filtered.map(item =>
                                `<div onclick="selectItem(${item.id}, '${item.name}','${divId}')">${item.name}</div>`)
                            .join('') :
                            '<div>نتیجه‌ای یافت نشد</div>';
                    } else {
                        const filtered = reshtes;
                        dropdown.innerHTML = filtered.length ?
                            filtered.map(item =>
                                `<div onclick="selectItem(${item.id}, '${item.name}','${divId}')">${item.name}</div>`)
                            .join('') :
                            '<div>نتیجه‌ای یافت نشد</div>';
                    }


                    box.classList.toggle("filled", input.value.trim() !== "");
                } else if (divId == "herfe") {
                    if (status == 1) {
                        const filtered = herves.filter(item => item.name.toLowerCase().includes(value));
                        dropdown.innerHTML = filtered.length ?
                            filtered.map(item =>
                                `<div onclick="selectItem(${item.id}, '${item.name}','${divId}')">${item.name}</div>`)
                            .join('') :
                            '<div>نتیجه‌ای یافت نشد</div>';
                    } else {
                        const filtered = herves;
                        dropdown.innerHTML = filtered.length ?
                            filtered.map(item =>
                                `<div onclick="selectItem(${item.id}, '${item.name}','${divId}')">${item.name}</div>`)
                            .join('') :
                            '<div>نتیجه‌ای یافت نشد</div>';
                    }
                    box.classList.toggle("filled", input.value.trim() !== "");
                }
                const firstOption = dropdown.querySelector("div");
                if (firstOption) firstOption.classList.add("active");
            }

            function selectItem(id, name, divId) {
                const input = document.getElementById("searchInput" + divId);
                const box = document.getElementById("autocompleteBox" + divId);
                const dropdown = document.getElementById("dropdownList" + divId);


                if (divId == "state") {
                    $('selectedId').change(function() { // به تغییرات در لیست *استان* گوش میدیم
                        var cityId = $(this).val(); //  مقدار (ID) *استان* انتخاب شده
                        if (cityId) {
                            $.ajax({
                                url: '/states/' + cityId, //  URL جدید
                                type: 'GET',
                                dataType: 'json',
                                success: function(data) {
                                    const filtered = data.filter(item => item.title.toLowerCase().includes(
                                        value));
                                    dropdown.innerHTML = filtered.length ?
                                        filtered.map(item =>
                                            `<div onclick="selectItem(${item.id}, '${item.title}','${divId}')">${item.title}</div>`
                                        )
                                        .join('') :
                                        '<div>نتیجه‌ای یافت نشد</div>';
                                    box.classList.toggle("filled", input.value.trim() !== "");
                                }
                            });
                        } else {
                            $('#state').empty();
                            $('#state').append(
                                '<option value="">شهرستان</option>'); //اگر استانی انتخاب *نشد*، شهرستان ها خالی
                        }
                    });
                    clearInput('city');
                }

                input.value = name;
                document.getElementById("selectedId" + divId).value = id;
                box.classList.add("filled");
                dropdown.style.display = 'none';
                const clearBtn = document.getElementById("clearBtn_" + divId);
                clearBtn.style.display = 'block';
            }

            function clearInput(id) {
                if (id == 'name') {
                    const box = document.getElementById("autocompleteBoxname");
                    box.classList.remove("filled");
                    const input = document.getElementById("searchInputname");
                    input.value = "";
                    const clearBtn = document.getElementById("clearBtn_name");
                    clearBtn.style.display = 'none';
                } else {
                    const box = document.getElementById("autocompleteBox" + id);
                    const input = document.getElementById("searchInput" + id);
                    input.value = "";
                    document.getElementById("selectedId" + id).value = "";
                    box.classList.remove("filled");
                    if (id == 'state') {
                        const box2 = document.getElementById("autocompleteBoxcity");
                        const input2 = document.getElementById("searchInputcity");
                        input2.value = "";
                        document.getElementById("selectedIdcity").value = "";
                        box2.classList.remove("filled");
                        const clearBtn2 = document.getElementById("clearBtn_city");
                        clearBtn2.style.display = 'none';
                    }
                    const clearBtn = document.getElementById("clearBtn_" + id);
                    clearBtn.style.display = 'none';
                    filterOptions(id, 0);
                }
            }

            // بستن لیست با کلیک خارج از آن
            document.addEventListener("click", function(e) {
                const box1 = document.getElementById("autocompleteBoxstate");
                const box2 = document.getElementById("autocompleteBoxcity");
                const box3 = document.getElementById("autocompleteBoxgroup");
                const box4 = document.getElementById("autocompleteBoxherfe");
                const dropdown1 = document.getElementById("dropdownListstate");
                const dropdown2 = document.getElementById("dropdownListcity");
                const dropdown3 = document.getElementById("dropdownListgroup");
                const dropdown4 = document.getElementById("dropdownListherfe");


                if (box1 && !box1.contains(e.target)) {
                    dropdown1.style.display = "none";
                }
                if (box2 && !box2.contains(e.target)) {
                    dropdown2.style.display = "none";
                }
                if (box3 && !box3.contains(e.target)) {
                    dropdown3.style.display = "none";
                }
                if (box4 && !box4.contains(e.target)) {
                    dropdown4.style.display = "none";
                }
            });

            document.querySelectorAll("input[id^='searchInput']").forEach(input => {
                input.addEventListener("keydown", function(e) {
                    const id = this.id.replace("searchInput", "");
                    const dropdown = document.getElementById("dropdownList" + id);
                    const items = dropdown.querySelectorAll("div");
                    const active = dropdown.querySelector(".active");
                    let index = Array.from(items).indexOf(active);

                    if (e.key === "ArrowDown") {
                        e.preventDefault();
                        if (index < items.length - 1) {
                            if (active) active.classList.remove("active");
                            items[index + 1].classList.add("active");
                            items[index + 1].scrollIntoView({
                                block: "nearest"
                            });
                        }
                    }

                    if (e.key === "ArrowUp") {
                        e.preventDefault();
                        if (index > 0) {
                            if (active) active.classList.remove("active");
                            items[index - 1].classList.add("active");
                            items[index - 1].scrollIntoView({
                                block: "nearest"
                            });
                        }
                    }

                    if (e.key === "Enter") {
                        e.preventDefault();
                        if (active) {
                            const idValue = getIdFromElement(active); // تابع استخراج id
                            const name = active.textContent.trim();
                            selectItem(idValue, name, id);
                        }
                    }
                });
            });

            function getIdFromElement(el) {
                // استخراج id از onclick
                const onclick = el.getAttribute("onclick");
                const match = onclick.match(/selectItem\((\d+),/);
                return match ? parseInt(match[1]) : "";
            }
        </script>
        {{-- adds --}}
        <div class="container" id="main-container" style="position: relative;bottom: 20px;">
            <div id="events-slider" class="splide" style="padding: 0 5px !important;">
                <div class="section-title-container">
                    <div class="section-title">
                        <img src="{{ asset('site/public/icon/vertical-line.svg') }}" aria-hidden="true"
                            class="vertical-line" alt="">
                        <span class="title">آگهی های ویژه</span>
                    </div>

                    <div class="section-options gap-0" style="margin-inline-end: -6px;">
                        <button class="nav-btn prev">
                            < </button><span class="fw-bold" style="font-size: 14px;position: relative;bottom: 2px;">1
                                    - 5</span><button class="nav-btn next"> ></button>
                    </div>
                </div>

                <div class="splide__track fix-shadow-margin px-0 py-2">
                    <ul class="splide__list">
                        @foreach ($Advertisements as $advertisement)
                            <li class="splide__slide">
                                <div class="flip-card">
                                    <div class="flip-card-inner">
                                        <!-- جلوی کارت -->
                                        <div class="flip-card-front">
                                            <div class="position-relative image-badge pb-1">
                                                @if (is_null($advertisement->image))
                                                    <img src="{{ asset('site/public/icon/vertical-line.svg') }}"
                                                        class="card-img-top" alt="event image">
                                                @else
                                                    <img src="{{ asset($advertisement->image ?? 'site/public/icon/vertical-line.svg') }}"
                                                        class="card-img-top" alt="event image">
                                                @endif
                                                @if ($advertisement->discount_percent > 0)
                                                    <div class="discount-squer"
                                                        style="position: absolute;top: -4px;right: 20px;">
                                                        <img src="{{ asset('Group 1.svg') }}" width="90"
                                                            alt="discount">
                                                        <span class="d-flex"
                                                            style="font-size: 12px;font-weight: 800;position: absolute;right: 16px;top: 7px;">
                                                            <span class="me-1" style="font-size: 13px;">تخفیف</span>
                                                            <strong class=""
                                                                style="font-size: 12px;">{{ $advertisement->discount_percent }}%</strong>
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="details d-flex flex-column h-100 text-end pt-2">
                                                <div class="d-flex justify-content-between mb-2 text-secondary small">
                                                    <small><i class="bi bi-telephone text-warning"
                                                            style="position: relative;top: 2px;"></i>
                                                        {{ $advertisement->organ?->tel ?? '03512341234' }}
                                                    </small>
                                                    <small>{{ $advertisement->organ?->cityRelation->title ?? 'یزد' }}
                                                        <i class="bi bi-geo-alt text-warning"
                                                            style="position: relative;top: 2px;font-size: 17.5px;"></i></small>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center align-content-center justify-content-end mb-2">
                                                    {{-- <h5 class="mt-2 me-2 text-align-center" style="font-size: 16px;">
                                                        {{ $advertisement->organ?->name ?? 'نام آموزشگاه' }}
                                                    </h5>
                                                    <img src="{{ asset($advertisement->organ?->file_logo ?? 'user.svg') }}"
                                                        alt="school" width="35px" height="35px"> --}}
                                                    <div class="section-title d-flex align-content-center align-items-center my-2"
                                                        style="padding-right: 6px;">
                                                        <h5 class="title me-2 mb-0" style="font-size: 16px;">
                                                            {{ $advertisement->organ?->name ?? 'نام آموزشگاه' }} </h5>
                                                        <img src="{{ asset('site/public/icon/vertical-line.svg') }}"
                                                            aria-hidden="true" class="vertical-line me-0"
                                                            style="height: 25px !important" alt="">
                                                    </div>
                                                </div>

                                                <p class="text-justify text-end" style="padding-right: 6px;">
                                                    {{ $advertisement->text }}</p>
                                                <div
                                                    class="bottom-icons2 mt-3 align-self-end d-flex align-items-center">

                                                    <small>
                                                        <a type="button" id="like-btn2{{ $advertisement->id }}"
                                                            class="like-btn2 text-decoration-none text-reset"
                                                            data-id="{{ $advertisement->id }}">
                                                            <small class="like-count"
                                                                style="font-size: 11.9px">0</small>
                                                            <i class="bi bi-heart ms-1"
                                                                style="position: relative;top: 2px;font-size:14px !important;"></i>
                                                        </a>
                                                    </small>
                                                    <small>
                                                        {{ $advertisement->visits()->count() }}
                                                        <i class="bi bi-eye ms-1"
                                                            style="position: relative;top: 2px;"></i>
                                                    </small>
                                                    <small dir="rtl">
                                                        <i class="bi bi-clock me-1"
                                                            style="position: relative;top: 2px;"></i>
                                                        {{ jdate($advertisement->created_at)->ago() }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- پشت کارت -->
                                        <div class="flip-card-back border">
                                            @if ($advertisement->discount_percent > 0)
                                                <div class="discount-squer"
                                                    style="position: absolute;top: 8px;left: 26px;">
                                                    <img src="{{ asset('Group 1.svg') }}" width="90"
                                                        alt="discount">
                                                    <span class="d-flex"
                                                        style="font-size: 12px;font-weight: 800;position: absolute;right: 12px;top: 7px;">
                                                        <span class="me-1" style="font-size: 13px;">تخفیف</span>
                                                        <strong class="" style="font-size: 12px;">10%</strong>
                                                    </span>
                                                </div>
                                            @endif

                                            <h4 class="">{{ $advertisement->title }}</h4>
                                            <p class="text-justify px-1" style="font-size: 14px">
                                                {{ $advertisement->text }}
                                            </p>
                                            <div class="border rounded-2 bg-light p-1 time">
                                                <p class="text-center m-0"
                                                    style="font-size: 14px;direction: rtl;font-weight:bold;margin-bottom:4px">
                                                    <span class="text-primary"
                                                        style="font-size: 14px">1403/05/08</span>
                                                    <span class="text-dark" style="font-size: 14px;">الی</span>
                                                    <span class="text-primary"
                                                        style="font-size: 14px">1403/05/20</span>
                                                </p>
                                            </div>
                                            {{-- <button class="adv-btn btn btn-light text-primary border w-100 mb-2">
                                                    اطلاعات بیشتر
                                                    <i class="bi bi-info-circle ms-1 text-danger"
                                                        style="position: relative;top: 2px;"></i>
                                                </button>
                                                <button class="adv-btn btn-takhalof btn btn-light border w-100 mb-2">
                                                    <span class="text-primary" style="font-size: 14px">ثبت تخلف</span>
                                                    <i class="bi bi-exclamation-triangle ms-1"
                                                        style="position: relative;top: 2px;color: #9c0006;"></i>
                                                </button> --}}
                                            <!-- محتوای پشت کارت -->
                                            <div class="bottom-icons2 mt-3 align-self-end d-flex align-items-center"
                                                style="left: 23px;right:23px;direction: rtl;">
                                                <a href="#" class="text-reset text-decoration-none">
                                                    <small dir="rtl" style="font-size: 11.9px">
                                                        <i class="bi bi-eye me-1"
                                                            style="position: relative;top: 2px;"></i>
                                                        مشاهده
                                                    </small>
                                                </a>

                                                <a href="#" class="text-reset text-decoration-none">
                                                    <small style="font-size: 11.9px">
                                                        <i class="bi bi-exclamation-triangle me-1"
                                                            style="position: relative;top: 2px;"></i>
                                                        ثبت تخلف
                                                    </small>
                                                </a>

                                                <small> <a type="button"
                                                        class="like-btn text-decoration-none text-reset"
                                                        data-id="{{ $advertisement->id }}">
                                                        <i class="bi bi-heart me-1"
                                                            style="position: relative;top: 2px;font-size:14px !important;"></i>
                                                        <small class="like-count" style="font-size: 11.9px">0</small>
                                                    </a>
                                                </small>
                                            </div>
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
                        <div class="d-flex flex-column align-items-center">
                            {{-- <a href="#"
                                class="position-relative text-reset text-decoration-none btn btn-light rounded-circle border p-0 align-content-center comp-btn"
                                style="width:32px;height:32px">
                                <i class="bi bi-arrow-repeat position-relative"></i>
                                <span class="badge text-dark text-align-center">0</span>
                            </a> --}}
                            <a href="#" class="btn btn-light rounded-circle comp-link"><span
                                    class="badge text-align-center">0</span></a>
                        </div>
                        <label class="switch2">
                            <input type="checkbox" name="off" id="off">
                            <span class="slider"></span>
                        </label>
                        <label class="switch">
                            <input type="checkbox" name="hot-annos" id="hot-annos">
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>

                <div class="row row-gap-3" id="hot-annos-list">
                    {{-- خودکار اضافه می‌شود --}}
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
                                <a href="#" class="text-reset text-decoration-none">
                                    <div class="row anno-card shadow rounded-3" style="overflow: visible !important;">
                                        <div class="col-6 position-relative" style="padding: 12px;min-height: 170px !important;">
                                            <div class="row g-0" dir="ltr">
                                                <div class="col align-content-center text-start p-0">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <span class="text-small-1">${item.city}</span>
                                                        <span class="">|</span>
                                                        <span class="text-small-1">${item.tel}</span>
                                                    </div>
                                                </div>
                                                <div class="col text-end p-0">
                                                    <div class="d-flex justify-content-end">
                                                        <h5 class="mt-2 me-2 text-align-center fw-bold" style="font-size: 16px">
                                                         دارالفنون فاضل
                                                        </h5>
                                                        <img src="{{ asset('site/public/icon/vertical-line.svg') }}" alt="school" width="5px"
                                                            height="35px">
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="fw-bold mt-2 mb-1" style="font-size: 15px">عنوان اگهی</p>
                                            <p style="font-size: 16px">
                                                ${item.text}
                                            </p>
                                            <div class="bottom-icons border-top align-items-center align-self-end" style="position: absolute;padding: 5px 12px 0 12px;bottom: 7.5px;left: 0;right: 0;" dir="ltr">
                                                <div class="checkbox-wrapper-13 d-flex align-items-center" dir="rtl">
                                                  <input id="comp${item.id}" type="checkbox">
                                                  <label for="comp${item.id}">مقایسه</label>
                                                </div>
                                                <small style="font-size: 11.9px;">
                                                    <a type="button" class="text-decoration-none text-reset"
                                                        data-id="{{ $advertisement->id }}">
                                                        <small class="like-count" style="font-size: 11.9px;">${item.likes}</small>
                                                        <i class="bi bi-heart ms-1 text-primary"
                                                        style="position: relative;top: 2px;font-size:14px !important;"></i>
                                                    </a>
                                                </small style="font-size: 11.9px;">
                                                <small style="font-size: 11.9px;">
                                                    ${item.views}
                                                    <i class="bi bi-eye ms-1 text-primary" style="position: relative;top: 2px;"></i>
                                                </small>
                                                <small dir="rtl" style="font-size: 11.9px;">
                                                    <i class="bi bi-clock ms-1 text-primary" style="position: relative;top: 2px;"></i>
                                                     ${item.time}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-6 position-relative img ads-img-col" style="z-index: 5;overflow: visible;">
                                            <div class="img-container h-100">
                                                <a href="#" class="text-reset text-decoration-none">
                                                    <img src="${item.image}" alt="${item.title}"
                                                         style="object-fit: cover; width: 100%; height: 100%;">
                                                </a>
                                                <!-- این دیو با هاور نمایش داده می‌شود -->
                                                <div class="hover-reveal border-top">
                                                    <div class="bottom-icons py-0 px-1 align-self-end d-flex align-items-center"
                                                        style="direction: rtl;">
                                                        <a href="#" class="text-reset text-decoration-none">
                                                            <small style="font-size: 11.9px" class="fw-bold">
                                                                <i class="bi bi-exclamation-triangle ms-1 text-primary"
                                                                style="position: relative;top: 2px;"></i>
                                                                ثبت تخلف
                                                            </small>
                                                        </a>
                                                        <p class="text-center m-0 d-flex"
                                                                style="font-size: 11.9px;direction: rtl;font-weight:bold;margin-bottom:4px">
                                                                <span class="text-dark fw-bold" style="font-size: 11.9px">1403/05/08</span>
                                                                <span class="text-primary fw-bold mx-1" style="font-size: 11.9px;"> الی </span>
                                                                <span class="text-dark fw-bold" style="font-size: 11.9px">1403/05/20</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="discount-squer" style="position: absolute; top: -5px; left: 18px; z-index: 66;">
                                                <img src="{{ asset('Group 1.svg') }}" width="90" alt="discount">
                                                <span class="d-flex" style="font-size: 12px; font-weight: 800; position: absolute; right: 16px; top: 7px;direction: ltr;">
                                                    <span class="me-1" style="font-size: 13px;">تخفیف</span>
                                                    <strong style="font-size: 12px;">10%</strong>
                                                </span>
                                            </div>
                                            <div class="permume-squer" style="position: absolute; top: -7px; right: 12px; z-index: 66;">
                                                <img src="{{ asset('hot-bookmark.svg') }}" width="36" alt="discount">
                                            </div>
                                        </div>
                                    </div>
                                </a>
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
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('.like-btn').each(function() {
                        const btn = $(this);
                        const adId = btn.data('id');
                        const btn2 = $("#like-btn2" + adId);
                        const adId2 = btn2.data('id');

                        // 1. دریافت وضعیت لایک و شمارش
                        $.get('/like-count/' + adId, function(res) {
                            btn.find('.like-count').text(res.count);
                            btn2.find('.like-count').text(res.count);
                        });

                        $.get('/like/' + adId + '/check', function(res) {
                            if (res.liked) {
                                btn.addClass('liked');
                                btn.find('i').removeClass('bi-heart').addClass('bi-heart-fill text-danger');
                                btn2.addClass('liked');
                                btn2.find('i').removeClass('bi-heart').addClass(
                                    'bi-heart-fill text-danger');
                            } else {
                                btn.removeClass('liked');
                                btn.find('i').removeClass('bi-heart-fill text-danger').addClass('bi-heart');
                                btn2.removeClass('liked');
                                btn2.find('i').removeClass('bi-heart-fill text-danger').addClass(
                                    'bi-heart');
                            }
                        });

                        // $.ajaxSetup({
                        //     headers: {
                        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        //     }
                        // });
                        // 2. رویداد کلیک برای لایک یا حذف
                        btn.on('click', function() {
                            let adId = btn.data('id');
                            let adId2 = btn2.data('id');
                            let icon = btn.find('i');
                            let icon2 = btn2.find('i');
                            let countElem = btn.find('.like-count');
                            let countElem2 = btn2.find('.like-count');
                            let isLiked = icon.hasClass('bi-heart-fill');
                            let isLiked2 = icon2.hasClass('bi-heart-fill');

                            // وضعیت اولیه رو ذخیره می‌کنیم تا در صورت خطا برگردیم
                            let originalCount = parseInt(countElem.text());
                            let newCount = isLiked ? originalCount - 1 : originalCount + 1;

                            // تغییر ظاهری سریع
                            if (isLiked) {
                                icon.removeClass('bi-heart-fill text-danger').addClass('bi-heart');
                                icon2.removeClass('bi-heart-fill text-danger').addClass('bi-heart');
                            } else {
                                icon.removeClass('bi-heart').addClass('bi-heart-fill text-danger');
                                icon2.removeClass('bi-heart').addClass('bi-heart-fill text-danger');
                            }
                            countElem.text(newCount);
                            countElem2.text(newCount);

                            // ارسال به سرور
                            $.ajax({
                                url: '/like/' + adId,
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(res) {
                                    // اگر سرور موفق بود، هیچ‌کاری نکن
                                },
                                error: function() {
                                    // در صورت خطا، همه چیز رو به حالت اول برگردون
                                    if (isLiked) {
                                        icon.removeClass('bi-heart').addClass(
                                            'bi-heart-fill text-danger');
                                        countElem.text(originalCount);
                                        countElem2.text(originalCount2);
                                    } else {
                                        icon.removeClass('bi-heart-fill text-danger').addClass(
                                            'bi-heart');
                                        countElem.text(originalCount);
                                        countElem2.text(originalCount2);
                                    }
                                }
                            });
                        });

                    });
                });
            </script>
        </div>

        {{-- vodeo --}}
        <div class="container-fluid p-0 mt-4" id="full-width-video" style="box-shadow: 0 0 1rem #919191;">
            <div class="video" style="height: 92vh; position: relative; overflow: hidden;">
                <img id="video-cover" src="{{ asset('site/public/img/1.png') }}" class="img"
                    style="width:100%; height:100%; object-fit:cover;" alt="">
                <video src="{{ asset('fazel.mp4') }}" id="video-player" class="d-none"
                    style="width:100%; height:100%; object-fit:cover;"></video>

                <!-- دکمه Stop که فقط با هاور نمایش داده می‌شود -->
                <div id="btn-stop-container" class="btn-stop-container"
                    style="position:absolute; top:50%; left:50%; display:none;transform:translate(-50%, -50%);">
                    <button id="btn-stop" class="btn-play btn-stop">
                        <span class="bi bi-pause-fill"></span>
                    </button>
                </div>
                <!-- دکمه Play وسط -->
                <div id="btn-play-container" class="btn-play-container"
                    style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);">
                    <button id="btn-play" class="btn-play pulse">
                        <span class="bi bi-play-fill"></span>
                    </button>
                </div>


            </div>
        </div>


        {{-- courses --}}
        <div class="container mb-5">
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
                <div class="splide__track rounded-3 shadow" id="vije">
                    <ul class="splide__list rounded-3" id="vije2">
                        @foreach ($courses as $course)
                            <li class="splide__slide rounded-3">
                                <a href="{{ route('course', ['id' => $course->id]) }}"
                                    class="text-reset text-decoration-none">
                                    <div class="row offer-card m-0 align-items-stretch" dir="rtl">
                                        <div
                                            class="col-6 p-3 text-center d-flex flex-wrap align-content-around flex-column">
                                            <div class="row g-0" dir="ltr">
                                                <div class="col align-content-top text-start p-0">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <div class="me-3">
                                                            <span><span class="badge me-1"
                                                                    style="font-size: 12px;background-color:#e69926">20%</span><del
                                                                    style="font-size: 14px"
                                                                    class="text-primary">5,000,000</del></span>
                                                            <span class="d-block" style="font-size: 14px"
                                                                dir="rtl">4,000,000 <span
                                                                    style="padding-right: 6px;font-size:14px">تومان</span></span>
                                                        </div>
                                                        <div class="text-center me-3">
                                                            <span><i class="bi bi-mortarboard text-primary"></i></span>
                                                            <span class="d-block" style="font-size: 14px">حضوری</span>
                                                        </div>
                                                        <div class="text-center me-3">
                                                            <span><i class="bi bi-clock text-primary"></i></span>
                                                            <span class="d-block" style="font-size: 14px"
                                                                dir="rtl">50 ساعت</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col text-end p-0">
                                                    <div class="d-flex justify-content-end align-items-center">
                                                        <h5 class="mt-2 me-2 text-align-center fw-bold"
                                                            style="font-size: 16px">
                                                            دارالفنون فاضل
                                                        </h5>
                                                        <img src="{{ asset('user.svg') }}" alt="user"
                                                            width="50">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- تغییر نام کلاس -->
                                            <p class="title text-title-2 text-bold-2 mt-0">{{ $course->name }}</p>
                                            <p class="text mb-0 text-justify text-center pe-2">
                                                {{ $course->description }}</p>
                                            <div class="row m-0 mt-4 mb-3 px-4" dir="ltr">
                                                {{-- تایمر شمارش معکوس --}}
                                                <div class="countdown-timer" id="countdown-{{ $course->id }}"
                                                    data-end-date="{{ $course->date }}">
                                                    <div class="timer-col">
                                                        <span class="timer-number days">12
                                                            {{-- <span class="d-block text-dark">روز</span> --}}
                                                        </span>
                                                        {{-- <span class="timer-text">روز</span> --}}
                                                    </div>
                                                    <div class="timer-col">
                                                        <span class="timer-number hours">20
                                                            {{-- <span class="d-block text-dark">روز</span> --}}
                                                        </span>
                                                        {{-- <span class="timer-text">ساعت</span> --}}
                                                    </div>
                                                    <div class="timer-col">
                                                        <span class="timer-number minutes">20
                                                            {{-- <span class="d-block text-dark">روز</span> --}}
                                                        </span>
                                                        {{-- <span class="timer-text">دقیقه</span> --}}
                                                    </div>
                                                    <div class="timer-col">
                                                        <span class="timer-number seconds">20
                                                            {{-- <span class="d-block text-dark">روز</span> --}}
                                                        </span>
                                                        {{-- <span class="timer-text">ثانیه</span> --}}
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- icons --}}
                                            <div class="bottom-icons align-items-center align-self-end w-100 pt-3"
                                                style="" dir="ltr">
                                                <small style="font-size: 11.9px;">
                                                    <i class="bi bi-arrow-left me-1 text-primary"
                                                        style="position: relative;top: 4px;"></i>
                                                    مشاهده جزئیات
                                                </small>
                                                <small dir="rtl" style="font-size: 11.9px;">
                                                    <i class="bi bi-heart ms-1 text-primary"
                                                        style="position: relative;top: 2px;"></i>
                                                    50
                                                </small>
                                                <small dir="rtl" style="font-size: 11.9px;">
                                                    <i class="bi bi-eye ms-1 text-primary"
                                                        style="position: relative;top: 2px;"></i>
                                                    112
                                                </small>
                                                <small style="font-size: 11.9px;">
                                                    035-31231234
                                                    <i class="bi bi-telephone ms-1 text-primary cours-tel-icon"
                                                        style="position: relative;top: 2px;"></i>
                                                </small>
                                                <small dir="rtl" style="font-size: 11.9px;">
                                                    <i class="bi bi-geo-alt ms-1 text-primary"
                                                        style="position: relative;top: 2px;"></i>
                                                    یزد
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-6 p-0 position-relative">
                                            <img src="{{ asset($course->image ?? 'Untitled.png') }}"
                                                class="w-100 h-100 object-fit-cover" alt="{{ $course->name }}">
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

            {{-- courses cards --}}
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
                                <div class="col-5 shadow p-0 img position-relative overflow-hidden">
                                    <img src="{{ asset($item->image ?? 'Untitled.png') }}" alt=""
                                        class="w-100 h-100 object-fit-cover">
                                    <div class="hover-reveal2 border-top">
                                        <div class="bottom-icons py-0 px-1 align-self-end d-flex align-items-center"
                                            style="direction: rtl;">
                                            <div style="font-size: 11.9px;" class="text-center fw-bold">
                                                <a href="#"
                                                    class="text-reset text-decoration-none text-center fw-bold"
                                                    style="font-size: 11.9px;">

                                                    <i class="bi bi-heart ms-1 text-primary d-block"
                                                        style="position: relative;top: 2px;"></i>
                                                    120
                                                </a>
                                            </div>
                                            <div style="font-size: 11.9px;" class="text-center fw-bold">
                                                <a href="#"
                                                    class="text-reset text-decoration-none text-center fw-bold"
                                                    style="font-size: 11.9px;">

                                                    <i class="bi bi-eye ms-1 text-primary d-block"
                                                        style="position: relative;top: 2px;font-size:19px"></i>
                                                    <span class="fw-bold text-dark"
                                                        style="position: relative;bottom:2px;font-size:11.9px">120</span>
                                                </a>

                                            </div>
                                            <div style="font-size: 11.9px;" class="text-center fw-bold"
                                                dir="rtl">
                                                <i class="bi bi-clock ms-1 text-primary d-block"
                                                    style="position: relative;top: 2px;"></i>
                                                50 ساعت
                                            </div>
                                            <div style="font-size: 11.9px;" class="text-center fw-bold">
                                                <i class="bi bi-mortarboard ms-1 text-primary d-block"
                                                    style="position: relative;top: 2px;"></i>
                                                حضوری
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-7 shadow d-flex flex-wrap align-content-around flex-column justify-content-between gap-2 p-3 py-2"
                                    style="border-top-left-radius: 5px;border-bottom-left-radius: 5px;">
                                    <div class="row g-0 w-100 align-content-center" dir="ltr">
                                        <div class="col align-content-center text-start p-0">
                                            <div class="d-flex align-items-center gap-1">
                                                <span class="text-small-1">یزد</span>
                                                <span class="">|</span>
                                                <span class="text-small-1">035-31231234</span>
                                            </div>
                                        </div>
                                        <div class="col text-end p-0">
                                            <div class="d-flex justify-content-end">
                                                <a href="#" class="text-reset text-decoration-none">
                                                    <h5 class="mt-2 me-0 text-align-center fw-bold"
                                                        style="font-size: 16px">
                                                        دارالفنون فاضل
                                                    </h5>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="text-reset text-decoration-none">

                                        <h5 class="text-center">{{ $item->name }}</h5>
                                    </a>

                                    <div class="row m-0 mt-2 p-0 w-100" dir="ltr">
                                        {{-- تایمر شمارش معکوس --}}
                                        <div
                                            class="col-6 p-0 d-flex flex-wrap justify-content-center align-content-center">
                                            <div class="d-flex flex-wrap align-content-center align-items-center">
                                                <span><span class="badge me-1"
                                                        style="font-size: 12px;background-color:#e69926">20%</span><del
                                                        style="font-size: 14px"
                                                        class="text-primary">5,000,000</del></span>
                                                <span class="d-block" style="font-size: 14px"
                                                    dir="rtl">4,000,000 <span
                                                        style="padding-right: 6px;font-size:14px">تومان</span></span>
                                            </div>
                                        </div>
                                        <div class="col-6 p-0">
                                            <div class="countdown-timer timer-short justify-content-between"
                                                id="countdown-{{ $item->id }}"
                                                data-end-date="{{ $item->date }}">
                                                <div class="timer-col">
                                                    <span class="timer-number days">12
                                                        {{-- <span class="d-block text-dark">روز</span> --}}
                                                    </span>
                                                    {{-- <span class="timer-text">روز</span> --}}
                                                </div>
                                                <div class="timer-col">
                                                    <span class="timer-number hours">20
                                                        {{-- <span class="d-block text-dark">روز</span> --}}
                                                    </span>
                                                    {{-- <span class="timer-text">ساعت</span> --}}
                                                </div>
                                                <div class="timer-col">
                                                    <span class="timer-number minutes">20
                                                        {{-- <span class="d-block text-dark">روز</span> --}}
                                                    </span>
                                                    {{-- <span class="timer-text">دقیقه</span> --}}
                                                </div>
                                                <div class="timer-col">
                                                    <span class="timer-number seconds">20
                                                        {{-- <span class="d-block text-dark">روز</span> --}}
                                                    </span>
                                                    {{-- <span class="timer-text">ثانیه</span> --}}
                                                </div>
                                            </div>
                                        </div>
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
        <div class="container my-5">
            {{-- text --}}
            <div id="advantages" class="mt-5 mb-5">
                <div class="section-title-container">
                    <div class="section-title">
                        <img src="{{ asset('site/public/icon/vertical-line.svg') }}" aria-hidden="true"
                            class="vertical-line" alt="">
                        <span class="title">{{ $content_title->title }}</span>
                    </div>

                    <div class="section-options">
                    </div>
                </div>

                <div class="row mx-0 row-gap-4 fix-shadow-margin"
                    style="margin-left: -10px !important; margin-right: -10px !important;">
                    @foreach ($contents as $key => $content)
                        <div class="col-md-4">
                            <div class="advantage-card h-100">
                                <p class="fw-bold text-primary fs-4 text-count">{{ $key + 1 }}</p>
                                <p class="title text-title-3 text-bold-2">{{ $content['title'] }}</p>
                                <p class="text mb-0 text-normal text-dark">{{ $content['text'] }}</p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <!-- بخش کارت‌ها -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="contact-card h-100 d-flex flex-wrap align-content-between w-100">
                        <div class="card-box d-flex align-items-center justify-content-start rounded-4">
                            <div class="icon-box bg-white bg-opacity-25 border rounded-3 p-2">
                                <i class="bi bi-share fs-4 text-secondary info-icons"></i>
                            </div>
                            <div class="text-start me-3 mt-2">
                                <h6 class="fw-bold text-dark">شبکه های اجتماعی</h6>
                                <p class="text-dark text-justify">از آخرین اخبار و کمپین‌ها از طریق شبکه های اجتماعی
                                    مطلع شوید.</p>
                            </div>
                        </div>
                        <div class="card-box d-flex align-items-center justify-content-between rounded-3 p-2 px-3 mt-3 w-100"
                            style="background-color: #F8F9FA;">
                            <a href="#" class="fw-bold text-decoration-none text-success">پشتیبانی</a>
                            <div class="d-flex align-items-center justify-content-end me-2">
                                <div class="text-dark" dir="ltr">@webkidnet</div>
                                {{-- <i class="bi bi-send text-primary"></i> --}}
                                <span class="border border-3 rounded-circle me-2"
                                    style="width: 30px;height:30px;background: #eba607;border-color: #eba607 !important;">
                                    <i class="bi bi-send text-white"
                                        style="font-size: 16px;position: relative;top: 3px;left: 0;"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-card h-100 d-flex flex-wrap align-content-between w-100">
                        <div class="card-box d-flex align-items-center justify-content-start rounded-4">
                            <div class="icon-box bg-white bg-opacity-25 border rounded-3 p-2">
                                <i class="bi bi-telephone fs-4 text-secondary info-icons"></i>
                            </div>
                            <div class="text-start me-3 mt-2">
                                <h6 class="fw-bold text-dark">تلفن تماس</h6>
                                <p class="text-dark text-justify">همه‌روزه از ساعت 9:00 الی 17:00 پاسخگوی تماس شما
                                    هستیم.</p>
                            </div>
                        </div>
                        <div class="card-box d-flex align-items-center justify-content-between rounded-3 p-2 px-3 mt-3 w-100"
                            style="background-color: #F8F9FA;">
                            <a href="#" class="fw-bold text-decoration-none text-success">تماس</a>
                            <div class="d-flex align-items-center justify-content-end me-2">
                                <div class="text-dark" dir="ltr">0919 089 4203</div>
                                <span class="border border-3 rounded-circle me-2"
                                    style="width: 30px;height:30px;background: #eba607;border-color: #eba607 !important;">
                                    <i class="bi bi-telephone text-white"
                                        style="font-size: 16px;position: relative;top: 2px;left: 0;"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-card h-100 d-flex flex-wrap align-content-between w-100">
                        <div class="card-box d-flex align-items-center justify-content-start rounded-4">
                            <div class="icon-box bg-white bg-opacity-25 border rounded-3 p-2">
                                <i class="bi bi-chat-dots fs-4 text-secondary info-icons"></i>
                            </div>
                            <div class="text-start me-3 mt-2">
                                <h6 class="fw-bold text-dark">پیام رسان ها</h6>
                                <p class="text-dark text-justify">در پیام رسان‌های زیر پاسخگوی سوالات شما هستیم.</p>
                            </div>
                        </div>
                        <div class="card-box d-flex align-items-center justify-content-between rounded-3 p-2 px-3 mt-3 w-100"
                            style="background-color: #F8F9FA;">
                            <a href="#" class="fw-bold text-decoration-none text-success">ارسال پیام</a>
                            <div class="d-flex align-items-center justify-content-end me-2">
                                <div class="text-dark" dir="ltr">0919 089 4203</div>
                                {{-- <i class="bi bi-whatsapp fs-4 text-success me-2"></i> --}}
                                <span class="border border-3 rounded-circle me-2"
                                    style="width: 30px;height:30px;background: #eba607;border-color: #eba607 !important;">
                                    <i class="bi bi-whatsapp text-white"
                                        style="font-size: 16px;position: relative;top: 2px;left: 0;"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- بخش نقشه -->
            <div class="map-container22 mb-4">
                <div id="map" class="shadow" style="height: 300px;
            border-radius: 12px;"></div>
            </div>

            <!-- بخش فوتر -->
            <div class="footer-section row text-center text-md-start g-0">
                <div class="col" style="height: 160px;">
                    <div class="row bg-white shadow p-2 g-0 border rounded-3" style="height: 160px;">
                        <div class="col align-content-center p-2">
                            <div class="card-box d-flex align-items-center justify-content-start rounded-4">
                                <div class="icon-box-footer d-flex align-items-center justify-content-center"
                                    style="width: 104px !important;">
                                    <i class="bi bi-geo-alt footer-icon"></i>
                                </div>
                                <div class="text-start me-2 mt-2">
                                    <h6 class="fw-bold text-dark">آدرس :</h6>
                                    <p>یزد، خیابان کاشانی، روبروی بیمارستان شهید صدوقی، کوچه شهید
                                        رفیعی 24</p>
                                </div>
                            </div>
                        </div>
                        <div class="col align-content-center p-2">
                            <div class="card-box d-flex align-items-center justify-content-start rounded-4">
                                <div class="icon-box-footer d-flex align-items-center justify-content-center">
                                    <i class="bi bi-clock footer-icon"></i>
                                </div>
                                <div class="text-start me-2 mt-2">
                                    <h6 class="fw-bold text-dark">ساعات کاری :</h6>
                                    <p class="">شنبه تا پنجشنبه <br>
                                        8:30 - 13:30 | 16:30 - 20:30
                                    </p>
                                    {{-- <p class="m-0 p-0"></p> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col align-content-center p-2">
                            <div class="card-box d-flex align-items-center justify-content-start rounded-4">
                                <div class="icon-box-footer d-flex align-items-center justify-content-center">
                                    <i class="bi bi-envelope footer-icon"></i>
                                </div>
                                <div class="text-start me-2 mt-2">
                                    <h6 class="fw-bold text-dark">پست الکترونیک :</h6>
                                    <p>info@FazelEdu.com <br>
                                        contact@FazelEdu.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-2 p-0 h-100 text-center">
                    <div class="border rounded-3 shadow-sm h-100 bg-white me-2 text-center">
                        <img src="{{ asset('enemad.png') }}" class="rounded-3" alt="enamad"
                            style="height: 133px;">
                    </div>
                </div> --}}
                <div class="col-md-2 p-0 pe-1 h-100 text-center">
                    <div class="border rounded-3 shadow-sm w-100 bg-white text-center">
                        <section id="vertical-slider" class="splide rounded-3" aria-label="Vertical Slider">
                            <div class="splide__track rounded-3">
                                <ul class="splide__list rounded-3">
                                    <li
                                        class="splide__slide rounded-3 align-content-center align-items-center text-center">
                                        <img src="{{ asset('enemad.png') }}" class="rounded-3 my-auto mx-auto"
                                            style="height: 125px" alt="enamad">
                                    </li>
                                    <li
                                        class="splide__slide rounded-3 align-content-center align-items-center text-center">
                                        <img src="{{ asset('image2.png') }}" class="rounded-3 my-auto mx-auto"
                                            style="height: 125px" alt="image2">
                                    </li>
                                    <li
                                        class="splide__slide rounded-3 align-content-center align-items-center text-center">
                                        <img src="{{ asset('image3.png') }}" class="rounded-3 my-auto mx-auto"
                                            style="height: 125px" alt="image3">
                                    </li>
                                </ul>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    new Splide('#vertical-slider', {
                        direction: 'ttb', // اسلایدر عمودی (top-to-bottom)
                        height: '160px', // ارتفاع ثابت
                        pagination: true,
                        arrows: false,
                        autoplay: true,
                        interval: 3000,
                        type: 'loop',
                        perPage: 1,
                    }).mount();
                });
            </script>
        </div>
    </main>

    <footer id="footer">

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

    <!-- Chat Container -->
    <div class="chat-container" id="btn-support">
        <div class="chat-box" id="chatBox">
            <div class="chat-header" id="chatHeader">
                <div class="d-flex align-items-center">
                    <span class="border border-2 px-1 rounded-2 ms-2" style="border-color: #e69926 !important">
                        <i class="bi bi-chat-dots text-primary"></i>
                    </span>
                    <h5>پشتیبانی آنلاین</h5>
                </div>
                <button class="close-btn" id="closeBtn"><i class="bi bi-dash-lg"></i></button>
            </div>
            <div class="chat-body" id="chatBody">
                <div class="message received">
                    سلام! چگونه می‌توانم به شما کمک کنم؟
                    <span class="message-time">۱۰:۰۲ ق.ظ</span>
                </div>
                <div class="message sent">
                    سلام، من در مورد محصولات شما سوالی دارم
                    <span class="message-time">۱۰:۰۳ ق.ظ</span>
                </div>
                <div class="message received">
                    حتما، لطفا سوال خود را بپرسید.
                    <span class="message-time">۱۰:۰۳ ق.ظ</span>
                </div>
            </div>
            <div class="chat-footer" id="chatFooter">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="پیام خود را بنویسید..."
                        id="messageInput">
                    <button class="btn send-btn" id="sendBtn">
                        <i class="bi bi-send" style="position: relative;top: 3px;"></i>
                    </button>
                </div>
            </div>
        </div>

        <button class="chat-btn" id="chatBtn">
            <i class="bi bi-chat-dots" id="chatIcon"></i>
            {{-- <img src="{{asset('support.png')}}" alt="support" class="w-100 h-100"> --}}
        </button>
    </div>
    <!--endregion: support button -->

    <!--region: go to top button -->
    <a href="#" id="btn-go-to-top" class="shadow">
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
    {{-- <a href="#" id="btn-news" class="btn-news">
        <span>اخبار</span>
    </a> --}}
    <div class="right-nav" id="btn-news">
        <p><a href="#" class="text-decoration-none text-dark">اخبار</a></p>
    </div>

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
            <div class="news-list" id="newsContainer" style="width: 1280px;margin: 0 auto;">
                <div class="text-end">
                    {{-- <a href="{{ route('news') }}" class="btn btn-archive">مشاهده آرشیو</a> --}}
                </div>
                @foreach ($news as $item)
                    <div class="khabar-container news-item" style="display:none;">
                        <div class="khabar-item row align-items-center">
                            @php
                                $media = json_decode($item->media, true) ?? [];
                                $firstImage = $media[0] ?? null;
                                $otherImages = array_slice($media, 1);
                            @endphp
                            <div class="col-md-3">
                                <div class="row g-0">
                                    @if ($item->images->count() > 0)
                                        <div class="col-4">
                                            <div class="row g-0 khabar-gallery-row">
                                                @foreach ($item->images as $images)
                                                    <div class="col-12 p-1 text-center">
                                                        <a href="javascript:void(0)" class="image-link"
                                                            data-image-src="{{ asset($images->image_path) }}">
                                                            <img src="{{ asset($images->image_path) }}"
                                                                alt="تصویر خبر {{ $item->title }}"
                                                                class="w-100 rounded-2">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col">
                                        <div class="khabar-image-main h-100">
                                            <a href="javascript:void(0)" class="image-link"
                                                data-image-src="{{ asset($item->cover ? $item->cover : $item->images()->first()->image_path) }}"><img
                                                    class="khabar-image-main-cover"
                                                    src="{{ asset($item->cover ? $item->cover : $item->images()->first()->image_path) }}"
                                                    alt="تصویر خبر {{ $item->title }}"></a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="khabar-content h-100">
                                    <h2 class="khabar-title">{{ $item->title }}</h2>
                                    @php
                                        $plainText = strip_tags($item->text);
                                        $words = explode(' ', $plainText);
                                        $shortText = implode(' ', array_slice($words, 0, 20));
                                        $publishDate = \Morilog\Jalali\Jalalian::fromDateTime(
                                            $item->publish_at,
                                        )->format('H:i Y/m/d');
                                        $shortUrl = route('home'); // Assuming a route to view the post
                                    @endphp

                                    <div class="khabar-text-box" id="khabar-{{ $item->id }}">
                                        <div class="short-text">{{ $item->short ?? $shortText }}...</div>
                                        <div class="khabar-meta align-items-center">
                                            <a href="{{ route('news') }}" class="btn btn-primary px-3">بیشتر
                                                بخوانید</a>
                                            <div>
                                                <span class="views mx-2"><i class="bi bi-eye"></i>
                                                    {{ $item->views_count }}
                                                    بازدید</span>
                                                <span class="mx-2"><i class="bi bi-heart"></i> 250</span>
                                                <span class="date mx-2"><i class="bi bi-clock"></i>
                                                    {{ $publishDate }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            let splideInstance = null;

                                            $('.image-link').click(function() {
                                                // alert('ok');
                                                // دریافت ایندکس عکس کلیک شده
                                                const index = $('.image-link').index($(this));
                                                // alert(index);

                                                // نمایش مودال
                                                const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
                                                imageModal.show();
                                                // alert('ok');

                                                // مقداردهی اولیه Splide (فقط یک بار)
                                                if (!splideInstance) {
                                                    // alert('ok');

                                                    splideInstance = new Splide('#gallerySplide', {
                                                        type: 'slide',
                                                        perPage: 1,
                                                        perMove: 1,
                                                        arrows: true,
                                                        pagination: true,
                                                        direction: 'rtl',
                                                        breakpoints: {
                                                            768: {
                                                                arrows: false
                                                            }
                                                        }
                                                    }).mount();

                                                } else {

                                                    // اگر از قبل وجود داشت، به عکس کلیک شده برو
                                                    splideInstance.go(index);

                                                }
                                            });

                                            // وقتی مودال بسته شد، Splide را از بین ببریم
                                            $('#imageModal').on('hidden.bs.modal', function() {
                                                if (splideInstance) {
                                                    splideInstance.destroy();
                                                    splideInstance = null;
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="splide" id="gallerySplide">
                                                <div class="splide__track">
                                                    <ul class="splide__list">
                                                        @foreach ($item->images as $images)
                                                            <li class="splide__slide">
                                                                <img src="{{ asset($images->image_path) }}"
                                                                    alt="تصویر خبر {{ $item->title }}"
                                                                    class="img-fluid rounded">
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">بستن</button>
                                        </div>
                                    </div>
                                </div>
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
                {{-- <div class="text-start">
                    <a href="{{ route('news') }}" class="btn btn-archive">مشاهده آرشیو</a>
                </div> --}}
                {{-- pagination --}}
            </div>
            <nav id="paginationControls" class="d-flex justify-items-center justify-content-between">
                <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-center">
                    <div>
                        <ul class="pagination justify-content-center">

                        </ul>
                    </div>
                </div>
            </nav>

        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const newsContainer = document.getElementById('newsContainer');
                const paginationControls = document.getElementById('paginationControls');
                const allNewsItems = Array.from(document.querySelectorAll('.news-item'));
                const itemsPerPage = 4; // تعداد اخبار در هر صفحه
                let currentPage = 1;

                // تابع برای نمایش اخبار صفحه جاری
                function showPage(page) {
                    // مخفی کردن همه اخبار
                    allNewsItems.forEach(item => {
                        item.style.display = 'none';
                    });

                    // محاسبه محدوده اخبار برای صفحه جاری
                    const startIndex = (page - 1) * itemsPerPage;
                    const endIndex = startIndex + itemsPerPage;

                    // نمایش اخبار صفحه جاری
                    for (let i = startIndex; i < endIndex && i < allNewsItems.length; i++) {
                        allNewsItems[i].style.display = 'block';
                    }

                    // به روزرسانی پیجینیشن
                    updatePaginationControls();

                    // اسکرول به بالای صفحه
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }

                // تابع برای ایجاد کنترل‌های صفحه‌بندی
                function updatePaginationControls() {
                    const totalPages = Math.ceil(allNewsItems.length / itemsPerPage);
                    let paginationHTML = ``;

                    // دکمه قبلی
                    if (currentPage > 1) {
                        paginationHTML += `
                        <li class="page-item">
                            <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">قبلی</a>
                        </li>`;
                    } else {
                        paginationHTML += `
                        <li class="page-item">
                            <a class="page-link">قبلی</a>
                        </li>`;
                    }

                    // لینک‌های صفحات
                    for (let i = 1; i <= totalPages; i++) {
                        if (i === currentPage) {
                            paginationHTML += `
                    <li class="page-item active">
                        <a class="page-link" href="#">${i}</a>
                    </li>`;
                        } else {
                            paginationHTML += `
                    <li class="page-item">
                        <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                    </li>`;
                        }
                    }

                    // دکمه بعدی
                    if (currentPage < totalPages) {
                        paginationHTML += `
                <li class="page-item">
                    <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">بعدی</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="{{ route('news') }}">آرشیو اخبار</a>
                </li>`;
                    } else {
                        paginationHTML += `
                        <li class="page-item">
                            <a class="page-link">بعدی</a>
                        </li>
                        <li class="page-item">
                    <a class="page-link" href="{{ route('news') }}">آرشیو اخبار</a>
                </li>`;
                    }

                    paginationControls.querySelector('ul').innerHTML = paginationHTML;
                }

                // تابع تغییر صفحه (در scope سراسری)
                window.changePage = function(page) {
                    currentPage = page;
                    showPage(currentPage);
                    return false; // جلوگیری از رفتار پیش‌فرض لینک
                };

                // مقداردهی اولیه
                showPage(currentPage);
            });
        </script>
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
                    // alert(endDateStr);
                    // alert(endDate);
                    // alert(now);

                    if (timeLeft > 0) {
                        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                        $(this).find('.days').html(pad(days) +
                            '<span class="d-block text-dark">روز</span>');
                        $(this).find('.hours').html(pad(hours) +
                            '<span class="d-block text-dark">ساعت</span>');
                        $(this).find('.minutes').html(pad(minutes) +
                            '<span class="d-block text-dark">دقیقه</span>');
                        $(this).find('.seconds').html(pad(seconds) +
                            '<span class="d-block text-dark">ثانیه</span>');

                    } else {
                        $(this).html('<p>زمان این دوره به پایان رسیده است.</p>');
                    }
                });

                function pad(num) {
                    return num < 10 ? '0' + num : num;
                }
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
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const playButton = document.getElementById('btn-play');
            const video = document.getElementById('video-player');
            const previewImage = document.getElementById('video-cover');
            const btnPlayContainer = document.getElementById('btn-play-container');
            const stopButton = document.getElementById('btn-stop');

            let isPlaying = false;
            const videoSrc = '/public/vid/1.mp4'; // مسیر ویدیو

            // دکمه Play وسط
            playButton.addEventListener('click', function(e) {
                e.stopPropagation();

                if (!isPlaying) {
                    if (video.src === '') {
                        video.src = videoSrc;
                    }
                    previewImage.classList.add('d-none');
                    video.classList.remove('d-none');
                    video.play();
                    btnPlayContainer.classList.add('d-none');
                    isPlaying = true;
                } else {
                    video.pause();
                    btnPlayContainer.classList.remove('d-none');
                    isPlaying = false;
                }
            });

            // کلیک روی خود ویدیو
            video.addEventListener('click', function() {
                if (isPlaying) {
                    video.pause();
                    btnPlayContainer.classList.remove('d-none');
                    isPlaying = false;
                } else {
                    video.play();
                    btnPlayContainer.classList.add('d-none');
                    isPlaying = true;
                }
            });

            // دکمه Stop که فقط با هاور ظاهر می‌شود
            stopButton.addEventListener('click', function(e) {
                e.stopPropagation();
                if (isPlaying) {
                    video.pause();
                    btnPlayContainer.classList.remove('d-none');
                    isPlaying = false;
                } else {
                    video.play();
                    btnPlayContainer.classList.add('d-none');
                    isPlaying = true;
                }
            });

            // وقتی ویدیو تمام شد → دکمه Play نمایش داده شود
            video.addEventListener('ended', function() {
                isPlaying = false;
                btnPlayContainer.classList.remove('d-none');
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Splide('#modal-slider', {
                type: 'slide',
                perPage: 1,
                pagination: true,
                arrows: false,
                rewind: true,
                height: '400px',
                cover: true,
                autoplay: true,
            }).mount();
        });
    </script>

    <script>
document.addEventListener("DOMContentLoaded", function () {
        const lat = 31.879293;
        const lng = 54.373840;

        const map = L.map('map').setView([lat, lng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        L.marker([lat, lng]).addTo(map)
            .bindPopup('مکان آموزشگاه')
            .openPopup();
});
</script>

</body>

</html>
