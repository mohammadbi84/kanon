@extends('site.layout.master')

@section('head')
    <title>ورود</title>
    <!-- link slider -->
    <link rel="stylesheet" href="{{asset('site/assets/css/login.css')}}">
    <link rel="stylesheet" href="{{asset('site/assets/css/main-menu-full.css')}}">
@endsection
@section('content')
    <div class="container wrapper d-flex align-items-center justify-content-center mb-5" style="margin-top: 120px !important">
        <div class="row w-75 login-card bg-white">
            <!-- اسلایدر راست -->
            <div class="col-md-6 d-none d-md-block p-0">
                @include('auth.layouts.slider')
            </div>
            {{-- فورم سمت چپ --}}
            <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
                {{-- <div class="mb-4 text-center">
                    <a href="#" class="">
                       <img src="{{ asset('site/public/img/logo-yazdskill2.png') }}" alt="kanon" width="100">
                    </a>
                </div> --}}
                <h4 class="mb-4">صفحه ورود</h4>
                <p class="text-muted mb-5">برای دسترسی به امکانات سایت، ابتدا وارد حساب کاربری شوید.</p>
                <form action="{{ route('signIn') }}" method="post">
                    @csrf
                    <div class="mb-5 mt-4">
                        <div class="autocomplete @if (old('mobile')) filled @endif"
                            id="autocompleteBoxmobile">
                            <input type="text" id="searchInputmobile" class="" name="mobile"
                                value="{{ old('mobile') }}" oninput="nameinput('mobile')"
                                @error('mobile')
                                    style="border:red solid 1px"
                                    @enderror>
                            <label for="searchInputmobile">موبایل یا ایمیل</label>
                            <span class="clear-btn" id="clearBtn_mobile" onclick="clearInput('mobile')"
                                @if (old('mobile')) style="display:block !important" @endif>×</span>
                        </div>
                        @error('mobile')
                            <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">ورود</button>

                    <div class="text-center">
                        <div class="mb-2">حساب کاربری ندارید؟ <a href="{{ route('register') }}">ثبت نام کنید</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {{-- inputs --}}
    <script src="{{asset('site/assets/js/inputs.js')}}"></script>
    <script src="{{asset('site/assets/js/main-menu-full.js')}}"></script>
    {{-- menu btn --}}
    <script>
        document.querySelector('.login-btn').addEventListener('click', function(e) {
            e.preventDefault();
            return false;
        });
        $('.login-btn').css('pointer-events', 'none');
    </script>
@endsection
