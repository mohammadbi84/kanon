<!doctype html>
<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <title>کانون</title>


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

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        .btn-news {
            position: fixed;
            top: 50%;
            transform: translateY(-50%);
            height: 118px;
            width: 31px;
            text-align: center;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to bottom, #ececec, #ececec);
            color: black;
            font-weight: bold;
            text-decoration: none;
            border-top-left-radius: 60px;
            border-bottom-left-radius: 60px;
            transition: background 0.4s ease-in-out, transform 0.4s ease-in-out;
        }

        .btn-news:hover {
            background: linear-gradient(to bottom, #e8e8e8, #e8e8e8);
            transform: translateY(-50%) scale(1.05);
        }

        .btn-news span {
            writing-mode: vertical-rl;
            text-align: center;
            text-orientation: mixed;
            rotate: 180deg;
        }
    </style>
    <style>
        /* دکمه با پس‌زمینه نقشه جاده‌ای */
        #show-map-button {
            padding: 15px 30px;
            background-image: url('https://tile.openstreetmap.org/0/0/0.png'); /* تصویر از OpenStreetMap */
            background-repeat: no-repeat;
            background-size: cover;
            border: none;
            cursor: pointer;
            color: transparent;
            font-size: 0;
            /* width: 200px;
            height: 60px; */
            border-radius: 8px;
            text-align: center;
            transition: 0.3s ease;
            position: relative;
            display: flex;
            align-items: center; /* عمودی وسط */
            justify-content: center; /* افقی وسط */
        }

        /* متن روی دکمه */
        #show-map-button span {
            color: var(--primary-color);
            font-size: 16px;
            font-weight: bold;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
        }
        #map {
    display: none;
    position: absolute;
    top: -200px;
    width: 90%;
    max-width: 400px;
    height: 200px;
    left: 5vw;
    outline-style: none;
}

/* برای نمایش در صفحات کوچک‌تر از 768px */
@media (max-width: 768px) {
    #map {
        width: 95%;
        height: 150px; /* کاهش ارتفاع برای صفحه‌های کوچک‌تر */
        top: -150px; /* تغییر موقعیت برای صفحه‌های کوچک */
    }
}

/* برای نمایش در صفحات کوچک‌تر از 480px (موبایل‌ها) */
@media (max-width: 480px) {
    #map {
        width: 100%;
        height: 120px; /* کاهش بیشتر ارتفاع */
        top: -100px; /* تنظیم موقعیت مناسب */
    }
}


        .form-container {
            margin: 20px;
        }
    </style>
    <script src="{{ asset('site/src/js/init.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" rel="stylesheet">

</head>

