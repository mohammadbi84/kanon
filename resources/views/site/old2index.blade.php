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
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>

    <!--icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"/>
    <!-- BOOTSTRAP 5 -->


    <!-- SLIDER LIBRARY (tiny slider) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>
    <!-- SLIDER LIBRARY (tiny slider) -->


    <!-- SLIDER LIBRARY (Splide) -->
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
    <!-- SLIDER LIBRARY (Splide) -->


    <link rel="stylesheet" href="{{asset('site/src/style/styles.css')}}">
    <script src="{{asset('site/src/js/utils.js')}}"></script>

    <!-- main menu -->
    <link rel="stylesheet" href="{{asset('site/src/style/main-menu.css')}}">
    <script src="{{asset('site/src/js/main-menu.js')}}"></script>
    <!-- main menu -->

    <!-- top slider -->
    <link rel="stylesheet" href="{{asset('site/src/style/top-slider.css')}}">
    <script src="{{asset('site/src/js/top-slider.js')}}"></script>
    <!-- top slider -->

    <!-- top ad -->
    <link rel="stylesheet" href="{{asset('site/src/style/top-ad.css')}}">
    <script src="{{asset('site/src/js/top-ad.js')}}"></script>
    <!-- top ad -->

    <!-- video popup -->
    <link rel="stylesheet" href="{{asset('site/src/style/video-popup.css')}}">
    <script src="{{asset('site/src/js/video-popup.js')}}"></script>
    <!-- video popup -->

    <!-- forms -->
    <link rel="stylesheet" href="{{asset('site/src/style/forms.css')}}">
    <!-- forms -->

    <!-- btn-play with pulse -->
    <link rel="stylesheet" href="{{asset('site/src/style/btn-play-pulse.css')}}">
    <!-- btn-play with pulse -->

    <!-- btn support -->
    <link rel="stylesheet" href="{{asset('site/src/style/btn-support.css')}}">
    <script src="{{asset('site/src/js/btn-support.js')}}"></script>
    <!-- btn go-to-top -->

    <!-- btn go-to-top -->
    <link rel="stylesheet" href="{{asset('site/src/style/btn-go-to-top.css')}}">
    <script src="{{asset('site/src/js/btn-go-to-top.js')}}"></script>
    <!-- btn go-to-top -->

    <!-- switch element -->
    <link rel="stylesheet" href="{{asset('site/src/style/switch.css')}}">
    <!-- switch element -->


    <script src="{{asset('site/src/js/init.js')}}"></script>

</head>

<body>

<div id="top-bar" style="
     width: 100%;
     height: var(--top-bar-height);
     position: sticky;
     top: 0;
     z-index: 2000;
     background-color: var(--top-bar-color)
">
</div>


