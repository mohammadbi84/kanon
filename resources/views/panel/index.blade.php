@extends('panel.layout.master')
@section('head')
    <title>حساب کاربری</title>
    <style>
        .card-box {
            border-radius: 20px;
            padding: 25px;
            background: white;
            height: 100%;
        }

        .icon-box {
            width: 45px;
            height: 45px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 15px;
        }

        .rounded-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid #3b82f6;
        }

        .badge-style {
            background: #f1f5f9;
            font-size: 0.8rem;
            padding: 3px 10px;
            border-radius: 10px;
        }

        .text-light-blue {
            color: #3b82f6;
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

        .alert-dismissible .btn-close {
            right: auto !important;
            left: 0 !important;
        }

        .text-alert {
            font-size: 12px;
            line-height: 25px;
            color: #484848;
            text-align: justify;
        }

        .alert-costum {
            background: #e9e9e9;
            border: 2px dashed #d6d6d6;
            padding-right: 16px !important;
        }


        /* slider collapse */
        /* دکمه بالا وقتی بازه */
        .slider-close-btn {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 10;
            border-radius: 6px 0 10px;
            width: 41px;
            height: 41px;
            line-height: 1;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            padding: 0;
            background: #fff;
            border: #fff;
        }

        .slider-close-btn:hover {
            background: #ccc;
        }

        .slider-close-btn i {
            font-size: 30px;
            color: #e69926;
        }

        /* هدر وقتی بسته شد */
        .slider-header {
            /* display: none; */
            background: #fff;
            border: 1px solid #ddd;
            padding: 0 1rem;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            height: 41px;
        }

        .card-header {
            display: none;
            background: transparent !important;
        }

        .plus-btn {
            padding: 0;
            text-align: center;
            width: 41px;
            height: 41px;
            position: absolute;
            left: 0;
            top: 0;
            align-content: center;
        }

        .plus-btn i {
            font-size: 29px;
        }

        #accordion .card {
            background: transparent !important;
        }
    </style>
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="container wrapper mb-5 py-5" style="margin-top: 120px">
        <div class="row g-0">
            {{-- profile and info --}}
            <div class="col-md-12">
                <div class="row p-4 rounded-3 shadow-sm bg-white border g-0">
                    <!-- آیکون ها -->
                    <div class="col-md-9">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <div class="card-box text-center bg-light">
                                    <img src="https://i.ibb.co/zP0sZp2/avatar.png" alt="avatar"
                                        class="rounded-avatar mb-2">
                                    <div class="fw-bold mt-3">آموزشگاه فاضل</div>
                                    <div class="text-muted small mt-1">09927501130</div>
                                    <a href="{{route('personal_page')}}" class="btn btn-primary btn-sm mt-3">تکمیل پروفایل</a>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row h-100 flex-wrap align-content-around">
                                    <div class="col-12">
                                        <div class="card-box bg-light rounded-4">
                                            <div>
                                                <div class="fw-bold my-3">موجودی شما</div>
                                                <small class="text-muted"> 0 تومان</small>
                                            </div>
                                            <div class="text-center">
                                                <button
                                                    class="btn btn-light bg-white border px-3 p-2 rounded-pill btn-sm mt-4 mx-auto">
                                                    <i class="fas fa-plus"></i> افزایش موجودی
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <a href="#" class="text-decoration-none">
                                            <div class="card-box d-flex align-items-center justify-content-between rounded-4"
                                                style="background-color: #ECFFEC;">
                                                <div class="icon-box bg-success bg-opacity-25 text-success">
                                                    <i class="fa-solid fa-dollar-sign"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">تراکنش ها</div>
                                                    <div class="fw-bold text-success">0</div>
                                                </div>
                                                <i class="bi bi-chevron-left text-success"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row h-100">
                                    <div class="col-12 mb-2">
                                        <a href="#" class="text-decoration-none">
                                            <div class="card-box d-flex align-items-center justify-content-between rounded-4"
                                                style="background-color: #FFF9D9;">
                                                <div class="icon-box bg-warning bg-opacity-25 text-warning">
                                                    <i class="bi bi-camera-video-fill"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">تبلیغات</div>
                                                    <div class="fw-bold text-warning">0</div>
                                                </div>
                                                <i class="bi bi-chevron-left text-warning"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <a href="#" class="text-decoration-none">
                                            <div class="card-box d-flex align-items-center justify-content-between rounded-4"
                                                style="background-color: #E4F9FF;">
                                                <div class="icon-box bg-primary bg-opacity-25">
                                                    <i class="bi bi-file-earmark-text-fill" style="color: #0D6EFD"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">آگهی ها</div>
                                                    <div class="fw-bold" style="color: #0D6EFD">0</div>
                                                </div>
                                                <i class="bi bi-chevron-left text-primary"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-12">
                                        <a href="#" class="text-decoration-none">
                                            <div class="card-box d-flex align-items-center justify-content-between rounded-4"
                                                style="background-color: #FEF2F2;">
                                                <div class="icon-box bg-danger bg-opacity-25 text-danger">
                                                    <i class="bi bi-heart-fill"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">لایک ها</div>
                                                    <div class="fw-bold text-danger">0</div>
                                                </div>
                                                <i class="bi bi-chevron-left text-danger"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- اشتراک -->
                    <div class="col-md-3 pe-3">
                        <div class="card-box text-white text-center align-content-center" style="background: #1654CD;">
                            <h5 class="fw-bold mb-4 text-warning">شما اشتراک ندارید!</h5>
                            <p class="mb-4 p-1 rounded-pill text-center" style="background-color: #2563EB;">با خرید
                                اشتراک تا ۷۸٪
                                تخفیف نسبت به خرید تکی دریافت کنید</p>
                            <button class="btn btn-light text-primary rounded-pill">خرید اشتراک</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- alert --}}
            <div class="col-md-12">
                <div class="alert alert-costum alert-dismissible mt-5 mb-0">
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> --}}
                    <button type="button" data-bs-dismiss="alert"
                        class="btn collapse2 btn-sm btn-dark slider-close-btn slider-toggle"><i class="bi bi-dash"
                            style="position: relative;"></i></button>
                    <strong>توجه!</strong>
                    <div class="row mt-3">
                        <div class="col-md-9">
                            <p class="text-alert mt-2">
                                لطفا جهت استفاده آسان تر از سامانه، از راهتماى ساماته استفاده كنيد.
                                در صورتى كه مايل به ايجاد درخواست جديد هستيد از كزينه درخواست جديد در همين صفحه استفاده
                                كنيد. و يا
                                از متوى سمت راست سامانه، كزينه درخواست رزرو تابلو را
                                انتخاب كرده و بر اساس نوع تابلو درخواست خودرا ايجاد كنيد.
                                در صورتى كه درخواست شما در انتظار تاييد كارشناس سامانه است، منتظر بمانيد تا بيامك مربوط به
                                تاييد و
                                يا رد درخواست براى شما ارسال شود.
                                ـر صورتى كه درخواست شما تابيد شده است وبيامك مربوط به أن براى شما ارسال شده است، جهت تاييد
                                تهايى و
                                ادامه درخواست از منوى سمت راس
                                رزرو تابلو را انتخاب كرده وبر اساس نوع تايلو درخواست هاى خود را انتخاب ومشاهده كنيد.

                                وادامه درخواست از منوى سمت راست ساماته، كزينه درخواست
                                ر صیرتی كه درخواست شما رد شده است و پيامك مربوط به آن براى شما ارسال شده است، جهت مشاهده
                                دلیل رد
                                درخواست و ایجاد درخواست جديد از منوى سمت راست
                                سامانه، كزينه درخواست رزرو تابلورا انتخاب كرده وبر اساس نوع تابلو درخواست هاى خودرا انتخاب
                                ومشاهده
                                كنيد.

                                ٠ ويديو هاى من

                                صورت بروز هر كونه مشكل با شماره تلفن ٠٣٥٣٨٢٧٧٢٥٠ و٠٣٥٣٣١٣٥٣٠٨ واحد تبليغات (آقاى سلمانى)
                                تماس
                                بكيريد.
                            </p>
                        </div>
                        <div class="col-md-3 text-center">
                            <img src="{{ asset('site/public/img/User_Panel-question.png') }}" alt="question"
                                class="object-fit-cover" width="250">
                        </div>
                    </div>
                </div>
            </div>
            {{-- slider --}}
            <div class="col-12 mt-5">
                <div id="accordion">
                    <div class="card border-0">
                        <div class="card-header border-0 p-0">
                            <div class="slider-header">
                                <span>اسلایدر تبلیغاتی</span>
                                <a class="btn btn-light plus-btn border border-end-0 collapse1" data-bs-toggle="collapse"
                                    href="#collapseOne"><i class="bi bi-plus" style="position: relative;top:1px"></i></a>
                            </div>
                        </div>
                        <div id="collapseOne" class="collapse show border-0" data-bs-parent="#accordion">
                            <button type="button" data-bs-toggle="collapse" href="#collapseOne"
                                class="btn collapse2 btn-sm btn-dark slider-close-btn slider-toggle"><i class="bi bi-dash"
                                    style="position: relative;top:1px"></i></button>
                            <div class="card-body bg-transparent p-0 border-0">
                                <div class="splide" id="slider_panel" role="group"
                                    aria-label="Splide Basic HTML Example">
                                    <div class="splide__track rounded-3 shadow-sm">
                                        <ul class="splide__list">
                                            <li class="splide__slide"><img src="{{ asset('1.jpg') }}" alt="">
                                            </li>
                                            <li class="splide__slide"><img src="{{ asset('2.jpg') }}" alt="">
                                            </li>
                                            <li class="splide__slide"><img src="{{ asset('3.jpg') }}" alt="">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- adds and classes and more --}}
            <div class="col-md-12">
                <div class="row mt-5 pb-2 px-0 g-0 gap-3">
                    <div class="col-md-3 pe-0">
                        <div id="accordionthree">
                            <div class="card border-0">
                                <div class="card-header border-0 p-0">
                                    <div class="slider-header">
                                        <span>ویدیو تبلیغات</span>
                                        <a class="btn btn-light plus-btn border border-end-0 collapse1"
                                            data-bs-toggle="collapse" href="#collapsethree"><i class="bi bi-plus"
                                                style="position: relative;top:1px"></i></a>
                                    </div>
                                </div>
                                <div id="collapsethree" class="collapse show border-0" data-bs-parent="#accordionthree">
                                    <button type="button" data-bs-toggle="collapse" href="#collapsethree"
                                        class="btn collapse2 btn-sm btn-dark slider-close-btn slider-toggle border"><i
                                            class="bi bi-dash" style="position: relative;top:1px"></i></button>
                                    <div class="card-body bg-transparent p-0 border-0">
                                        <div class="border rounded-3 bg-white shadow-sm p-0">
                                            <div class="video"
                                                style="aspect-ratio: 9 / 16; position: relative; overflow: hidden;border-radius:8px">
                                                <img id="video-cover" src="{{ asset('site/public/img/1.png') }}"
                                                    class="img"
                                                    style="width:100%; height:100%; object-fit:cover;z-index: 0;"
                                                    alt="">
                                                <video src="{{ asset('divar.mp4') }}" id="video-player" class="d-none"
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
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col ps-0">
                        <div id="accordionTwo">
                            <div class="card border-0">
                                <div class="card-header border-0 p-0">
                                    <div class="slider-header">
                                        <span>پست های شما</span>
                                        <a class="btn btn-light plus-btn border border-end-0 collapse1"
                                            data-bs-toggle="collapse" href="#collapsetwo"><i class="bi bi-plus"
                                                style="position: relative;top:1px"></i></a>
                                    </div>
                                </div>
                                <div id="collapsetwo" class="collapse show border-0" data-bs-parent="#accordionTwo">
                                    <button type="button" data-bs-toggle="collapse" href="#collapsetwo"
                                        class="btn collapse2 btn-sm slider-close-btn slider-toggle border"
                                        style="top: 1px:left:1px;"><i class="bi bi-dash"
                                            style="position: relative;top:1px"></i></button>
                                    <div class="card-body bg-transparent p-0 border-0">
                                        <div class="border rounded-3 bg-white shadow-sm p-3 m-0 h-100">
                                            <!-- تب آگهی‌ها و کلاس‌ها -->
                                            <div class="">
                                                <ul class="nav nav-tabs mb-3 pe-0 border-bottom-0 position-relative"
                                                    id="tabTwo" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link tabtow-link text-dark active"
                                                            id="ads-tab" data-bs-toggle="tab" data-bs-target="#ads"
                                                            type="button" role="tab">
                                                            <i class="bi bi-newspaper ms-2"></i>
                                                            آگهی‌ها
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link tabtow-link text-dark" id="classes-tab"
                                                            data-bs-toggle="tab" data-bs-target="#classes" type="button"
                                                            role="tab">
                                                            <i class="bi bi-pencil ms-2"></i>
                                                            کلاس‌های آموزشی
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link tabtow-link text-dark" id="opper-tab"
                                                            data-bs-toggle="tab" data-bs-target="#opper" type="button"
                                                            role="tab">
                                                            <i class="bi bi-newspaper ms-2"></i>
                                                            فرصت های شغلی
                                                        </button>
                                                    </li>
                                                </ul>
                                                <div class="tab-content" id="tabTwoContent">
                                                    <div class="tab-pane fade show active" id="ads"
                                                        role="tabpanel">
                                                        <div
                                                            class="school-event-card row d-flex align-items-center flex-wrap border-top">
                                                            <!-- سمت راست: تصویر و اطلاعات -->
                                                            <div class="col-2 p-0">
                                                                <img src="{{ asset('https://kanon.royceceramica.com/files/files/1/img3.jpg') }}"
                                                                    class="event-image" alt="رویداد">
                                                            </div>
                                                            <!-- سمت چپ: تاریخ و دکمه -->
                                                            <div class="text-start col-10 pe-4 position-relative">
                                                                <div class="discount-squer"
                                                                    style="position: absolute;left: -11px;top: -38px;">
                                                                    <img src="{{ asset('Group 1.svg') }}" width="90"
                                                                        alt="discount">
                                                                    <span class="d-flex"
                                                                        style="font-size: 12px;font-weight: 800;position: absolute;right: 12px;top: 7px;"
                                                                        dir="ltr">
                                                                        <span class="me-1"
                                                                            style="font-size: 13px;">تخفیف</span>
                                                                        <strong class=""
                                                                            style="font-size: 12px;">10%</strong>
                                                                    </span>
                                                                </div>
                                                                <div class=" d-flex justify-content-between position-relative"
                                                                    style="bottom: 33px;width: 88%;" dir="ltr">
                                                                    <div class="" style="padding-top: 4px;">
                                                                        <p class="text-center m-0"
                                                                            style="font-size: 14px;direction: rtl;font-weight:bold;margin-bottom:4px">
                                                                            <span class="text-dark"
                                                                                style="font-size: 14px;">اعتبار :
                                                                            </span>
                                                                            <span class="text-primary"
                                                                                style="font-size: 14px">1403/05/08</span>
                                                                            <span class="text-dark"
                                                                                style="font-size: 14px;">الی</span>
                                                                            <span class="text-primary"
                                                                                style="font-size: 14px">1403/05/20</span>
                                                                        </p>
                                                                    </div>
                                                                    <a href="#"
                                                                        class="text-reset text-decoration-none">
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
                                                                    <p class="text-muted text-intro mt-2 position-relative"
                                                                        style="bottom: 12px;">
                                                                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از
                                                                        صنعت چاپ و با
                                                                        استفاده
                                                                        از طراحان
                                                                        گرافیک است
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="school-event-card row d-flex align-items-center flex-wrap border-top">
                                                            <!-- سمت راست: تصویر و اطلاعات -->
                                                            <div class="col-2 p-0">
                                                                <img src="{{ asset('https://kanon.royceceramica.com/files/files/1/img3.jpg') }}"
                                                                    class="event-image" alt="رویداد">
                                                            </div>
                                                            <!-- سمت چپ: تاریخ و دکمه -->
                                                            <div class="text-start col-10 pe-4 position-relative">
                                                                <div class="discount-squer"
                                                                    style="position: absolute;left: -11px;top: -38px;">
                                                                    <img src="{{ asset('Group 1.svg') }}" width="90"
                                                                        alt="discount">
                                                                    <span class="d-flex"
                                                                        style="font-size: 12px;font-weight: 800;position: absolute;right: 12px;top: 7px;"
                                                                        dir="ltr">
                                                                        <span class="me-1"
                                                                            style="font-size: 13px;">تخفیف</span>
                                                                        <strong class=""
                                                                            style="font-size: 12px;">10%</strong>
                                                                    </span>
                                                                </div>
                                                                <div class=" d-flex justify-content-between position-relative"
                                                                    style="bottom: 33px;width: 88%;" dir="ltr">
                                                                    <div class="" style="padding-top: 4px;">
                                                                        <p class="text-center m-0"
                                                                            style="font-size: 14px;direction: rtl;font-weight:bold;margin-bottom:4px">
                                                                            <span class="text-dark"
                                                                                style="font-size: 14px;">اعتبار :
                                                                            </span>
                                                                            <span class="text-primary"
                                                                                style="font-size: 14px">1403/05/08</span>
                                                                            <span class="text-dark"
                                                                                style="font-size: 14px;">الی</span>
                                                                            <span class="text-primary"
                                                                                style="font-size: 14px">1403/05/20</span>
                                                                        </p>
                                                                    </div>
                                                                    <a href="#"
                                                                        class="text-reset text-decoration-none">
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
                                                                    <p class="text-muted text-intro mt-2 position-relative"
                                                                        style="bottom: 12px;">
                                                                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از
                                                                        صنعت چاپ و با
                                                                        استفاده
                                                                        از طراحان
                                                                        گرافیک است
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="school-event-card row d-flex align-items-center flex-wrap border-top">
                                                            <!-- سمت راست: تصویر و اطلاعات -->
                                                            <div class="col-2 p-0">
                                                                <img src="{{ asset('https://kanon.royceceramica.com/files/files/1/img3.jpg') }}"
                                                                    class="event-image" alt="رویداد">
                                                            </div>
                                                            <!-- سمت چپ: تاریخ و دکمه -->
                                                            <div class="text-start col-10 pe-4 position-relative">
                                                                <div class="discount-squer"
                                                                    style="position: absolute;left: -11px;top: -38px;">
                                                                    <img src="{{ asset('Group 1.svg') }}" width="90"
                                                                        alt="discount">
                                                                    <span class="d-flex"
                                                                        style="font-size: 12px;font-weight: 800;position: absolute;right: 12px;top: 7px;"
                                                                        dir="ltr">
                                                                        <span class="me-1"
                                                                            style="font-size: 13px;">تخفیف</span>
                                                                        <strong class=""
                                                                            style="font-size: 12px;">10%</strong>
                                                                    </span>
                                                                </div>
                                                                <div class=" d-flex justify-content-between position-relative"
                                                                    style="bottom: 33px;width: 88%;" dir="ltr">
                                                                    <div class="" style="padding-top: 4px;">
                                                                        <p class="text-center m-0"
                                                                            style="font-size: 14px;direction: rtl;font-weight:bold;margin-bottom:4px">
                                                                            <span class="text-dark"
                                                                                style="font-size: 14px;">اعتبار :
                                                                            </span>
                                                                            <span class="text-primary"
                                                                                style="font-size: 14px">1403/05/08</span>
                                                                            <span class="text-dark"
                                                                                style="font-size: 14px;">الی</span>
                                                                            <span class="text-primary"
                                                                                style="font-size: 14px">1403/05/20</span>
                                                                        </p>
                                                                    </div>
                                                                    <a href="#"
                                                                        class="text-reset text-decoration-none">
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
                                                                    <p class="text-muted text-intro mt-2 position-relative"
                                                                        style="bottom: 12px;">
                                                                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از
                                                                        صنعت چاپ و با
                                                                        استفاده
                                                                        از طراحان
                                                                        گرافیک است
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="classes" role="tabpanel">
                                                        <ul class="list-group list-group-flush small pe-0">
                                                            <li class="list-group-item">کلاس آموزش React - دوشنبه‌ها</li>
                                                            <li class="list-group-item">کلاس آموزش AutoCAD - چهارشنبه‌ها
                                                            </li>
                                                        </ul>
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
        </div>
    </div>
@endsection
@section('script')
    <script>
        var splide = new Splide('#slider_panel', {
            type: 'loop',
            direction: 'rtl',
            perPage: 1,
            autoplay: true,
            cover: true,
            height: '400px',
        });
        splide.mount();


        // minus
        $(document).ready(function() {
            $(".collapse1").on("click", function() {
                let card = $(this).closest(".card");
                card.find(".collapse2").show();
                let parent = $(this).closest(".card-header");
                parent.hide();

                var rounded = card.find(".rounded-0");
                rounded.removeClass("rounded-0");
                rounded.addClass("rounded-3");
            });
            $(".collapse2").on("click", function() {
                $(this).hide();
                let card = $(this).closest(".card");

                var rounded = card.find(".rounded-3");
                rounded.removeClass("rounded-3");
                rounded.addClass("rounded-0");

                card.find(".card-header").show();
            });
        });
    </script>
    {{-- video --}}
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
@endsection
