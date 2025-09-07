<!doctype html>
<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <title> لیست دوره ها</title>

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
        <div class="container mb-5">
            <div id="courses" style="margin-top: 180px">
                <div class="section-title-container">
                    <div class="section-title">
                        <img src="{{ asset('site/public/icon/vertical-line.svg') }}" aria-hidden="true"
                            class="vertical-line" alt="">
                        <span class="title">لیست دوره ها</span>
                    </div>
                    <div class="section-options">
                    </div>
                </div>

                <div class="row row-gap-3">
                    @foreach ($courses as $item)
                        <div class="col-md-6 mt-3">
                            <div class="row course-card m-0">
                                <div class="col-4 p-0 img">
                                    <img src="{{ asset($item->image) }}" alt="" class="w-100 h-100">
                                </div>
                                <div class="col-8 d-flex justify-content-between details gap-3">
                                    <div>
                                        <p class="mb-3 text-title-2 text-bold-3 text-blue">{{$item->name}}</p>
                                        <p class="mb-3">{{$item->description}}</p>
                                        <p class="text-start mb-0 mt-5">{{number_format($item->price / 10)}} تومان</p>
                                    </div>
                                    <div class="d-flex flex-column gap-2 align-items-center justify-content-center me-5">
                                        <a href="#" class="btn btn-icon"><span class="bi bi-floppy"></span></a>
                                        <a href="{{route('course',['id'=>$item->id])}}" class="btn btn-icon"><span class="bi bi-eye"></span></a>
                                        <a href="#" class="btn btn-icon"><span class="bi bi-cart-plus"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
