@extends('site.layout.master')
@section('head')
    <title>فرصت های شغلی</title>
    <style>
        body {
            background: #f2f2f2 !important;
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
    @php
        $chunks = $groups->chunk(ceil($groups->count() / 3)); // تقسیم به 3 قسمت
    @endphp
    <div class="container wrapper mb-5" style="padding-top: 120px !important">
        <h3 class="text-center">عنوان اصلی وسط صفحه</h3>
        <p class="text-center text-muted mb-4">متن فرعی زیر عنوان اصلی به صورت وسط چین و جاستیفای با رنگ کمرنگ تر از اصلی</p>
        <div class="row gap-3">
            @foreach ($chunks as $chunk)
                <div class="col item-col rounded-3 p-3 gap-2 shadow">
                    @foreach ($chunk as $group)
                        <a href="#" class="text-decoration-none text-reset">
                            <div class="border rounded-3 d-flex justify-content-between px-3 py-2 bg-white">
                                <div class="text">{{ $group->name }}</div>
                                <div>
                                    <span class="badge count-span">{{ $group->organs->count() ?? 0 }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('script')
@endsection
