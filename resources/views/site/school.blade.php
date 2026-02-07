@extends('site.layout.master')
@section('head')
    <title>آموزشگاه</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    {{-- login btn --}}
    <style>
        .login-btn {
            background-color: transparent !important;
            width: 70px !important;
            /* border: 1px solid black; */

        }

        .register-btn {
            color: white !important;
            /* background-color: transparent; */
            background-color: #ffffff00 !important;
            /* border: 1px solid black; */
            border: none;
            width: 70px !important;

        }

        .background-slide {
            position: absolute;
            width: 70px;
            /* اندازه بزرگ‌تر برای هر دو دکمه */
            height: 44px;
            background-color: #EBA607;
            border-radius: 0.5rem;
            right: 80px;
            top: 6px;
            z-index: -1;
            transition: transform 0.5s cubic-bezier(0, -0.55, 0, 1);
        }

        .login-btn,
        .register-btn {
            position: relative;
            z-index: 1;
        }

        .login-btn:hover {
            transition-delay: 50ms;
            color: white !important;
            background-color: #ffffff00 !important;
        }

        .login-btn:hover~.background-slide {
            /* transform: translateX(calc(74% + 1rem)); */
            transform: translateX(74px);
            /* width: 50px; */
            /* height: 45px; */
            /* right: 147px; */
            /* top: 2px; */
        }

        .login-btn:hover~.register-btn {
            transition-delay: 0.1s;
            background-color: #ffffff;
            border: none;
            color: black !important;
        }

        .register-btn:hover {
            background-color: transparent;
            border-color: #2563eb;
        }
    </style>
    {{-- styles --}}
    <style>
        .profile-bg {
            height: 350px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border: 4px solid white;
            object-fit: cover;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .profile-bg {
                height: 200px;
            }

            .stat-divider::after {
                display: none;
            }
        }

        .tabone-link.active {
            background-color: white !important;
            /* border-color: var(--bs-nav-tabs-link-active-border-color); */
            border-bottom: 3px solid #ffae00 !important;
        }

        .tabtow-link.active i {
            color: #e69926;
        }

        .tabtow-link:hover {
            color: #e69926 !important;
        }

        .nav-tabs .nav-link {
            margin-bottom: calc(-1 * var(--bs-nav-tabs-border-width));
            border: none;
            border-color: #ffae00;
        }


        .leaflet-touch .leaflet-control-attribution {
            display: none !important;
        }


        /* کلاس ها */
        .school-event-card {
            background-color: white;
            /* overflow: hidden; */
            padding: 2rem 1.5rem;
        }

        .event-image {
            width: 130px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .event-date {
            font-weight: bold;
            font-size: 16px;
        }

        .event-date i {
            font-size: 1rem;
            margin-right: 6px;
        }

        .more-link {
            font-size: 0.9rem;
            text-decoration: none;
        }

        .more-link i {
            font-size: 0.8rem;
            vertical-align: middle;
        }

        .bi-telephone::before {
            transform: scaleX(-1);
        }

        .text-intro {
            text-align: justify;
            line-height: 1.9;
            font-size: 16px;
        }

        .text-comment {
            text-align: justify;
            line-height: 1.7;
            font-size: 14px;
        }

        .comment-small {
            font-size: 12px;
        }

        /* gallery */
        .gallery-img {
            cursor: pointer;
            transition: transform 0.3s ease;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .gallery-img:hover {
            transform: scale(1.03);
        }

        .modal-content {
            border-radius: 16px;
            overflow: hidden;
        }

        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fff;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: auto;
            max-height: 80vh;
            object-fit: contain;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #EBA607 !important;
            background: rgb(182 182 182 / 50%);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 1px solid;
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 1.5rem;
        }

        .swiper-pagination-bullet-active {
            background: #EBA607 !important;
        }

        .swiper-pagination-bullet {
            background: #b5b5b5d4;
            opacity: 0.9;
        }

        .modal-header {
            border-bottom: none;
            /* padding: 1rem 1rem 0; */
        }

        .btn-close {
            /* filter: invert(1); */
        }

        .gallery-link {
            cursor: pointer;
        }





        /* teacher slider */
        .teacher-card {
            text-align: center;
            background: #fff;
            /* border-radius: 0px; */
            /* padding: 5px; */
            cursor: pointer;
            /* transition: transform 0.3s ease; */
            height: 100%;
        }

        .teacher-card:hover {
            /* transform: translateY(-5px); */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .teacher-card .card-body {
            padding: 5px
        }

        .teacher-card img {
            width: 100%;
            /* border-radius: 10px; */
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
            margin-bottom: 10px;
            height: 100%;
            aspect-ratio: 9 / 10;
            object-fit: cover;
        }

        .teacher-card h4 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .teacher-card p {
            font-size: 14px;
            /* color: #555; */
        }

        /* مدال */
        .teacherModal .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
        }

        .teacherModal .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            text-align: center;
            position: relative;
        }

        .teacherModal .modal .close {
            position: absolute;
            top: 10px;
            right: 15px;
            cursor: pointer;
            font-size: 20px;
        }

        /* .swiper.teachers-slider {
                                                                                        direction: rtl !important;
                                                                                    } */
        .swiper.teachers-slider .swiper-button-next {
            display: none;
        }

        .swiper.teachers-slider .swiper-button-prev {
            display: none;
        }

        .modal-close-btn:hover i {
            color: #e69926;
        }

        .modal-close-btn:hover {
            background-color: #f8f9fa !important;
        }



        /* styles */
        /* inputs */
        .autocomplete {
            position: relative;
            /* width: 300px; */
        }

        .autocomplete input,
        .autocomplete textarea {
            outline: 0px solid transparent !important;
            width: 100%;
            padding: 10px 30px 10px 10px;
            padding-left: 30px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .autocomplete label {
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
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-weight: bold;
            color: #888;
        }


        /* comments */
        .comments-row {
            max-height: 500px;
            overflow-y: scroll;
        }

        .comments-row::-webkit-scrollbar {
            background-color: #ffffff;
            width: 4px;
        }

        .comments-row::-webkit-scrollbar-thumb {
            background-color: #bfbfbf;
            border-radius: 10px;
            width: 4px;
        }

        .card {
            border-radius: 10px;
            /* box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); */
            transition: all 0.3s;
            margin-bottom: 20px;
        }

        .company-logo {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .job-title {
            color: #6c757d;
            font-size: 1rem;
        }


        .feature-badge {
            background-color: #e9ecef;
            color: #495057;
            /* margin-left: 5px; */
            /* margin-bottom: 5px; */
            font-size: 0.8rem;
        }

        .badge-success {
            background-color: #bbffcbbb;
            color: #2fbc50;
            /* margin-left: 5px; */
            /* margin-bottom: 5px; */
            font-size: 0.8rem;
        }

        .badge-danger {
            background-color: #ffbbbbbb;
            color: #b72929;
            /* margin-left: 5px; */
            /* margin-bottom: 5px; */
            font-size: 0.8rem;
        }

        .badge-primary {
            background-color: #bbecffbb;
            color: #2795ba;
            /* margin-left: 5px; */
            /* margin-bottom: 5px; */
            font-size: 0.8rem;
        }

        .stats-section {
            padding-left: 15px;
        }

        .stat-item {
            text-align: left;
        }

        .stat-value {
            font-weight: bold;
            font-size: 1.1rem;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .info-bar {
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
            padding: 10px 19px;
            border-radius: 0 0 10px 10px;
            margin-top: 15px;
        }

        .salary {
            color: #242424;
            /* font-weight: bold; */
            font-size: 12.8px;
        }

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
            width: 100%;
        }

        .timer-short .timer-number {
            font-size: 15px;
        }
    </style>
@endsection
@section('content')
    {{-- banner --}}
    <div class="profile-bg w-100 position-relative" style="">
        <img src="{{ asset('https://yazdskill.com/files/files/1/img3.jpg') }}" alt="test"
            class="w-100 h-100 object-fit-cover">
    </div>

    {{-- profile --}}
    <div class="container" style="position: relative;bottom: 50px;">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm rounded-4 px-4 py-3 mb-5">
                    <div class="row align-items-center">
                        <div class="col-md-auto text-center mb-3 mb-md-0">
                            <img src="https://wowslider.com/sliders/demo-18/data1/images/hongkong1081704.jpg"
                                class="rounded-circle profile-avatar">
                        </div>
                        <div class="col text-start text-md-start">
                            <h4 class="fw-bold text-dark">دارالفنون فاضل</h4>
                            <p class="text-muted">
                                <span class="text-small-1">یزد</span>
                                <span class="">|</span>
                                <span class="text-small-1">035-31231234</span>
                            </p>
                            <div class="d-inline-flex gap-2 flex-wrap justify-content-center justify-content-md-start">
                                <span class="badge bg-primary bg-opacity-10 text-primary">فعال</span>
                                <span class="badge bg-primary bg-opacity-10 text-primary">ویژه</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-5 mt-4 mt-md-0">
                            <div class="d-flex justify-content-between position-relative">
                                <div class="text-center stat-divider">
                                    <small class="text-muted">دنبال کنندگان</small>
                                    <h5 class="fw-bold">1,254</h5>
                                </div>
                                <div class="text-center stat-divider">
                                    <small class="text-muted">دنبال شوندگان</small>
                                    <h5 class="fw-bold">568</h5>
                                </div>
                                <div class="text-center stat-divider">
                                    <small class="text-muted">کلاس‌ها</small>
                                    <h5 class="fw-bold">24</h5>
                                </div>
                                <div class="text-center">
                                    <small class="text-muted">امتیاز</small>
                                    <h5 class="fw-bold">4.8</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- main content --}}
    <div class="container mt-0 position-relative" style="position: relative;bottom: 70px;">
        <div class="row">
            <!-- ستون سمت راست -->
            <div class="col-lg-4 mb-4">
                <!-- اطلاعات تماس -->
                <div class="card shadow-sm p-3 rounded-4 mb-4">
                    <h6 class="fw-bold mb-3">اطلاعات تماس</h6>
                    <ul class="list-unstyled text-muted small mb-4 pe-0">
                        <li class="">
                            <div class="card-box d-flex align-items-center justify-content-start rounded-4">
                                <div class="icon-box bg-white bg-opacity-25">
                                    <i class="bi bi-envelope fs-5 text-secondary ms-2"
                                        style="position: relative;top:5px;"></i>
                                </div>
                                <div class="text-start ms-3 mt-2">
                                    <span class="text-mute">ایمیل : </span>
                                    <p class="text-dark mb-0 d-inline">kiley.brown@example.com</p>
                                </div>
                            </div>
                        </li>
                        <li class="">
                            <div class="card-box d-flex align-items-center justify-content-start rounded-4">
                                <div class="icon-box bg-white bg-opacity-25">
                                    <i class="bi bi-link-45deg fs-5 text-secondary ms-2"
                                        style="position: relative;top:5px;"></i>
                                </div>
                                <div class="text-start ms-3 mt-2">
                                    <span class="text-mute">وب‌سایت : </span>
                                    <p class="text-dark mb-0 d-inline">example.com</p>
                                </div>
                            </div>
                        </li>
                        <li class="">
                            <div class="card-box d-flex align-items-center justify-content-start rounded-4">
                                <div class="icon-box bg-white bg-opacity-25">
                                    <i class="bi bi-telephone fs-5 text-secondary ms-2"
                                        style="position: relative;top:5px;"></i>
                                </div>
                                <div class="text-start ms-3 mt-2">
                                    <span class="text-mute">تلفن : </span>
                                    <p class="text-dark mb-0 d-inline" dir="ltr">+98 987 654 3210</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div>
                        <div id="map" class="" style="height: 250px;border-radius: 12px;z-index:1;"></div>
                    </div>
                </div>

                <!-- اساتید -->
                <div class="card shadow-sm p-3 rounded-4 mb-4">
                    <h6 class="fw-bold mb-3">اساتید</h6>
                    <div class="row g-2" dir="ltr">
                        <div class="col-12 p-0">
                            <!-- اسلایدر -->
                            <div class="swiper teachers-slider">
                                <div class="swiper-wrapper">
                                    <!-- کارت استاد -->
                                    <div class="swiper-slide">
                                        <div class="teacher-card card text-center border" data-bs-toggle="modal"
                                            data-bs-target="#teacherModal" data-name="الکسانس" data-degree="دکترای عمران"
                                            data-details="سابقه: 10 سال تدریس در دانشگاه تهران، دروس: سازه، مقاومت مصالح"
                                            data-image="https://yazdskill.com/files/files/1/img1.jpg">
                                            <img src="https://yazdskill.com/files/files/1/img1.jpg"
                                                class="card-img-top" alt="استاد">
                                            <div class="card-body p-0">
                                                <p class="card-title text-intro text-center text-muted">الکسانس</p>
                                                {{-- <p class="card-text text-muted">دکترای عمران</p> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- کارت بعدی -->
                                    <div class="swiper-slide">
                                        <div class="teacher-card card text-center border" data-bs-toggle="modal"
                                            data-bs-target="#teacherModal" data-name="دیمیک هریس"
                                            data-degree="کارشناسی ارشد معماری"
                                            data-details="سابقه: 8 سال تدریس در دانشگاه شریف، دروس: معماری مدرن"
                                            data-image="https://yazdskill.com/files/files/1/img1.jpg">
                                            <img src="https://yazdskill.com/files/files/1/img1.jpg"
                                                class="card-img-top" alt="استاد">
                                            <div class="card-body p-0">
                                                <p class="card-title text-intro text-center text-muted">دیمیک هریس</p>
                                                {{-- <p class="card-text text-muted">کارشناسی ارشد معماری</p> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- کارت بعدی -->
                                    <div class="swiper-slide">
                                        <div class="teacher-card card text-center border" data-bs-toggle="modal"
                                            data-bs-target="#teacherModal" data-name="چلیسی جاگر"
                                            data-degree="دکترای برق"
                                            data-details="سابقه: 12 سال تدریس، دروس: الکترونیک قدرت"
                                            data-image="https://yazdskill.com/files/files/1/img1.jpg">
                                            <img src="https://yazdskill.com/files/files/1/img1.jpg"
                                                class="card-img-top" alt="استاد">
                                            <div class="card-body p-0">
                                                <p class="card-title text-intro text-center text-muted">چلیسی جاگر</p>
                                                {{-- <p class="card-text text-muted">دکترای برق</p> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- کنترل‌ها -->
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>

                            <!-- مدال Bootstrap -->
                            <div class="modal fade" id="teacherModal" tabindex="-1" aria-labelledby="teacherModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
                                    <div class="modal-content" style="overflow: visible;">
                                        {{-- <div class="modal-header pb-0" style="flex-direction: row-reverse;">
                                            <h5 class="modal-title" id="teacherModalLabel">اطلاعات استاد</h5>
                                            <button type="button" class="btn-close m-0 position-absolute"
                                                data-bs-dismiss="modal" aria-label="بستن" style="left: 9px"></button>
                                        </div> --}}
                                        <div class="modal-body text-end gap-3 p-0">
                                            <button type="button"
                                                class="btn btn-light position-absolute top-0 start-0 modal-close-btn"
                                                data-bs-dismiss="modal"
                                                style="border-radius: 15px 0 15px 0 !important;padding: 0 !important;z-index: 2;width: 41px;height: 41px;">
                                                <i class="bi bi-x-lg"
                                                    style="font-size: x-large;position: relative;top: 2.5px;"></i>
                                            </button>
                                            <div class="w-100 text-center">
                                                <img id="modalImage" src=""
                                                    class="h-100 w-100 object-fit-cover shadow-sm"
                                                    style="aspect-ratio: 9/10;border-top-left-radius:16px;border-top-right-radius:16px;"
                                                    alt="استاد">
                                            </div>
                                            <div class="p-3">
                                                <h4 id="modalName"></h4>
                                                <p class="text-primary" id="modalDegree"></p>
                                                <p id="modalDetails" class="text-start text-justify" dir="rtl"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- گالری تصاویر -->
                <div class="card shadow-sm p-3 rounded-4 mb-4">
                    <h6 class="fw-bold mb-3">گالری تصاویر</h6>
                    <div class="row g-2 mb-2">
                        <!-- تصاویر گالری کوچک -->
                        <div class="col-4">
                            <img src="https://yazdskill.com/files/files/1/img2.jpg"
                                class="img-fluid rounded-3 gallery-img" alt="گالری" data-bs-toggle="modal"
                                data-bs-target="#galleryModal" data-index="0">
                        </div>
                        <div class="col-4">
                            <img src="https://picsum.photos/id/237/800/600" class="img-fluid rounded-3 gallery-img"
                                alt="گالری" data-bs-toggle="modal" data-bs-target="#galleryModal" data-index="1">
                        </div>
                        <div class="col-4">
                            <img src="https://picsum.photos/id/238/800/600" class="img-fluid rounded-3 gallery-img"
                                alt="گالری" data-bs-toggle="modal" data-bs-target="#galleryModal" data-index="2">
                        </div>
                        <!-- می‌توانید تصاویر بیشتری اضافه کنید -->
                    </div>
                    <div class="gallery-link text-primary small d-flex align-items-center justify-content-end"
                        data-bs-toggle="modal" data-bs-target="#galleryModal">
                        به گالری بروید <i class="bi bi-arrow-left me-1" style="position: relative;top: 3px;"></i>
                    </div>
                    {{-- <a href="#" class="text-primary small d-flex align-items-center justify-content-end">
                        به گالری بروید <i class="bi bi-arrow-left me-1" style="position: relative;top: 3px;"></i>
                    </a> --}}
                </div>
                <!-- comment start -->
                <div class="card shadow-sm p-3 rounded-4 mb-4" style="padding-left: 10px !important;">
                    {{-- <h6 class="fw-bold mb-3">نظرات کاربران</h6> --}}
                    <div class="section-title mb-2 d-flex justify-content-between">
                        <div class="">
                            <img src="{{ asset('site/public/icon/vertical-line.svg') }}" aria-hidden="true"
                                class="vertical-line" width="5px" alt="">
                            <h6 class="title fw-bold d-inline">دیدگاه کاربران</h6>
                        </div>
                        <div class="align-content-center">
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#myModal">دیدگاه جدید</button>
                        </div>
                    </div>
                    <div class="row g-2 mb-2 comments-row ps-1" style="margin-left: 1px;">
                        <!-- Display Comments -->
                        <div class="">
                            <div class="border p-3 rounded-3 mb-3" style="background: #eeeeee8a;">
                                <div class=" d-flex justify-content-between">
                                    <div class=" header">
                                        <img src="{{ asset('usprofile-dflt.webp') }}" alt="user" class="rounded"
                                            width="40">
                                        <span class="me-1">کاربر اول</span>
                                    </div>
                                    <div class=" time d-flex align-items-center">
                                        <small class="text-muted comment-small">
                                            <i class="bi bi-clock ms-2 position-relative" style="top: 2px"></i>
                                            2 روز پیش
                                        </small>
                                    </div>
                                </div>
                                <p class="mb-0 mt-2 text-comment text-muted">
                                    این یک نظر تستی است. متن نظر در اینجا نمایش داده می‌شود.
                                </p>
                                {{-- <a href="#" class="mt-3">
                                    پاسخ
                                    <i class="fa-solid fa-reply fa-xs"></i>
                                </a> --}}
                                <!-- Replies -->
                                {{-- <div class="ms-4 mt-3">
                                    <div class="border p-2 rounded-3 mb-2 bg-white">
                                        <p class="mb-1"><strong>پاسخ ۱</strong></p>
                                        <p class="mb-0">این یک پاسخ تستی به نظر کاربر ۱ است.</p>
                                    </div>
                                    <div class="border p-2 rounded-3 mb-2 bg-white">
                                        <p class="mb-1"><strong>پاسخ ۲</strong></p>
                                        <p class="mb-0">این یک پاسخ دیگر به نظر کاربر ۱ است.</p>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="">
                            <div class="border p-3 rounded-3 mb-3" style="background: #eeeeee8a;">
                                <div class=" d-flex justify-content-between">
                                    <div class=" header">
                                        <img src="{{ asset('usprofile-dflt.webp') }}" alt="user" class="rounded"
                                            width="40">
                                        <span class="me-1">کاربر اول</span>
                                    </div>
                                    <div class=" time d-flex align-items-center">
                                        <small class="text-muted comment-small">
                                            <i class="bi bi-clock ms-2 position-relative" style="top: 2px"></i>
                                            2 روز پیش
                                        </small>
                                    </div>
                                </div>
                                <p class="mb-0 mt-2 text-comment text-muted">
                                    این یک نظر تستی است. متن نظر در اینجا نمایش داده می‌شود.
                                </p>
                                {{-- <a href="#" class="mt-3">
                                    پاسخ
                                    <i class="fa-solid fa-reply fa-xs"></i>
                                </a> --}}
                                <!-- Replies -->
                                {{-- <div class="ms-4 mt-3">
                                    <div class="border p-2 rounded-3 mb-2 bg-white">
                                        <p class="mb-1"><strong>پاسخ ۱</strong></p>
                                        <p class="mb-0">این یک پاسخ تستی به نظر کاربر ۱ است.</p>
                                    </div>
                                    <div class="border p-2 rounded-3 mb-2 bg-white">
                                        <p class="mb-1"><strong>پاسخ ۲</strong></p>
                                        <p class="mb-0">این یک پاسخ دیگر به نظر کاربر ۱ است.</p>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="">
                            <div class="border p-3 rounded-3 mb-3" style="background: #eeeeee8a;">
                                <div class=" d-flex justify-content-between">
                                    <div class=" header">
                                        <img src="{{ asset('usprofile-dflt.webp') }}" alt="user" class="rounded"
                                            width="40">
                                        <span class="me-1">کاربر اول</span>
                                    </div>
                                    <div class=" time d-flex align-items-center">
                                        <small class="text-muted comment-small">
                                            <i class="bi bi-clock ms-2 position-relative" style="top: 2px"></i>
                                            2 روز پیش
                                        </small>
                                    </div>
                                </div>
                                <p class="mb-0 mt-2 text-comment text-muted">
                                    این یک نظر تستی است. متن نظر در اینجا نمایش داده می‌شود.
                                </p>
                                {{-- <a href="#" class="mt-3">
                                    پاسخ
                                    <i class="fa-solid fa-reply fa-xs"></i>
                                </a> --}}
                                <!-- Replies -->
                                {{-- <div class="ms-4 mt-3">
                                    <div class="border p-2 rounded-3 mb-2 bg-white">
                                        <p class="mb-1"><strong>پاسخ ۱</strong></p>
                                        <p class="mb-0">این یک پاسخ تستی به نظر کاربر ۱ است.</p>
                                    </div>
                                    <div class="border p-2 rounded-3 mb-2 bg-white">
                                        <p class="mb-1"><strong>پاسخ ۲</strong></p>
                                        <p class="mb-0">این یک پاسخ دیگر به نظر کاربر ۱ است.</p>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="">
                            <div class="border p-3 rounded-3 mb-3" style="background: #eeeeee8a;">
                                <div class=" d-flex justify-content-between">
                                    <div class=" header">
                                        <img src="{{ asset('usprofile-dflt.webp') }}" alt="user" class="rounded"
                                            width="40">
                                        <span class="me-1">کاربر اول</span>
                                    </div>
                                    <div class=" time d-flex align-items-center">
                                        <small class="text-muted comment-small">
                                            <i class="bi bi-clock ms-2 position-relative" style="top: 2px"></i>
                                            2 روز پیش
                                        </small>
                                    </div>
                                </div>
                                <p class="mb-0 mt-2 text-comment text-muted">
                                    این یک نظر تستی است. متن نظر در اینجا نمایش داده می‌شود.
                                </p>
                                {{-- <a href="#" class="mt-3">
                                    پاسخ
                                    <i class="fa-solid fa-reply fa-xs"></i>
                                </a> --}}
                                <!-- Replies -->
                                {{-- <div class="ms-4 mt-3">
                                    <div class="border p-2 rounded-3 mb-2 bg-white">
                                        <p class="mb-1"><strong>پاسخ ۱</strong></p>
                                        <p class="mb-0">این یک پاسخ تستی به نظر کاربر ۱ است.</p>
                                    </div>
                                    <div class="border p-2 rounded-3 mb-2 bg-white">
                                        <p class="mb-1"><strong>پاسخ ۲</strong></p>
                                        <p class="mb-0">این یک پاسخ دیگر به نظر کاربر ۱ است.</p>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="">
                            <div class="border p-3 rounded-3 mb-3" style="background: #eeeeee8a;">
                                <div class=" d-flex justify-content-between">
                                    <div class=" header">
                                        <img src="{{ asset('usprofile-dflt.webp') }}" alt="user" class="rounded"
                                            width="40">
                                        <span class="me-1">کاربر اول</span>
                                    </div>
                                    <div class=" time d-flex align-items-center">
                                        <small class="text-muted comment-small">
                                            <i class="bi bi-clock ms-2 position-relative" style="top: 2px"></i>
                                            2 روز پیش
                                        </small>
                                    </div>
                                </div>
                                <p class="mb-0 mt-2 text-comment text-muted">
                                    این یک نظر تستی است. متن نظر در اینجا نمایش داده می‌شود.
                                </p>
                                {{-- <a href="#" class="mt-3">
                                    پاسخ
                                    <i class="fa-solid fa-reply fa-xs"></i>
                                </a> --}}
                                <!-- Replies -->
                                {{-- <div class="ms-4 mt-3">
                                    <div class="border p-2 rounded-3 mb-2 bg-white">
                                        <p class="mb-1"><strong>پاسخ ۱</strong></p>
                                        <p class="mb-0">این یک پاسخ تستی به نظر کاربر ۱ است.</p>
                                    </div>
                                    <div class="border p-2 rounded-3 mb-2 bg-white">
                                        <p class="mb-1"><strong>پاسخ ۲</strong></p>
                                        <p class="mb-0">این یک پاسخ دیگر به نظر کاربر ۱ است.</p>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- The Modal -->
                <div class="modal fade" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal body -->
                            <div class="modal-body">
                                <!-- Content section -->
                                <div class="p-3" style="direction: ltr;">
                                    <div class="p-0" dir="rtl">
                                        <div class="mb-3 mt-3">
                                            <div class="autocomplete" id="autocompleteBoxname">
                                                <input type="text" id="searchInputname" name="name"
                                                    oninput="nameinput('name')">
                                                <label for="searchInputname">نام و نام خانوادگی</label>
                                                <span class="clear-btn" id="clearBtn_name"
                                                    onclick="clearInput('name')">×</span>
                                            </div>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <div class="autocomplete" id="autocompleteBoxdescription">
                                                <textarea id="searchInputdescription" name="description" rows="4" oninput="nameinput('description')"></textarea>
                                                <label for="searchInputdescription" style="top: 10px;">متن دیدگاه</label>
                                                <span class="clear-btn" id="clearBtn_description"
                                                    onclick="clearInput('description')" style="top: 23px;">×</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Buttons -->
                                    <div class="d-flex justify-content-start gap-3 align-items-center">
                                        <button type="button"
                                            class="btn btn-primary d-flex align-items-center px-4 py-2">
                                            ثبت دیدگاه
                                        </button>
                                        <button type="button" class="btn btn-outline-danger px-4 py-2"
                                            data-bs-dismiss="modal">
                                            لغو
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- comment end -->

                <!-- Modal -->
                <div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header justify-content-between">
                                <h6 class="m-0">گالری تصاویر</h6>
                                <button type="button" class="btn-close ms-0 ps-0" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-0">
                                <!-- Swiper -->
                                <div class="swiper mySwiper">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <img src="https://yazdskill.com/files/files/1/img2.jpg"
                                                alt="تصویر ۱" class="w-100 h-100 object-fit-cover">
                                        </div>
                                        <div class="swiper-slide">
                                            <img src="https://picsum.photos/id/237/800/600" alt="تصویر ۲"
                                                class="w-100 h-100 object-fit-cover">
                                        </div>
                                        <div class="swiper-slide">
                                            <img src="https://picsum.photos/id/238/800/600" alt="تصویر ۳"
                                                class="w-100 h-100 object-fit-cover">
                                        </div>
                                        <!-- اسلایدهای بیشتر -->
                                    </div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ستون سمت چپ -->
            <div class="col-lg-8 mb-4">

                <!-- تب رشته، حرفه، مهارت -->
                <div class="card shadow-sm p-3 rounded-4 mb-4">
                    <ul class="nav nav-tabs mb-3 pe-0" id="tabOne" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tabone-link text-dark active" id="fields-tab" data-bs-toggle="tab"
                                data-bs-target="#fields" type="button" role="tab">عناوین رشته</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tabone-link text-dark" id="professions-tab" data-bs-toggle="tab"
                                data-bs-target="#professions" type="button" role="tab">عناوین حرفه</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tabone-link text-dark" id="skills-tab" data-bs-toggle="tab"
                                data-bs-target="#skills" type="button" role="tab">مهارت‌ها</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="tabOneContent">
                        <div class="tab-pane fade show active" id="fields" role="tabpanel">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card-box d-flex align-items-center justify-content-start rounded-4">
                                        <div class="icon-box bg-white bg-opacity-25">
                                            <i class="bi bi-check-circle fs-3 text-secondary ms-2"></i>
                                        </div>
                                        <div class="text-start ms-3 mt-2">
                                            <p class="text-mute fw-bold">رشته تست</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-box d-flex align-items-center justify-content-start rounded-4">
                                        <div class="icon-box bg-white bg-opacity-25">
                                            <i class="bi bi-check-circle fs-3 text-secondary ms-2"></i>
                                        </div>
                                        <div class="text-start ms-3 mt-2">
                                            <p class="text-mute fw-bold">رشته تست</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-box d-flex align-items-center justify-content-start rounded-4">
                                        <div class="icon-box bg-white bg-opacity-25">
                                            <i class="bi bi-check-circle fs-3 text-secondary ms-2"></i>
                                        </div>
                                        <div class="text-start ms-3 mt-2">
                                            <p class="text-mute fw-bold">رشته تست</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="professions" role="tabpanel">
                            <ul class="list-group list-group-flush small pe-0">
                                <li class="list-group-item">حرفه ۱</li>
                                <li class="list-group-item">حرفه ۲</li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="skills" role="tabpanel">
                            <ul class="list-group list-group-flush small pe-0">
                                <li class="list-group-item">مهارت ۱</li>
                                <li class="list-group-item">مهارت ۲</li>
                                <li class="list-group-item">مهارت ۳</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- معرفی آموزشگاه -->
                <div class="card shadow-sm p-3 rounded-4 mb-4">
                    <h6 class="fw-bold mb-3">معرفی آموزشگاه</h6>
                    <p class="text-muted text-intro mb-0">
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است،
                        چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد
                        نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته
                        حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان
                        رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید
                        داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل
                        حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار
                        گیرد.لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است،
                        چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد
                        نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته
                        حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان
                        رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید
                        داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل
                        حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار
                        گیرد.
                    </p>
                </div>

                <!-- تب آگهی‌ها و کلاس‌ها -->
                <div class="card shadow-sm p-3 rounded-4">
                    <ul class="nav nav-tabs mb-3 pe-0 border-bottom-0 position-relative" id="tabTwo" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tabtow-link text-dark active" id="ads-tab" data-bs-toggle="tab"
                                data-bs-target="#ads" type="button" role="tab">
                                <i class="bi bi-newspaper ms-2"></i>
                                آگهی‌ها
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tabtow-link text-dark" id="classes-tab" data-bs-toggle="tab"
                                data-bs-target="#classes" type="button" role="tab">
                                <i class="bi bi-pencil ms-2"></i>
                                کلاس‌های آموزشی
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tabtow-link text-dark" id="jobs-tab" data-bs-toggle="tab"
                                data-bs-target="#jobs" type="button" role="tab">
                                <i class="bi bi-briefcase ms-2"></i>
                                فرصت های شغلی
                            </button>
                        </li>
                        <div class="position-absolute" style="left: 0;bottom:0">
                            <label class="switch2">
                                <input type="checkbox" name="off" id="off">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </ul>
                    <div class="tab-content" id="tabTwoContent">
                        <div class="tab-pane fade show active" id="ads" role="tabpanel">
                            <div class="school-event-card row d-flex align-items-center flex-wrap border-top">
                                <!-- سمت راست: تصویر و اطلاعات -->
                                <div class="col-2 p-0">
                                    <img src="{{ asset('https://yazdskill.com/files/files/1/img3.jpg') }}"
                                        class="event-image" alt="رویداد">
                                </div>
                                <!-- سمت چپ: تاریخ و دکمه -->
                                <div class="text-start col-10 pe-4 position-relative">
                                    <div class="discount-squer" style="position: absolute;left: -11px;top: -38px;">
                                        <img src="{{ asset('Group 1.svg') }}" width="90" alt="discount">
                                        <span class="d-flex"
                                            style="font-size: 12px;font-weight: 800;position: absolute;right: 12px;top: 7px;"
                                            dir="ltr">
                                            <span class="me-1" style="font-size: 13px;">تخفیف</span>
                                            <strong class="" style="font-size: 12px;">10%</strong>
                                        </span>
                                    </div>
                                    <div class=" d-flex justify-content-between position-relative"
                                        style="bottom: 33px;width: 88%;" dir="ltr">
                                        <div class="" style="padding-top: 4px;">
                                            <p class="text-center m-0"
                                                style="font-size: 14px;direction: rtl;font-weight:bold;margin-bottom:4px">
                                                <span class="text-dark" style="font-size: 14px;">اعتبار : </span>
                                                <span class="text-primary" style="font-size: 14px">1403/05/08</span>
                                                <span class="text-dark" style="font-size: 14px;">الی</span>
                                                <span class="text-primary" style="font-size: 14px">1403/05/20</span>
                                            </p>
                                        </div>
                                        <a href="#" class="text-reset text-decoration-none">
                                            <small style="font-size: 11.9px">
                                                5
                                                <i class="bi bi-exclamation-triangle ms-1 text-primary"
                                                    style="position: relative;top: 2px;"></i>
                                            </small>
                                        </a>
                                        <small style="font-size: 11.9px;">
                                            50
                                            <i class="bi bi-heart ms-1 text-primary"
                                                style="position: relative;top: 2px;"></i>
                                        </small>
                                        <small style="font-size: 11.9px;">
                                            112
                                            <i class="bi bi-eye ms-1 text-primary"
                                                style="position: relative;top: 2px;"></i>
                                        </small>
                                        <small style="font-size: 11.9px;">
                                            2 روز پیش
                                            <i class="bi bi-clock ms-1 text-primary"
                                                style="position: relative;top: 2px;"></i>
                                        </small>
                                    </div>
                                    <div class="event-date mb-3">
                                        <span class="badge bg-success mb-1"
                                            style="padding:6px;font-size:16px;font-weight: 400;position: relative;bottom: 17px;">نمایش
                                            شهربازی</span>
                                        <p class="text-muted text-intro mt-2 position-relative" style="bottom: 12px;">
                                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان
                                            گرافیک است
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="school-event-card row d-flex align-items-center flex-wrap border-top">
                                <!-- سمت راست: تصویر و اطلاعات -->
                                <div class="col-2 p-0">
                                    <img src="{{ asset('https://yazdskill.com/files/files/1/img3.jpg') }}"
                                        class="event-image" alt="رویداد">
                                </div>
                                <!-- سمت چپ: تاریخ و دکمه -->
                                <div class="text-start col-10 pe-4 position-relative">
                                    <div class="discount-squer" style="position: absolute;left: -11px;top: -38px;">
                                        <img src="{{ asset('Group 1.svg') }}" width="90" alt="discount">
                                        <span class="d-flex"
                                            style="font-size: 12px;font-weight: 800;position: absolute;right: 12px;top: 7px;"
                                            dir="ltr">
                                            <span class="me-1" style="font-size: 13px;">تخفیف</span>
                                            <strong class="" style="font-size: 12px;">10%</strong>
                                        </span>
                                    </div>
                                    <div class=" d-flex justify-content-between position-relative"
                                        style="bottom: 33px;width: 88%;" dir="ltr">
                                        <div class="" style="padding-top: 4px;">
                                            <p class="text-center m-0"
                                                style="font-size: 14px;direction: rtl;font-weight:bold;margin-bottom:4px">
                                                <span class="text-dark" style="font-size: 14px;">اعتبار : </span>
                                                <span class="text-primary" style="font-size: 14px">1403/05/08</span>
                                                <span class="text-dark" style="font-size: 14px;">الی</span>
                                                <span class="text-primary" style="font-size: 14px">1403/05/20</span>
                                            </p>
                                        </div>
                                        <a href="#" class="text-reset text-decoration-none">
                                            <small style="font-size: 11.9px">
                                                5
                                                <i class="bi bi-exclamation-triangle ms-1 text-primary"
                                                    style="position: relative;top: 2px;"></i>
                                            </small>
                                        </a>
                                        <small style="font-size: 11.9px;">
                                            50
                                            <i class="bi bi-heart ms-1 text-primary"
                                                style="position: relative;top: 2px;"></i>
                                        </small>
                                        <small style="font-size: 11.9px;">
                                            112
                                            <i class="bi bi-eye ms-1 text-primary"
                                                style="position: relative;top: 2px;"></i>
                                        </small>
                                        <small style="font-size: 11.9px;">
                                            2 روز پیش
                                            <i class="bi bi-clock ms-1 text-primary"
                                                style="position: relative;top: 2px;"></i>
                                        </small>
                                    </div>
                                    <div class="event-date mb-3">
                                        <span class="badge bg-success mb-1"
                                            style="padding:6px;font-size:16px;font-weight: 400;position: relative;bottom: 17px;">نمایش
                                            شهربازی</span>
                                        <p class="text-muted text-intro mt-2 position-relative" style="bottom: 12px;">
                                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان
                                            گرافیک است
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="school-event-card row d-flex align-items-center flex-wrap border-top">
                                <!-- سمت راست: تصویر و اطلاعات -->
                                <div class="col-2 p-0">
                                    <img src="{{ asset('https://yazdskill.com/files/files/1/img3.jpg') }}"
                                        class="event-image" alt="رویداد">
                                </div>
                                <!-- سمت چپ: تاریخ و دکمه -->
                                <div class="text-start col-10 pe-4 position-relative">
                                    <div class="discount-squer" style="position: absolute;left: -11px;top: -38px;">
                                        <img src="{{ asset('Group 1.svg') }}" width="90" alt="discount">
                                        <span class="d-flex"
                                            style="font-size: 12px;font-weight: 800;position: absolute;right: 12px;top: 7px;"
                                            dir="ltr">
                                            <span class="me-1" style="font-size: 13px;">تخفیف</span>
                                            <strong class="" style="font-size: 12px;">10%</strong>
                                        </span>
                                    </div>
                                    <div class=" d-flex justify-content-between position-relative"
                                        style="bottom: 33px;width: 88%;" dir="ltr">
                                        <div class="" style="padding-top: 4px;">
                                            <p class="text-center m-0"
                                                style="font-size: 14px;direction: rtl;font-weight:bold;margin-bottom:4px">
                                                <span class="text-dark" style="font-size: 14px;">اعتبار : </span>
                                                <span class="text-primary" style="font-size: 14px">1403/05/08</span>
                                                <span class="text-dark" style="font-size: 14px;">الی</span>
                                                <span class="text-primary" style="font-size: 14px">1403/05/20</span>
                                            </p>
                                        </div>
                                        <a href="#" class="text-reset text-decoration-none">
                                            <small style="font-size: 11.9px">
                                                5
                                                <i class="bi bi-exclamation-triangle ms-1 text-primary"
                                                    style="position: relative;top: 2px;"></i>
                                            </small>
                                        </a>
                                        <small style="font-size: 11.9px;">
                                            50
                                            <i class="bi bi-heart ms-1 text-primary"
                                                style="position: relative;top: 2px;"></i>
                                        </small>
                                        <small style="font-size: 11.9px;">
                                            112
                                            <i class="bi bi-eye ms-1 text-primary"
                                                style="position: relative;top: 2px;"></i>
                                        </small>
                                        <small style="font-size: 11.9px;">
                                            2 روز پیش
                                            <i class="bi bi-clock ms-1 text-primary"
                                                style="position: relative;top: 2px;"></i>
                                        </small>
                                    </div>
                                    <div class="event-date mb-3">
                                        <span class="badge bg-success mb-1"
                                            style="padding:6px;font-size:16px;font-weight: 400;position: relative;bottom: 17px;">نمایش
                                            شهربازی</span>
                                        <p class="text-muted text-intro mt-2 position-relative" style="bottom: 12px;">
                                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان
                                            گرافیک است
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="classes" role="tabpanel">
                            <div class="row">
                                <div class="col-12 mt-3">
                                    <div class="row course-card m-0">
                                        <div class="col-4 shadow p-0 img position-relative overflow-hidden">
                                            <img src="{{ asset($item->image ?? 'Untitled.png') }}" alt=""
                                                class="w-100 h-100 object-fit-cover">
                                        </div>

                                        <div class="col-8 shadow d-flex flex-wrap align-content-around flex-column justify-content-between gap-2 p-3 py-1"
                                            style="border-top-left-radius: 5px;border-bottom-left-radius: 5px;">
                                            <div class="row g-0 w-100 align-content-center" dir="ltr">
                                                <div class="d-flex align-items-center justify-content-start gap-3">
                                                    <div style="font-size: 11.9px;" class="text-center fw-bold">
                                                        حضوری
                                                        <i class="bi bi-mortarboard ms-1 text-primary"
                                                            style="position: relative;top: 2px;"></i>
                                                    </div>
                                                    <div style="font-size: 11.9px;" class="text-center fw-bold">
                                                        50 ساعت
                                                        <i class="bi bi-clock ms-1 text-primary"
                                                            style="position: relative;top: 2px;"></i>
                                                    </div>
                                                    <div style="font-size: 11.9px;" class="text-center fw-bold">
                                                        <a href="#"
                                                            class="text-reset text-decoration-none text-center fw-bold"
                                                            style="font-size: 11.9px;">

                                                            <span class="fw-bold text-dark"
                                                                style="position: relative;bottom:2px;font-size:11.9px">120</span>
                                                            <i class="bi bi-eye ms-1 text-primary"
                                                                style="position: relative;top: 2px;font-size:19px"></i>
                                                        </a>

                                                    </div>
                                                    <div style="font-size: 11.9px;" class="text-center fw-bold">
                                                        <a href="#"
                                                            class="text-reset text-decoration-none text-center fw-bold"
                                                            style="font-size: 11.9px;">

                                                            120
                                                            <i class="bi bi-heart ms-1 text-primary"
                                                                style="position: relative;top: 2px;"></i>
                                                        </a>
                                                    </div>



                                                </div>
                                            </div>
                                            <a href="#" class="text-reset text-decoration-none">
                                                <h5 class="text-start">دوره آموزشی HTML</h5>
                                            </a>
                                            <div class="row m-0 mt-2 p-0 w-100" dir="ltr">
                                                {{-- تایمر شمارش معکوس --}}
                                                <div
                                                    class="col-6 p-0 d-flex flex-wrap justify-content-start align-content-center">
                                                    <div
                                                        class="d-flex flex-wrap align-content-center align-items-center flex-column">
                                                        <span><span class="badge me-1"
                                                                style="font-size: 12px;background-color:#e69926">20%</span><del
                                                                style="font-size: 14px"
                                                                class="text-primary">5,000,000</del></span>
                                                        <span class="d-block" style="font-size: 14px"
                                                            dir="rtl">4,000,000 <span
                                                                style="padding-right: 6px;font-size:14px">تومان</span></span>
                                                    </div>
                                                </div>
                                                <div class="col-6 p-0 d-flex justify-content-end">
                                                    <div class="countdown-timer timer-short justify-content-between gap-3"
                                                        id="countdown-1" data-end-date="2025-12-30 22:46:25">
                                                        <div class="timer-col">
                                                            <span class="timer-number days">12</span>
                                                        </div>
                                                        <div class="timer-col">
                                                            <span class="timer-number hours">20</span>
                                                        </div>
                                                        <div class="timer-col">
                                                            <span class="timer-number minutes">20</span>
                                                        </div>
                                                        <div class="timer-col">
                                                            <span class="timer-number seconds">20</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="jobs" role="tabpanel">
                            <!-- کارت 1 -->
                            <div class="card border">
                                <div class="card-body p-0">
                                    <div class="row p-2 py-3 g-0">
                                        <div class="col-12">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <h6 class="job-title m-0">مدرس زبان انگلیسی</h6>
                                                </div>
                                                <div class="job-features gap-3">
                                                    <span class="badge badge-success">پاره وقت</span>
                                                    <span class="badge badge-danger">دورکاری</span>
                                                    <span class="badge badge-primary">تجربه لازم: ۲ سال</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info-bar p-2">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="stat-item">
                                                        <a href="#" class="text-reset text-decoration-none">
                                                            <small style="font-size: 13px;">
                                                                <i class="bi bi-heart ms-1 text-primary"
                                                                    style="position: relative;top: 2px;"></i>
                                                                50
                                                            </small>
                                                        </a>
                                                    </div>
                                                    <div class="stat-item">
                                                        <small style="font-size: 13px;">
                                                            <i class="bi bi-eye ms-1 text-primary"
                                                                style="position: relative;top: 2px;"></i>
                                                            112
                                                        </small>
                                                    </div>
                                                    <div class="stat-item">
                                                        <small style="font-size: 13px;">
                                                            <i class="bi bi-clock ms-1 text-primary"
                                                                style="position: relative;top: 2px;"></i>
                                                            2 روز پیش
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <span class="salary">8,000,000 <small>تومان / درآمد ماهانه </small></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- اسکریپت‌های نقشه -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // مختصات: یزد
        const lat = 31.8974;
        const lng = 54.3569;

        const map = L.map('map').setView([lat, lng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        L.marker([lat, lng]).addTo(map)
            .bindPopup('مکان آموزشگاه')
            .openPopup();
    </script>


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
                        $(this).find('.days').html(0 +
                            '<span class="d-block text-dark">روز</span>');
                        $(this).find('.hours').html(0 +
                            '<span class="d-block text-dark">ساعت</span>');
                        $(this).find('.minutes').html(0 +
                            '<span class="d-block text-dark">دقیقه</span>');
                        $(this).find('.seconds').html(0 +
                            '<span class="d-block text-dark">ثانیه</span>');
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


    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // مقداردهی اولیه Swiper
        const mySwiper = new Swiper(".mySwiper", {
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            keyboard: true,
            loop: true,
        });

        // مدیریت رویداد کلیک روی تصاویر
        document.querySelectorAll('.gallery-img').forEach(img => {
            img.addEventListener('click', function() {
                const index = parseInt(this.getAttribute('data-index'));
                mySwiper.slideTo(index, 0); // +1 به دلیل فعال بودن loop
            });
        });
        // مدیریت رویداد کلیک روی لینک
        document.querySelector('.gallery-link').addEventListener('click', function() {
            mySwiper.slideTo(0, 0); // نمایش اولین تصویر
        });
        // مدیریت رویداد نمایش مدال
        const galleryModal = document.getElementById('galleryModal');
        galleryModal.addEventListener('show.bs.modal', function(event) {
            // اگر تصویری که کلیک شده، index دارد
            if (event.relatedTarget && event.relatedTarget.hasAttribute('data-index')) {
                const index = parseInt(event.relatedTarget.getAttribute('data-index'));
                mySwiper.slideTo(index, 0); // +1 به دلیل فعال بودن loop
            }
        });
    </script>


    {{-- teachers slider --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Swiper
            const swiper = new Swiper('.teachers-slider', {
                slidesPerView: 3,
                spaceBetween: 20,
                loop: true,
                autoplay: {
                    delay: 3000,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    991: {
                        slidesPerView: 3
                    },
                    600: {
                        slidesPerView: 2
                    }
                }
            });

            // Bootstrap modal content
            const modalName = document.getElementById('modalName');
            const modalDegree = document.getElementById('modalDegree');
            const modalDetails = document.getElementById('modalDetails');
            const modalImage = document.getElementById('modalImage');

            document.querySelectorAll('.teacher-card').forEach(card => {
                card.addEventListener('click', () => {
                    modalName.textContent = card.dataset.name;
                    modalDegree.textContent = card.dataset.degree;
                    modalDetails.textContent = card.dataset.details;
                    modalImage.src = card.dataset.image;
                });
            });
        });
    </script>

    {{-- inputs --}}
    <script>
        function nameinput(id) {
            const input = document.getElementById("searchInput" + id);
            const box = document.getElementById("autocompleteBox" + id);
            const clearBtn = document.getElementById("clearBtn_" + id);
            if (input.value.length > 0) {
                box.classList.add("filled");
                clearBtn.style.display = 'block';
            } else {
                box.classList.remove("filled");
                clearBtn.style.display = 'none';
            }
        }

        function clearInput(id) {

            const box = document.getElementById("autocompleteBox" + id);
            box.classList.remove("filled");
            const input = document.getElementById("searchInput" + id);
            input.value = "";
            const clearBtn = document.getElementById("clearBtn_" + id);
            clearBtn.style.display = 'none';

            if (id == 'state') {
                const box2 = document.getElementById("autocompleteBoxcity");
                const input2 = document.getElementById("searchInputcity");
                input2.value = "";
                document.getElementById("selectedIdcity").value = "";
                box2.classList.remove("filled");
                const clearBtn2 = document.getElementById("clearBtn_city");
                clearBtn2.style.display = 'none';
            }
        }
    </script>
@endsection
