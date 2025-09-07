<!doctype html>
<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <title>آموزشگاه {{ $school->name }}</title>


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


    <script src="{{ asset('site/src/js/init.js') }}"></script>

</head>

<body>
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
                                    وبلاگ ها
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">آیتم 1</a></li>
                                    <li><a class="dropdown-item" href="#">آیتم 2</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">آیتم 3</a></li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#footer">درباره ما</a>
                            </li>
                        </ul>
                        <div class="d-flex gap-2 align-items-stretch justify-content-center">
                            <a href="#" class="btn btn-icon"><span class="bi bi-search"></span></a>
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
    </header>

    <main>
        <div class="container mt-5">
            <div class="row" style="margin-top: 200px">
                <div class="col-md-12">
                    <div class="card shadow-lg rounded">
                        <div class="card-header bg-primary text-white text-center">
                            @if ($school->file_logo)
                                <img src="{{ asset( $school->file_logo) }}" alt="لوگوی آموزشگاه" class="img-fluid rounded mb-3" style="max-height: 120px;">
                            @endif
                            <h4>{{ $school->name }} - مشخصات آموزشگاه</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>اطلاعات کلی</h5>
                                    <ul class="list-group">
                                        <li class="list-group-item"><strong>نوع:</strong>
                                            {{ $school->type == 1 ? 'سنف' : 'آموزشگاه' }}</li>
                                        <li class="list-group-item"><strong>تلفن:</strong> {{ $school->tel }}</li>
                                        <li class="list-group-item"><strong>موبایل:</strong> {{ $school->mobile }}</li>
                                        <li class="list-group-item"><strong>آدرس:</strong>
                                            {{ $school->address ?? 'آدرس موجود نیست' }}</li>
                                        <li class="list-group-item"><strong>ایمیل:</strong>
                                            {{ $school->email ?? 'ایمیل موجود نیست' }}</li>
                                        <li class="list-group-item"><strong>سایت:</strong> <a
                                                href="{{ $school->site ?? '#' }}"
                                                target="_blank">{{ $school->site ?? 'سایت موجود نیست' }}</a></li>
                                    </ul>
                                </div>
    
                                <div class="col-md-6">
                                    <h5>اطلاعات اضافی</h5>
                                    <ul class="list-group">
                                        <li class="list-group-item"><strong>کد پستی:</strong> {{ $school->postal }}</li>
                                        @if($school->baradaran == 1)
                                            <li class="list-group-item"><strong>برادران:</strong> بله
                                            </li>
                                        @else
                                            <li class="list-group-item"><strong>برادران:</strong> خیر
                                            </li>
                                        @endif
    
                                        @if($school->khaharan == 1)
                                            <li class="list-group-item"><strong>خواهران:</strong> بله
                                            </li>
                                        @else
                                            <li class="list-group-item"><strong>خواهران:</strong> خیر
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
    
                            <hr>
                            <h5 id="#mapto">موقعیت مکانی</h5>
                            <div id="map" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <br>
    
    <!-- بارگذاری فایل‌های CSS و JS برای Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    
    <script>
        // تابع برای نمایش نقشه
        function initMap() {
            // اگر مختصات موجود نیست، مختصات کاشانی (مشهد) را به جای آن‌ها قرار می‌دهیم
            var lat = '{{ $school->lat }}' ? parseFloat('{{ $school->lat }}') : 31.879149757604807; // عرض جغرافیایی کاشانی
            var lng = '{{ $school->lang }}' ? parseFloat('{{ $school->lang }}') : 54.373513673179474; // طول جغرافیایی کاشانی
    
            var schoolLocation = [lat, lng];
    
            // ساخت نقشه با موقعیت اولیه و بزرگ‌نمایی 14
            var map = L.map('map').setView(schoolLocation, 14);
    
            // اضافه کردن TileLayer به نقشه (نقشه پیش‌فرض OpenStreetMap)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
    
            // اضافه کردن نشانگر (Marker) در موقعیت آموزشگاه
            L.marker(schoolLocation).addTo(map)
                .bindPopup('<b>{{ $school->name }}</b><br>{{ $school->address ?? "آدرس موجود نیست" }}')
                .openPopup();
        }
    
        // فراخوانی تابع برای نمایش نقشه
        initMap();
    </script>
    
    

    <footer id="footer">
        <div class="crd crd-shadow" style="border-bottom-left-radius: 0; border-bottom-right-radius: 0">
            <div class="container px-0">
                <div class="row align-items-stretch mx-0 gx-5 py-3 fix-shadow-margin">
                    <div class="col-md-4 p-3 align-content-center">
                        <div class="crd crd-shadow crd-pad">
                            <p class="text-title-2 text-bold-2 text-blue">لوگو کانون آموزش</p>
                            <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و
                                با استفاده از طراحان
                                گرافیک
                                است.</p>
                            <div class="text-end">
                                <a href="#" class="btn btn-text">
                                    <span class="text-bold-3">مشاهده بیشتر</span>
                                    <span class="bi bi-arrow-left pe-2 text-bold-2"></span>
                                </a>
                            </div>

                            <hr style="background-color: black; height: 2px; opacity: 1; margin: 20px 0">

                            <div class="row mt-2">
                                <div class="col">
                                    <a href="#" class="btn btn-text w-100 text-bold-2">فروشگاه ها</a>
                                </div>
                                <div class="col">
                                    <a href="#" class="btn btn-text w-100 text-bold-2">جذب مدرس</a>
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

                            <div class="row mt-3">
                                <div class="col">
                                    <a href="#" class="btn btn-primary w-100 text-bold-2">ارسال تیکت</a>
                                </div>
                                <div class="col">
                                    <a href="#" class="btn btn-primary w-100 text-bold-2">عضویت در خبرنامه</a>
                                </div>
                            </div>
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
    <a href="#" id="btn-news" class="btn btn-light" style="
    position:fixed;
    top: 50%;
    transform: translateY(-50%);
    background: url({{ asset('site/public/img/back-btn-news.png') }}) round;
    height: 118px;
    width: 31px;
    text-align: center;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
">
        <span style="
        writing-mode: vertical-rl;
        text-align: center;
        text-orientation: mixed;
        rotate: 180deg;
    ">اخبار</span>
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
            {{-- @foreach ($news as $item)
            <p class="bg-light rounded-5 p-5 btn btn-light w-100"> {{ $item->text }} </p>
            @endforeach --}}
        </div>

    </div>
    <!--endregion: wave overlay-->

</body>

</html>