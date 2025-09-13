@php
    // دریافت زمان حال با منطقه زمانی تنظیم شده در برنامه
    $now = \Carbon\Carbon::now();

    // دریافت تبلیغات فعال از دیتابیس
    $advs = App\Models\topadv::where('start_date', '<=', $now)
        ->where('end_date', '>=', $now)
        ->orderBy('id', 'desc')
        ->get();

    $organs = App\Models\Organ::latest()->take(3)->get();
    $register_message = App\Models\RegisterMessage::first();
@endphp

@if ($advs->isNotEmpty())
    <div id="top-bar-container" style="width: 100%; position: fixed; top: 0; z-index: 2000;">
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
                        <span class="text {{ $adv->animation_type ? 'animate__animated ' . $adv->animation_type : '' }}">
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
        style="width: 100%; min-height: var(--top-bar-height); position: fixed; top: 0; z-index: 2000; padding-top: var(--top-bar-height); background-color: var(--top-bar-color)">
        <div class="top-ad-container-close"></div>
    </div>
@endif
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
</style>
@php
    $request = request();
    $previousUrl = url()->previous(); // آدرس کامل صفحه قبلی
    $currentUrl = $request->fullUrl(); // آدرس کامل صفحه فعلی

    // گرفتن نام روت قبلی
    $previousRoute = app('router')
        ->getRoutes()
        ->match(app('request')->create($previousUrl))
        ->getName();
@endphp
@if ($register_message->status != 2)
    @if (Route::currentRouteName() == 'register' and !$previousRoute or
            Route::currentRouteName() == 'register' and $previousRoute != 'home' or
            Route::currentRouteName() == 'register' and !$errors->any() and $register_message->status)
        <div class="modal fade" id="registermessageModal" tabindex="-1" dir="rtl">
            <div class="modal-dialog modal-lg">
                <div class="modal-content text-center">
                    <div class="modal-header bg-primary text-white">
                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button> --}}
                        <h5 class="modal-title" id="customModalLabel">قبل از ثبت نام بخوانید</h5>
                    </div>
                    <div class="modal-body">
                        <p class="text-start" style="text-align: justify;">{{ $register_message->text }}</p>
                    </div>
                    <div class="modal-footer d-flex justify-content-end">
                        <a href="/" class="btn btn-danger">لغو</a>
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">تایید</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
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
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('job-opportunity.index') }}">فرصت های شغلی</a>
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
                            <div id="toggleSearch" class="btn btn-icon position-relative align-items-center"
                                type="button">
                                <span class="bi bi-search"></span>

                                <!-- اینپوت کنار آیکون (سمت راست باز میشه) -->
                                <div id="searchInputWrapper" class="search-box-horizontal p-0 ">
                                    <input type="text" class="input" placeholder="جستجو..." />
                                </div>
                            </div>

                            <!-- آیکون‌های دیگر -->
                            <a href="#" class="btn btn-icon"><span class="bi bi-basket"></span></a>
                            {{-- <div class="button-container">
                                <a href="/login" class="btn btn-icon btn-primary login_btn">ورود</a>
                                @if (Route::currentRouteName() == 'register' and !$previousRoute or Route::currentRouteName() == 'register' and $previousRoute != 'home' or Route::currentRouteName() == 'register' and !$errors->any() and $register_message->status)
                                    <a data-bs-toggle="modal" data-bs-target="#registermessageModal"
                                        class="btn btn-icon btn-primary register_btn">ثبت نام</a>
                                @else
                                    <a href="{{ route('register') }}"
                                        class="btn btn-icon btn-primary register_btn">ثبت نام</a>
                                @endif
                            </div> --}}
                            <div class="flex justify-center items-center">
                                <div class="button-container">
                                    <a href="/login" class="btn btn-icon login-btn login_btn">ورود</a>
                                    @if (Route::currentRouteName() == 'register' and !$previousRoute or
                                            Route::currentRouteName() == 'register' and $previousRoute != 'home' or
                                            Route::currentRouteName() == 'register' and !$errors->any() and $register_message->status)
                                        <a data-bs-toggle="modal" data-bs-target="#registermessageModal"
                                            class="btn btn-icon register-btn register_btn">ثبت نام</a>
                                    @else
                                        <a href="{{ route('register') }}"
                                            class="btn btn-icon register-btn register_btn">ثبت
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
    </header>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

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

    $(document).ready(function() {
        $('#registermessageModal').modal({
            backdrop: 'static', // کلیک روی بک‌گراند کار نکنه
            keyboard: false // دکمه Escape کار نکنه
        });
        $('#registermessageModal').modal('show');
    });
</script>
