@extends('site.layout.master')
@section('head')
    <title>فرصت های شغلی</title>
    <style>
        .card {
            border-radius: 10px;
            /* box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); */
            transition: all 0.3s;
            margin-bottom: 20px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .company-logo {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .job-title {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .job-features {
            margin-top: 10px;
        }

        .feature-badge {
            background-color: #e9ecef;
            color: #495057;
            margin-left: 5px;
            margin-bottom: 5px;
            font-size: 0.8rem;
        }

        .badge-success {
            background-color: #bbffcbbb;
            color: #2fbc50;
            margin-left: 5px;
            margin-bottom: 5px;
            font-size: 0.8rem;
        }

        .badge-danger {
            background-color: #ffbbbbbb;
            color: #b72929;
            margin-left: 5px;
            margin-bottom: 5px;
            font-size: 0.8rem;
        }

        .badge-primary {
            background-color: #bbecffbb;
            color: #2795ba;
            margin-left: 5px;
            margin-bottom: 5px;
            font-size: 0.8rem;
        }

        .stats-section {
            padding-left: 15px;
        }

        .stat-item {
            margin-bottom: 10px;
            text-align: left;
        }

        .stat-value {
            font-weight: bold;
            font-size: 1.1rem;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .info-bar {
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
            padding: 10px 19px;
            border-radius: 0 0 10px 10px;
            margin-top: 15px;
        }

        .salary {
            color: #242424;
            /* font-weight: bold; */
            font-size: 12.8px;
        }

        .filter-section {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            /* box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); */
            margin-bottom: 30px;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
        }

        .btn-primary {
            background-color: #0d6efd;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
        }

        @media (max-width: 768px) {
            .stats-section {
                padding-top: 15px;
                margin-top: 15px;
            }
        }

        .item-col {
            /* background: #fff; */
            background: #f8f9fc;
            display: flex;
            flex-direction: column;
        }

        .count-span {
            background: #e699263e;
            color: #e69926;
        }

        .tabone-link.active {
            background-color: white !important;
            /* border-color: var(--bs-nav-tabs-link-active-border-color); */
            /* border: none; */
            border: none !important;
            border-bottom: 2px solid #ffae00 !important;
            color: #e69926 !important;
            font-weight: bold;
            /* transform: scale(1.2);
                                        margin-bottom: 1.5px !important; */
        }

        .tabone-link.active i {
            color: #e69926 !important;
        }

        .tabone-link {
            border: none !important;
            color: #000;
            margin-bottom: -1.5px !important;
        }

        .tabone-link i {
            position: relative;
            top: 2px;
        }

        .tabone-link:hover {
            /* border: none !important; */
            color: #e69926;
        }

        .nav-tabs {
            border-color: #ececec;
            border-width: 2px
        }

        .autocomplete {
            position: relative;
            /* width: 300px; */
        }

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
    </style>
    {{-- login btn --}}
    <style>
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
            transform: translateX(74px);
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
@endsection
@section('content')
    <div class="container wrapper mb-5"
        style="min-height: 100vh;align-items: center;align-content: center;padding-top:110px;">
        <div class="bg-white border shadow rounded-3">
            <ul class="nav nav-tabs pe-3 gap-4" id="tabOne" role="tablist" style="border-radius: 5px 5px 0 0">
                <li class="nav-item" role="presentation">
                    <button class="nav-link tabone-link py-3 px-1 active" id="fields-tab" data-bs-toggle="tab"
                        data-bs-target="#fields" type="button" role="tab">آموزشی
                    </button>
                </li>
            </ul>
            <div class="tab-content p-3 pb-5" id="tabOneContent" style="border-radius: 0 0 5px 5px">
                <div class="tab-pane fade show active" id="fields" role="tabpanel">
                    <!-- لیست کارت‌های موقعیت شغلی -->
                    <div class="row" id="jobCards">
                        <div class="col-12">
                            <!-- بخش فیلترها -->
                            <div class="filter-section px-0">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <div class="autocomplete" id="autocompleteBoxherfe">
                                            <input type="text" id="searchInputherfe" oninput="filterOptions('herfe',1)"
                                                onclick="dropdownshow('herfe')">
                                            <label>حرفه</label>
                                            <span class="clear-btn" id="clearBtn_herfe"
                                                onclick="clearInput('herfe')">×</span>
                                            <div class="dropdown" id="dropdownListherfe" style="display: none;"></div>
                                            <input type="hidden" name="herfe" id="selectedIdherfe">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="autocomplete" id="autocompleteBoxherfe">
                                            <input type="text" id="searchInputherfe" oninput="filterOptions('herfe',1)"
                                                onclick="dropdownshow('herfe')">
                                            <label>حرفه</label>
                                            <span class="clear-btn" id="clearBtn_herfe"
                                                onclick="clearInput('herfe')">×</span>
                                            <div class="dropdown" id="dropdownListherfe" style="display: none;"></div>
                                            <input type="hidden" name="herfe" id="selectedIdherfe">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="autocomplete" id="autocompleteBoxherfe">
                                            <input type="text" id="searchInputherfe" oninput="filterOptions('herfe',1)"
                                                onclick="dropdownshow('herfe')">
                                            <label>حرفه</label>
                                            <span class="clear-btn" id="clearBtn_herfe"
                                                onclick="clearInput('herfe')">×</span>
                                            <div class="dropdown" id="dropdownListherfe" style="display: none;"></div>
                                            <input type="hidden" name="herfe" id="selectedIdherfe">
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <button class="btn btn-primary w-100 h-100" id="applyFilter">
                                            <i class="bi bi-funnel ms-2"></i>اعمال فیلتر
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- کارت 1 -->
                        <div class="col-lg-6">
                            <div class="card border">
                                <div class="card-body p-0">
                                    <div class="row p-3 pb-0">
                                        <div class="col-9">
                                            <div class="d-flex align-items-start">
                                                <img src="{{ asset('no-image.svg') }}" alt="لوگو آموزشگاه"
                                                    class="company-logo">
                                                <div class="me-4">
                                                    <h5 class="card-title mb-2">آموزشگاه زبان خارجه</h5>
                                                    <p class="job-title">مدرس زبان انگلیسی</p>
                                                    <div class="job-features">
                                                        <span class="badge badge-success">پاره وقت</span>
                                                        <span class="badge badge-danger">دورکاری</span>
                                                        <span class="badge badge-primary">تجربه لازم: ۲ سال</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3 stats-section">
                                            <div class="stat-item">
                                                <a href="#" class="text-reset text-decoration-none">
                                                    <small style="font-size: 13px;">
                                                        50
                                                        <i class="bi bi-heart me-1 text-primary"
                                                            style="position: relative;top: 2px;"></i>
                                                    </small>
                                                </a>
                                            </div>
                                            <div class="stat-item">
                                                <small style="font-size: 13px;">
                                                    112
                                                    <i class="bi bi-eye me-1 text-primary"
                                                        style="position: relative;top: 2px;"></i>
                                                </small>
                                            </div>
                                            <div class="stat-item">
                                                <small style="font-size: 13px;">
                                                    2 روز پیش
                                                    <i class="bi bi-clock me-1 text-primary"
                                                        style="position: relative;top: 2px;"></i>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info-bar">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <div class="d-flex align-items-center gap-1">
                                                    <span class="text-small-1">یزد</span>
                                                    <span class="">|</span>
                                                    <span class="text-small-1">035-31231234</span>
                                                </div>
                                            </div>
                                            <div>
                                                <span class="salary">8,000,000 <small>تومان / درآمد ماهانه </small></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
