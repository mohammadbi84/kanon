@extends('site.layout.master')

@section('head')
    <title>تایید شماره موبایل</title>
    <style>
        body {
            background-color: #F3F3F9;
        }

        a {
            text-decoration: none;
        }

        .login-card {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            height: 580px;
        }

        .form-control {
            border-radius: 5px;
            /* padding-right: 40px; */
        }

        .input-group-text {
            border: none;
            background: none;
            cursor: pointer;
        }

        .btn-primary {
            border-radius: 5px;
            padding: 10px 0;
            background-color: #EBA607;
            border-color: #c58c06;
        }

        .btn-primary:hover {
            background-color: #f6b829;
            border-color: #c58c06;
        }

        .btn-primary:active {
            background-color: #f6b829 !important;
            border-color: #c58c06 !important;
        }

        /* inputs */
        .autocomplete {
            position: relative;
            /* width: 300px; */
        }

        .autocomplete input {
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
        .autocomplete.filled label {
            outline: none !important;
            border: none !important;
            top: -10px;
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
    </style>
    <style>
        .slide-caption {
            position: absolute;
            bottom: 7%;
            left: 0;
            right: 0;
            background: #252641aa;
            color: #ffffff;
            text-align: center;
            padding: 11px 0;
            font-size: 16px;
        }

        .splide .splide__pagination .splide__pagination__page {
            height: 8px !important;
            width: 50px !important;
            border-radius: 5px !important;
            background: #e0e0e0 !important;
            opacity: 1;
        }

        .splide__arrow {
            display: none;
        }

        .splide .splide__pagination .splide__pagination__page.is-active {
            background: #E9A507 !important;
            transform: none;
        }

        /* .login_btn {
                                                        display: none !important;
                                                    } */

        .form-control:focus {
            color: var(--bs-body-color);
            background-color: var(--bs-body-bg);
            border-color: #f6b829 !important;
            outline: 0;
            box-shadow: 0 0 0 .25rem #e4a71855 !important;
        }

        .form_btn {
            background: transparent !important;
            border: none !important;
        }

        .progress-bar-bg {
            width: 100%;
            height: 10px;
            background-color: #e0e0e0;
            border-radius: 6px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            width: 100%;
            background-color: #eba607;
            transition: width 1s linear;
            border-radius: 6px;
        }

        .progress-bar-text {
            margin-top: 8px;
            font-size: 14px;
            color: #333;
            font-weight: bold;
        }
    </style>
    <style>
        .login-btn {
            background-color: transparent !important;
            width: 70px !important;
            color: white !important;
        }

        .register-btn {
            color: black !important;
            background-color: #ffffff00 !important;
            border: none;
            width: 70px !important;

        }


        .background-slide {
            position: absolute;
            width: 70px;
            height: 44px;
            background-color: #EBA607;
            border-radius: 0.5rem;
            right: 80px;
            top: 6px;
            z-index: -1;
            transition: transform 0.5s cubic-bezier(0, -0.55, 0, 1);
            transform: translateX(74px);
        }

        .login-btn,
        .register-btn {
            position: relative;
            z-index: 1;
        }

        .register-btn:hover {
            transition-delay: 50ms;
            color: white !important;
            background-color: #ffffff00 !important;
        }

        .register-btn:hover~.background-slide {
            transform: translateX(0px);
        }

        .login-btn:has(+ .register-btn:hover) {
            transition-delay: 0.1s;
            background-color: #ffffff;
            color: black !important;
        }

        .register-btn:hover {
            background-color: transparent;
            border-color: #2563eb;
        }
    </style>
    <!-- input with floating-label -->
    <link rel="stylesheet" type="text/css" href="{{ asset('site/src/style/input-with-floating-label.css') }}" media="screen">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/src/style/input-with-floating-label-rtl-fix.css') }}"
        media="screen">
    <!-- input with floating-label -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="container wrapper d-flex align-items-center justify-content-center mb-5" style="margin-top: 120px">
        <div class="row w-75 login-card bg-white">
            <!-- اسلایدر راست -->
            <div class="col-md-6 d-none d-md-block p-0">
                <section dir="ltr" class="splide h-100" id="slider-1" aria-label="Splide Basic HTML Example">
                    <div class="splide__track h-100 shadow">
                        <ul class="splide__list h-100">
                            @foreach ($sliders as $slider)
                                <li class="splide__slide position-relative">
                                    <a href="#">
                                        <img src="{{ asset($slider->image) }}" class="h-100"
                                            style="object-fit: cover;width: 100%;height: 100%;">
                                        <div class="slide-caption">متن اسلاید اول</div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </section>
            </div>

            <!-- فرم ورود کد تایید -->
            <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
                <h4 class="mb-4">تایید شماره موبایل</h4>
                <p class="text-muted mb-5">لطفا کد تایید ارسال شده را وارد کنید.</p>
                <form action="{{ route('code_check') }}" method="post" id="verifyForm">
                    @csrf
                    <div class="d-flex justify-content-between mb-5" dir="ltr">
                        @for ($i = 1; $i <= 6; $i++)
                            <input type="text" class="form-control text-center mx-1 only-number"
                                {{ $i == 1 ? 'autofocus' : '' }} maxlength="1" name="code[]" id="code{{ $i }}"
                                style="width: 45px; height: 50px; font-size: 22px;" required>
                        @endfor
                    </div>
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <button type="submit" class="btn btn-primary w-100 mb-3">تایید</button>
                </form>
                <div class="text-end mt-0" style="position: relative;bottom: 18px;">
                    <small id="resend_div">
                        <div class="progress-timer-container ps-1">
                            <div class="progress-bar-text" id="progress-time-label">02:00</div>
                        </div>
                        <div id="resend-text" class="mt-3 text-muted text-center">ارسال مجدد کد تا اتمام زمان</div>
                        <div id="resend-btn" class="text-muted mt-2 text-center" style="display: none;">
                            <button id="resend-code-btn" class="form_btn" data-user-id="{{ $user->id }}">ارسال مجدد
                                کد</button>
                        </div>
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- slider -->
    <script>
        var splide = new Splide('#slider-1', {
            type: 'loop',
            perPage: 1,
            autoplay: true,
        });
        splide.mount();
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            const inputs = $("input[name='code[]']");

            inputs.on("input", function() {
                const index = inputs.index(this);
                let value = $(this).val();

                // فقط عدد قبول کن
                value = value.replace(/[^0-9]/g, '');
                this.value = value;

                // فقط اگر عدد معتبر وارد شد برو فیلد بعدی
                if (value.length === 1 && index < inputs.length - 1) {
                    inputs.eq(index + 1).focus();
                }

                // اگر آخرین فیلد پر شد، فرم رو ارسال کن
                if (index === inputs.length - 1 && value.length === 1) {
                    $("#verifyForm").submit();
                }
            });

            // رفتن به عقب با backspace
            inputs.on("keydown", function(e) {
                const index = inputs.index(this);
                if (e.key === "Backspace" && !$(this).val() && index > 0) {
                    inputs.eq(index - 1).focus();
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // ارسال مجدد کد با AJAX
            $(document).on('click', '#resend-code-btn', function() {
                let userId = $(this).data('user-id');
                let btn = $(this);

                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> در حال ارسال...');

                $.ajax({
                    url: '/resend-code/' + userId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // نمایش پیام موفقیت
                            toastr.success('کد جدید با موفقیت ارسال شد');

                            // ریست تایمر
                            resetResendTimer(300);

                            // غیرفعال کردن دکمه تا پایان تایمر
                            btn.hide();
                            $('#resend-text').show();
                        } else {
                            toastr.error('خطا در ارسال کد: ' + response.message);
                            btn.prop('disabled', false).text('ارسال مجدد کد');
                        }
                    },
                    error: function(xhr) {
                        toastr.error('خطا در ارتباط با سرور');
                        btn.prop('disabled', false).text('ارسال مجدد کد');
                    }
                });
            });

            // تابع ریست تایمر
            function resetResendTimer(time) {
                let timeLeft = time; // 2 دقیقه = 120 ثانیه
                $('#resend-text').show();
                $('#resend-btn').hide();

                let timer = setInterval(function() {
                    let minutes = Math.floor(timeLeft / 60);
                    let seconds = timeLeft % 60;

                    $('#progress-time-label').text(
                        (minutes < 10 ? '0' + minutes : minutes) + ':' +
                        (seconds < 10 ? '0' + seconds : seconds)
                    );

                    if (timeLeft <= 0) {
                        clearInterval(timer);
                        $('#resend-text').hide();
                        $('#resend-btn').show();
                    }

                    timeLeft--;
                }, 1000);
            }

            // شروع تایمر هنگام لود صفحه
            resetResendTimer(120);
        });
    </script>
@endsection
