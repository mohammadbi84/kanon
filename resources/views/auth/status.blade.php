@extends('site.layout.master')

@section('head')
    <title>پیگیری ثبت نام</title>
    <style>
        .herfeDiv {
            overflow-y: scroll;
            width: 300px;
            max-height: 400px;
            padding: 12px;
        }

        .herfeDiv::-webkit-scrollbar {
            width: 5px;
        }

        .herfeDiv::-webkit-scrollbar-track {
            width: 5px;
        }

        .herfeDiv::-webkit-scrollbar-thumb {
            background-color: #EBA607 !important;
            color: #EBA607 !important;
            border-radius: 5px;
        }

        .form-control {
            border-top-right-radius: 5px !important;
            border-bottom-right-radius: 5px !important;
        }

        .form {
            width: 400px;
            max-height: 540px;
            margin-top: 150px;
            /* background: white; */
            /* backdrop-filter: blur(30px); */
        }

        #togglePassword {
            cursor: pointer;
            position: absolute;
            left: 10px;
            top: 27%;
            z-index: 10;
        }

        #togglePassword_repet {
            cursor: pointer;
            position: absolute;
            left: 10px;
            top: 27%;
            z-index: 10;
        }
    </style>
    <!-- input with floating-label -->
    <link rel="stylesheet" type="text/css" href="{{ asset('site/src/style/input-with-floating-label.css') }}" media="screen">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/src/style/input-with-floating-label-rtl-fix.css') }}"
        media="screen">
    <!-- input with floating-label -->
@endsection
@section('content')
    <div class="container mb-4">
        <div class="d-flex align-items-center justify-content-center min-vh-100">
            <div class="text-center form p-5 border bg-white shadow rounded-2">
                @csrf
                <h3 class="mb-5">پیگیری ثبت نام</h3>
                <!-- phone number -->

                <div class="row">
                    @if ($user && $user->hasRole('organ'))
                        @if ($organ && $organ->status == '5')
                            <p class="text-success">مراحل ثبت نام شما تکمیل شد !</p>
                        @elseif($organ->status == '0')
                            <p class="text-primary">در حال بررسی درخواست شما...</p>
                        @elseif($organ->status == '1' || $organ->status == '4')
                            <p class="text-success">درخواست شما تایید شد !</p>
                            @if (!$user->password)
                                <form action="{{ route('set_password', ['id' => $user->id]) }}" method="post">
                                    @csrf
                                    <p class="form-p mb-2 mt-3 pb-0 ">لطفا برای خود یک رمز ورود تعیین کنید</p>
                                    <div class="input-group mt-3 form-label-group in-border">
                                        <input type="password" class="form-control" name="password" id="password"
                                            aria-label="Username" value="{{ old('password') }}" placeholder="a">
                                        <label for="">رمز عبور</label>
                                        <span class="p-0" id="togglePassword" style="cursor: pointer">
                                            <span class="bi bi-eye" id="toggleIcon"></span>
                                        </span>
                                    </div>
                                    @error('password')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                    <div class="input-group mt-3 form-label-group in-border">
                                        <input type="password" class="form-control" name="password_repet"
                                            id="password_repet" aria-label="Username" value="{{ old('password_repet') }}"
                                            placeholder="a">
                                        <label for="">تکرار رمز عبور</label>
                                        <span class="p-0" id="togglePassword_repet" style="cursor: pointer">
                                            <span class="bi bi-eye" id="toggleIcon_repet"></span>

                                        </span>
                                    </div>
                                    @error('password_repet')
                                        <small class="text-danger mt-2">{{$message }}</small>
                                    @enderror
                                    <div class="form-group mt-3">
                                        <label for="captcha">کد کپچا را وارد نمایید:</label>
                                        <div class="d-flex align-items-center text-center">
                                            <span class="w-100" id="captcha">{!! captcha_img('default') !!}</span>
                                            <button type="button" class="btn btn-light ms-2" id="refresh-captcha">
                                                ↻
                                            </button>
                                        </div>
                                        <div class="input-group mt-3 form-label-group in-border">
                                            <input type="text" class="form-control" name="captcha" id="captcha"
                                                aria-label="Username" value="{{ old('captcha') }}" placeholder="a">
                                            <label for="">کد کپچا</label>
                                        </div>
                                        @error('captcha')
                                            <span class="text-danger">{{$message }}</span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-success mt-3 mb-2 border py-2 rounded-3 w-100">
                                        ذخیره
                                    </button>
                                </form>
                            @else
                                <p>ثبت نام شما تکمیل شده است، لطفا برای مراحل بعد اقدام به ورود
                                    کنید</p>
                                <a href="/dashboard/home" class="btn btn-primary">ورود به داشبورد</a>
                            @endif
                        @elseif($organ->status == '2')
                            <p class="text-danger">درخواست شما رد شد !</p>
                        @elseif ($organ->status == '5')
                            <p class="text-success">مراحل ثبت نام شما تکمیل شد !</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.getElementById("togglePassword").addEventListener("click", function() {
            const passwordInput = document.getElementById("password");
            const toggleIcon = document.getElementById("toggleIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("bi-eye");
                toggleIcon.classList.add("bi-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("bi-eye-slash");
                toggleIcon.classList.add("bi-eye");
            }
        });
        document.getElementById("togglePassword_repet").addEventListener("click", function() {
            const passwordInput_repet = document.getElementById("password_repet");
            const toggleIcon_repet = document.getElementById("toggleIcon_repet");

            if (passwordInput_repet.type === "password") {
                passwordInput_repet.type = "text";
                toggleIcon_repet.classList.remove("bi-eye");
                toggleIcon_repet.classList.add("bi-eye-slash");
            } else {
                passwordInput_repet.type = "password";
                toggleIcon_repet.classList.remove("bi-eye-slash");
                toggleIcon_repet.classList.add("bi-eye");
            }
        });
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
@endsection
