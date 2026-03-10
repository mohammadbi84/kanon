@extends('site.layout.master')
@section('head')
    <title>رمز ورود</title>
    <link rel="stylesheet" href="{{asset('site/assets/css/login.css')}}">
    <link rel="stylesheet" href="{{asset('site/assets/css/main-menu-full.css')}}">
@endsection
@section('content')
    <div class="container wrapper d-flex align-items-center justify-content-center mb-5" style="margin-top: 120px">
        <div class="row w-75 login-card bg-white justify-content-center">
            <!-- اسلایدر راست -->
            <div class="col-md-6 d-none d-md-block p-0">
               @include('auth.layouts.slider')
            </div>
            {{-- فورم سمت چپ --}}
            <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
                <div class="text-end">
                    <a href="/login" class="btn btn-outline-secondary btn-sm">
                        بازگشت
                        <i class="bi bi-arrow-left me-1" style="position: relative;top: 2px;"></i>
                    </a>
                </div>
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
                            <span class="position-absolute password-toggle" onclick="togglePassword('searchInputpassword')">
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
                                        <input type="text" id="searchInputcaptcha" class="only-number" name="captcha"
                                            value="{{ old('captcha') }}" oninput="nameinput('captcha')"
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
            </div>
        </div>
    </div>
@endsection
@section('script')
<script src="{{asset('site/assets/js/inputs.js')}}"></script>
    <script src="{{asset('site/assets/js/main-menu-full.js')}}"></script>
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
