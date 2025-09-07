@extends('site.layout.master')
@section('head')
    <title>فرم ثبت‌نام</title>
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
    </style>
    <!-- input with floating-label -->
    <link rel="stylesheet" type="text/css" href="{{ asset('site/src/style/input-with-floating-label.css') }}" media="screen">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/src/style/input-with-floating-label-rtl-fix.css') }}"
        media="screen">
    <!-- input with floating-label -->
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <!-- persian-datepicker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">
    <style>
        /* .register_btn{
                                                                                                                                                                                                    display: none !important;
                                                                                                                                                                                                } */
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

        .autocomplete .dropdown {
            /* padding-bottom: 50px; */
            position: absolute;
            top: 110%;
            border-radius: 5px;
            right: 0;
            left: 0;
            border: 1px solid #ccc;
            border-top: none;
            max-height: 250px;
            overflow-y: auto;
            background: white;
            z-index: 2;
        }

        .autocomplete .dropdown::-webkit-scrollbar {
            background-color: #ffffff;
            width: 3px;
        }

        .autocomplete .dropdown::-webkit-scrollbar-thumb {
            background-color: #bfbfbf;
            border-radius: 10px;
            width: 6px;
        }

        .autocomplete .dropdown div {
            padding: 8px 10px;
            cursor: pointer;
        }

        .autocomplete .dropdown div:hover {
            background: #f0f0f0;
        }

        .choices__inner {
            background-color: white !important;
        }

        .choices__input {
            background-color: white !important;
        }

        .choices__list--single .choices__item {
            padding-right: 18px !important;
        }

        .choices[data-type*=select-one] .choices__button {
            right: none !important;
            margin-right: none !important;
        }

        .choices__list--dropdown {
            border-radius: 4px !important;
            margin-top: 8px !important;
            padding: 5px;
            /* max-height: 200px !important; */
            overflow-y: scroll !important;
        }

        .choices__inner {
            border-radius: 6px;
        }

        .is-open .choices__inner {
            border-radius: 6px !important;
        }

        .choices__list--dropdown::-webkit-scrollbar {
            border-radius: 8px;
            width: 6px;
            background-color: #ffffff
        }

        .choices__list--dropdown::-webkit-scrollbar-thumb {
            background-color: #bfbfbf;
            border-radius: 10px;
            width: 6px;
        }

        .choices__list--dropdown .choices__list,
        .choices__list[aria-expanded] .choices__list {
            border-radius: 8px !important;
            margin-top: 10px;
        }

        .choices__list--multiple .choices__item {
            background-color: #EBA607 !important;
            border-color: #af7d07 !important;
        }


        /* phone */
        .d-flex.gap-0>div input {
            border-radius: 5px !important;
        }

        .d-flex.gap-0>div:first-child input {
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
        }

        .d-flex.gap-0>div:last-child input {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }

        .choices {
            margin-bottom: 0 !important;
        }


        .login-btn {
            background-color: transparent !important;
            width: 70px !important;
            /* border: 1px solid black; */

        }

        .register-btn {
            color: white !important;
            /* background-color: transparent; */
            background-color: #ffffff00 !important;
            /* border: 1px solid black; */
            border: none;
            width: 70px !important;

        }

        .navbar-expand-lg .container {
            padding: 0 20px !important;
        }

        .background-slide {
            position: absolute;
            width: 70px;
            /* اندازه بزرگ‌تر برای هر دو دکمه */
            height: 44px;
            background-color: #EBA607;
            border-radius: 0.5rem;
            right: 80px;
            top: 6px;
            z-index: -1;
            transition: transform 0.5s cubic-bezier(0, -0.55, 0, 1);
        }

        .login-btn,
        .register-btn {
            position: relative;
            z-index: 1;
        }

        .login-btn:hover {
            transition-delay: 50ms;
            color: white !important;
            background-color: #ffffff00 !important;
        }

        .login-btn:hover~.background-slide {
            /* transform: translateX(calc(74% + 1rem)); */
            transform: translateX(74px);
            /* width: 50px; */
            /* height: 45px; */
            /* right: 147px; */
            /* top: 2px; */
        }

        .login-btn:hover~.register-btn {
            transition-delay: 0.1s;
            background-color: #ffffff;
            border: none;
            color: black !important;
        }

        .register-btn:hover {
            background-color: transparent;
            border-color: #2563eb;
        }
    </style>
    @error('herfe')
        <style>
            .choices__inner {
                border-color: rgb(255, 0, 0) !important;
            }
        </style>
    @enderror
    <style>
        .register_title h3 {
            font-size: 22px;
            margin-top: 5px;

        }

        .register_title img {
            height: 60%;
        }

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

        /* choises */
        .choices__list--multiple .choices__item {
            border-radius: 5px !important;
        }

        .choices[data-type*=select-multiple] .choices__button,
        .choices[data-type*=text] .choices__button {
            position: relative;
            left: 0;
            display: inline-block;
            margin: 0 !important;
            margin-right: 10px !important;
            padding-left: 0px !important;
            border-left: none !important;
        }


        /* datepicker */
        .datepicker-plot-area {
            width: 300px !important;
            min-width: 300px !important;
        }
    </style>
    {{-- انیمیشن --}}
    <style>
        /* انیمیشن لرزش */
        @keyframes shake {
            0% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            50% {
                transform: translateX(5px);
            }

            75% {
                transform: translateX(-5px);
            }

            100% {
                transform: translateX(0);
            }
        }

        .shake {
            animation: shake 0.3s;
        }

        .error-message {
            color: red;
            font-size: 0.875rem;
            margin-top: 5px;
            display: none;
        }

        /* استایل برای گروه input و دکمه */
        .input-group>.form-select {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }

        .input-group>.btn {
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
        }

        /* استایل تب‌ها در مدال */
        .nav-tabs .nav-link {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        /* استایل چک‌باکس‌ها */
        .form-check-input {
            margin-top: 0.2rem;
        }

        /* استایل تب‌ها */
        .nav-tabs {
            border-bottom: none !important;
            border-right: none !important;
            border-left: none !important;
        }

        .nav-tabs .nav-link {
            border-top: none !important;
            border-right: none !important;
            border-left: none !important;
            border-bottom: 4px solid transparent;
            border-radius: 0;
            color: #555;
            font-weight: 500;
            transition: all 0.3s;
        }

        .nav-tabs .nav-link:hover {
            border-top: none !important;
            border-right: none !important;
            border-left: none !important;
            border-bottom: 4px solid transparent;
            border-radius: 0;
            color: #555;
            font-weight: 500;
            transition: all 0.3s;
        }

        .nav-tabs .nav-link.active {
            border-bottom: 4px solid #EBA607;
            border-top: none !important;
            color: #EBA607;
            background-color: transparent;
        }


        .choices__list--dropdown .choices__list,
        .choices__list[aria-expanded] .choices__list {
            padding-left: 10px;
        }

        .choices__list::-webkit-scrollbar {
            background-color: #ffffff !important;
            width: 6px !important;
        }

        .choices__list::-webkit-scrollbar-thumb {
            background-color: #bfbfbf !important;
            border-radius: 10px !important;
            width: 6px !important;
        }
    </style>
@endsection
@section('content')
    {{-- main --}}
    <div class="container mb-5" style="margin-top: 100px;">
        <form action="{{ route('register_post') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif --}}
            <div class="row row-cols-center">
                <div class="col-md-2"></div>
                <div class="col-md-8 px-0">
                    @if ($alert->status == 1)
                        <div class="alert alert-dismissible"
                            style="text-align: justify;background-color:{{ $alert->color }}">
                            <strong>{{ $alert->title }}</strong>
                            <br>
                            {{ $alert->text }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-2"></div>
                <div class="col-md-8 rounded-3 bg-white shadow">
                    {{-- steps --}}
                    <div class="row px-3">
                        <div class="stepper d-flex justify-content-between">
                            <!-- مرحله 1: فعال -->
                            <div class="step active">
                                <div class="step-number">1</div>
                                <div class="step-title">ایجاد درخواست</div>
                            </div>

                            <!-- مرحله 2 -->
                            <div class="step">
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
                    <!-- اطلاعات سازمان -->
                    <div class="row rounded-4 p-3 pb-0">
                        <div class="d-flex flex-wrap align-content-center mb-2 register_title">
                            <img src="{{ asset('site/public/icon/vertical-line.svg') }}" aria-hidden="true" class="ms-2"
                                alt="">
                            <h3>مشخصات پروانه تاسیس</h3>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="autocomplete @if (old('name')) filled @endif"
                                id="autocompleteBoxname">
                                <input type="text" id="searchInputname" class="only-persian" name="name"
                                    value="{{ old('name') }}" oninput="nameinput('name')"
                                    @error('name')
                                    style="border:red solid 1px"
                                    @enderror>
                                <label for="searchInputname">نام آموزشگاه</label>
                                <span class="clear-btn" id="clearBtn_name" onclick="clearInput('name')"
                                    @if (old('name')) style="display:block !important" @endif>×</span>
                            </div>
                            <div class="error-message" id="error-name">فقط حروف فارسی مجاز است.</div>
                            @error('name')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="autocomplete @if (old('number')) filled @endif"
                                id="autocompleteBoxnumber">
                                <input type="text" id="searchInputnumber" class="only-number" name="number"
                                    value="{{ old('number') }}" oninput="nameinput('number')"
                                    @error('number')
                                    style="border:red solid 1px"
                                    @enderror>
                                <label for="searchInputnumber">شماره شناسایی</label>
                                <span class="clear-btn" id="clearBtn_number" onclick="clearInput('number')"
                                    @if (old('number')) style="display:block !important" @endif>×</span>
                            </div>
                            @error('number')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="autocomplete @if (old('sodor')) filled @endif"
                                id="autocompleteBoxsodor">
                                <input type="text" id="searchInputsodor" class="only-number-sign" name="sodor"
                                    value="{{ old('sodor') }}" oninput="nameinput('sodor')"
                                    @error('sodor')
                                    style="border:red solid 1px"
                                    @enderror>
                                <label for="searchInputsodor">شماره صدور</label>
                                <span class="clear-btn" id="clearBtn_sodor" onclick="clearInput('sodor')"
                                    @if (old('sodor')) style="display:block !important" @endif>×</span>
                            </div>
                            @error('sodor')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="autocomplete @if (old('sodor_start')) filled @endif"
                                id="autocompleteBoxsodor_start">
                                <input type="text" id="searchInputsodor_start" name="sodor_start" readonly
                                    value="{{ old('sodor_start') }}" oninput="nameinput('sodor_start')"
                                    @error('sodor_start')
                                    style="border:red solid 1px"
                                    @enderror>
                                <label for="searchInputsodor_start">تاریخ صدور</label>
                                <span class="clear-btn" id="clearBtn_sodor_start" onclick="clearInput('sodor_start')"
                                    @if (old('sodor_start')) style="display:block !important" @endif>×</span>
                            </div>
                            @error('sodor_start')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="autocomplete @if (old('sodor_end')) filled @endif"
                                id="autocompleteBoxsodor_end">
                                <input type="text" id="searchInputsodor_end" name="sodor_end" readonly
                                    value="{{ old('sodor_end') }}" oninput="nameinput('sodor_end')"
                                    @error('sodor_end')
                                    style="border:red solid 1px"
                                    @enderror>
                                <label for="searchInputsodor_end">تاریخ پایان اعتبار</label>
                                <span class="clear-btn" id="clearBtn_sodor_end" onclick="clearInput('sodor_end')"
                                    @if (old('sodor_end')) style="display:block !important" @endif>×</span>
                            </div>
                            @error('sodor_end')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="autocomplete @if (old('parvane_date')) filled @endif"
                                id="autocompleteBoxparvane_date">
                                <input type="text" id="searchInputparvane_date" name="parvane_date" readonly
                                    value="{{ old('parvane_date') }}" oninput="nameinput('parvane_date')"
                                    @error('parvane_date')
                                    style="border:red solid 1px"
                                    @enderror>
                                <label for="searchInputparvane_date">تاریخ اولین پروانه کسب
                                    <small>(اختیاری)</small></label>
                                <span class="clear-btn" id="clearBtn_parvane_date" onclick="clearInput('parvane_date')"
                                    @if (old('parvane_date')) style="display:block !important" @endif>×</span>
                            </div>
                            @error('parvane_date')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3 align-content-center">
                            <div class="row g-0">
                                <div class="col-1 p-1">
                                    <input type="radio" class="form-check-input" name="parvane" id="parvane_first"
                                        {{ old('parvane') == 1 ? 'checked' : '' }} value="1" onchange="">
                                </div>
                                <div class="col-5 p-1">
                                    <label for="parvane_first" class="form-check-label">اولین پروانه کسب</label>
                                </div>
                                <div class="col-1 p-1">
                                    <input type="radio" class="form-check-input" name="parvane" id="parvane_tamdid"
                                        {{ old('parvane') == 2 ? 'checked' : '' }} value="2" onchange="">
                                </div>
                                <div class="col-5 p-1 ps-0">
                                    <label for="parvane_tamdid" class="form-check-label">تمدید پروانه کسب</label>
                                </div>
                            </div>
                            @error('parvane')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3 mt-2 pe-4">
                            <div class="row pb-0 align-content-center">
                                <div class="col-1 mb-0 p-0 align-content-center">
                                    <p class="p-0 m-0">جنسیت : </p>
                                </div>
                                <div class="col-5 mb-0 p-0 align-content-center">
                                    <div class="d-flex flex-wrap align-content-center p-0">
                                        <div class="form-check form-check-inline ms-2 me-0" dir="rtl">
                                            <input type="radio" class="form-check-input" name="mardzan" id="baradaran"
                                                {{ old('mardzan') == 1 ? 'checked' : '' }} value="1"
                                                onchange="handleGenderChange()">
                                        </div>
                                        <label for="baradaran" class="form-check-label">برادران</label>

                                        <div class="form-check form-check-inline ms-2" dir="rtl">
                                            <input type="radio" class="form-check-input" name="mardzan" id="khaharan"
                                                {{ old('mardzan') == 2 ? 'checked' : '' }} value="2"
                                                onchange="handleGenderChange()">
                                        </div>
                                        <label for="khaharan" class="form-check-label">خواهران</label>

                                        <div class="form-check form-check-inline ms-2" dir="rtl">
                                            <input type="radio" class="form-check-input" name="mardzan" id="mokhtalet"
                                                {{ old('mardzan') == 3 ? 'checked' : '' }} value="3"
                                                onchange="handleGenderChange()">
                                        </div>
                                        <label for="mokhtalet" class="form-check-label">برادران،خواهران</label>
                                    </div>
                                </div>
                                <div class="col mb-0 p-0 align-content-center">
                                    <div class="d-flex flex-wrap align-content-center p-0">
                                        <div class="form-check form-check-inline ms-2 me-0" dir="rtl">
                                            <input type="checkbox" class="form-check-input" name="tabsare"
                                                {{ old('mardzan') == 3 ? 'checked' : '' }} value="1" id="tabsare34"
                                                disabled>
                                        </div>
                                        <label for="tabsare34" class="form-check-label ms-2">دارای مجوز تبصره ۳۴</label>
                                    </div>
                                </div>
                                @error('mardzan')
                                    <small class="text-danger mt-0 p-0">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <h6 class="mb-1">عناوین رشته</h6>

                        <div class="col-md-12 mb-3">
                            <!-- Select اصلی با Choices -->
                            <select id="mySelect" class="form-select mb-0" multiple name="herfe[]"
                                @error('herfe') style="border:red solid 1px !important" @enderror>
                                @foreach ($herfes as $herfe)
                                    <option value="{{ $herfe->id }}"
                                        @if (old('herfe') && in_array($herfe->id, old('herfe'))) selected @endif>
                                        {{ $herfe->name }} ({{ $herfe->khoshe->name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('herfe')
                                <small class="text-danger m-0 p-0">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-12 text-end">
                            <!-- دکمه باز کردن مدال -->
                            <button type="button" class="btn btn-primary" style="height: 48px;" data-bs-toggle="modal"
                                data-bs-target="#herfeModal">
                                <i class="bi bi-caret-up-fill fs-5" style="position: relative;top: 6%;"></i> انتخاب
                                سریع
                                از لیست
                            </button>
                        </div>

                        <!-- مدال حرفه‌ها -->
                        <div class="modal fade" id="herfeModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header d-block p-0">
                                        <div class="row g-0 p-3 mt-1" dir="rtl">
                                            <div class="col" style="text-align: right;">
                                                <h5 class="" id="">عناوین رشته</h5>
                                            </div>
                                            <div class="col" style="text-align: left;"> <button type="button"
                                                    class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <!-- تب‌های خوشه‌ها -->
                                        <ul class="nav nav-tabs rounded-3 mb-2 mt-2 shadow align-content-center ps-3 pe-3"
                                            style="background-color: #252641;color: white;" id="khosheTabs"
                                            role="tablist">
                                            <div class="d-flex align-items-center ms-2">
                                                <strong class="mb-0">خوشه‌ها :</strong>
                                            </div>

                                            @foreach ($khoshes as $index => $khoshe)
                                                <li class="nav-item " role="presentation">
                                                    <button
                                                        class="nav-link text-white p-3 {{ $index === 0 ? 'active' : '' }}"
                                                        id="tab-{{ $khoshe->id }}" data-bs-toggle="tab"
                                                        data-bs-target="#khoshe-{{ $khoshe->id }}" type="button">
                                                        {{ $khoshe->name }} (
                                                        <small>{{ $khoshe->herfes()->count() }}</small> )
                                                    </button>
                                                </li>
                                            @endforeach
                                            {{-- <div class="align-content-center">
                                                <small> مورد انتخاب شده</small>
                                            </div> --}}
                                        </ul>

                                        <!-- محتوای تب‌ها -->
                                        <div class="tab-content p-3 border-0" id="khosheTabsContent">
                                            @foreach ($khoshes as $index => $khoshe)
                                                <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                                                    id="khoshe-{{ $khoshe->id }}" role="tabpanel">
                                                    @php
                                                        $herfes = $khoshe->herfes()->orderBy('name', 'asc')->get();
                                                        $half = ceil($herfes->count() / 2);
                                                        $leftHerfes = $herfes->slice(0, $half);
                                                        $rightHerfes = $herfes->slice($half);
                                                    @endphp

                                                    <div class="row">
                                                        <!-- ستون اول -->
                                                        <div class="col-md-6">
                                                            @foreach ($leftHerfes as $herfe)
                                                                <div class="d-flex flex-wrap align-content-center p-0">
                                                                    <div class="form-check form-check-inline ms-2"
                                                                        dir="rtl">
                                                                        <input type="checkbox"
                                                                            class="form-check-input herfe-checkbox"
                                                                            id="herfe-{{ $herfe->id }}"
                                                                            value="{{ $herfe->id }}"
                                                                            data-herfe-name="{{ $herfe->name }}"
                                                                            data-khoshe-name="{{ $khoshe->name }}"
                                                                            @if (in_array($herfe->id, old('herfe', []))) checked @endif>
                                                                    </div>
                                                                    <label for="herfe-{{ $herfe->id }}"
                                                                        class="form-check-label">{{ $herfe->name }}</label>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        <!-- ستون دوم -->
                                                        <div class="col-md-6">
                                                            @foreach ($rightHerfes as $herfe)
                                                                <div class="d-flex flex-wrap align-content-center p-0">
                                                                    <div class="form-check form-check-inline ms-2"
                                                                        dir="rtl">
                                                                        <input type="checkbox"
                                                                            class="form-check-input herfe-checkbox"
                                                                            id="herfe-{{ $herfe->id }}"
                                                                            value="{{ $herfe->id }}"
                                                                            data-herfe-name="{{ $herfe->name }}"
                                                                            data-khoshe-name="{{ $khoshe->name }}"
                                                                            @if (in_array($herfe->id, old('herfe', []))) checked @endif>
                                                                    </div>
                                                                    <label for="herfe-{{ $herfe->id }}"
                                                                        class="form-check-label">{{ $herfe->name }}</label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="modal-footer d-block p-0">
                                        <div class="row g-0 p-3 mt-1" dir="rtl">
                                            <div class="col-8" style="text-align: right;">
                                                <p>
                                                    انتخاب شده ها :
                                                    @foreach ($khoshes as $index => $khoshe)
                                                        <span class="ms-2">
                                                            {{ $khoshe->name }} ( <small class="selected-count"
                                                                data-khoshe-id="{{ $khoshe->id }}">0</small> )
                                                        </span>
                                                    @endforeach
                                                </p>
                                            </div>
                                            <div class="col" style="text-align: left;">
                                                <span>جمع کل : ( <small id="totalSelected">0</small> )</span>
                                                <button type="button" class="btn btn-primary me-2"
                                                    id="applyHerfes">ذخیره</button>
                                            </div>
                                        </div>
                                        {{-- <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">انصراف</button> --}}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- انتخاب نوع شخصیت -->
                    <div class="row rounded-4 p-3 pt-0 mt-0">
                        <div class="d-flex flex-wrap align-content-center mb-2 register_title">
                            <img src="{{ asset('site/public/icon/vertical-line.svg') }}" aria-hidden="true"
                                class="ms-2" alt="">
                            <h3>اطلاعات هویتی مؤسس</h3>
                        </div>
                        {{-- <h5>نوع</h5> --}}
                        <div class="row px-0 mb-2">
                            <div class="col-md-12">
                                <div class="d-flex flex-wrap align-content-center pe-0">
                                    <div class="form-check form-check-inline ms-2 me-0" dir="rtl">
                                        <input type="radio" name="haghighi" id="haghighi" value="1"
                                            class="form-check-input" {{ old('haghighi', 1) == 1 ? 'checked' : '' }}
                                            onclick="toggleForms()">
                                    </div>
                                    <label class="form-check-label" for="haghighi">حقیقی</label>

                                    <div class="form-check form-check-inline ms-2" dir="rtl">
                                        <input type="radio" name="haghighi" id="hoghoghi" value="2"
                                            class="form-check-input" {{ old('haghighi') == 2 ? 'checked' : '' }}
                                            onclick="toggleForms()">
                                    </div>
                                    <label class="form-check-label" for="hoghoghi">حقوقی</label>
                                </div>
                            </div>
                        </div>

                        <!-- فرم حقیقی -->
                        <div class="row px-0 mx-0 mt-2 " id="haghighi-form"
                            style="display:{{ old('haghighi', 1) == 1 ? '' : 'none' }}">
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete @if (old('modir_name')) filled @endif"
                                    id="autocompleteBoxmodir_name">
                                    <input type="text" id="searchInputmodir_name" class="only-persian"
                                        name="modir_name" value="{{ old('modir_name') }}"
                                        oninput="nameinput('modir_name')"
                                        @error('modir_name')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputmodir_name">نام</label>
                                    <span class="clear-btn" id="clearBtn_modir_name" onclick="clearInput('modir_name')"
                                        @if (old('modir_name')) style="display:block !important" @endif>×</span>
                                </div>
                                <div class="error-message" id="error-modir_name">فقط حروف فارسی مجاز است.</div>
                                @error('modir_name')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete @if (old('modir_family')) filled @endif"
                                    id="autocompleteBoxmodir_family">
                                    <input type="text" id="searchInputmodir_family" class="only-persian"
                                        name="modir_family" value="{{ old('modir_family') }}"
                                        oninput="nameinput('modir_family')"
                                        @error('modir_family')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputmodir_family">نام خانوادگی</label>
                                    <span class="clear-btn" id="clearBtn_modir_family"
                                        onclick="clearInput('modir_family')"
                                        @if (old('modir_family')) style="display:block !important" @endif>×</span>
                                </div>
                                <div class="error-message" id="error-modir_family">فقط حروف فارسی مجاز است.</div>

                                @error('modir_family')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete @if (old('modir_father')) filled @endif"
                                    id="autocompleteBoxmodir_father">
                                    <input type="text" id="searchInputmodir_father" class="only-persian"
                                        name="modir_father" value="{{ old('modir_father') }}"
                                        oninput="nameinput('modir_father')"
                                        @error('modir_father')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputmodir_father">نام پدر</label>
                                    <span class="clear-btn" id="clearBtn_modir_father"
                                        onclick="clearInput('modir_father')"
                                        @if (old('modir_father')) style="display:block !important" @endif>×</span>
                                </div>
                                <div class="error-message" id="error-modir_father">فقط حروف فارسی مجاز است.</div>

                                @error('modir_father')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete @if (old('modir_national')) filled @endif"
                                    id="autocompleteBoxmodir_national">
                                    <input type="text" id="searchInputmodir_national" data-rule="nationalCode"
                                        class="validate-input" name="modir_national" maxlength="12"
                                        value="{{ old('modir_national') }}" oninput="nameinput('modir_national')"
                                        @error('modir_national')
                                        style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputmodir_national">شماره ملی</label>
                                    <span class="clear-btn" id="clearBtn_modir_national"
                                        onclick="clearInput('modir_national')"
                                        @if (old('modir_national')) style="display:block !important" @endif>×</span>
                                </div>
                                <div class="error-message" id="error-modir_national"></div>
                                @error('modir_national')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete @if (old('modir_shenasname')) filled @endif"
                                    id="autocompleteBoxmodir_shenasname">
                                    <input type="text" id="searchInputmodir_shenasname" class="only-number"
                                        name="modir_shenasname" value="{{ old('modir_shenasname') }}"
                                        oninput="nameinput('modir_shenasname')"
                                        @error('modir_shenasname')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputmodir_shenasname">شماره شناسنامه</label>
                                    <span class="clear-btn" id="clearBtn_modir_shenasname"
                                        onclick="clearInput('modir_shenasname')"
                                        @if (old('modir_shenasname')) style="display:block !important" @endif>×</span>
                                </div>
                                @error('modir_shenasname')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete @if (old('modir_birthday')) filled @endif"
                                    id="autocompleteBoxmodir_birthday">
                                    <input type="text" id="searchInputmodir_birthday" name="modir_birthday" readonly
                                        value="{{ old('modir_birthday') }}" oninput="nameinput('modir_birthday')"
                                        @error('modir_birthday')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputmodir_birthday">تاریخ تولد</label>
                                    <span class="clear-btn" id="clearBtn_modir_birthday"
                                        onclick="clearInput('modir_birthday')"
                                        @if (old('modir_birthday')) style="display:block !important" @endif>×</span>
                                </div>
                                @error('modir_birthday')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete @if (old('modir_sodor')) filled @endif"
                                    id="autocompleteBoxmodir_sodor">
                                    <input type="text" id="searchInputmodir_sodor" class="only-persian"
                                        name="modir_sodor" value="{{ old('modir_sodor') }}"
                                        oninput="nameinput('modir_sodor')"
                                        @error('modir_sodor')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputmodir_sodor">محل صدور</label>
                                    <span class="clear-btn" id="clearBtn_modir_sodor" onclick="clearInput('modir_sodor')"
                                        @if (old('modir_sodor')) style="display:block !important" @endif>×</span>
                                </div>
                                <div class="error-message" id="error-modir_sodor">فقط حروف فارسی مجاز است.</div>

                                @error('modir_sodor')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                {{-- <label class="mb-2">شماره تماس</label> --}}
                                <div class="d-flex gap-0">
                                    <!-- شماره اصلی -->
                                    <div class="autocomplete flex-grow-1 @if (old('haghighi_number')) filled @endif"
                                        id="autocompleteBoxhaghighi_number">
                                        <input type="text" id="searchInputhaghighi_number"
                                            class="only-number validate-input" data-rule="phone" name="haghighi_number"
                                            value="{{ old('haghighi_number') }}" oninput="nameinput('haghighi_number')"
                                            maxlength="8"
                                            @error('haghighi_number') style="border:red solid 1px" @enderror>
                                        <label for="searchInputhaghighi_number">شماره تلفن</label>
                                        <span class="clear-btn" id="clearBtn_haghighi_number"
                                            onclick="clearInput('haghighi_number')"
                                            @if (old('haghighi_number')) style="display:block !important" @endif>×</span>
                                    </div>
                                    <!-- پیش شماره -->
                                    <div class="autocomplete flex-grow-0 @if (old('haghighi_prefix')) filled @endif"
                                        style="width: 120px;" id="autocompleteBoxhaghighi_prefix">
                                        <input type="text" id="searchInputhaghighi_prefix"
                                            class="only-number validate-input" data-rule="prefix" name="haghighi_prefix"
                                            maxlength="3" value="{{ old('haghighi_prefix') }}"
                                            oninput="nameinput('haghighi_prefix')"
                                            @error('haghighi_prefix') style="border:red solid 1px" @enderror>
                                        <label for="searchInputhaghighi_prefix">پیش شماره</label>
                                        <span class="clear-btn" id="clearBtn_haghighi_prefix"
                                            onclick="clearInput('haghighi_prefix')"
                                            @if (old('haghighi_prefix')) style="display:block !important" @endif>×</span>
                                    </div>
                                </div>
                                <div class="error-message" id="error-haghighi_prefix"></div>
                                <div class="error-message" id="error-haghighi_number"></div>
                                @error('haghighi_prefix')
                                    <small class="text-danger mt-2 d-block">{{ $message }}</small>
                                @enderror

                                @error('haghighi_number')
                                    <small class="text-danger mt-2 d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete @if (old('modir_mobile')) filled @endif"
                                    id="autocompleteBoxmodir_mobile">
                                    <input type="text" id="searchInputmodir_mobile" class="only-number validate-input"
                                        maxlength="11" data-rule="mobile" name="modir_mobile"
                                        value="{{ old('modir_mobile') }}" oninput="nameinput('modir_mobile')"
                                        @error('modir_mobile')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputmodir_mobile">
                                        شماره موبایل
                                        <small>(نام کاربری)</small>
                                    </label>
                                    <span class="clear-btn" id="clearBtn_modir_mobile"
                                        onclick="clearInput('modir_mobile')"
                                        @if (old('modir_mobile')) style="display:block !important" @endif>×</span>
                                </div>
                                <div class="error-message" id="error-modir_mobile"></div>
                                @error('modir_mobile')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete @if (old('modir_email')) filled @endif"
                                    id="autocompleteBoxmodir_email">
                                    <input type="email" id="searchInputmodir_email" class="" name="modir_email"
                                        value="{{ old('modir_email') }}" oninput="nameinput('modir_email')"
                                        @error('modir_email')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputmodir_email">
                                        ایمیل <small>(اختیاری)</small>
                                    </label>
                                    <span class="clear-btn" id="clearBtn_modir_email" onclick="clearInput('modir_email')"
                                        @if (old('modir_email')) style="display:block !important" @endif>×</span>
                                </div>
                                @error('modir_email')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="autocomplete @if (old('address_moasses')) filled @endif"
                                    id="autocompleteBoxaddress_moasses">
                                    <input type="text" id="searchInputaddress_moasses" class="only-persian"
                                        name="address_moasses" value="{{ old('address_moasses') }}"
                                        oninput="nameinput('address_moasses')"
                                        @error('address_moasses')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputaddress_moasses">آدرس محل سکونت <small>(اختیاری)</small></label>
                                    <span class="clear-btn" id="clearBtn_address_moasses"
                                        onclick="clearInput('address_moasses')"
                                        @if (old('address_moasses')) style="display:block !important" @endif>×</span>
                                </div>
                                <div class="error-message" id="error-address_moasses">فقط حروف فارسی مجاز است.</div>

                                @error('address_moasses')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <!-- فرم حقوقی -->
                        <div class="row px-0 mx-0 mt-2" id="hoghoghi-form"
                            style="display: {{ old('haghighi') == 2 ? '' : 'none' }}">
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete @if (old('hoghoghi_name')) filled @endif"
                                    id="autocompleteBoxhoghoghi_name">
                                    <input type="text" id="searchInputhoghoghi_name" class="only-persian"
                                        name="hoghoghi_name" value="{{ old('hoghoghi_name') }}"
                                        oninput="nameinput('hoghoghi_name')"
                                        @error('hoghoghi_name')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputhoghoghi_name">نام شرکت</label>
                                    <span class="clear-btn" id="clearBtn_hoghoghi_name"
                                        onclick="clearInput('hoghoghi_name')"
                                        @if (old('hoghoghi_name')) style="display:block !important" @endif>×</span>
                                </div>
                                <div class="error-message" id="error-hoghoghi_name">فقط حروف فارسی مجاز است.</div>

                                @error('hoghoghi_name')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete @if (old('hoghoghi_sabt')) filled @endif"
                                    id="autocompleteBoxhoghoghi_sabt">
                                    <input type="text" id="searchInputhoghoghi_sabt" class="only-number"
                                        name="hoghoghi_sabt" value="{{ old('hoghoghi_sabt') }}"
                                        oninput="nameinput('hoghoghi_sabt')"
                                        @error('hoghoghi_sabt')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputhoghoghi_sabt">شماره ثبت</label>
                                    <span class="clear-btn" id="clearBtn_hoghoghi_sabt"
                                        onclick="clearInput('hoghoghi_sabt')"
                                        @if (old('hoghoghi_sabt')) style="display:block !important" @endif>×</span>
                                </div>
                                @error('hoghoghi_sabt')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete @if (old('hoghoghi_tarikh')) filled @endif"
                                    id="autocompleteBoxhoghoghi_tarikh">
                                    <input type="text" id="searchInputhoghoghi_tarikh" name="hoghoghi_tarikh" readonly
                                        value="{{ old('hoghoghi_tarikh') }}" oninput="nameinput('hoghoghi_tarikh')"
                                        @error('hoghoghi_tarikh')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputhoghoghi_tarikh">تاریخ ثبت</label>
                                    <span class="clear-btn" id="clearBtn_hoghoghi_tarikh"
                                        onclick="clearInput('hoghoghi_tarikh')"
                                        @if (old('hoghoghi_tarikh')) style="display:block !important" @endif>×</span>
                                </div>
                                @error('hoghoghi_tarikh')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete @if (old('hoghoghi_modir')) filled @endif"
                                    id="autocompleteBoxhoghoghi_modir">
                                    <input type="text" id="searchInputhoghoghi_modir" class="only-persian"
                                        name="hoghoghi_modir" value="{{ old('hoghoghi_modir') }}"
                                        oninput="nameinput('hoghoghi_modir')"
                                        @error('hoghoghi_modir')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputhoghoghi_modir">مدیر عامل</label>
                                    <span class="clear-btn" id="clearBtn_hoghoghi_modir"
                                        onclick="clearInput('hoghoghi_modir')"
                                        @if (old('hoghoghi_modir')) style="display:block !important" @endif>×</span>
                                </div>
                                <div class="error-message" id="error-hoghoghi_modir">فقط حروف فارسی مجاز است.</div>

                                @error('hoghoghi_modir')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                {{-- <label class="mb-2">شماره تماس</label> --}}
                                <div class="d-flex gap-0">
                                    <!-- شماره اصلی -->
                                    <div class="autocomplete flex-grow-1 @if (old('hoghoghi_tamas')) filled @endif"
                                        id="autocompleteBoxhoghoghi_tamas">
                                        <input type="text" id="searchInputhoghoghi_tamas"
                                            class="only-number validate-input" data-rule="phone" name="hoghoghi_tamas"
                                            maxlength="8" value="{{ old('hoghoghi_tamas') }}"
                                            oninput="nameinput('hoghoghi_tamas')"
                                            @error('hoghoghi_tamas') style="border:red solid 1px" @enderror>
                                        <label for="searchInputhoghoghi_tamas">شماره تلفن</label>
                                        <span class="clear-btn" id="clearBtn_hoghoghi_tamas"
                                            onclick="clearInput('hoghoghi_tamas')"
                                            @if (old('hoghoghi_tamas')) style="display:block !important" @endif>×</span>
                                    </div>
                                    <!-- پیش شماره -->
                                    <div class="autocomplete flex-grow-0 @if (old('hoghoghi_prefix')) filled @endif"
                                        style="width: 120px;" id="autocompleteBoxhoghoghi_prefix">
                                        <input type="text" id="searchInputhoghoghi_prefix"
                                            class="only-number validate-input" data-rule="prefix" name="hoghoghi_prefix"
                                            maxlength="3" value="{{ old('hoghoghi_prefix') }}"
                                            oninput="nameinput('hoghoghi_prefix')"
                                            @error('hoghoghi_prefix') style="border:red solid 1px" @enderror>
                                        <label for="searchInputhoghoghi_prefix">پیش شماره</label>
                                        <span class="clear-btn" id="clearBtn_hoghoghi_prefix"
                                            onclick="clearInput('hoghoghi_prefix')"
                                            @if (old('hoghoghi_prefix')) style="display:block !important" @endif>×</span>
                                    </div>
                                </div>
                                <div class="error-message" id="error-hoghoghi_prefix"></div>
                                <div class="error-message" id="error-hoghoghi_tamas"></div>
                                @error('hoghoghi_prefix')
                                    <small class="text-danger mt-2 d-block">{{ $message }}</small>
                                @enderror

                                @error('hoghoghi_tamas')
                                    <small class="text-danger mt-2 d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete @if (old('hoghoghi_mobile')) filled @endif"
                                    id="autocompleteBoxhoghoghi_mobile">
                                    <input type="text" id="searchInputhoghoghi_mobile" maxlength="11"
                                        class="only-number validate-input" data-rule="mobile" name="hoghoghi_mobile"
                                        value="{{ old('hoghoghi_mobile') }}" oninput="nameinput('hoghoghi_mobile')"
                                        @error('hoghoghi_mobile')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputhoghoghi_mobile">
                                        شماره موبایل
                                        <small>(نام کاربری)</small>
                                    </label>
                                    <span class="clear-btn" id="clearBtn_hoghoghi_mobile"
                                        onclick="clearInput('hoghoghi_mobile')"
                                        @if (old('hoghoghi_mobile')) style="display:block !important" @endif>×</span>
                                </div>
                                <div class="error-message" id="error-hoghoghi_mobile"></div>
                                @error('hoghoghi_mobile')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="autocomplete @if (old('modir_email')) filled @endif"
                                    id="autocompleteBoxmodir_email">
                                    <input type="email" id="searchInputmodir_email" class="" name="modir_email"
                                        value="{{ old('modir_email') }}" oninput="nameinput('modir_email')"
                                        @error('modir_email')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputmodir_email">
                                        ایمیل <small>(اختیاری)</small>
                                    </label>
                                    <span class="clear-btn" id="clearBtn_modir_email" onclick="clearInput('modir_email')"
                                        @if (old('modir_email')) style="display:block !important" @endif>×</span>
                                </div>
                                @error('modir_email')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="autocomplete @if (old('hoghoghi_address')) filled @endif"
                                    id="autocompleteBoxhoghoghi_address">
                                    <input type="text" id="searchInputhoghoghi_address" class="only-persian"
                                        name="hoghoghi_address" value="{{ old('hoghoghi_address') }}"
                                        oninput="nameinput('hoghoghi_address')"
                                        @error('hoghoghi_address')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputhoghoghi_address">آدرس شرکت <small>(اختیاری)</small></label>
                                    <span class="clear-btn" id="clearBtn_hoghoghi_address"
                                        onclick="clearInput('hoghoghi_address')"
                                        @if (old('hoghoghi_address')) style="display:block !important" @endif>×</span>
                                </div>
                                <div class="error-message" id="error-hoghoghi_address">فقط حروف فارسی مجاز است.</div>

                                @error('hoghoghi_address')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- اطلاعات تماس -->
                    <div class="row rounded-4 p-3 pt-0">
                        <div class="d-flex flex-wrap align-content-center mb-2 register_title">
                            <img src="{{ asset('site/public/icon/vertical-line.svg') }}" aria-hidden="true"
                                class="ms-2" alt="">
                            <h3>اطلاعات مکان آموزشگاه</h3>
                        </div>
                        <!-- استان -->
                        <div class="col-md-6 mb-3">
                            <div class="autocomplete filled" id="autocompleteBoxstate">
                                <input type="text" id="searchInputstate" name="state_test" class="only-persian"
                                    oninput="filterOptions('state',1)" onclick="dropdownshow('state')"
                                    value="{{ old('state_test', 'یزد') }}"
                                    @error('state')
                                    style="border:red solid 1px"
                                    @enderror>
                                <label for="searchInputstate">استان</label>
                                <span class="clear-btn" style="display: block !important;" id="clearBtn_state"
                                    onclick="clearInput('state')">×</span>
                                <div class="dropdown" id="dropdownListstate" style="display: none;"></div>
                                <input type="hidden" name="state" id="selectedIdstate"
                                    value="{{ old('state', '31') }}">
                            </div>
                            <div class="error-message" id="error-state_test">فقط حروف فارسی مجاز است.</div>

                            @error('state')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="autocomplete filled" id="autocompleteBoxcity">
                                <input type="text" id="searchInputcity" name="city_test" class="only-persian"
                                    oninput="filterOptions('city',1)" onclick="dropdownshow('city')"
                                    value="{{ old('city_test', 'یزد') }}"
                                    @error('city')
                                    style="border:red solid 1px"
                                    @enderror>
                                <label for="searchInputcity">شهرستان</label>
                                <span class="clear-btn" style="display: block !important;" id="clearBtn_city"
                                    onclick="clearInput('city')">×</span>
                                <div class="dropdown" id="dropdownListcity" style="display: none;"></div>
                                <input type="hidden" name="city" id="selectedIdcity"
                                    value="{{ old('city', '1149') }}">
                            </div>
                            <div class="error-message" id="error-city_test">فقط حروف فارسی مجاز است.</div>

                            @error('city')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="autocomplete @if (old('postal')) filled @endif"
                                id="autocompleteBoxpostal">
                                <input type="text" id="searchInputpostal" class="" name="postal"
                                    value="{{ old('postal') }}" oninput="formatPostalCode(this)" maxlength="11"
                                    @error('postal') style="border:red solid 1px" @enderror>
                                <label for="searchInputpostal">کدپستی</label>
                                <span class="clear-btn" id="clearBtn_postal" onclick="clearInput('postal')"
                                    @if (old('postal')) style="display:block !important" @endif>×</span>
                            </div>
                            @error('postal')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            {{-- <label class="mb-2">شماره تماس</label> --}}
                            <div class="d-flex gap-0">
                                <!-- شماره اصلی -->
                                <div class="autocomplete flex-grow-1 @if (old('tel')) filled @endif"
                                    id="autocompleteBoxtel">
                                    <input type="text" id="searchInputtel" class="only-number validate-input"
                                        data-rule="phone" name="tel" value="{{ old('tel') }}" maxlength="8"
                                        oninput="nameinput('tel')" @error('tel') style="border:red solid 1px" @enderror>
                                    <label for="searchInputtel">شماره تلفن</label>
                                    <span class="clear-btn" id="clearBtn_tel" onclick="clearInput('tel')"
                                        @if (old('tel')) style="display:block !important" @endif>×</span>
                                </div>
                                <!-- پیش شماره -->
                                <div class="autocomplete flex-grow-0 @if (old('tel_prefix')) filled @endif"
                                    style="width: 120px;" id="autocompleteBoxtel_prefix">
                                    <input type="text" id="searchInputtel_prefix" class="only-number validate-input"
                                        data-rule="prefix" name="tel_prefix" maxlength="3"
                                        value="{{ old('tel_prefix') }}" oninput="nameinput('tel_prefix')"
                                        @error('tel_prefix') style="border:red solid 1px" @enderror>
                                    <label for="searchInputtel_prefix">پیش شماره</label>
                                    <span class="clear-btn" id="clearBtn_tel_prefix" onclick="clearInput('tel_prefix')"
                                        @if (old('tel_prefix')) style="display:block !important" @endif>×</span>
                                </div>
                            </div>
                            <div class="error-message" id="error-tel_prefix"></div>
                            <div class="error-message" id="error-tel"></div>
                            @error('tel_prefix')
                                <small class="text-danger mt-2 d-block">{{ $message }}</small>
                            @enderror

                            @error('tel')
                                <small class="text-danger mt-2 d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            {{-- <label class="mb-2">شماره تماس</label> --}}
                            <div class="d-flex gap-0">
                                <!-- شماره اصلی -->
                                <div class="autocomplete flex-grow-1 @if (old('fax')) filled @endif"
                                    id="autocompleteBoxfax">
                                    <input type="text" id="searchInputfax" class="only-number validate-input"
                                        maxlength="8" data-rule="fax" name="fax" value="{{ old('fax') }}"
                                        oninput="nameinput('fax')" @error('fax') style="border:red solid 1px" @enderror>
                                    <label for="searchInputfax">فکس <small>(اختیاری)</small></label>
                                    <span class="clear-btn" id="clearBtn_fax" onclick="clearInput('fax')"
                                        @if (old('fax')) style="display:block !important" @endif>×</span>
                                </div>
                                <!-- پیش شماره -->
                                <div class="autocomplete flex-grow-0 @if (old('fax_prefix')) filled @endif"
                                    style="width: 120px;" id="autocompleteBoxfax_prefix">
                                    <input type="text" id="searchInputfax_prefix" class="only-number validate-input"
                                        data-rule="prefix" name="fax_prefix" maxlength="3"
                                        value="{{ old('fax_prefix') }}" oninput="nameinput('fax_prefix')"
                                        @error('fax_prefix') style="border:red solid 1px" @enderror>
                                    <label for="searchInputfax_prefix">پیش شماره</label>
                                    <span class="clear-btn" id="clearBtn_fax_prefix" onclick="clearInput('fax_prefix')"
                                        @if (old('fax_prefix')) style="display:block !important" @endif>×</span>
                                </div>
                            </div>
                            <div class="error-message" id="error-fax_prefix"></div>
                            <div class="error-message" id="error-fax"></div>
                            @error('fax_prefix')
                                <small class="text-danger mt-2 d-block">{{ $message }}</small>
                            @enderror

                            @error('fax')
                                <small class="text-danger mt-2 d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="autocomplete @if (old('mobile')) filled @endif"
                                id="autocompleteBoxmobile">
                                <input type="text" id="searchInputmobile" class="only-number validate-input"
                                    data-rule="mobile" name="mobile" value="{{ old('mobile') }}"
                                    oninput="nameinput('mobile')" maxlength="11"
                                    @error('mobile')
                                    style="border:red solid 1px"
                                    @enderror>
                                <label for="searchInputmobile">موبایل <small>(اختیاری)</small></label>
                                <span class="clear-btn" id="clearBtn_mobile" onclick="clearInput('mobile')"
                                    @if (old('mobile')) style="display:block !important" @endif>×</span>
                            </div>
                            <div class="error-message" id="error-mobile"></div>
                            @error('mobile')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="autocomplete @if (old('address')) filled @endif"
                                id="autocompleteBoxaddress">
                                <input type="text" id="searchInputaddress" class="only-persian" name="address"
                                    value="{{ old('address') }}" oninput="nameinput('address')"
                                    @error('address')
                                    style="border:red solid 1px"
                                    @enderror>
                                <label for="searchInputaddress">آدرس</label>
                                <span class="clear-btn" id="clearBtn_address" onclick="clearInput('address')"
                                    @if (old('address')) style="display:block !important" @endif>×</span>
                            </div>
                            <div class="error-message" id="error-address">فقط حروف فارسی مجاز است.</div>

                            @error('address')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    {{-- مستندات --}}
                    <div class="row rounded-4 p-3 pt-0 justify-content-center">
                        <div class="d-flex flex-wrap align-content-center mb-2 register_title">
                            <img src="{{ asset('site/public/icon/vertical-line.svg') }}" aria-hidden="true"
                                class="ms-2" alt="">
                            <h3>بارگذاری مستندات</h3>
                        </div>
                        <div class="col-12">
                            <div class="row g-0 rounded-3 border pt-3 mb-3" style="background-color: #f2f7ff">
                                <div class="col-md-12 mb-2">
                                    <div class="mb-3 p-2 rounded-3" style="background-color: #f2f7ff">
                                        <span>تصویر پروانه کسب (رو)</span>
                                        <div
                                            class="border mt-2 bg-white @error('file_tasis_front') border-danger @enderror rounded-2 d-flex align-items-center mt-1">
                                            <label for="file_tasis_front" class="btn btn-primary ms-2">انتخاب فایل</label>
                                            <input type="file" id="file_tasis_front" name="file_tasis_front"
                                                accept="image/*" style="display: none;">
                                            <span id="file_tasis_front_count" class="text-primary file-count">فایلی انتخاب
                                                نشده</span>
                                        </div>
                                        <div id="file_tasis_front_preview" class="mt-2"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="mb-3 p-2 rounded-3" style="background-color: #f2f7ff">
                                        <span>تصویر پروانه کسب (پشت)</span>
                                        <div
                                            class="border mt-2 bg-white @error('file_tasis_back') border-danger @enderror rounded-2 d-flex align-items-center mt-1">
                                            <label for="file_tasis_back" class="btn btn-primary ms-2">انتخاب فایل</label>
                                            <input type="file" id="file_tasis_back" name="file_tasis_back"
                                                accept="image/*" style="display: none;">
                                            <span id="file_tasis_back_count" class="text-primary file-count">فایلی انتخاب
                                                نشده</span>
                                        </div>
                                        <div id="file_tasis_back_preview" class="mt-2"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-0 rounded-3 border pt-3" style="background-color: #f2f7ff">
                                <div class="col-md-12">
                                    <div class="mb-3 p-2 rounded-3" style="background-color: #f2f7ff">
                                        <span>تصاویر عناوین آموزشی <small>( اختیاری )</small></span>
                                        <div
                                            class="border mt-2 bg-white @error('file') border-danger @enderror rounded-2 d-flex align-items-center mt-1">
                                            <label class="btn btn-primary ms-3">
                                                انتخاب فایل
                                                <input type="file" id="customFileInput" name="file[]" class="d-none"
                                                    accept="image/*" multiple>
                                            </label>
                                            <span id="fileCountText" class="ms-2 text-primary">فایلی انتخاب نشده</span>
                                            <!-- نمایش لیست فایل‌ها -->
                                        </div>
                                        <div id="fileList" class="mt-3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- دکمه ارسال -->
                    <div class="row text-center justify-content-center rounded-4 p-4 pt-1">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col">
                                    <div class="input-group form-label-group in-border">
                                        <input type="text" class="form-control" name="captcha" id="captchatext"
                                            aria-label="Username" value="{{ old('captcha') }}" placeholder="a">
                                        <label for="">کد امنیتی</label>
                                    </div>
                                    @error('captcha')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <div class="text-start">
                                        <span class="w-100" id="captcha">{!! captcha_img('my_custom') !!}</span>
                                        <button type="button" class="btn btn-light ms-0" id="refresh-captcha">
                                            ↻
                                        </button>
                                    </div>
                                </div>
                                {{-- <div class="col border"></div> --}}
                            </div>
                            {{-- <div class="form-group mt-3">
                                <label for="captcha">کد کپچا را وارد نمایید:</label>


                            </div> --}}

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
                        </div>
                        <!-- Button to Open the Modal -->
                        <div class="mt-4 text-start">
                            <input type="checkbox" class="form-check-input" name="ghanon" value="1"
                                id="ghanon" required>
                            <label for="ghanon" class="form-check-label ms-2">
                                <p>
                                    <a type="button" style="text-decoration: none" class="text-primary"
                                        data-bs-toggle="modal" data-bs-target="#myModal">
                                        قوانین و مقررات
                                    </a>
                                    را مطالعه نموده و با آنها موفق هستم.
                                </p>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary text-white w-100 mx-auto shadow px-5">ثبت
                            درخواست</button>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </form>
    </div>
    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">قوانین و مقررات</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    {{ $ghanon }}
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">بستن</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        let choices;

        document.addEventListener('DOMContentLoaded', function() {
            // مقداردهی اولیه Choices
            choices = new Choices('#mySelect', {
                removeItemButton: true,
                searchEnabled: true,
                shouldSort: false,
                noResultsText: 'نتیجه‌ای پیدا نشد!',
                noChoicesText: 'هیچ گزینه‌ای موجود نیست!',
                itemSelectText: 'برای انتخاب کلیک کنید',
                placeholderValue: 'انتخاب کنید', // چون لیبل داریم، نیازی به placeholder اینجا نیست
                searchPlaceholderValue: 'جستجو...',
            });
            const modalElement = document.getElementById('herfeModal');

            // هم در باز شدن و هم بسته شدن مدال، چک‌باکس‌ها هماهنگ میشن
            modalElement.addEventListener('show.bs.modal', syncCheckboxesWithSelect);
            modalElement.addEventListener('hidden.bs.modal', syncCheckboxesWithSelect);

            function syncCheckboxesWithSelect() {
                // همه چک‌باکس‌ها رو غیرفعال می‌کنیم
                document.querySelectorAll('.herfe-checkbox').forEach(cb => cb.checked = false);

                // از روی گزینه‌های انتخاب‌شده توی سلکت، چک‌باکس مربوطه رو فعال می‌کنیم
                const selectedOptions = Array.from(document.querySelectorAll('#mySelect option')).filter(opt => opt
                    .selected);

                selectedOptions.forEach(option => {
                    const checkbox = document.querySelector(`.herfe-checkbox[value="${option.value}"]`);
                    if (checkbox) checkbox.checked = true;
                });
            }

            // دکمه اعمال در مدال
            document.getElementById('applyHerfes').addEventListener('click', function() {
                const selected = Array.from(document.querySelectorAll('.herfe-checkbox:checked')).map(cb =>
                    ({
                        id: cb.value,
                        name: cb.dataset.herfeName,
                        khoshe: cb.dataset.khosheName
                    }));

                updateCounters();
                updateMainSelect(selected);
                bootstrap.Modal.getInstance(document.getElementById('herfeModal')).hide();
            });

            // زمانی که select تغییر می‌کند (افزودن یا حذف)
            document.querySelector('#mySelect').addEventListener('change', function() {
                const selectedValues = Array.from(this.selectedOptions).map(opt => opt.value);
                document.querySelectorAll('.herfe-checkbox').forEach(cb => {
                    cb.checked = selectedValues.includes(cb.value);
                });
                updateCounters();
            });

            // وقتی چک‌باکس‌ها تغییر می‌کنند، select هم آپدیت شود
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('herfe-checkbox')) {
                    // const checked = document.querySelectorAll('.herfe-checkbox:checked');
                    // const selectedHerfes = Array.from(checked).map(cb => ({
                    //     id: cb.value,
                    //     name: cb.dataset.herfeName,
                    //     khoshe: cb.dataset.khosheName
                    // }));
                    // updateMainSelect(selectedHerfes);
                    updateCounters();
                }
            });

            // مقداردهی اولیه چک‌باکس‌ها بر اساس select
            const initialSelected = Array.from(document.querySelectorAll('#mySelect option[selected]')).map(opt =>
                opt.value);
            document.querySelectorAll('.herfe-checkbox').forEach(cb => {
                cb.checked = initialSelected.includes(cb.value);
            });

            updateCounters();
        });

        function updateMainSelect(herfes) {
            choices.removeActiveItems();
            herfes.forEach(herfe => {
                choices.setChoiceByValue(herfe.id.toString());
            });
        }

        function updateCounters() {
            const total = document.querySelectorAll('.herfe-checkbox:checked').length;
            document.getElementById('totalSelected').textContent = total;

            const counts = {};
            document.querySelectorAll('.herfe-checkbox').forEach(cb => {
                const khosheId = cb.closest('.tab-pane').id.replace('khoshe-', '');
                if (!counts[khosheId]) counts[khosheId] = 0;
                if (cb.checked) counts[khosheId]++;
            });

            document.querySelectorAll('.selected-count').forEach(el => {
                const khosheId = el.dataset.khosheId;
                el.textContent = counts[khosheId] || 0;
            });
        }
    </script>
    <style>
        .manual-date-fields {
            display: flex;
            gap: 5px;
            margin-bottom: 5px;
        }

        .manual-date-input {
            flex: 1;
            text-align: center;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .date-separator {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 10px;
        }

        .toolbox {
            margin-bottom: 10px !important;
        }

        .datepicker_title {
            position: relative;
            top: 10px;
            right: 18px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 1) 0%, rgba(242, 247, 255, 1) 100%);
        }
    </style>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/persian-date@1.0.0/dist/persian-date.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            const manualInputHTML = `
                <div class="manual-date-container text-end p-2">
                    <small class="datepicker_title px-1"> تایپ تاریخ </small>
                    <div class="row p-3 pt-4 border rounded-3 g-0" style="background-color: #f2f7ff">
                        <div class="col-5 p-1">
                            <div class="autocomplete">
                                <input type="text" class="manual-date-input year-input p-1" maxlength="4" style="height:40px">
                                <label style="right:6px;">سال</label>
                                <span class="clear-btn" style="display: none;left: 8px !important;">×</span>
                            </div>
                        </div>
                        <div class="col p-1">
                            <div class="autocomplete">
                                <input type="text" class="manual-date-input month-input p-1" maxlength="2" style="height:40px">
                                <label style="right:6px;">ماه</label>
                                <span class="clear-btn" style="display: none;left: 8px !important;">×</span>
                            </div>
                        </div>
                        <div class="col p-1">
                            <div class="autocomplete">
                                <input type="text" class="manual-date-input day-input p-1" maxlength="2" style="height:40px">
                                <label style="right:6px;">روز</label>
                                <span class="clear-btn" style="display: none;left: 8px !important;">×</span>
                            </div>
                        </div>
                        <div class="col-12 p-1">
                            <button class="btn-apply-date btn btn-primary btn-sm mt-2 mb-2 w-100" style="height:40px !important">اعمال تاریخ</button>
                            <small class="px-1 datepicker_alert text-danger"></small>
                        </div>
                    </div>
                </div>
            `;

            const dateInputs =
                "#searchInputsodor_start, #searchInputsodor_end, #searchInputmodir_birthday, #searchInputhoghoghi_tarikh, #searchInputparvane_date";

            $(dateInputs).each(function() {
                const $input = $(this);

                $input.wrap(
                    '<div class="datepicker-wrapper" style="position: relative;"></div>'
                ); // هر اینپوت رو داخل یک رپر میذاریم

                $input.persianDatepicker({
                    format: "YYYY/MM/DD",
                    autoClose: false,
                    initialValue: false,
                    toolbox: {
                        calendarSwitch: {
                            enabled: true
                        }
                    },
                    onShow: function() {
                        const $datepickerPopup = $('.datepicker-plot-area:visible');

                        if ($datepickerPopup.find('.manual-date-container').length === 0) {
                            $datepickerPopup.append(manualInputHTML);

                            const $yearInput = $datepickerPopup.find('.year-input');
                            const $monthInput = $datepickerPopup.find('.month-input');
                            const $dayInput = $datepickerPopup.find('.day-input');

                            // فقط عدد
                            $datepickerPopup.find('.manual-date-input').on('input', function() {
                                this.value = this.value.replace(/[^0-9]/g, '');
                                nameinputByElement(this);
                            });

                            // حرکت بین فیلدها
                            $yearInput.on('input', () => {
                                if ($yearInput.val().length === 4) $monthInput.focus();
                            });
                            $monthInput.on('input', () => {
                                if ($monthInput.val().length === 2) $dayInput.focus();
                            });

                            // دکمه اعمال
                            $datepickerPopup.find('.btn-apply-date').on('click', function() {
                                applyManualDate($yearInput, $monthInput, $dayInput,
                                    $input, $datepickerPopup);
                            });

                            // اینتر روی روز
                            $dayInput.on('keypress', function(e) {
                                if (e.which === 13) {
                                    applyManualDate($yearInput, $monthInput, $dayInput,
                                        $input, $datepickerPopup);
                                }
                            });

                            // دکمه پاک کردن
                            $datepickerPopup.find('.clear-btn').on('click', function() {
                                const wrapper = this.closest('.autocomplete');
                                const input = wrapper.querySelector('input');
                                input.value = '';
                                wrapper.classList.remove('filled');
                                this.style.display = 'none';
                                input.focus();
                            });
                        }

                        function injectManualBox() {
                            const $datepickerPopup2 = $('.datepicker-plot-area:visible');
                            if ($datepickerPopup2.find('.manual-date-container').length === 0) {
                                $datepickerPopup2.append(manualInputHTML);
                                bindManualDateEvents($datepickerPopup2);
                            } else {

                            }
                        }

                        function bindManualDateEvents($datepickerPopup) {
                            const $yearInput = $datepickerPopup.find('.year-input');
                            const $monthInput = $datepickerPopup.find('.month-input');
                            const $dayInput = $datepickerPopup.find('.day-input');

                            $datepickerPopup.find('.manual-date-input').on('input', function() {
                                this.value = this.value.replace(/[^0-9]/g, '');
                                nameinputByElement(this);
                            });

                            $yearInput.on('input', () => {
                                if ($yearInput.val().length === 4) $monthInput.focus();
                            });
                            $monthInput.on('input', () => {
                                if ($monthInput.val().length === 2) $dayInput.focus();
                            });

                            $datepickerPopup.find('.btn-apply-date').on('click', function() {
                                applyManualDate($yearInput, $monthInput, $dayInput,
                                    $input, $datepickerPopup);
                            });

                            $dayInput.on('keypress', function(e) {
                                if (e.which === 13) {
                                    applyManualDate($yearInput, $monthInput, $dayInput,
                                        $input, $datepickerPopup);
                                }
                            });

                            $datepickerPopup.find('.clear-btn').on('click', function() {
                                const wrapper = this.closest('.autocomplete');
                                const input = wrapper.querySelector('input');
                                input.value = '';
                                wrapper.classList.remove('filled');
                                this.style.display = 'none';
                                input.focus();
                            });
                        }

                        // injectManualBox();

                        // وقتی کاربر ماه/سال رو عوض میکنه یا اسکرول میکنه دوباره تزریق کنیم
                        const $datepickerContainer = $('.datepicker-container:visible');
                        $datepickerContainer.on('click wheel', function() {
                            setTimeout(injectManualBox, 100); // کمی تاخیر برای رندر شدن
                        });
                    },
                    onSelect: function(unix) {
                        nameinput($input.attr("id"));
                    },
                });

                // وقتی روی اینپوت کلیک شد و باکس بسته بود، دوباره بازش کن
                $input.on('click', function() {
                    const $datepickerPopup = $('.datepicker-plot-area');
                    if ($datepickerPopup.length === 0) {
                        $input.persianDatepicker('show');
                    } else {
                        $datepickerPopup.css('display', 'block');
                    }
                });
            });

            function applyManualDate($yearInput, $monthInput, $dayInput, $inputElement, $datepickerPopup) {
                const year = $yearInput.val().trim();
                const month = $monthInput.val().trim().padStart(2, '0');
                const day = $dayInput.val().trim().padStart(2, '0');
                const dateStr = `${year}/${month}/${day}`;

                if (isValidPersianDate(dateStr)) {
                    $inputElement.val(dateStr);
                    $datepickerPopup.find('.datepicker_alert').text('');
                    nameinput($inputElement.attr("id"));
                    $datepickerPopup.css('display', 'none'); // فقط همین پاپ‌آپ بسته بشه
                } else {
                    $datepickerPopup.find('.datepicker_alert').text('مقادیر وارد شده صحیح نمیباشد');
                    $yearInput.focus();
                }
            }

            function isValidPersianDate(dateStr) {
                if (!/^1[3-4]\d{2}\/(0[1-9]|1[0-2])\/(0[1-9]|[12]\d|3[01])$/.test(dateStr)) return false;
                const [y, m, d] = dateStr.split('/').map(Number);
                if ([4, 6, 9, 11].includes(m) && d > 30) return false;
                if (m === 12 && d > 29) return false;
                return true;
            }

            function nameinputByElement(inputElement) {
                const wrapper = inputElement.closest('.autocomplete');
                const clearBtn = wrapper.querySelector('.clear-btn');
                if (inputElement.value.length > 0) {
                    wrapper.classList.add("filled");
                    clearBtn.style.display = 'block';
                } else {
                    wrapper.classList.remove("filled");
                    clearBtn.style.display = 'none';
                }
            }
        });
    </script>
    <script>
        function toggleForms() {
            const isHaghighi = document.getElementById("haghighi").checked;
            document.getElementById("haghighi-form").style.display = isHaghighi ? "flex" : "none";
            document.getElementById("hoghoghi-form").style.display = isHaghighi ? "none" : "flex";

            const isHoghoghi = document.getElementById("hoghoghi").checked;
            document.getElementById("haghighi-form").style.display = isHoghoghi ? "none" : "flex";
            document.getElementById("hoghoghi-form").style.display = isHoghoghi ? "flex" : "none";
        }

        function handleGenderChange() {
            const mokhtalet = document.getElementById("mokhtalet").checked;
            const checkbox = document.getElementById("tabsare34");

            if (mokhtalet) {
                checkbox.checked = true;
                // checkbox.disabled = true;
            } else {
                checkbox.checked = false;
                // checkbox.disabled = false;
            }
        }

        // cities
        function changeostan(elem) {
            id = elem.value
            states = {!! json_encode($states->toArray()) !!}
            for (i = 0; i < states.length; i++) {
                if (id == states[i].id)
                    cities = states[i].cities
            }
            options = ''
            for (j = 0; j < cities.length; j++) {
                options += '<option value="' + cities[j].id + '">' + cities[j].title + '</option>'
            }
            document.getElementById('city').innerHTML = options

        }
    </script>
    {{-- inputs script --}}
    <script>
        // const element = document.getElementById('mySelect');
        // const choices = new Choices(element, {
        //     removeItemButton: true,
        //     searchEnabled: true,
        //     shouldSort: false,
        //     noResultsText: 'نتیجه‌ای پیدا نشد!',
        //     noChoicesText: 'هیچ گزینه‌ای موجود نیست!',
        //     itemSelectText: 'برای انتخاب کلیک کنید',
        //     placeholderValue: 'انتخاب کنید', // چون لیبل داریم، نیازی به placeholder اینجا نیست
        //     searchPlaceholderValue: 'جستجو...',
        // });

        $(document).on("input", ".only-persian", function() {
            let value = $(this).val();
            let inputField = $(this);
            let name = inputField.attr('name');
            let errorMsg = $("#error-" + name);

            // الگوی حروف انگلیسی (به جز اعداد و نقطه)
            let englishLettersPattern = /[A-Za-z]/;

            if (englishLettersPattern.test(value.replace(/[0-9۰-۹\.]/g, ''))) {
                // اگر حروف انگلیسی غیر از اعداد و نقطه وجود داشت
                inputField.addClass("border-danger shake");
                errorMsg.show();

                setTimeout(function() {
                    inputField.removeClass('shake');
                }, 300);
            } else {
                // اگر فقط فارسی، اعداد یا نقطه بود
                inputField.removeClass("border-danger");
                errorMsg.hide();
            }

            // حذف حروف غیرمجاز (نگه داشتن حروف فارسی، فاصله، اعداد انگلیسی/فارسی و نقطه)
            let filteredValue = value.replace(/[^\u0600-\u06FF\s0-9۰-۹\.]/g, '');
            inputField.val(filteredValue);

            // مدیریت ظاهر جعبه و دکمه حذف
            const box = document.getElementById("autocompleteBox" + name);
            const clearBtn = document.getElementById("clearBtn_" + name);
            if (filteredValue.length > 0) {
                box.classList.add("filled");
                clearBtn.style.display = 'block';
            } else {
                box.classList.remove("filled");
                clearBtn.style.display = 'none';
            }
        });


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
        $(document).on("input", ".only-number-sign", function() {
            this.value = this.value.replace(/[^0-9+\-*/.]/g, '');
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
    </script>
    <script>
        const states = @json($states);

        function nameinput(id) {
            if (id == 'searchInputsodor_start') {
                const input = document.getElementById("searchInputsodor_start");
                const box = document.getElementById("autocompleteBoxsodor_start");
                const clearBtn = document.getElementById("clearBtn_sodor_start");
                if (input.value.length > 0) {
                    const $datepickerPopup = $('.datepicker-plot-area:visible');
                    $datepickerPopup.css('display', 'none');
                    box.classList.add("filled");
                    clearBtn.style.display = 'block';
                } else {
                    box.classList.remove("filled");
                    clearBtn.style.display = 'none';
                }
            } else if (id == 'searchInputsodor_end') {
                const input = document.getElementById("searchInputsodor_end");
                const box = document.getElementById("autocompleteBoxsodor_end");
                const clearBtn = document.getElementById("clearBtn_sodor_end");
                if (input.value.length > 0) {
                    const $datepickerPopup = $('.datepicker-plot-area:visible');
                    $datepickerPopup.css('display', 'none');
                    box.classList.add("filled");
                    clearBtn.style.display = 'block';
                } else {
                    box.classList.remove("filled");
                    clearBtn.style.display = 'none';
                }
            } else if (id == 'searchInputparvane_date') {
                const input = document.getElementById("searchInputparvane_date");
                const box = document.getElementById("autocompleteBoxparvane_date");
                const clearBtn = document.getElementById("clearBtn_parvane_date");
                if (input.value.length > 0) {
                    const $datepickerPopup = $('.datepicker-plot-area:visible');
                    $datepickerPopup.css('display', 'none');
                    box.classList.add("filled");
                    clearBtn.style.display = 'block';
                } else {
                    box.classList.remove("filled");
                    clearBtn.style.display = 'none';
                }
            } else if (id == 'searchInputmodir_birthday') {
                const input = document.getElementById("searchInputmodir_birthday");
                const box = document.getElementById("autocompleteBoxmodir_birthday");
                const clearBtn = document.getElementById("clearBtn_modir_birthday");
                if (input.value.length > 0) {
                    const $datepickerPopup = $('.datepicker-plot-area:visible');
                    $datepickerPopup.css('display', 'none');
                    box.classList.add("filled");
                    clearBtn.style.display = 'block';
                } else {
                    box.classList.remove("filled");
                    clearBtn.style.display = 'none';
                }
            } else if (id == 'searchInputhoghoghi_tarikh') {
                const input = document.getElementById("searchInputhoghoghi_tarikh");
                const box = document.getElementById("autocompleteBoxhoghoghi_tarikh");
                const clearBtn = document.getElementById("clearBtn_hoghoghi_tarikh");
                if (input.value.length > 0) {
                    const $datepickerPopup = $('.datepicker-plot-area:visible');
                    $datepickerPopup.css('display', 'none');
                    box.classList.add("filled");
                    clearBtn.style.display = 'block';
                } else {
                    box.classList.remove("filled");
                    clearBtn.style.display = 'none';
                }
            } else {
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
        function dropdownshow(id) {
            filterOptions(id, 0);
            const dropdown = document.getElementById("dropdownList" + id);
            dropdown.style.display = 'block';
        }

        function hideDropdown() {
            const dropdown = document.getElementById("dropdownList" + id);
            setTimeout(() => dropdown.style.display = 'none', 150);
        }

        function filterOptions(divId, status) {
            const dropdown = document.getElementById("dropdownList" + divId);
            const input = document.getElementById("searchInput" + divId);
            const box = document.getElementById("autocompleteBox" + divId);
            const value = input.value.toLowerCase();
            if (divId == "city") {
                city = document.getElementById("selectedIdstate").value;
                $.ajax({
                    url: '/states/' + city, //  URL جدید
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {

                        if (status == 1) {
                            const filtered = data.filter(item => item.title.toLowerCase().startsWith(value));
                            dropdown.innerHTML = filtered.length ?
                                filtered.map((item, index) =>
                                    `<div class="${index === 0 ? 'active' : ''}" onclick="selectItem(${item.id}, '${item.title}','${divId}')">${item.title}</div>`
                                ).join('') :
                                '<div>نتیجه‌ای یافت نشد</div>';
                        } else {
                            const filtered = data;
                            dropdown.innerHTML = filtered.length ?
                                filtered.map((item, index) =>
                                    `<div class="${index === 0 ? 'active' : ''}" onclick="selectItem(${item.id}, '${item.title}','${divId}')">${item.title}</div>`
                                ).join('') :
                                '<div>نتیجه‌ای یافت نشد</div>';
                        }

                        box.classList.toggle("filled", input.value.trim() !== "");
                    }
                });

                box.classList.toggle("filled", input.value.trim() !== "");
            } else if (divId == "state") {

                if (status == 1) {
                    const filtered = states.filter(item => item.title.toLowerCase().includes(value));
                    dropdown.innerHTML = filtered.length ?
                        filtered.map(item =>
                            `<div onclick="selectItem(${item.id}, '${item.title}','${divId}')">${item.title}</div>`)
                        .join('') :
                        '<div>نتیجه‌ای یافت نشد</div>';
                } else {
                    const filtered = states;
                    dropdown.innerHTML = filtered.length ?
                        filtered.map(item =>
                            `<div onclick="selectItem(${item.id}, '${item.title}','${divId}')">${item.title}</div>`)
                        .join('') :
                        '<div>نتیجه‌ای یافت نشد</div>';
                }

                box.classList.toggle("filled", input.value.trim() !== "");
            }
            const firstOption = dropdown.querySelector("div");
            if (firstOption) firstOption.classList.add("active");
        }

        function selectItem(id, name, divId) {
            const input = document.getElementById("searchInput" + divId);
            const box = document.getElementById("autocompleteBox" + divId);
            const dropdown = document.getElementById("dropdownList" + divId);


            if (divId == "state") {
                $('selectedId').change(function() { // به تغییرات در لیست *استان* گوش میدیم
                    var cityId = $(this).val(); //  مقدار (ID) *استان* انتخاب شده
                    if (cityId) {
                        $.ajax({
                            url: '/states/' + cityId, //  URL جدید
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                const filtered = data.filter(item => item.title.toLowerCase().includes(
                                    value));
                                dropdown.innerHTML = filtered.length ?
                                    filtered.map(item =>
                                        `<div onclick="selectItem(${item.id}, '${item.title}','${divId}')">${item.title}</div>`
                                    )
                                    .join('') :
                                    '<div>نتیجه‌ای یافت نشد</div>';
                                box.classList.toggle("filled", input.value.trim() !== "");
                            }
                        });
                    } else {
                        $('#state').empty();
                        $('#state').append(
                            '<option value="">شهرستان</option>'); //اگر استانی انتخاب *نشد*، شهرستان ها خالی
                    }
                });
                clearInput('city');
            }

            input.value = name;
            document.getElementById("selectedId" + divId).value = id;
            box.classList.add("filled");
            dropdown.style.display = 'none';
            const clearBtn = document.getElementById("clearBtn_" + divId);
            clearBtn.style.display = 'block';
        }

        // function clearInput(id) {
        //     if (id == 'name') {
        //         const box = document.getElementById("autocompleteBoxname");
        //         box.classList.remove("filled");
        //         const input = document.getElementById("searchInputname");
        //         input.value = "";
        //         const clearBtn = document.getElementById("clearBtn_name");
        //         clearBtn.style.display = 'none';
        //     } else {
        //         const box = document.getElementById("autocompleteBox" + id);
        //         const input = document.getElementById("searchInput" + id);
        //         input.value = "";
        //         document.getElementById("selectedId" + id).value = "";
        //         box.classList.remove("filled");
        //         if (id == 'state') {
        //             const box2 = document.getElementById("autocompleteBoxcity");
        //             const input2 = document.getElementById("searchInputcity");
        //             input2.value = "";
        //             document.getElementById("selectedIdcity").value = "";
        //             box2.classList.remove("filled");
        //             const clearBtn2 = document.getElementById("clearBtn_city");
        //             clearBtn2.style.display = 'none';
        //         }
        //         const clearBtn = document.getElementById("clearBtn_" + id);
        //         clearBtn.style.display = 'none';
        //         filterOptions(id, 0);
        //     }
        // }

        // بستن لیست با کلیک خارج از آن
        document.addEventListener("click", function(e) {
            const box1 = document.getElementById("autocompleteBoxstate");
            const box2 = document.getElementById("autocompleteBoxcity");
            const box3 = document.getElementById("autocompleteBoxgroup");
            const box4 = document.getElementById("autocompleteBoxherfe");
            const dropdown1 = document.getElementById("dropdownListstate");
            const dropdown2 = document.getElementById("dropdownListcity");
            const dropdown3 = document.getElementById("dropdownListgroup");
            const dropdown4 = document.getElementById("dropdownListherfe");


            if (box1 && !box1.contains(e.target)) {
                dropdown1.style.display = "none";
            }
            if (box2 && !box2.contains(e.target)) {
                dropdown2.style.display = "none";
            }
            if (box3 && !box3.contains(e.target)) {
                dropdown3.style.display = "none";
            }
            if (box4 && !box4.contains(e.target)) {
                dropdown4.style.display = "none";
            }
        });

        document.querySelectorAll("input[id^='searchInput']").forEach(input => {
            input.addEventListener("keydown", function(e) {
                const id = this.id.replace("searchInput", "");
                const dropdown = document.getElementById("dropdownList" + id);
                const items = dropdown.querySelectorAll("div");
                const active = dropdown.querySelector(".active");
                let index = Array.from(items).indexOf(active);

                if (e.key === "ArrowDown") {
                    e.preventDefault();
                    if (index < items.length - 1) {
                        if (active) active.classList.remove("active");
                        items[index + 1].classList.add("active");
                        items[index + 1].scrollIntoView({
                            block: "nearest"
                        });
                    }
                }

                if (e.key === "ArrowUp") {
                    e.preventDefault();
                    if (index > 0) {
                        if (active) active.classList.remove("active");
                        items[index - 1].classList.add("active");
                        items[index - 1].scrollIntoView({
                            block: "nearest"
                        });
                    }
                }

                if (e.key === "Enter") {
                    e.preventDefault();
                    if (active) {
                        const idValue = getIdFromElement(active); // تابع استخراج id
                        const name = active.textContent.trim();
                        selectItem(idValue, name, id);
                    }
                }
            });
        });

        function getIdFromElement(el) {
            // استخراج id از onclick
            const onclick = el.getAttribute("onclick");
            const match = onclick.match(/selectItem\((\d+),/);
            return match ? parseInt(match[1]) : "";
        }
    </script>
    {{-- validation --}}
    <script>
        $(document).ready(function() {
            $(document).on("blur", ".validate-input", function() {
                let inputField = $(this);
                let rule = inputField.data("rule");
                let value = inputField.val();
                let name = inputField.attr('name');
                let errorMsg = $("#error-" + name);

                let isValid = validateInput(rule, value);
                if (!isValid.status) {
                    // اگر فیلد نامعتبر بود
                    inputField.addClass("border-danger shake");
                    errorMsg.text(isValid.message).show();

                    setTimeout(function() {
                        inputField.removeClass('shake');
                    }, 300);
                } else {
                    // اگر معتبر بود
                    inputField.removeClass("border-danger");
                    errorMsg.hide();
                }
            });
        });

        function checkCodeMeli(code) {
            // حذف خط تیره‌ها از کد ملی
            code = code.replace(/-/g, '');

            // بررسی اولیه
            if (isNaN(code)) return false;
            if (code === "") return false;
            if (code.length !== 10) return false;

            // بررسی صحت الگوریتم کد ملی
            let sum = 0;
            for (let i = 0; i < 9; i++) {
                sum += parseInt(code[i]) * (10 - i);
            }

            const remainder = sum % 11;
            const controlDigit = parseInt(code[9]);

            // شرایط صحت کد ملی
            return (remainder < 2 && controlDigit === remainder) ||
                (remainder >= 2 && controlDigit === (11 - remainder));
        }

        function isValidIranianNationalCode(input) {
            // حذف همه خط تیره‌ها و فضاها
            const code = input.replace(/[- ]/g, '');

            // بررسی طول کد
            if (code.length !== 10) return false;

            // بررسی اینکه همه ارقام یکسان نباشند
            if (/^(\d)\1{9}$/.test(code)) return false;

            // محاسبه مجموع کنترل
            let sum = 0;
            for (let i = 0; i < 9; i++) {
                sum += parseInt(code.charAt(i)) * (10 - i);
            }

            const remainder = sum % 11;
            const controlDigit = parseInt(code.charAt(9));

            // اعتبارسنجی نهایی
            return (remainder < 2 && controlDigit === remainder) ||
                (remainder >= 2 && controlDigit === (11 - remainder));
        }

        // تابع اعتبارسنجی مرکزی
        function validateInput(rule, value) {
            // alert(value);
            if (value.length == 0) {
                return {
                    status: true
                }
            } else {
                switch (rule) {
                    case 'mobile':
                        if (!/^09\d{9}$/.test(value)) {
                            return {
                                status: false,
                                message: "شماره موبایل باید با 09 شروع شده و 11 رقمی باشد."
                            };
                        }
                        break;
                    case 'nationalCode':
                        if (!isValidIranianNationalCode(value)) {
                            return {
                                status: false,
                                message: "کد ملی وارد شده معتبر نیست."
                            };
                        }
                        break;
                    case 'prefix':
                        if (!/^\d{3}$/.test(value)) {
                            return {
                                status: false,
                                message: "پیش شماره باید 3 رقمی باشد."
                            };
                        }
                        break;
                    case 'fax':
                        if (!/^\d{8}$/.test(value)) {
                            return {
                                status: false,
                                message: "فکس باید 8 رقمی باشد."
                            };
                        }
                        break;
                    case 'phone':
                        if (!/^\d{8}$/.test(value)) {
                            return {
                                status: false,
                                message: "شماره تلفن باید 8 رقمی باشد."
                            };
                        }
                        break;
                }
                return {
                    status: true
                };
            }
        }
    </script>
    {{-- فایل عناوین آموزشی --}}
    <script>
        $(document).on('change', '.custom-file-input', function() {
            let fileCount = this.files.length;
            let fileCountText = fileCount === 0 ? 'فایلی انتخاب نشده' : fileCount + ' فایل انتخاب شده';
            // عنصر نمایشی که کنار این اینپوت هست رو پیدا کن
            $(this).siblings('.file-count').text(fileCountText);
        });

        // files select
        let selectedFiles = [];

        $('#customFileInput').on('change', function(event) {
            let files = Array.from(event.target.files);
            selectedFiles = selectedFiles.concat(files);

            updateFileList();
        });

        function updateFileList() {
            if (selectedFiles.length === 0) {
                $('#fileCountText').text('فایلی انتخاب نشده');
                $('#customFileInput').val('');
                $('#fileList').empty();
                return;
            }

            $('#fileCountText').text(selectedFiles.length + ' فایل انتخاب شده');

            let html = '';
            selectedFiles.forEach((file, index) => {
                let sizeInKB = (file.size / 1024).toFixed(1);
                html += `
            <div class="d-flex align-items-center justify-content-between mb-2 border bg-white p-2 rounded">
                <div class="d-flex align-items-center">
                    <img src="${URL.createObjectURL(file)}" alt="تصویر" width="50px" class="me-3 rounded">
                    <div class="me-3">
                        <div>${file.name}</div>
                        <small class="text-muted">${sizeInKB} KB</small>
                    </div>
                </div>
                <button type="button" class="btn btn-close text-danger btn-sm" onclick="removeFiles(${index})"></button>
            </div>
        `;
            });
            $('#fileList').html(html);
            // alert('ok');
        }

        function removeFiles(index) {
            // alert('ok');
            selectedFiles.splice(index, 1);
            // alert('ok');
            updateFileList();
            // alert('ok');
        }
    </script>
    <script>
        $('#file_tasis_front').on('change', function(event) {
            let file = event.target.files[0];
            if (file) {
                let sizeInKB = (file.size / 1024).toFixed(1);
                $('#file_tasis_front_count').text('1 فایل انتخاب شده');

                let html = `
            <div class="d-flex align-items-center justify-content-between mb-2 border bg-white p-2 rounded">
                <div class="d-flex align-items-center">
                    <img src="${URL.createObjectURL(file)}" alt="تصویر" width="50px" class="me-3 rounded">
                    <div class="me-3">
                        <div>${file.name}</div>
                        <small class="text-muted">${sizeInKB} KB</small>
                    </div>
                </div>
                <button type="button" class="btn btn-close text-danger btn-sm" onclick="removeFile('front')"></button>
            </div>
        `;
                $('#file_tasis_front_preview').html(html);
            }
        });

        $('#file_tasis_back').on('change', function(event) {
            let file = event.target.files[0];
            if (file) {
                let sizeInKB = (file.size / 1024).toFixed(1);
                $('#file_tasis_back_count').text('1 فایل انتخاب شده');

                let html = `
            <div class="d-flex align-items-center justify-content-between mb-2 border bg-white p-2 rounded">
                <div class="d-flex align-items-center">
                    <img src="${URL.createObjectURL(file)}" alt="تصویر" width="50px" class="me-3 rounded">
                    <div class="me-3">
                        <div>${file.name}</div>
                        <small class="text-muted">${sizeInKB} KB</small>
                    </div>
                </div>
                <button type="button" class="btn btn-close text-danger btn-sm" onclick="removeFile('back')"></button>
            </div>
        `;
                $('#file_tasis_back_preview').html(html);
            }
        });

        function removeFile(type) {
            if (type === 'front') {
                $('#file_tasis_front').val('');
                $('#file_tasis_front_count').text('فایلی انتخاب نشده');
                $('#file_tasis_front_preview').empty();
            } else if (type === 'back') {
                $('#file_tasis_back').val('');
                $('#file_tasis_back_count').text('فایلی انتخاب نشده');
                $('#file_tasis_back_preview').empty();
            }
        }
    </script>
    <script>
        document.querySelector('.register-btn').addEventListener('click', function(e) {
            e.preventDefault();
            return false;
        });
        $('.register-btn').css('pointer-events', 'none');



        document.addEventListener('DOMContentLoaded', function() {
            const nationalCodeInput = document.getElementById('searchInputmodir_national');
            // فرمت کردن کد ملی هنگام تایپ
            nationalCodeInput.addEventListener('input', function(e) {
                // حذف همه خط تیره‌های موجود
                let value = this.value.replace(/-/g, '');

                // اضافه کردن خط تیره در موقعیت‌های مورد نظر
                if (value.length > 3) {
                    value = value.substring(0, 3) + '-' + value.substring(3);
                }
                if (value.length > 10) {
                    value = value.substring(0, 10) + '-' + value.substring(10);
                }

                // محدود کردن طول به 12 کاراکتر (با احتساب خط تیره‌ها)
                this.value = value.substring(0, 12);

                // فراخوانی تابع nameinput که در کد شما وجود دارد
                nameinput('modir_national');
            });

            // حذف خط تیره‌ها قبل از ارسال فرم
            const form = nationalCodeInput.closest('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    nationalCodeInput.value = nationalCodeInput.value.replace(/-/g, '');
                });
            }
        });
        // تابع فرمت کردن کد پستی
        function formatPostalCode(input) {
            // حذف همه خط تیره‌های موجود
            let value = input.value.replace(/-/g, '');

            // محدود کردن به 10 رقم (بدون خط تیره)
            value = value.substring(0, 10);

            // اضافه کردن خط تیره بعد از 5 رقم
            if (value.length > 5) {
                value = value.substring(0, 5) + '-' + value.substring(5);
            }

            // اعمال مقدار فرمت شده
            input.value = value;

            // فراخوانی تابع nameinput که در کد شما وجود دارد
            nameinput('postal');
        }

        // حذف خط تیره قبل از ارسال فرم
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function() {
                    const postalInput = document.getElementById('searchInputpostal');
                    postalInput.value = postalInput.value.replace(/-/g, '');
                });
            }
        });
    </script>
@endsection