<header>
    @if($adv)

    <div class="top-ad-container">
        <span>{{$adv->text}}</span>
        <button class="btn-close"></button>
    </div>
    @endif


    <div class="main-menu">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="/">
                    <img src="{{asset('site/public/img/logo.png')}}" alt="website logo">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between ms-3" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">صفحه نخست</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                آموزشگاه ها
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">آیتم 1</a></li>
                                <li><a class="dropdown-item" href="#">آیتم 2</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">آیتم 3</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                دوره ها
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">آیتم 1</a></li>
                                <li><a class="dropdown-item" href="#">آیتم 2</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">آیتم 3</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                وبلاگ ها
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">آیتم 1</a></li>
                                <li><a class="dropdown-item" href="#">آیتم 2</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">آیتم 3</a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">درباره ما</a>
                        </li>
                    </ul>
                    <div class="d-flex gap-2 align-items-stretch justify-content-center">
                        <a href="#" class="btn btn-icon"><span class="bi bi-basket"></span></a>
                        <a href="#" class="btn btn-icon"><span class="bi bi-search"></span></a>
                        <div style="background-color: #9DCCFF4D; border-radius: var(--raduis); padding: 4px;">
                            <a href="#" class="btn btn-text">ورود</a>
                            <a href="#" class="btn btn-icon btn-primary">ثبت نام</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>


    <div class="top-slider-container">
        <div class="top-slider">
            @foreach($sliders as $slider)
                @if($slider -> video)
            <div class="item">
                <div class="video h-100">
                    <img src="{{asset($slider->image)}}" class="img" alt="">
                    <div class="btn-play-container">
                        <button class="btn-play" onclick="openVideoPopup('/public/vid/1.mp4')">
                            <span class="bi bi-play-fill"></span>
                        </button>
                    </div>
                </div>
            </div>
                @else

            <div class="item">
                <img src="{{asset($slider->image)}}" class="img" alt="">
            </div>
                @endif
            @endforeach

        </div>

        <div class="container position-absolute top-0 bottom-0 end-0 start-0">
            <div class="top-slider-thumbs">
                <div class="title">
                    <span class="text text-bold-1">پست های ترند</span>
                    <div>
                        <button class="nav-btn prev"><</button>
                        <button class="nav-btn next">></button>
                    </div>
                </div>
                @foreach($sliders as $key=>$slider)

                <div class="item" data-index="{{$key}}">
                    <img src="{{asset($slider->image)}}" class="img" alt="">
                    <div>
                        <span>{{$slider->name}}</span>
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
            <form action="#" method="get" class="search-bar text-bold-2 bg-blue">
                <div class="row">
                    <div class="col-2">
                        <input type="text" name="name" id="name" placeholder="نام آموزشگاه" class="form-control">
                    </div>

                    <div class="col-2">
                        <select name="city" id="city" class="form-select">
                            <option value="-1" selected>شهرستان</option>
                            <option value="1">یزد</option>
                            <option value="2">میبد</option>
                            <option value="3">اشکذر</option>
                        </select>
                    </div>

                    <div class="col-2">
                        <select name="group" id="group" class="form-select">
                            <option value="" selected>گروه آموزشی</option>
                            @foreach($groups as $group)
                                <option value="{{$group->id}}">{{$group->name}}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-2">
                        <select name="profession" id="profession" class="form-select">
                            <option value="" selected>حرفه</option>
                            @foreach($herfes as $herfe)
                                <option value="{{$herfe->id}}">{{$herfe->name}}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-2">
                        <button type="submit" class="btn btn-primary d-block w-100">جستجوی آموزشگاه</button>
                    </div>

                    <div class="col-2">
                        <a href="#" class="btn btn-outline-info d-block">نمایش از روی نقشه</a>
                    </div>
                </div>
            </form>
        </div>


        <div id="events-slider" class="splide">
            <div class="section-title-container">
                <div class="section-title">
                    <img src="{{asset('site/public/icon/vertical-line.svg')}}" aria-hidden="true" class="vertical-line" alt="">
                    <span class="title">آگهی های نردبان شده</span>
                </div>

                <div class="section-options" style="margin-inline-end: -6px;">
                    <button class="nav-btn prev"><</button>
                    <button class="nav-btn next">></button>
                </div>
            </div>

            <div class="splide__track fix-shadow-margin">
                <ul class="splide__list">
                    <li class="splide__slide">
                        <div class="event-card">
                            <div class="img">
                                <img src="{{asset('site/public/icon/vertical-line.svg')}}" alt="event image">
                            </div>

                            <div class="details">
                                <div class="top">
                                    <div class="d-flex align-items-center gap-1">
                                        <span class="bi bi-grid text-primary"></span>
                                        <span class="text-small-1">بازاریابی</span>
                                    </div>

                                    <div class="d-flex align-items-center gap-1">
                                        <span class="bi bi-clock text-primary"></span>
                                        <span class="text-small-1">180 دقیقه</span>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <h3 class="text-title-3">رویداد ملی کسب و کار</h3>
                                    <p class="text-justify text-normal">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از
                                        صنعت چاپ، و
                                        با استفاده از طراحان
                                        گرافیک
                                        است.</p>
                                </div>

                                <div class="bottom mt-4">
                                    <div class="d-inline-flex align-items-center gap-2">
                                        <img src="{{asset('site/public/img/2.png')}}" alt="user pic" class="user-pic">
                                        <span class="text-title-4">سرکار خانم عااااا</span>
                                    </div>

                                    <div>
                                        <span class="text-primary text-bold-2">8000 تومان</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
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
                    <p class="text-white text-center mb-0 text-bold-3">کلی مطلب آموزشی جالب در اینستاگرام کانون منتظر
                        شماست!!!</p>
                </div>

                <div class="col-2">
                    <a class="btn btn-light w-100 text-blue" href="#">اینجا کلیک کنید</a>
                </div>
            </div>

            <img src="{{asset('site/public/img/invite-instagram.png')}}" alt="" style="height: 160px; margin-top: -120px">
        </div>


        <div id="annos">
            <div class="section-title-container">
                <div class="section-title">
                    <img src="{{asset('site/public/icon/vertical-line.svg')}}" aria-hidden="true" class="vertical-line" alt="">
                    <span class="title">جدیدترین آگهی ها</span>
                </div>

                <div class="section-options">
                    <span class="text-bold-2 text-title-3">داغ ترین ها</span>

                    <label class="switch">
                        <input type="checkbox" name="hot-annos" id="hot-annos">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div class="row row-gap-3">
                <div class="col-md-6">
                    <div class="row anno-card">
                        <div class="col-6 details">
                            <p class="text-title-3 text-bold-2 text-blue">رویداد ملی کسب و کار</p>
                            <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک
                                است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است</p>

                            <div class="flex-center-between-space">
                                <div class="d-inline-flex align-items-center gap-2">
                                    <img src="{{asset('site/public/img/2.png')}}" alt="user pic" class="user-pic">
                                    <span class="text-small-1">سرکار خانم عااااا</span>
                                </div>

                                <div>
                                    <span class="text-primary text-small-1 text-bold-2">8000 تومان</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 img">
                            <img src="{{asset('site/public/img/1.png')}}" alt="" class="w-100 h-100">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4" style="text-align: end">
                <a href="#" class="btn btn-primary">
                    <span>مشاهده بیشتر</span>
                    <span class="bi bi-arrow-left pe-2"></span>
                </a>
            </div>
        </div>

    </div>

    <div class="container-fluid p-0 mt-5" id="full-width-video">
        <div class="video" style="height: 70vh">
            <img src="{{asset('site/public/img/1.png')}}" class="img" alt="">
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
                    <img src="{{asset('site/public/icon/vertical-line.svg')}}" aria-hidden="true" class="vertical-line" alt="">
                    <span class="title">مزایای گواهینامه های فنی و حرفه ای</span>
                </div>

                <div class="section-options">
                </div>
            </div>

            <div class="row row-gap-4 mx-0 fix-shadow-margin"
                 style="margin-left: -10px !important; margin-right: -10px !important">
                <div class="col-md-4">
                    <div class="advantage-card">
                        <p class="title text-title-3 text-bold-2">گواهی نامه ICDL</p>
                        <p class="text mb-0 text-normal">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با
                            استفاده از
                            طراحان گرافیک است،
                            چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی
                            تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.</p>
                    </div>
                </div>
            </div>
        </div>


        <div id="special-offers" class="splide mt-5">
            <div class="section-title-container">
                <div class="section-title">
                    <img src="{{asset('site/public/icon/vertical-line.svg')}}" aria-hidden="true" class="vertical-line" alt="">
                    <span class="title">پیشنهاد ویژه (دوره های آموزشی)</span>
                </div>

                <div class="section-options">
                </div>
            </div>


            <div class="splide__track fix-shadow-margin">
                <ul class="splide__list">
                    <li class="splide__slide">
                        <div class="row offer-card m-0">
                            <div class="col-5 p-3 text-center">
                                <p class="title text-title-2 text-bold-2">دوره آموزشی ICDL</p>

                                <p class="text mb-0">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با
                                    استفاده از
                                    طراحان گرافیک است،
                                    چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط
                                    فعلی
                                    تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.</p>

                                <div class="row m-0 mt-4 px-4" dir="ltr" id="timer">
                                    <div class="col-3 timer-col">
                                        <span class="timer-number">90</span>
                                        <span class="timer-text">روز</span>
                                    </div>

                                    <div class="col-3 timer-col">
                                        <span class="timer-number">12</span>
                                        <span class="timer-text">ساعت</span>
                                    </div>

                                    <div class="col-3 timer-col">
                                        <span class="timer-number">22</span>
                                        <span class="timer-text">دقیقه</span>
                                    </div>

                                    <div class="col-3 timer-col">
                                        <span class="timer-number">47</span>
                                        <span class="timer-text">ثانیه</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-7 p-0 position-relative">
                                <img src="{{asset('site/public/img/1.png')}}" class="w-100 h-100" alt="">
                                <span class="school-name text-title-2 text-bold-2">آموزشکده فاضل</span>
                            </div>
                        </div>
                    </li>
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
                        <button type="submit" class="btn btn-primary w-100 text-bold-2" href="#" style="padding: 20px">
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
                            opacity: 1; /* Firefox */
                        }

                        #mobile-for-newsletter ::-ms-input-placeholder { /* Edge 12 -18 */
                            color: white;
                        }
                    </style>

                    <div class="col-2">
                        <!-- empty for image place -->
                    </div>
                </div>
            </form>

            <div style="text-align: end">
                <img src="{{asset('site/public/img/invite-newsletter.png')}}" alt=""
                     style="height: 160px; margin-top: -130px; transform: scale(1.2)">
            </div>
        </div>


        <div id="courses">
            <div class="section-title-container">
                <div class="section-title">
                    <img src="{{asset('site/public/icon/vertical-line.svg')}}" aria-hidden="true" class="vertical-line" alt="">
                    <span class="title">جدیدترین دوره های آموزشی</span>
                </div>

                <div class="section-options">
                </div>
            </div>

            <div class="row row-gap-3">
                <div class="col-md-6 mt-3">
                    <div class="row course-card m-0">
                        <div class="col-4 p-0 img">
                            <img src="{{asset('site/public/img/1.png')}}" alt="" class="w-100 h-100">
                        </div>

                        <div class="col-8 d-flex details gap-3">
                            <div>
                                <p class="mb-0 text-title-2 text-bold-3 text-blue">رویداد ملی کسب و کار</p>
                                <p class="mb-0">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و
                                    با استفاده از طراحان
                                    گرافیک
                                    است.</p>
                                <p class="text-end mb-0 mt-2">300,000 تومان</p>
                            </div>
                            <div class="d-flex flex-column gap-2 align-items-center justify-content-center">
                                <a href="#" class="btn btn-icon"><span class="bi bi-floppy"></span></a>
                                <a href="#" class="btn btn-icon"><span class="bi bi-eye"></span></a>
                                <a href="#" class="btn btn-icon"><span class="bi bi-cart-plus"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4" style="text-align: end">
                <a href="#" class="btn btn-primary">
                    <span>مشاهده بیشتر</span>
                    <span class="bi bi-arrow-left pe-2"></span>
                </a>
            </div>
        </div>
    </div>
