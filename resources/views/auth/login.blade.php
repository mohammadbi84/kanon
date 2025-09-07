@extends('site.layout.master')

@section('head')
    <title>ورود</title>
    <!-- link slider -->
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

        /* .login_btn{
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
    </style>
@endsection
@section('content')
    <div class="container wrapper d-flex align-items-center justify-content-center mb-5" style="margin-top: 120px !important">
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
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
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
    <script>
        document.querySelector('.login-btn').addEventListener('click', function(e) {
            e.preventDefault();
            return false;
        });
        $('.login-btn').css('pointer-events', 'none');
    </script>
@endsection
