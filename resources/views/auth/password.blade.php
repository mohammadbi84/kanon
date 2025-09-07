@extends('site.layout.master')
@section('head')
    <title>ورود</title>
    <!-- link slider -->
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
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
    {{-- login btn --}}
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
    </style>
@endsection
@section('content')
    <div class="container wrapper d-flex align-items-center justify-content-center mb-5" style="margin-top: 120px">
        <div class="row w-75 login-card bg-white justify-content-center">
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
                <div class="text-end">
                    <a href="/login" class="btn btn-outline-secondary btn-sm">
                        بازگشت
                        <i class="bi bi-arrow-left me-1" style="position: relative;top: 2px;"></i>
                    </a>
                </div>
                {{-- متغیر --}}
                @if ($user && $user->hasRole('organ'))
                    @if ($organ && $organ->status == '5' or $organ and $organ->status == '1' and $user->password)
                        <h4 class="mb-4">رمز ورود</h4>
                        <p class="text-muted mb-4">رمز عبور خود را وارد کنید.</p>
                        <form action="{{ route('check_password') }}" method="post">
                            @csrf
                            <div class="mb-5 mt-4">
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
                                <input type="text" name="mobile" value="{{ $user->mobile ?? $user->email }}" hidden>
                            </div>
                            @if (session('login_attempts') >= 1)
                                <div class="row mb-5">
                                    <div class="col">
                                        <div class="">
                                            <div class="autocomplete @if (old('captcha')) filled @endif"
                                                id="autocompleteBoxcaptcha">
                                                <input type="text" id="searchInputcaptcha" class="only-number"
                                                    name="captcha" value="{{ old('captcha') }}"
                                                    oninput="nameinput('captcha')"
                                                    @error('captcha')
                                                    style="border:red solid 1px"
                                                    @enderror>
                                                <label for="searchInputcaptcha">کد امنیتی</label>
                                                <span class="clear-btn" id="clearBtn_captcha"
                                                    onclick="clearInput('captcha')"
                                                    @if (old('captcha')) style="display:block !important" @endif>×</span>
                                            </div>
                                            @error('captcha')
                                                <small class="text-danger mt-2">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <input type="text" name="user" value="{{ $user->id }}" hidden>
                                    </div>
                                    <div class="col">
                                        <div class="d-flex align-items-center text-center">
                                            <span class="w-100" id="captcha">{!! captcha_img('my_custom') !!}</span>
                                            <button type="button" class="btn btn-light ms-2" id="refresh-captcha">
                                                ↻
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <button type="submit" class="btn btn-primary w-100 mb-4">ورود</button>

                        </form>
                        <div class="text-center">
                            <div class="mb-2">
                                <form action="{{ route('one_time_password') }}" method="post">
                                    @csrf
                                    <button class="form_btn" type="submit" name="user" value="{{ $user->id }}">ورود
                                        با رمز
                                        عبور یکبار مصرف</button>
                                </form>
                            </div>
                            <div class="mb-2"><a href="{{ route('forgot_password') }}">
                                    فراموشی رمز عبور
                                </a>
                            </div>
                        </div>
                    @elseif($status and $organ->status == '0')
                        {{-- steps --}}
                        <div class="row px-3">
                            <div class="stepper d-flex justify-content-between">
                                <!-- مرحله 1: فعال -->
                                <div class="step">
                                    <div class="step-number">1</div>
                                    <div class="step-title">ایجاد درخواست</div>
                                </div>

                                <!-- مرحله 2 -->
                                <div class="step active">
                                    <div class="step-number">2</div>
                                    <div class="step-title">تایید کارشناس</div>
                                </div>

                                <!-- مرحله 3 -->
                                <div class="step">
                                    <div class="step-number">3</div>
                                    <div class="step-title">تکمیل اطلاعات</div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-warning alert-dismissible mt-4" style="text-align: justify">
                            <strong>توجه!</strong>
                            <br>
                            اپراتور درحال بررسی درخواست شماست. نتیجه به شماره موبایل شما پیامک خواهد شد.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @elseif($status and $organ->status == '1' and !$user->password)
                        @if (!$user->password)
                            <form action="{{ route('set_password') }}" method="post">
                                @csrf
                                <p class="form-p mb-2 mt-3 pb-0 ">لطفا برای خود یک رمز ورود تعیین کنید
                                </p>
                                <div class="mb-3 mt-3">
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
                                <div class="mb-3 mt-3">
                                    <div class="autocomplete @if (old('password_repet')) filled @endif"
                                        id="autocompleteBoxpassword_repet">
                                        <input type="password" id="searchInputpassword_repet" class=""
                                            name="password_repet"
                                            oninput="nameinput('password_repet')"
                                            @error('password_repet')
                                    style="border:red solid 1px"
                                    @enderror>
                                        <label for="searchInputpassword_repet">تکرار رمز عبور</label>
                                        <span class="position-absolute password-toggle"
                                            onclick="togglePassword('searchInputpassword_repet')">
                                            <i class="bi bi-eye-slash" id="toggleIconsearchInputpassword_repet"></i>
                                        </span>
                                    </div>
                                    @error('password_repet')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary mt-3 mb-3 border py-2 rounded-3 w-100">
                                    ذخیره
                                </button>
                            </form>
                        @else
                        @endif
                    @elseif($status and $organ->status == '2')
                        <div class="alert alert-success mt-4" style="text-align: justify">
                            <strong>رد شده!</strong>
                            <br>
                            درخواست شما توسط اپراتور رد شد.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @else
                        <form action="{{ route('check_organ_id') }}" method="post">
                            @csrf
                            <p class="form-p mb-2 mt-3 pb-0 ">لطفا برای دیدن وضعیت ثبت نام شماره شناسایی اموزشگاه را
                                وارد کنید.</p>
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
                            <div class="form-group mt-3">
                                {{-- <label for="captcha">کد کپچا را وارد نمایید:</label> --}}
                                <div class="row">
                                    <div class="col">
                                        <div class="">
                                            <div class="autocomplete @if (old('captcha')) filled @endif"
                                                id="autocompleteBoxcaptcha">
                                                <input type="text" id="searchInputcaptcha" class="only-number"
                                                    name="captcha" value="{{ old('captcha') }}"
                                                    oninput="nameinput('captcha')"
                                                    @error('captcha')
                                                    style="border:red solid 1px"
                                                    @enderror>
                                                <label for="searchInputcaptcha">کد امنیتی</label>
                                                <span class="clear-btn" id="clearBtn_captcha"
                                                    onclick="clearInput('captcha')"
                                                    @if (old('captcha')) style="display:block !important" @endif>×</span>
                                            </div>
                                            @error('captcha')
                                                <small class="text-danger mt-2">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <input type="text" name="user" value="{{ $user->id }}" hidden>
                                    </div>
                                    <div class="col">
                                        <div class="d-flex align-items-center text-center">
                                            <span class="w-100" id="captcha">{!! captcha_img('my_custom') !!}</span>
                                            <button type="button" class="btn btn-light ms-2" id="refresh-captcha">
                                                ↻
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-5 mb-4 border py-2 rounded-3 w-100">
                                ذخیره
                            </button>
                        </form>
                    @endif
                @else
                    <h4 class="mb-4">رمز ورود</h4>
                    <p class="text-muted mb-4">رمز عبور خود را وارد کنید.</p>
                    <form action="{{ route('check_password') }}" method="post">
                        @csrf
                        <div class="mb-5 mt-4">
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
                            <input type="text" name="mobile" value="{{ $user->mobile ?? $user->email }}" hidden>
                        </div>
                        @if (session('login_attempts') >= 1)
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="">
                                        <div class="autocomplete @if (old('captcha')) filled @endif"
                                            id="autocompleteBoxcaptcha">
                                            <input type="text" id="searchInputcaptcha" class="only-number"
                                                name="captcha" value="{{ old('captcha') }}"
                                                oninput="nameinput('captcha')"
                                                @error('captcha')
                                                    style="border:red solid 1px"
                                                    @enderror>
                                            <label for="searchInputcaptcha">کد امنیتی</label>
                                            <span class="clear-btn" id="clearBtn_captcha" onclick="clearInput('captcha')"
                                                @if (old('captcha')) style="display:block !important" @endif>×</span>
                                        </div>
                                        @error('captcha')
                                            <small class="text-danger mt-2">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <input type="text" name="user" value="{{ $user->id }}" hidden>
                                </div>
                                <div class="col">
                                    <div class="d-flex align-items-center text-center">
                                        <span class="w-100" id="captcha">{!! captcha_img('my_custom') !!}</span>
                                        <button type="button" class="btn btn-light ms-2" id="refresh-captcha">
                                            ↻
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary w-100 mb-4">ورود</button>
                    </form>
                    <div class="text-center">
                        <div class="mb-2">
                            <form action="{{ route('one_time_password') }}" method="post">
                                @csrf
                                <button class="form_btn" type="submit" name="user" value="{{ $user->id }}">ورود
                                    با رمز
                                    عبور یکبار مصرف</button>
                            </form>
                        </div>
                        <div class="mb-2"><a href="{{ route('forgot_password') }}">
                                فراموشی رمز عبور
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

    <!-- slider -->
    <script>
        var splide = new Splide('#slider-1', {
            type: 'loop',
            perPage: 1,
            autoplay: true,
        });
        splide.mount();
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
    {{-- inputs --}}
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
    {{-- captcha --}}
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
    <script>
        document.querySelector('.login-btn').addEventListener('click', function(e) {
            e.preventDefault();
            return false;
        });
        $('.login-btn').css('pointer-events', 'none');
    </script>
@endsection
