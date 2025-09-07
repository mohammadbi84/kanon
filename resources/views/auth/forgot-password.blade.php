@extends('site.layout.master')
@section('head')
    <title>فراموشی رمز عبور</title>
    <!-- link slider -->
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
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

        /* رمز */
        .password-toggle {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
    <style>
        /* steps */
        .stepper {
            position: relative;
            margin-top: 20px;
        }

        .stepper::before {
            content: '';
            position: absolute;
            top: 24px;
            left: 0;
            right: 0;
            height: 3px;
            background-color: #e0e0e0;
            z-index: 0;
        }

        .step {
            position: relative;
            text-align: center;
            z-index: 1;
            flex: 1;
        }

        .step .step-number {
            width: 50px;
            height: 50px;
            line-height: 40px;
            padding-top: 3%;
            background-color: #e0e0e0;
            color: #fff;
            border-radius: 50%;
            margin: 0 auto 10px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .step.active .step-number {
            background-color: #EBA607;
        }

        .step .step-title {
            font-size: 14px;
            color: #555;
        }

        .step.active .step-title {
            font-weight: bold;
            color: #EBA607;
        }
    </style>
    <style>
        .slide-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: #252641c7;
            color: #ffffff;
            text-align: center;
            min-height: 95px;
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

        .form_btn {
            background: transparent !important;
            border: none !important;
        }

        /* .login_btn {
                                display: none !important;
                            } */
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

        .bi-arrow-left::before {
            margin-top: 4px !important;
        }

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
            {{-- فورم سمت چپ --}}
            <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
                @if ($status == 1)
                    <div class="text-end">
                        <a href="/login" class="btn btn-outline-secondary btn-sm">
                            بازگشت
                            <i class="bi bi-arrow-left me-1" style="position: relative;top: 2px;"></i>
                        </a>
                    </div>
                    <h4 class="mb-4">فراموشی رمز عبور</h4>
                    <p class="text-muted mb-2">برای تغییر رمز عبور لطفا موارد خواسته شده را تکمیل کنید.</p>
                    <form action="{{ route('forgot_password.store') }}" method="post">
                        @csrf
                        <div class="mb-3 mt-4">
                            <div class="autocomplete @if (old('number')) filled @endif"
                                id="autocompleteBoxnumber">
                                <input type="text" id="searchInputnumber" class="only-number" name="number"
                                    value="{{ old('number') }}" oninput="nameinput('number')"
                                    @error('number')
                                                    style="border:red solid 1px"
                                                    @enderror>
                                <label for="searchInputnumber">شماره شناسایی یا کد رهگیری</label>
                                <span class="clear-btn" id="clearBtn_number" onclick="clearInput('number')"
                                    @if (old('number')) style="display:block !important" @endif>×</span>
                            </div>
                            @error('number')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3 mt-4">
                            <div class="autocomplete @if (old('mobile')) filled @endif"
                                id="autocompleteBoxmobile">
                                <input type="text" id="searchInputmobile" class="only-number" name="mobile"
                                    value="{{ old('mobile') }}" oninput="nameinput('mobile')"
                                    @error('mobile')
                                                    style="border:red solid 1px"
                                                    @enderror>
                                <label for="searchInputmobile">شماره موبایل</label>
                                <span class="clear-btn" id="clearBtn_mobile" onclick="clearInput('mobile')"
                                    @if (old('mobile')) style="display:block !important" @endif>×</span>
                            </div>
                            @error('mobile')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 mb-3 border py-2 rounded-3 w-100">
                            ذخیره
                        </button>
                    </form>
                @elseif ($status == 2)
                    <div class="text-end">
                        <a href="/login" class="btn btn-outline-secondary btn-sm">
                            بازگشت
                            <i class="bi bi-arrow-left me-1" style="position: relative;top: 2px;"></i>
                        </a>
                    </div>
                    <h4 class="mb-4">اعتبار سنجی</h4>
                    <p class="text-muted mb-5">لطفا کد اعتبارسنجی ارسال شده به موبایل خود را در کادر زیر وارد نمایید.</p>
                    <form action="{{ route('forgot_password.code_check') }}" method="post" id="verifyForm">
                        @csrf
                        <div class="d-flex justify-content-between mb-4" dir="ltr">
                            @for ($i = 1; $i <= 6; $i++)
                                <input type="text" class="form-control text-center mx-1 only-number"
                                    {{ $i == 1 ? 'autofocus' : '' }} maxlength="1" name="code[]"
                                    id="code{{ $i }}" style="width: 45px; height: 50px; font-size: 22px;"
                                    required>
                            @endfor
                        </div>
                        <div class="mb-4 mt-3">
                            <div class="autocomplete @if (old('password')) filled @endif"
                                id="autocompleteBoxpassword">
                                <input type="password" id="searchInputpassword" class="" name="password"
                                    value="{{ old('password') }}" oninput="nameinput('password')"
                                    @error('password')
                                    style="border:red solid 1px"
                                    @enderror>
                                <label for="searchInputpassword">رمز عبور</label>
                                <span class="position-absolute password-toggle"
                                    onclick="togglePassword('searchInputpassword')">
                                    <i class="bi bi-eye-slash" id="toggleIconsearchInputpassword"></i>
                                </span>
                            </div>
                            @error('password')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <input type="hidden" name="id" value="{{ $user }}">
                        <button type="submit" class="btn btn-primary w-100 mb-3">تایید</button>
                    </form>
                    <div class="text-end mt-0" style="position: relative;bottom: 16px;">
                        <small id="resend_div">
                            <div class="progress-timer-container ps-1">
                                <div class="progress-bar-text" id="progress-time-label">02:00</div>
                            </div>
                            <div id="resend-btn" class="text-muted mt-2 text-center" style="display: none;">
                                <button id="resend-code-btn" class="form_btn" data-user-id="{{ $user }}">ارسال
                                    مجدد کد تایید</button>
                            </div>
                        </small>
                    </div>
                @else
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <!-- slider -->
    <script>
        var splide = new Splide('#slider-1', {
            type: 'loop',
            perPage: 1,
            autoplay: true,
        });
        splide.mount();
    </script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {{-- inputs --}}
    {{-- رمز --}}
    <script>
        function togglePassword(id) {
            const passwordInput = document.getElementById(id);
            const toggleIcon = document.getElementById('toggleIcon' + id);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            }
        }
    </script>
    <script>
        $(document).on("input", ".only-number", function() {
            this.value = this.value.replace(/[^0-9]/g, '');
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
    <script>
        document.getElementById('refresh-captcha').onclick = function() {
            // alert('ok');
            fetch('/refresh-captcha')
                .then(res => res.text())
                .then(data => {
                    document.querySelector('#captcha').innerHTML = data;
                });
            // alert('ok');
        };
    </script>
    {{-- رمز --}}
    <script>
        function togglePassword(id) {
            const passwordInput = document.getElementById(id);
            const toggleIcon = document.getElementById('toggleIcon' + id);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            }
        }
    </script>
    {{-- code --}}
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
                    $("#searchInputpassword").focus();
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
                $('#resend-btn').hide();
                $('#progress-time-label').show();

                let timer = setInterval(function() {
                    let minutes = Math.floor(timeLeft / 60);
                    let seconds = timeLeft % 60;

                    $('#progress-time-label').text(
                        (minutes < 10 ? '0' + minutes : minutes) + ':' +
                        (seconds < 10 ? '0' + seconds : seconds)
                    );

                    if (timeLeft <= 0) {
                        clearInterval(timer);
                        $('#resend-btn').show();
                        $('#progress-time-label').hide();
                    }

                    timeLeft--;
                }, 1000);
            }

            // شروع تایمر هنگام لود صفحه
            resetResendTimer(120);
        });
    </script>
@endsection
