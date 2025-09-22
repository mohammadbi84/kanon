<!-- در صورت عدم وجود تبلیغ فعال، نوار fallback به صورت پیش‌فرض نمایش داده می‌شود -->
<div id="top-bar"
    style="width: 100%; min-height: var(--top-bar-height); position: fixed; top: 0; z-index: 2000; padding-top: var(--top-bar-height); background-color: var(--top-bar-color)">
    <div class="top-ad-container-close"></div>
</div>
<style>
    .input {
        height: 98%;
        width: 100%;
        padding-right: 8px;
    }

    .search-box-horizontal {
        position: absolute;
        top: 50%;
        left: 100%;
        transform: translateY(-50%) translateX(10px);
        width: 200px;
        height: 100%;
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s ease;
        z-index: 100;
        background: #D0E8FF;
    }

    .search-box-horizontal.show {
        opacity: 1;
        pointer-events: auto;
        transform: translateY(-50%) translateX(0);
    }

    .search-box-horizontal input {
        border-radius: 4px;
        border: 2px solid #ccc;
    }

    .search-box-horizontal input.focus {
        border-radius: 4px;
        outline: 2px solid #D0E8FF !important;
        border: none;
        /* outline: none; */
    }

    .nav-link i {
        font-size: 13px;
    }

    /* drop down */
    .dropdown-menu.dropdown-animated {
        visibility: hidden;
        opacity: 0;
        transform: translateY(5px);
        transition: all 0.3s ease;
        display: block;
        left: 0 !important;
        /* برای نمایش درست توسط بوت‌استرپ */
    }

    .dropdown .show+.dropdown-animated {
        opacity: 1 !important;
        transform: translateY(0) !important;
        visibility: visible !important;
    }

    /* انیمیشن پالس */
    /* Music Bg */
    .main-menu .navbar .btn-icon {
        width: 45px;
        height: 50px;
    }

    .music-bg {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .music-bg p {
        margin: 0;
        font-size: 9px;
        font-weight: 100;
    }

    .music-bg .lines {
        display: flex;
        width: 24px;
        height: 24px;
        margin: 0 auto 10px;
        align-items: flex-end;
    }

    .music-bg .lines span {
        display: inline-flex;
        margin: 0px 1px;
        width: 7px;
        height: 5px;
        background: #000000;
    }

    /* وقتی موزیک پلی هست */
    .audio-on .lines span:nth-child(1) {
        animation: musicline 2s 0.5s ease-out alternate infinite;
    }

    .audio-on .lines span:nth-child(2) {
        animation: musicline 2s 1s ease-out alternate infinite;
    }

    .audio-on .lines span:nth-child(3) {
        animation: musicline 2s 1.5s ease-out alternate infinite;
    }

    .audio-on .lines span:nth-child(4) {
        animation: musicline 2s 0.25s ease-out alternate infinite;
    }

    .audio-on .lines span:nth-child(5) {
        animation: musicline 2s 0.75s ease-out alternate infinite;
    }

    .audio-on .lines span:nth-child(6) {
        animation: musicline 2s 1.25s ease-out alternate infinite;
    }

    /* Animation Music Line */
    @keyframes musicline {
        0% {
            height: 5px;
        }

        10% {
            height: 10px;
        }

        20% {
            height: 5px;
        }

        30% {
            height: 14px;
        }

        40% {
            height: 18px;
        }

        50% {
            height: 5px;
        }

        60% {
            height: 16px;
        }

        70% {
            height: 10px;
        }

        80% {
            height: 12px;
        }

        90% {
            height: 4px;
        }

        100% {
            height: 18px;
        }
    }
</style>

<div class="container" id="navbar_container">
    <header style="position: relative;z-index:+50">
        <div class="main-menu small">
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
                                <a class="nav-link active" aria-current="page" href="/">
                                    <i class="bi bi-house-fill ms-1"></i> داشبورد</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="bi bi-camera-video-fill ms-1"></i> تبلیغات من</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="bi bi-file-earmark-text-fill ms-1"></i> آگهی های من</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="bi bi-images ms-1"></i> گالری تصاویر</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="bi bi-people-fill ms-1"></i> مدیریت اعضا</a>
                            </li>
                        </ul>
                        <div class="d-flex gap-2 align-items-center justify-content-center position-relative">
                            <!-- آیکون‌های دیگر -->
                            <a id="music-toggle" class="btn btn-icon music-bg audio-on">
                                <div class="lines">
                                    <span></span><span></span><span></span>
                                    <span></span><span></span><span></span>
                                </div>
                                {{-- <p>موسیقی</p> --}}
                            </a>
                            <!-- موزیک -->
                            <audio loop autoplay id="audio-player">
                                <source src="{{ asset('music.mp3') }}" type="audio/mpeg">
                            </audio>
                            <a href="#" class="btn btn-icon"><span class="bi bi-bell"></span></a>
                            {{-- cart --}}
                            <div class="dropdown">
                                <a class="text-decoration-none btn btn-icon" id="cartBtn" data-bs-toggle="dropdown"
                                    type="button" aria-expanded="false">
                                    <span class="bi bi-basket"></span>
                                </a>
                                <!-- منوی دراپ‌داون با انیمیشن -->
                                <ul class="dropdown-menu dropdown-animated text-end p-1 shadow border-0"
                                    style="width:350px">
                                    <li class="bg-white" style="position: sticky;top: 0px;">
                                        <h5 class="dropdown-header text-start border-bottom w-100">
                                            5 کالا
                                        </h5>
                                    </li>
                                    <li class="dropdown-item">
                                        <div class="row border-bottom">
                                            <div class="col-md-5 p-2">
                                                <a href="#">
                                                    <img src="{{ asset('Untitled.png') }}" alt="name"
                                                        class="w-100">
                                                </a>
                                            </div>
                                            <div class="col-md-7 p-2">
                                                <p class="drapdown-title mt-2 text-start">نام محصول</p>
                                                <div class="clearfix pt-2">
                                                    <span class="bg-danger text-white rounded-pill px-2"
                                                        style="font-size: 12px">5%</span>
                                                    <span class="text-secondary" style="font-size: 14px"><del
                                                            class="del">10,000</del></span>
                                                    9,500
                                                    <span class="toman">تومان</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="bg-white p-3 border-top" style="position: sticky;bottom: 0;">
                                        <div class="row ">
                                            <div class="col text-start">
                                                <span class="float-end mt-0 card-price">9,500<span
                                                        class="toman">تومان</span></span>
                                            </div>
                                            <div class="col text-start">
                                                <a href="#" class="btn btn-primary my-auto">مشاهده
                                                    سبدخرید</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                {{-- <ul class="dropdown-menu dropdown-animated text-end p-3 shadow border-0">
                                    <li class="cart-item">
                                        <a href="#" class="header-basket-list-item">
                                            <div class="header-basket-list-item-image">
                                                <img src="{{ asset('Untitled.png') }}" alt="name" class="w-100">
                                            </div>
                                            <div class="header-basket-list-item-content">
                                                <p class="header-basket-list-item-title">
                                                    نام محصول
                                                </p>
                                                <div class="header-basket-list-item-footer">
                                                    <button class="header-basket-list-item-remove">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul> --}}
                            </div>
                            {{-- profile --}}
                            <div class="dropdown">
                                <a class="text-decoration-none" id="userMenuBtn" data-bs-toggle="dropdown"
                                    type="button" aria-expanded="false">
                                    <div class="d-flex align-items-center justify-content-between rounded-4">
                                        <div class="icon-box">
                                            <img src="{{ asset('user.svg') }}" alt="user" width="50">
                                        </div>
                                        <div class="me-2">
                                            <div class="fw-bold text-dark">
                                                {{ Auth::user()->name . ' ' . Auth::user()->family }}
                                            </div>
                                            <small class="text-muted">شناسه : {{ Auth::user()->id }}</small>
                                        </div>
                                    </div>
                                </a>

                                <!-- منوی دراپ‌داون با انیمیشن -->
                                <ul class="dropdown-menu dropdown-animated text-end p-3 shadow border-0"
                                    style="min-width: 250px; border-radius: 20px;" aria-labelledby="userMenuBtn">
                                    <li class="fw-bold mb-2 text-center">فاضل عابدی</li>
                                    <li class="d-flex justify-content-between align-items-center mb-2">
                                        <span>کیف پول</span>
                                        <span class="text-success fw-bold">۰ تومان</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center mb-2">
                                        <span>باقی‌مانده اشتراک</span>
                                        <span class="text-primary fw-bold">غیرفعال</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center mb-3">
                                        <span>باقی‌مانده ویدکوین</span>
                                        <span class="text-warning fw-bold">۲۰</span>
                                    </li>
                                    <hr class="my-2">
                                    <li>
                                        <a class="dropdown-item text-muted d-flex align-items-center justify-content-between"
                                            href="#">
                                            <i class="bi bi-camera-video me-2"></i>
                                            ویدیوهای من
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger d-flex align-items-center justify-content-between"
                                            href="#">
                                            <i class="bi bi-box-arrow-right me-2"></i>
                                            خروج از حساب
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>
</div>



{{-- music --}}
<script>
    const audioPlayer = document.getElementById("audio-player");
    const toggleBtn = document.getElementById("music-toggle");

    // برای مرورگرها نیاز به تعامل کاربر هست، autoplay ممکنه بلاک بشه
    window.addEventListener("load", () => {
        audioPlayer.play().catch(() => {
            console.log("Autoplay بلاک شد، باید روی دکمه کلیک بشه.");
        });
    });

    toggleBtn.addEventListener("click", function(e) {
        e.preventDefault();
        if (audioPlayer.paused) {
            audioPlayer.play();
            toggleBtn.classList.add("audio-on");
        } else {
            audioPlayer.pause();
            toggleBtn.classList.remove("audio-on");
        }
    });
</script>