<body>
    @if ($adv)
        @php
            $start_date = \Carbon\Carbon::parse($adv->start_date);
            $end_date = \Carbon\Carbon::parse($adv->end_date);
            $current_date = \Carbon\Carbon::now();
            $animationClass = $adv->animation_type ? 'animate__animated ' . $adv->animation_type : '';
        @endphp
        {{-- @if ($current_date->between($start_date, $end_date)) --}}
        <div id="top-bar" style="
                                width: 100%;
                                min-height: var(--top-bar-height);
                                position: sticky;
                                top: 0;
                                z-index: 2000;
                                padding-top: var(--top-bar-height);
                                background-color: {{ $adv->background_color ?? 'var(--top-bar-color)' }};
                                color: {{ $adv->text_color ?? '#000' }};">
            <div class="top-ad-container" style="background-image: url('{{ asset($adv->background_image) }}');">
                <span class="text {{ $animationClass }}">
                    <span class="mx-3">اطلاعیه!</span>
                    {{ $adv->text }}
                </span>
                @if($adv->page_link)
                    <a href="{{ $adv->page_link }}" class="btn-link">مطالعه بیشتر</a>
                @endif
                <button class="btn-close" onclick="this.parentElement.parentElement.style.display='none'">×</button>
            </div>
        </div>
        {{-- @endif --}}
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
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
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
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    دوره ها
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#special-offers">پیشنهاد ویژه</a></li>
                                    <li><a class="dropdown-item" href="#courses">جدیدترین ها</a></li>
                                </ul>
                            </li>

                            <li class="nav-item btn-group">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
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
                        <div class="d-flex gap-2 align-items-stretch justify-content-center">
                            <a href="#search-bar" class="btn btn-icon"><span class="bi bi-search"></span></a>
                            <a href="#" class="btn btn-icon"><span class="bi bi-basket"></span></a>
                            <div style="background-color: #9DCCFF4D; border-radius: var(--raduis); padding: 4px;">
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
                            <div class="video h-100">
                                <img src="{{ asset($slider->image) }}" class="img" alt="">
                                <div class="btn-play-container">
                                    <button class="btn-play" onclick="openVideoPopup('/public/vid/1.mp4')">
                                        <span class="bi bi-play-fill"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="text-container">
                                <span>{{ $slider->name }}</span>
                                <a href="#" class="btn btn-primary">مشاهده جزئیات خبر</a>
                            </div>
                        </div>
                    @else
                        <div class="item">
                            <img src="{{ asset($slider->image) }}" class="img" alt="">
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="container top-slider-thumbs-container">
                <div class="top-slider-thumbs">
                    <div class="title">
                        <span class="text text-bold-1">پست های ترند</span>
                        <div>
                            <button class="nav-btn prev">
                                < </button>
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
                                    <svg fill="#ffffffb2" width="20px" height="20px" viewBox="0 0 24 24" id="Layer_1"
                                        data-name="Layer 1" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12,6a.99974.99974,0,0,0-1,1v4H9a1,1,0,0,0,0,2h3a.99974.99974,0,0,0,1-1V7A.99974.99974,0,0,0,12,6Zm0-4A10,10,0,1,0,22,12,10.01146,10.01146,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8.00917,8.00917,0,0,1,12,20Z" />
                                    </svg>
                                    {{$slider['time']}}</span>

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div id="search-bar">
                <form action="/schools" method="get" class="search-bar text-bold-2 bg-blue">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <input type="text" name="name" id="name" placeholder="نام آموزشگاه" class="form-control">
                        </div>
            
                        <div class="col">
                            <select name="state" id="state" class="form-select">
                                <option value="" selected>شهرستان</option>
                                @foreach ($states as $item)
                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                @endforeach
                            </select>
                        </div>
            
                        <div class="col">
                            <select name="group" id="group" class="form-select">
                                <option value="" selected>گروه آموزشی</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <select name="herfe" id="herfe" class="form-select">
                                <option value="" selected>حرفه</option>
                                @foreach ($herfes as $herfe)
                                    <option value="{{ $herfe->id }}">{{ $herfe->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary d-block w-100">جستجوی آموزشگاه</button>
                        </div>
                        <div class="col">
                            <button type="button" id="show-map-button">
                                <span>نمایش از روی نقشه</span>
                            </button>
            
                            <!-- نمایش نقشه -->
                            <div id="map" style="display: none;position: absolute;top: -200px;width: 400px;height: 200px;left: 100px;outline-style: none;"></div>
            
                            <!-- ارسال مختصات بعد از انتخاب مکان -->
                            <input type="hidden" name="lat" id="lat">
                            <input type="hidden" name="lng" id="lng">
                        </div>
                    </div>
                </form>
            </div>
            
            <script>
                var map;
                var marker;
        
                // ساخت نقشه و مشخص کردن موقعیت اولیه (یزد)
                function initMap() {
                    map = L.map('map').setView([31.8974, 54.3677], 13); // موقعیت اولیه (یزد)
        
                    // استفاده از OpenStreetMap برای لایه نقشه
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);
        
                    // اضافه کردن مارکر اولیه به نقشه
                    marker = L.marker([31.8974, 54.3677]).addTo(map)
                        .bindPopup("یزد")
                        .openPopup();
        
                    // افزودن قابلیت انتخاب مکان روی نقشه
                    map.on('click', function(e) {
                        var lat = e.latlng.lat;
                        var lng = e.latlng.lng;
        
                        // جابجایی مارکر به مکان جدید
                        marker.setLatLng([lat, lng]);
        
                        // به روزرسانی مختصات در ورودی‌های مخفی
                        document.getElementById('lat').value = lat;
                        document.getElementById('lng').value = lng;
                    });
                }
        
                // نمایش/مخفی کردن نقشه با هر بار کلیک روی دکمه
                document.getElementById('show-map-button').addEventListener('click', function(event) {
                    event.preventDefault(); // جلوگیری از ارسال فرم
                    
                    // پیدا کردن نقشه
                    var mapElement = document.getElementById('map');
                    
                    // تغییر نمایش نقشه
                    if (mapElement.style.display === 'none' || mapElement.style.display === '') {
                        mapElement.style.display = 'block'; // نمایش نقشه
                        initMap(); // بارگذاری نقشه اگر هنوز بارگذاری نشده باشد
                    } else {
                        mapElement.style.display = 'none'; // مخفی کردن نقشه
                    }
                });
            </script>
            <div id="events-slider" class="splide">
                <div class="section-title-container">
                    <div class="section-title">
                        <img src="{{ asset('site/public/icon/vertical-line.svg') }}" aria-hidden="true"
                            class="vertical-line" alt="">
                        <span class="title">آموزشگاه های پر طرفدار</span>
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
                                            <img src="{{ asset('site/public/icon/vertical-line.svg') }}" alt="event image">
                                        @else
                                            <img src="{{ asset($organ->file_logo) }}" alt="event image">
                                        @endif
                                    </div>

                                    <div class="details">
                                        <div class="top">
                                            <div class="d-flex align-items-center gap-1">
                                                <span class="bi bi-grid text-primary"></span>
                                                <span class="text-small-1">{{$organ->ostan->title}}</span>
                                            </div>

                                            <div class="d-flex align-items-center gap-1">
                                                <span class="text-small-1">{{$organ->tel}}</span>
                                                <span class="bi bi-telephone text-primary"></span>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <h3 class="text-title-3">{{$organ->name}}</h3>
                                            <p class="text-justify text-normal"></p>
                                        </div>

                                        <div class="bottom mt-4">
                                            <div class="d-inline-flex align-items-center gap-2">
                                                @if (is_null($organ->file_logo))
                                                    <img src="{{ asset('site/public/img/noPhoto.jpg') }}" alt="user pic"
                                                        class="user-pic">
                                                @else
                                                    <img src="{{ asset($organ->file_moases) }}" alt="user pic" class="user-pic">
                                                @endif

                                                <span class="text-title-4">{{$organ['moases']}}</span>
                                            </div>

                                            {{-- <div>
                                                <span class="text-primary text-bold-2">8000 تومان</span>
                                            </div> --}}
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
                <div class="row m-0" style="background: linear-gradient(270deg, #EE295F 0%, #9033C2 100%);
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
                        <span class="title">جدیدترین اخبار</span>
                    </div>
                </div>
                <div class="row row-gap-3">
                    @foreach ($HotNews as $item)
                        <div class="col-md-6">
                            <a href="{{route('new', ['id' => $item->id])}}" class="text-reset">
                                <div class="row anno-card">
                                    <div class="col-6 details">
                                        <p class="text-title-3 text-bold-2 text-blue">{{$item->title}}</p>
                                        <p>{{$item->text}}</p>
                                    </div>
                                    <div class="col-6 img">
                                        <img src="{{ asset($item->image) }}" alt="{{$item->title}}" class="w-100 h-100"
                                            style="max-height: 200px;">
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4" style="text-align: end">
                    <a href="/news" class="btn btn-primary">
                        <span>مشاهده بیشتر</span>
                        <span class="bi bi-arrow-left pe-2"></span>
                    </a>
                </div>
            </div>

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
                        <span class="title">رشته ها و حرفه های ارائه شده</span>
                    </div>

                    <div class="section-options">
                    </div>
                </div>

                <div class="row row-gap-4 mx-0 fix-shadow-margin"
                    style="margin-left: -10px !important; margin-right: -10px !important">
                    @foreach ($herfeha as $item)
                        <div class="col-md-4">
                            <div class="advantage-card">
                                <p class="title text-title-3 text-bold-2">{{$item->name}}</p>
                                <p class="text mb-0 text-normal">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ،
                                    و با
                                    استفاده از
                                    طراحان گرافیک است،
                                    چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی
                                    تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.</p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <div id="special-offers" class="splide mt-5">
                <div class="section-title-container">
                    <div class="section-title">
                        <img src="{{asset('site/public/icon/vertical-line.svg')}}" aria-hidden="true"
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
                                <a href="{{route('course', ['id' => $course->id])}}" class="text-reset">
                                    <div class="row offer-card m-0">
                                        <div class="col-5 p-3 text-center">
                                            <p class="title text-title-2 text-bold-2">دوره آموزشی {{$course->name}}</p>

                                            <p class="text mb-0">{{$course->description}}</p>
                                            <div class="row m-0 mt-4 px-4" dir="ltr" id="timer">
                                                <div class="col-3 timer-col">
                                                    <span class="timer-number">{{$course->hour}}</span>
                                                    <span class="timer-text">ساعت</span>
                                                </div>
                                                <div class="col-3 timer-col">
                                                    <span class="timer-number">{{$course->hour / 2}}</span>
                                                    <span class="timer-text">جلسه</span>
                                                </div>
                                                <div class="col-3 timer-col">
                                                    <span class="timer-number">3</span>
                                                    <span class="timer-text">روز در هفته</span>
                                                </div>
                                                <div class="col-3 timer-col">
                                                    <span class="timer-number">{{$course->hour}}</span>
                                                    <span class="timer-text">دانشجو</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-7 p-0 position-relative">
                                            <img src="{{asset($course->image)}}" class="w-100 h-100" alt="{{$course->name}}"
                                                style="max-height:420px">
                                            <span class="school-name text-title-2 text-bold-2">آموزشکده فاضل</span>
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
                    <div class="row m-0" style="background: linear-gradient(270deg, #3376C4 0%, #2AC3EF 100%);
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
                            <input type="text" name="mobile" id="mobile-for-newsletter" class="text-title-3 text-bold-2"
                                placeholder="شماره تماس خود را وارد کنید" style="
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
                                        <p class="mb-0 text-title-2 text-bold-3 text-blue">{{$item->name}}</p>
                                        <p class="mb-0">{{$item->description}}</p>
                                        <p class="text-start mb-0 mt-2">{{number_format($item->price / 10)}} تومان</p>
                                    </div>
                                    <div class="d-flex flex-column gap-2 align-items-center justify-content-center me-5">
                                        {{-- <a href="#" class="btn btn-icon"><span class="bi bi-floppy"></span></a> --}}
                                        <a href="{{route('course', ['id' => $item->id])}}" class="btn btn-icon"><span
                                                class="bi bi-eye"></span></a>
                                        <a href="#" class="btn btn-icon"><span class="bi bi-cart-plus"></span></a>
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
                                        <img src="{{ asset('site/public/img/enamad.png') }}" alt="" class="w-100">
                                    </a>
                                </div>

                                <div class="col crd crd-shadow crd-pad">
                                    <a href="#">
                                        <img src="{{ asset('site/public/img/enamad.png') }}" alt="" class="w-100">
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

    <a href="#" id="btn-news" class="btn-news">
        <span>اخبار</span>
    </a>

    <!--endregion: news button -->


    <!--region: wave overlay-->
    <div class="overlay-container">

        <div class="svg-container">
            <svg width="100%" height="100%" id="svg" viewBox="0 0 1440 690" xmlns="http://www.w3.org/2000/svg">
                <path d="" stroke="none" stroke-width="0" fill="var(--overlay-1-back-color)" fill-opacity="1"
                    class="path" transform="rotate(-180 720 350)">
                </path>
            </svg>
        </div>

        <div class="svg-container">
            <svg width="100%" height="100%" id="svg" viewBox="0 0 1440 690" xmlns="http://www.w3.org/2000/svg">
                <path d="" stroke="none" stroke-width="0" fill="var(--overlay-2-back-color)" fill-opacity="1"
                    class="path" transform="rotate(-180 720 350)">
                </path>
            </svg>
        </div>

        <div class="svg-container">
            <svg width="100%" height="100%" id="svg" viewBox="0 0 1440 690" xmlns="http://www.w3.org/2000/svg">
                <path d="" stroke="none" stroke-width="0" fill="var(--overlay-3-back-color)" fill-opacity="1"
                    class="path" transform="rotate(-180 720 350)">
                </path>
            </svg>
        </div>


        <div class="items-panel" style="z-index: 1000;">
            <button class="btn btn-close"></button>
            @foreach ($news as $item)
                <a href="{{route('new', ['id' => $item->id])}}">
                    <p class="bg-light rounded-5 p-5 btn btn-light w-100"> {{ $item->text }} </p>

                </a>
            @endforeach
        </div>

    </div>
    <!--endregion: wave overlay-->

</body>

</html>