</main>

<footer>
    <div class="crd crd-shadow"
         style="border-bottom-left-radius: 0; border-bottom-right-radius: 0">
        <div class="row align-items-stretch m-0 gx-5">
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

            <div class="col-md-4 p-5 align-content-center">
                <div>
                    <p class="text-bold-2">نماد های اعتماد</p>

                    <div class="row m-0 p-3 gap-3">
                        <div class="col crd crd-shadow crd-pad">
                            <a href="#">
                                <img src="{{asset('site/public/img/enamad.png')}}" alt="" class="w-100">
                            </a>
                        </div>

                        <div class="col crd crd-shadow crd-pad">
                            <a href="#">
                                <img src="{{asset('site/public/img/enamad.png')}}" alt="" class="w-100">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex-center-between-space px-5 py-3 bg-blue">
        <span class="text-white">تمامی حقوق محفوظ میباشد.</span>

        <div class="d-flex gap-2 align-items-center justify-content-center">
            <a href="#" class="btn btn-icon"><span class="bi bi-whatsapp"></span></a>
            <a href="#" class="btn btn-icon"><span class="bi bi-telegram"></span></a>
            <a href="#" class="btn btn-icon"><span class="bi bi-instagram"></span></a>
        </div>
    </div>
</footer>

<!--region: support button -->
<a href="#" id="btn-support">
    <img src="{{asset('site/public/img/1.png')}}" alt="contact support">
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
    background: url({{asset('site/public/img/back-btn-news.png')}}) round;
    height: 118px;
    width: 31px;
    text-align: center;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;

">
    <span style="
    background-color: whitesmoke;
        writing-mode: vertical-rl;
        text-align: center;
        text-orientation: mixed;
        rotate: 180deg;
    ">اخبار</span>
</a>
<!--endregion: news button -->

</body>

</html>
