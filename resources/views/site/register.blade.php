<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>کانون | ورود و ثبت نام</title>

    <!-- BOOTSTRAP 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!--icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
    <!-- SLIDER LIBRARY (Splide) -->
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">

    <!-- intersection extension for slider autoplay only when slider is visible in viewport -->
    <script
        src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-intersection@0.2.0/dist/js/splide-extension-intersection.min.js"
        integrity="sha256-JKADUEtliYhbM/9Tqt7qaeQb7T2XmLEKqJ068n6tcq0=" crossorigin="anonymous"></script>
    <!-- SLIDER LIBRARY (Splide) -->


    {{--    <link rel="stylesheet" href="{{asset('site/src/style/styles.css')}}"> --}}
    <script src="{{ asset('site//src/js/utils.js') }}"></script>


    <!-- auth -->
    <link rel="stylesheet" href="{{ asset('site/src/style/auth.css') }}">
    <script src="{{ asset('site/src/js/auth.js') }}"></script>
    <!-- auth -->


    <!-- input with floating-label -->
    <link rel="stylesheet" type="text/css" href="{{ asset('site/src/style/input-with-floating-label.css') }}"
        media="screen">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/src/style/input-with-floating-label-rtl-fix.css') }}"
        media="screen">
    <!-- input with floating-label -->

    <style>
        .steps .step {
            padding: 8px !important;
        }

        .errors_alert {
            top: 20px;
            left: 50px;
            position: absolute !important;
        }
    </style>

    <!-- BEGIN PAGE LEVEL STYLES -->

    <link type="text/css" href="{{ asset('date/css/persian-datepicker.css') }}" rel="stylesheet" />

    {{--    <script type="text/javascript" src="{{asset('date/js/jquery.min.js')}}"></script> --}}

    <script type="text/javascript" src="{{ asset('date/js/persian-datepicker.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            // حالت پیشفرض
            $('#datepicker0').datepicker();
            //-----------------------------------
            // نمایش شماره هفته
            $('#datepicker1').datepicker({
                showWeek: true
            });
            //-----------------------------------
            // پرکردن فیلد اضافی
            $("#datepicker2").datepicker({
                dateFormat: './dd/mm/yy.html',
                altField: '#alternate2',
                altFormat: 'DD، d MM yy'
            });
            //-----------------------------------
            // نمایش دکمه ها
            $('#datepicker3').datepicker({
                showButtonPanel: true
            });
            //-----------------------------------
            // تغییر قالب نمایش تاریخ و تغییر سایز خودکار فیلد
            $("#datepicker4").datepicker({
                dateFormat: './dd/mm/yy.html',
                autoSize: true
            });
            $("#format4").change(function() {
                $('#datepicker4').datepicker('option', {
                    dateFormat: $(this).val()
                });
            });
            //-----------------------------------
            // استفاده از dropdown
            $('#datepicker5').datepicker({
                changeMonth: true,
                changeYear: true
            });
            //-----------------------------------
            // انتخاب با کلیک بر روی عکس
            $("#datepicker6").datepicker({
                showOn: 'button',
                buttonImage: './styles/images/calendar.png',
                buttonImageOnly: true
            });
            //-----------------------------------
            // نمایش inline
            $('#datepicker7').datepicker();
            //-----------------------------------
            // نمایش چند ماه
            $('#datepicker8').datepicker({
                numberOfMonths: 3,
                showButtonPanel: true
            });
            //-----------------------------------
            // غیرفعال کردن روزها
            $('#datepicker9').datepicker({
                beforeShowDay: function(date) {
                    if (date.getDay() == 5)
                        return [false, '', 'تعطیلات آخر هفته'];
                    return [true];
                }
            });
            //-----------------------------------
            // تاریخ پیشفرض
            $('#datepicker10').datepicker({
                defaultDate: new JalaliDate(1361, 4, 10) //this means "./1361/05/10.html"
            });
            //-----------------------------------
            // تنظیم حداقل و حداکثر
            $('#datepicker11').datepicker({
                minDate: '-3d',
                maxDate: '+1w +2d'
            });
            //-----------------------------------
            // تنظیم حداقل بصورت پویا
            $('#datepicker12from').datepicker({
                onSelect: function(dateText, inst) {
                    $('#datepicker12to').datepicker('option', 'minDate', new JalaliDate(inst[
                        'selectedYear'], inst['selectedMonth'], inst['selectedDay']));
                }
            });
            $('#datepicker12to').datepicker();
            //-----------------------------------
            // استفاده همزمان از تقویم میلادی
            $('#datepicker13').datepicker({
                regional: ''
            });
            //-----------------------------------
            // استفاده همزمان از تقویم هجری قمری
            $('#datepicker14').datepicker({
                regional: 'ar'
            });
        });
    </script>
    {{-- new calendar --}}
    <link href='{{ asset('behzadidatepicker/css/normalize.css') }}' rel='stylesheet' />
    <link href='{{ asset('behzadidatepicker/css/fontawesome/css/font-awesome.min.css') }}' rel='stylesheet' />
    {{--    <link href='{{asset("behzadidatepicker/css/vertical-responsive-menu.min.css")}}' rel="stylesheet" /> --}}
    <link href='{{ asset('behzadidatepicker/css/style.css') }}' rel="stylesheet" />
    <link href='{{ asset('behzadidatepicker/css/prism.css') }}' rel="stylesheet" />
    <link rel="stylesheet" href='{{ asset('behzadidatepicker/css/persianDatepicker-default.css') }}' />
    <script src='{{ asset('behzadidatepicker/js/prism.js') }}'></script>
    <script src='{{ asset('behzadidatepicker/js/vertical-responsive-menu.min.js') }}'></script>
    {{-- end calendar --}}

    <link rel="stylesheet" href="https://static.neshan.org/sdk/leaflet/v1.9.4/neshan-sdk/v1.0.8/index.css" />
    <script src="https://static.neshan.org/sdk/leaflet/v1.9.4/neshan-sdk/v1.0.8/index.js"></script>


    {{--    map --}}
    <link rel="stylesheet" href="https://cdn.map.ir/web-sdk/1.4.2/css/mapp.min.css">
    <link rel="stylesheet" href="https://cdn.map.ir/web-sdk/1.4.2/css/fa/style.css">

    {{--    --}}

    <script>
        $(document).ready(function() {
            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });
    </script>
    <style>
        .steps {
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
        }

        .step {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: start;
            width: 100%;
            cursor: pointer;
            /* اضافه کردن نشانگر ماوس */
            pointer-events: none;
            /* غیرفعال کردن کلیک روی آیتم‌های منوی کناری */

        }
    </style>

</head>

<body class="auth">
    <div class="card">
        <div class="row h-100">
            <div class="col-4 ps-0">
                <div class="steps">
                    <span class="step-indicator">◀</span>
                    <div class="step" data-index="0">
                        <span class="circle-number">1</span>
                        <span class="text">قوانین</span>
                    </div>

                    <div class="step" data-index="1" id="sl2">
                        <span class="circle-number">2</span>
                        <span class="text">اطلاعات صنفی</span>
                    </div>

                    <div class="step" data-index="2" id="sl3">
                        <span class="circle-number">3</span>
                        <span class="text">اطلاعات موسس</span>
                    </div>
                    <div class="step" data-index="3" id="sl4">
                        <span class="circle-number">4</span>
                        <span class="text">اطلاعات تماس</span>
                    </div>
                    <div class="step" data-index="4" id="sl5">
                        <span class="circle-number">5</span>
                        <span class="text">نقشه</span>
                    </div>

                    <div class="step" data-index="5" id="sl6">
                        <span class="circle-number">6</span>
                        <span class="text">رشته و حرفه</span>
                    </div>

                    <div class="step" data-index="6" id="sl7">
                        <span class="circle-number">7</span>
                        <span class="text">اپلود فایل</span>
                    </div>

                    <div class="step" data-index="7" id="sl8">
                        <span class="circle-number">8</span>
                        <span class="text">تائید شماره موبایل</span>
                    </div>
                </div>
            </div>

            <div class="col-8 h-100 pe-0">
                <div class="panels">
                    <div class="splide h-100" role="group" aria-label="Splide Basic HTML Example">
                        <div class="splide__track h-100">
                            <ul class="splide__list">
                                {{--                            ghanon --}}
                                <li class="splide__slide panel">
                                    {{ $ghanon }}
                                    <button type="button" class="btn btn-success mt-5" onclick="goto2()">
                                        قوانین را مطالعه نموده و میپذیرم.
                                    </button>
                                </li>
                                {{--                            senfi --}}
                                <li class="splide__slide panel">
                                    <form action="register" method="post" id="form-orig"
                                        enctype="multipart/form-data">
                                        @CSRF
                                        <div class="row">
                                            <div class="col-md-6  form-label-group in-border">
                                                {!! $errors->first('number', '<p class="text-danger" >:message</p>') !!}
                                                <div class="input-group mb-4 form-label-group in-border">
                                                    <input type="text" class="form-control" name="name"
                                                        id="name" aria-label="Username" required
                                                        value="{{ old('name') }}" placeholder="a">
                                                    <label for="">نام سازمان</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-label-group in-border">
                                                @if ($errors->first('name'))
                                                @endif
                                                {!! $errors->first('name', '<p class="text-danger" >:message</p>') !!}
                                                <div class="input-group mb-4 form-label-group in-border">
                                                    <input type="number" class="form-control" name="number"
                                                        id="number" aria-label="Username" required
                                                        value="{{ old('number') }}" placeholder="a">
                                                    <label for="">شماره شناسایی</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-label-group in-border">
                                                {!! $errors->first('sodor', '<p class="text-danger" >:message</p>') !!}
                                                <div class="input-group mb-4 form-label-group in-border">
                                                    <input type="number" class="form-control" name="sodor"
                                                        id="sodor" aria-label="Username" placeholder="a"
                                                        value="{{ old('sodor') }}">
                                                    <label for="">شماره صدور</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $errors->first('sodor_start', '<p class="text-danger" >:message</p>') !!}
                                                <div class="input-group mb-4 form-label-group in-border">

                                                    <input type="text" class=" usage form-control"
                                                        name="sodor_start" id="sodor_start" placeholder="a"
                                                        aria-label="Username" value="{{ old('sodor_start') }}"
                                                        autocomplete="false">
                                                    <label for="">تاریخ صدور</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                {!! $errors->first('sodor_end', '<p class="text-danger" >:message</p>') !!}
                                                <div class="input-group mb-4 form-label-group in-border ">
                                                    <input type="text" class=" usage form-control"
                                                        name="sodor_end" id="sodor_end" placeholder="a"
                                                        aria-label="Username" value="{{ old('sodor_end') }}">
                                                    <label for="">تاریخ پایان اعتبار</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                {!! $errors->first('sodor_end', '<p class="text-danger" >:message</p>') !!}
                                                <div class=" mb-4 form-label-group in-border d-flex">
                                                    <div class=" d-flex">
                                                        <span class="input-group-text" id="basic-addon5">دارای مجوز
                                                            تبصره 34</span>
                                                    </div>
                                                    <input type="checkbox" onclick="change34()"
                                                        class="form-check-input mx-2 mt-2" name="tabsare34"
                                                        id="tabsare34" aria-label="Username"
                                                        value="{{ old('tabsare34') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4 d-flex">
                                                {!! $errors->first('sodor_end', '<p class="text-danger" >:message</p>') !!}
                                                <div class="mb-4 d-flex">
                                                    <span class="input-group-text" id="basic-addon5">ویژه آموزش</span>
                                                    <label for="baradaran" class="mt-1 mx-2">برادران</label>
                                                    <input type="radio" class="form-check-input mt-2"
                                                        value="1" id="baradaran" name="mardzan"
                                                        aria-label="Username">
                                                </div>
                                            </div>
                                            <div class="col-md-4 d-flex">
                                                {!! $errors->first('sodor_end', '<p class="text-danger" >:message</p>') !!}
                                                <div class="mb-4 r">
                                                    <label for="khaharan" class="mt-1 mx-2">خواهران</label>
                                                    <input type="radio" class="form-check-input mt-2"
                                                        id="khaharan" value="2" name="mardzan"
                                                        aria-label="Username">
                                                </div>
                                            </div>
                                            <div id="done2" class="col-12">

                                            </div>


                                            <button type="button" class="btn btn-success btn-block"
                                                onclick="goto3()">
                                                تائید
                                            </button>
                                        </div>
                                </li>
                                {{--                            moases --}}
                                <li class="splide__slide panel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            {!! $errors->first('sodor_end', '<p class="text-danger" >:message</p>') !!}
                                            <div class="d-flex mb-4 form-label-group in-border">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon5">حقیقی</span>
                                                </div>
                                                <input type="radio" id="haghighi" onclick="haghighi2()" checked
                                                    class="form-check-input mx-2" name="haghighi" value="1"
                                                    aria-label="Username" style="height: 30px;width:25px;">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {!! $errors->first('sodor_end', '<p class="text-danger" >:message</p>') !!}
                                            <div class="d-flex mb-4 form-label-group in-border">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon5">حقوقی</span>
                                                </div>
                                                <input type="radio" id="hoghoghi" onclick="hoghoghi2()"
                                                    class="form-check-input mx-2" name="haghighi" value="2"
                                                    aria-label="Username" style="height: 30px;width:25px;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="haghighi-form">
                                        <div class="col-md-6">
                                            {!! $errors->first('modir_name', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">
                                                <input type="text" class="form-control" name="modir_name"
                                                    id="modir_name" aria-label="Username"
                                                    value="{{ old('modir_name') }}" placeholder="a">
                                                <label for="">نام</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {!! $errors->first('modir_family', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">

                                                <input type="text" class="form-control" name="modir_family"
                                                    id="modir_family" aria-label="Username" placeholder="a"
                                                    value="{{ old('modir_family') }}">
                                                <label for="">نام خانوادگی</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {!! $errors->first('modir_national', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">
                                                <input type="number" class="form-control" name="modir_national"
                                                    id="modir_national" aria-label="Username" placeholder="a"
                                                    value="{{ old('modir_national') }}">
                                                <label for="">شماره ملی</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {!! $errors->first('modir_shenasname', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">
                                                <input type="number" class="form-control" name="modir_shenasname"
                                                    id="modir_shenasname" aria-label="Username" placeholder="a"
                                                    value="{{ old('modir_shenasname') }}">
                                                <label for="">شماره شناسنامه</label>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            {!! $errors->first('modir_gender', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon5">جنسیت</span>
                                                </div>
                                                <select type="text" class="form-select" name="modir_gender"
                                                    id="modir_gender" aria-label="Username"
                                                    value="{{ old('modir_gender') }}">
                                                    <option value="">----</option>
                                                    <option value="1">مرد</option>
                                                    <option value="2">زن</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            {!! $errors->first('modir_father', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">

                                                <input type="text" class="form-control" name="modir_father"
                                                    id="modir_father" aria-label="Username" placeholder="a"
                                                    value="{{ old('modir_father') }}">
                                                <label for="">نام پدر</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            {!! $errors->first('modir_birthday', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">
                                                <input type="text" class=" usage form-control"
                                                    name="modir_birthday" id="modir_birthday" placeholder="a"
                                                    aria-label="Username" value="{{ old('modir_birthday') }}">
                                                <label for="">تاریخ تولد</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            {!! $errors->first('modir_sodor', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">

                                                <input type="text" class="form-control" name="modir_sodor"
                                                    id="modir_sodor" aria-label="Username" placeholder="a"
                                                    value="{{ old('modir_sodor') }}">
                                                <label for="">محل صدور شناسنامه</label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row" style="display: none" id="hoghoghi-form">
                                        <div class="col-md-6">
                                            {!! $errors->first('hoghoghi_name', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">

                                                <input type="text" class="form-control" name="hoghoghi_name"
                                                    id="hoghoghi_name" aria-label="Username" placeholder="a"
                                                    value="{{ old('hoghoghi_name') }}">
                                                <label for="">نام شرکت</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {!! $errors->first('hoghoghi_sabt', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">

                                                <input type="number" class="form-control" name="hoghoghi_sabt"
                                                    id="hoghoghi_sabt" aria-label="Username" placeholder="a"
                                                    value="{{ old('hoghoghi_sabt') }}">
                                                <label for="">شماره ثبت</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {!! $errors->first('hoghoghi_modir', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">

                                                <input type="text" class="form-control" name="hoghoghi_modir"
                                                    id="hoghoghi_modir" aria-label="Username" placeholder="a"
                                                    value="{{ old('hoghoghi_modir') }}">
                                                <label for="">مدیر عامل</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            {!! $errors->first('hoghoghi_tarikh', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">

                                                <input type="text" class=" usage form-control"
                                                    name="hoghoghi_tarikh" id="hoghoghi_tarikh" placeholder="a"
                                                    aria-label="Username" value="{{ old('hoghoghi_tarikh') }}">
                                                <label for="">تاریخ ثبت</label>
                                            </div>
                                        </div>


                                    </div>
                                    <div id="done3"></div>
                                    <button type="button" class="btn btn-success btn-block"
                                        onclick="goto4()">تائید</button>
                                </li>
                                {{--                            tamas --}}
                                <li class="splide__slide panel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            {!! $errors->first('state', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon5">استان *</span>
                                                </div>
                                                <select type="text" class="form-select" name="state"
                                                    aria-label="Username" value="{{ old('state') }}" id="ostan"
                                                    onchange="changeostan(this)">

                                                    <option value="">استان را انتخاب کنید</option>
                                                    @foreach ($states as $state)
                                                        <option value="{{ $state->id }}">
                                                            {{ $state->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {!! $errors->first('city', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon5">شهرستان *</span>
                                                </div>
                                                <select type="text" class="form-select" name="city"
                                                    id="city" aria-label="Username"
                                                    value="{{ old('city') }}">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            {!! $errors->first('address', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">

                                                <textarea type="text" class="form-control" name="address" id="address" aria-label="Username"
                                                    value="{{ old('address') }}"></textarea>
                                                <label for="">آدرس</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {!! $errors->first('postal', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">
                                                <input type="number" class="form-control" name="postal"
                                                    aria-label="Username" id="postal" placeholder="a"
                                                    value="{{ old('postal') }}">
                                                <label for="">کدپستی *</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            {!! $errors->first('tel', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">

                                                <input type="number" class="form-control" name="tel"
                                                    id="tel" aria-label="Username" placeholder="a"
                                                    value="{{ old('tel') }}">
                                                <label for="">تلفن *</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            {!! $errors->first('fax', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">

                                                <input type="text" required class="form-control" name="fax"
                                                    aria-label="Username" placeholder="a"
                                                    value="{{ old('fax') }}">
                                                <label for="">فکس</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            {!! $errors->first('mobile', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">
                                                <input type="tel" required class="form-control" name="mobile"
                                                    id="mobile" aria-label="Username" placeholder="a"
                                                    value="{{ old('mobile') }}">

                                                <label for="">موبایل *</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {!! $errors->first('site', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">
                                                <input type="url" class="form-control" name="site"
                                                    aria-label="Username" placeholder="a"
                                                    value="{{ old('site') }}">
                                                <label for="">سایت</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {!! $errors->first('email', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">
                                                <input type="email" class="form-control" name="email"
                                                    aria-label="Username" placeholder="a"
                                                    value="{{ old('email') }}">
                                                <label for="">ایمیل</label>
                                            </div>
                                        </div>
                                        @foreach ($socials as $social)
                                            <div class="col-md-6">
                                                {!! $errors->first('tel', '<p class="text-danger" >:message</p>') !!}
                                                <div class="input-group mb-4 form-label-group in-border">
                                                    <input type="text" class="form-control"
                                                        name="social{{ $social->id }}" aria-label="Username"
                                                        placeholder="a" value="">
                                                    <label for="">آدرس {{ $social->name }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div id="done4"></div>
                                    </div>
                                    <button type="button" class="btn btn-success btn-block" onclick="goto5()"> تائید
                                    </button>
                                </li>
                                {{--                            map --}}
                                <li class="splide__slide panel">
                                    <div style="position:relative;height: 70%">
                                        <div id="app" style="position:absolute;height: 100%;width: 80%"></div>
                                    </div>
                                    <div id="section2">
                                        <div id="form-saat">
                                            <h5>با کلیک روی نقشه محل خود را انتخاب کنید</h5>
                                            <div class="row" style="display: none">
                                                <input type="text" id="lat" name="lat" id="lat">
                                                <input type="text" id="lang" name="lang" id="lang">
                                            </div>
                                            <div class="row">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="done5"></div>
                                    <div>
                                        <button type="button" class=" mt-3 btn btn-success btn-block"
                                            onclick="goto6()">
                                            تائید
                                        </button>
                                    </div>
                                </li>
                                {{--                            herfe --}}
                                <li class="splide__slide panel">
                                    <div id="done7"></div>
                                    <div class="row">
                                        @foreach ($herfes as $herfe)
                                            <div class="col-md-3">
                                                <label for="{{ $herfe->id }}">
                                                    {{ $herfe->name }}
                                                </label>
                                                <input type="checkbox" name="herfe[{{ $herfe->id }}]"
                                                    id="{{ $herfe->id }}" value="{{ $herfe->id }}">
                                            </div>
                                        @endforeach

                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-success btn-block mt-3"
                                            onclick="goto7()">تائید
                                        </button>
                                    </div>

                                </li>
                                {{--                            file --}}
                                <li class="splide__slide panel">
                                    <div class="row" id="form3">
                                        <div class="col-12">
                                            {!! $errors->first('sodor_start', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon5">تصویر موسس</span>
                                                </div>
                                                <input type="file" class="form-control" name="file_moases"
                                                    aria-label="Username">

                                            </div>
                                        </div>
                                        <div class="col-12">
                                            {!! $errors->first('sodor_start', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon5">پروانه
                                                        تاسیس</span>
                                                </div>
                                                <input type="file" class="form-control" name="file_tasis"
                                                    aria-label="Username">

                                            </div>
                                        </div>
                                        <div class="col-12">
                                            {!! $errors->first('sodor_start', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon5">لوگو</span>
                                                </div>
                                                <input type="file" class="form-control" name="file_logo"
                                                    aria-label="Username">

                                            </div>
                                        </div>

                                    </div>


                                    <div>
                                        <button type="button" class="btn btn-success btn-block"
                                            onclick="goto8()">تائید
                                        </button>
                                    </div>

                                </li>
                                {{--                            mobile --}}
                                <li class="splide__slide panel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            {!! $errors->first('sodor_end', '<p class="text-danger" >:message</p>') !!}
                                            <div class="input-group mb-4 form-label-group in-border ">

                                                <input type="text" class=" form-control" name="password"
                                                    id="password" placeholder="a" aria-label="Username"
                                                    value="{{ old('password') }}">
                                                <label for="">رمز عبور</label>
                                            </div>
                                        </div>
                                        <div id="done8"></div>
                                    </div>
                                    <br>
                                    <p class="alert alert-info mb-4">
                                        لطفاً پس از تکمیل درخواست، به پنل کاربری خود وارد شوید و حتماً شماره موبایل خود
                                        را جهت بررسی و تأیید توسط مدیریت، تأیید کنید.
                                    </p>

                                    <button type="button" class="btn btn-success"
                                        onclick="gotodone()">تکمیل</button>
                                    </form>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mt-3 w-25 errors_alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- <script>
        // alert fade
        setTimeout(function() {
            bootstrap.Alert.getOrCreateInstance(document.querySelector(".alert")).close();
        }, 8000)
    </script> --}}
    @if ($errors->any())
        <script>
            document.getElementById('sl2').style.display = 'block';
            document.getElementById('sl3').style.display = 'block';
            document.getElementById('sl4').style.display = 'block';
            document.getElementById('sl5').style.display = 'block';
            document.getElementById('sl6').style.display = 'block';
            document.getElementById('sl7').style.display = 'block';
            document.getElementById('sl8').style.display = 'block';
        </script>
    @endif
    <script>
        function goto2() {
            // document.getElementById('sl2').style.display = 'block';
            document.getElementById('sl2').click();
        }

        function goto3() {
            $('input').css('border-color', '#aaa');
            $('.error-message').remove(); // حذف خطاهای قبلی

            let done2 = 1;

            function showError(inputId, message) {
                let inputElement = document.getElementById(inputId);
                inputElement.style.borderColor = "red";

                let errorElement = document.createElement("p");
                errorElement.className = "error-message text-danger";
                errorElement.innerHTML = message;

                // اضافه کردن خطا بالای input
                let parentDiv = inputElement.closest(".input-group");
                parentDiv.parentNode.insertBefore(errorElement, parentDiv);

                done2 = 0;
            }

            // فیلدهای خطادار
            if (!document.getElementById('name').value) {
                showError('name', 'نام را وارد کنید');
            }
            if (!document.getElementById('sodor').value) {
                showError('sodor', 'شماره صدور را وارد کنید');
            }
            if (!document.getElementById('number').value) {
                showError('number', 'شماره شناسایی را وارد کنید');
            }
            if (!document.getElementById('sodor_end').value) {
                showError('sodor_end', 'تاریخ پایان اعتبار را وارد کنید');
            }
            if (!document.getElementById('sodor_start').value) {
                showError('sodor_start', 'تاریخ صدور را وارد کنید');
            }

            // بررسی انتخاب جنسیت (برادران یا خواهران)
            if (!document.querySelector('input[name="mardzan"]:checked')) {
                let genderContainer = document.getElementById('gender-group'); // یک div والد برای اینپوت‌های radio
                let errorElement = document.createElement("p");
                errorElement.className = "error-message text-danger";
                errorElement.innerHTML = 'لطفاً جنسیت را انتخاب کنید';

                genderContainer.parentNode.insertBefore(errorElement, genderContainer);
                done2 = 0;
            }

            // اگر همه فیلدها درست بودن
            if (done2 == 1) {
                document.getElementById('sl3').click();
            }
        }

        function goto4() {
            $('input').css('border-color', '#aaa');
            $('.error-message').remove(); // حذف خطاهای قبلی

            let done3 = 1;

            function showError(inputId, message) {
                let inputElement = document.getElementById(inputId);
                inputElement.style.borderColor = "red";

                let errorElement = document.createElement("p");
                errorElement.className = "error-message text-danger";
                errorElement.innerHTML = message;

                // اضافه کردن خطا بالای input
                let parentDiv = inputElement.closest(".input-group");
                if (!parentDiv) parentDiv = inputElement.closest(".col-md-4"); // در صورت نبودن input-group
                parentDiv.parentNode.insertBefore(errorElement, parentDiv);

                done3 = 0;
            }

            if (document.getElementById('haghighi').checked) {
                // فرم اشخاص حقیقی
                if (!document.getElementById('modir_name').value) {
                    showError('modir_name', 'نام مدیر را وارد کنید');
                }
                if (!document.getElementById('modir_family').value) {
                    showError('modir_family', 'فامیل مدیر را وارد کنید');
                }
                if (!document.getElementById('modir_national').value) {
                    showError('modir_national', 'کد ملی مدیر را وارد کنید');
                }
                if (!document.getElementById('modir_shenasname').value) {
                    showError('modir_shenasname', 'شماره شناسایی مدیر را وارد کنید');
                }
                if (!document.getElementById('modir_gender').value) {
                    showError('modir_gender', 'جنسیت مدیر را انتخاب کنید');
                }
                if (!document.getElementById('modir_father').value) {
                    showError('modir_father', 'نام پدر مدیر را وارد کنید');
                }
                if (!document.getElementById('modir_birthday').value) {
                    showError('modir_birthday', 'تاریخ تولد مدیر را وارد کنید');
                }
                if (!document.getElementById('modir_sodor').value) {
                    showError('modir_sodor', 'محل صدور شناسنامه مدیر را وارد کنید');
                }
            } else {
                // فرم اشخاص حقوقی
                if (!document.getElementById('hoghoghi_name').value) {
                    showError('hoghoghi_name', 'نام شرکت را وارد کنید');
                }
                if (!document.getElementById('hoghoghi_sabt').value) {
                    showError('hoghoghi_sabt', 'شماره ثبت شرکت را وارد کنید');
                }
                if (!document.getElementById('hoghoghi_modir').value) {
                    showError('hoghoghi_modir', 'مدیر شرکت را وارد کنید');
                }
                if (!document.getElementById('hoghoghi_tarikh').value) {
                    showError('hoghoghi_tarikh', 'تاریخ ثبت شرکت را وارد کنید');
                }
            }

            if (done3 == 1) {
                document.getElementById('sl4').click();
            }
        }

        function goto5() {
            // حذف خطاهای قبلی و بازنشانی استایل فیلدها
            $('input, textarea, select').css('border-color', '#aaa');
            $('.error-message').remove();

            let done4 = 1;

            // تابع نمایش پیام خطا قبل از گروه ورودی
            function showError(element, message) {
                if (!element) return;

                element.style.borderColor = "red";

                let errorElement = document.createElement("p");
                errorElement.className = "error-message text-danger";
                errorElement.style.marginBottom = "5px"; // فاصله بین پیام خطا و فیلد
                errorElement.style.fontSize = "14px"; // تنظیم سایز فونت پیام خطا
                errorElement.innerHTML = message;

                // یافتن والد مناسب برای درج پیام خطا
                let parent = element.closest(".input-group") || element.closest(".form-label-group") || element.parentNode;

                // درج پیام خطا قبل از گروه ورودی
                parent.parentNode.insertBefore(errorElement, parent);

                done4 = 0;
            }

            // فیلدهای ضروری برای اعتبارسنجی
            let requiredFields = [{
                    selector: '#ostan',
                    message: 'استان را وارد کنید'
                },
                {
                    selector: '#city',
                    message: 'شهر را وارد کنید'
                },
                {
                    selector: '#address',
                    message: 'آدرس را وارد کنید'
                },
                {
                    selector: '#postal',
                    message: 'کد پستی را وارد کنید'
                },
                {
                    selector: '#tel',
                    message: 'تلفن را وارد کنید'
                },
                {
                    selector: '[name="fax"]',
                    message: 'فکس را وارد کنید'
                },
                {
                    selector: '#mobile',
                    message: 'موبایل را وارد کنید'
                },
                {
                    selector: '[name="site"]',
                    message: 'سایت را وارد کنید'
                },
                {
                    selector: '[name="email"]',
                    message: 'ایمیل را وارد کنید'
                }
            ];

            // بررسی فیلدهای ضروری
            requiredFields.forEach(field => {
                let element = document.querySelector(field.selector);
                if (element && (!element.value || !element.value.trim())) {
                    showError(element, field.message);
                }
            });

            // بررسی فیلدهای شبکه‌های اجتماعی
            let socialFields = document.querySelectorAll('input[name^="social"]');
            socialFields.forEach(field => {
                if (!field.value || !field.value.trim()) {
                    let labelElement = field.parentNode.querySelector('label');
                    let labelText = labelElement ? labelElement.innerText : 'این فیلد';
                    showError(field, labelText + ' را وارد کنید');
                }
            });

            // اگر همه فیلدها پر شده باشند، به اسلاید بعدی می‌رود
            if (done4 === 1) {
                document.getElementById('sl5').click();
            }
        }

        function goto6() {
            // بازنشانی استایل ورودی‌ها و پاکسازی پیام‌های خطا
            $('input').css('border-color', '#aaa');
            $('#done5').html('');

            let done5 = 1;
            let done5text = '';

            // دریافت المان‌های مربوط به lat و lang
            let latElement = document.getElementById('lat');
            let langElement = document.getElementById('lang');

            // بررسی مقدار هر دو فیلد
            if (!latElement.value || !langElement.value) {
                done5 = 0;
                done5text = 'محل را روی نقشه انتخاب کنید';

                if (!latElement.value) {
                    latElement.style.borderColor = "red";
                }
                if (!langElement.value) {
                    langElement.style.borderColor = "red";
                }
            }

            // در صورت صحیح بودن، به اسلاید بعدی می‌رود
            if (done5 === 1) {
                document.getElementById('sl6').click();
            } else {
                document.getElementById('done5').innerHTML = '<p style="color:red">' + done5text + '</p>';
            }
        }

        function goto7() {
            // بازنشانی استایل ورودی‌ها
            $('input').css('border-color', '#aaa');

            // پاکسازی پیام خطای قبلی از container مخصوص
            $('#done7').html('');

            let checkedCount = $('input[type="checkbox"]:checked').length;

            if (checkedCount === 0) {
                // اگر هیچ چک‌باکسی انتخاب نشده باشد، پیام خطا را در container نمایش می‌دهیم
                $('#done7').html('<p class="error-message text-danger">لطفاً حداقل یک حرفه را انتخاب کنید.</p>');
            } else {
                // اگر حداقل یک چک‌باکس انتخاب شده باشد، پیام خطا پاک می‌شود و به اسلاید بعدی می‌رویم
                $('#done7').html('');
                document.getElementById('sl7').click();
            }
        }

        function goto8() {
            // بازنشانی استایل‌های ورودی و حذف پیام‌های خطای قبلی
            $('input').css('border-color', '#aaa');
            $('.error-message').remove();

            let valid = true;

            // بررسی فیلد تصویر موسس
            if (!$('input[name="file_moases"]').val()) {
                valid = false;
                $('input[name="file_moases"]').css('border-color', 'red');
                // قرار دادن پیام خطا بالای گروه ورودی مربوطه
                $('input[name="file_moases"]').closest('.input-group')
                    .before('<p class="error-message text-danger">تصویر موسس را انتخاب کنید</p>');
            }

            // بررسی فیلد پروانه تاسیس
            if (!$('input[name="file_tasis"]').val()) {
                valid = false;
                $('input[name="file_tasis"]').css('border-color', 'red');
                $('input[name="file_tasis"]').closest('.input-group')
                    .before('<p class="error-message text-danger">پروانه تاسیس را انتخاب کنید</p>');
            }

            // بررسی فیلد لوگو
            if (!$('input[name="file_logo"]').val()) {
                valid = false;
                $('input[name="file_logo"]').css('border-color', 'red');
                $('input[name="file_logo"]').closest('.input-group')
                    .before('<p class="error-message text-danger">لوگو را انتخاب کنید</p>');
            }

            if (valid) {
                document.getElementById('sl8').click();
            }
        }

        function gotodone() {
            // بازنشانی استایل‌های ورودی
            $('input').css('border-color', '#aaa');
            $('.error-message').remove(); // حذف پیام‌های خطای قبلی

            let done8text = '';
            let valid = true;

            // بررسی فیلد رمز عبور
            if (!document.getElementById('password').value) {
                valid = false;
                document.getElementById('password').style.borderColor = "red";
                done8text = 'رمز را وارد کنید';

                // قرار دادن پیام خطا بالای فیلد رمز عبور
                $('#password').closest('.input-group')
                    .before('<p class="error-message text-danger">' + done8text + '</p>');
            }

            // در صورتی که تمام فیلدها معتبر باشند، فرم ارسال می‌شود
            if (valid) {
                document.getElementById('form-orig').submit();
            }
        }

        function haghighi2() {
            document.getElementById('haghighi-form').style.removeProperty('display');
            document.getElementById('hoghoghi-form').style.display = 'none';
        }

        function hoghoghi2() {
            document.getElementById('haghighi-form').style.display = 'none';
            document.getElementById('hoghoghi-form').style.removeProperty('display');
        }

        function change34() {

            if (document.getElementById('tabsare34').checked == true) {
                document.getElementById('baradaran').type = 'checkbox'
                document.getElementById('baradaran').name = 'baradaran'
                document.getElementById('khaharan').type = 'checkbox'
                document.getElementById('khaharan').name = 'khaharan'

            } else {
                document.getElementById('baradaran').type = 'radio'
                document.getElementById('baradaran').name = 'mardzan'
                document.getElementById('khaharan').type = 'radio'
                document.getElementById('khaharan').name = 'mardzan'
            }
        }

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
    <script>
        oldkar = 0
        newkar = 1

        function addkar() {
            newElem = document.getElementById('form-saat').innerHTML
            newElem = newElem.replaceAll('[0]', '[' + newkar + ']')


            newkar += 1
            oldkar += 1
            // document.getElementById('section2').innerHTML += nnn
            objTo = document.getElementById('section2')

            var divtest = document.createElement("div");

            divtest.innerHTML = newElem;

            objTo.appendChild(divtest)
        }
        oldfile = 0
        newfile = 1

        function addfile() {
            newElem = document.getElementById('form-aks').innerHTML
            newElem = newElem.replaceAll('[0]', '[' + newkar + ']')
            // nnn='<input name="ss">'
            newfile += 1
            oldfile += 1
            // document.getElementById('section2').innerHTML += nnn
            objTo = document.getElementById('form3')
            var divtest = document.createElement("div");
            divtest.innerHTML = newElem;

            objTo.appendChild(divtest)
        }
    </script>

    {{--    calc --}}
    <script type="text/javascript" src="https://cdn.map.ir/web-sdk/1.4.2/js/jquery-3.2.1.min.js"></script>

    {{-- <script src='{{asset("behzadidatepicker/js/jquery-1.10.1.min.js")}}'></script> --}}
    <script src='{{ asset('behzadidatepicker/js/persianDatepicker.js') }}'></script>
    <script>
        $(function() {
            //usage
            $(".usage").persianDatepicker();

            //themes
            $("#pdpDefault").persianDatepicker({
                alwaysShow: true,
            });
            $("#pdpLatoja").persianDatepicker({
                theme: "latoja",
                alwaysShow: true,
            });
            $("#pdpLightorang").persianDatepicker({
                theme: "lightorang",
                alwaysShow: true,
            });
            $("#pdpMelon").persianDatepicker({
                theme: "melon",
                alwaysShow: true,
            });
            $("#pdpDark").persianDatepicker({
                theme: "dark",
                alwaysShow: true,
            });

            //size
            $("#pdpSmall").persianDatepicker({
                cellWidth: 14,
                cellHeight: 12,
                fontSize: 8
            });
            $("#pdpBig").persianDatepicker({
                cellWidth: 78,
                cellHeight: 60,
                fontSize: 18
            });

            //formatting
            $("#pdpF1").persianDatepicker({
                formatDate: "YYYY/MM/DD 0h:0m:0s:ms"
            });
            $("#pdpF2").persianDatepicker({
                formatDate: "YYYY-0M-0D"
            });
            $("#pdpF3").persianDatepicker({
                formatDate: "YYYY-NM-DW|ND",
                isRTL: !0
            });

            //startDate & endDate
            $("#pdpStartEnd").persianDatepicker({
                startDate: "1394/11/12",
                endDate: "1395/5/5"
            });
            $("#pdpStartToday").persianDatepicker({
                startDate: "today",
                endDate: "1410/11/5"
            });
            $("#pdpEndToday").persianDatepicker({
                startDate: "1397/11/12",
                endDate: "today"
            });

            //selectedBefor & selectedDate
            $("#pdpSelectedDate").persianDatepicker({
                selectedDate: "1404/1/1",
                alwaysShow: !0
            });
            $("#pdpSelectedBefore").persianDatepicker({
                selectedBefore: !0
            });
            $("#pdpSelectedBoth").persianDatepicker({
                selectedBefore: !0,
                selectedDate: "1395/5/5"
            });

            //jdate & gdate attributes
            $("#pdp-data-jdate").persianDatepicker({
                onSelect: function() {
                    alert($("#pdp-data-jdate").attr("data-gdate"));
                }
            });
            $("#pdp-data-gdate").persianDatepicker({
                showGregorianDate: true,
                onSelect: function() {
                    alert($("#pdp-data-gdate").attr("data-jdate"));
                }
            });


            //Gregorian date
            $("#pdpGregorian").persianDatepicker({
                showGregorianDate: true
            });

            // jDateFuctions
            // var jdf = new jDateFunctions();
            // var pd = new persianDate();
            // $("#pdpjdf-1").persianDatepicker({
            //     onSelect: function () {
            //         $("#pdpjdf-1").val(jdf.getJulianDayFromPersian(pd.parse($("#pdpjdf-1").val())));
            //         $("#pdpjdf-2").val(jdf.getLastDayOfPersianMonth(pd.parse($("#pdpjdf-1").val())));
            //         $("#pdpjdf-3").val(jdf.getPCalendarDate($("#pdpjdf-1").val()));
            //     }
            // });


            // //convert jalali date to miladi
            // $("#year, #month, #day").on("change", function () {
            //     $("#month").val() > 6 ? $("#day-31").hide() : $("#day-31").show();;
            //     showConverted();
            // });

            // $("#year").keyup(showConverted);
            //
            // function showConverted() {
            //     try{
            //         var pd = new persianDate();
            //         pd.year = parseInt($("#year").val());
            //         pd.month = parseInt($("#month").val());
            //         pd.date = parseInt($("#day").val());
            //
            //         var jdf = new jDateFunctions();
            //         $("#converted").html("Gregorian :  " + jdf.getGDate(pd)._toString("YYYY/MM/DD") + "     [" + jdf.getGDate(pd) + "]<br />Julian:  " + jdf.getJulianDayFromPersian(pd));
            //
            //     } catch (e) {
            //         $("#converted").html("Enter the year correctly!");
            //     }
            // }


            //startDate is tomarrow
            var p = new persianDate();
            $("#pdpStartDateTomarrow").persianDatepicker({
                startDate: p.now().addDay(1).toString("YYYY/MM/DD"),
                endDate: p.now().addDay(4).toString("YYYY/MM/DD")
            });


        });
    </script>
    {{--    end clc --}}

    {{-- map --}}
    {{-- <script type="text/javascript" src="https://cdn.map.ir/web-sdk/1.4.2/js/jquery-3.2.1.min.js"></script> --}}
    <script type="text/javascript" src="https://cdn.map.ir/web-sdk/1.4.2/js/mapp.env.js"></script>
    <script type="text/javascript" src="https://cdn.map.ir/web-sdk/1.4.2/js/mapp.min.js"></script>
    <script>
        latt = langg = '0'
        $(document).ready(function() {
            var app = new Mapp({
                element: '#app',
                presets: {
                    latlng: {
                        lat: 31.87610,
                        lng: 54.36172
                    },
                    zoom: 12
                },
                apiKey: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImZjYjNlNjRlMTVlNmFiYjRlOTcwMzgzYTJlN2Q0ZDBmNGU0NjNhYjI0MTQxMWZlMjIxMjQ4NjE0MzNlOTRhZWU2ZGRjZmM3NGZkOGI3ZTViIn0.eyJhdWQiOiIyODI4NSIsImp0aSI6ImZjYjNlNjRlMTVlNmFiYjRlOTcwMzgzYTJlN2Q0ZDBmNGU0NjNhYjI0MTQxMWZlMjIxMjQ4NjE0MzNlOTRhZWU2ZGRjZmM3NGZkOGI3ZTViIiwiaWF0IjoxNzIyNTg2Nzk4LCJuYmYiOjE3MjI1ODY3OTgsImV4cCI6MTcyNTE3ODc5OCwic3ViIjoiIiwic2NvcGVzIjpbImJhc2ljIl19.R5bSY4hCK-TEjB56bWWzPWOgiu6kl3POvmzHFsH-ClaH72fkMzAYKrRo4xJwc8OUr7ca3G4SreRN305y0fp4hUIBXe0AcESw-eAq1Qbs08qoDpXRYtESDE4Xiw_avdXjiYY9vGDU6YX23psmVLVPvYz0CRPCzZ9nRKdX2bH_XDEhCHUH48v2jp_LBaHhy9YwXrCDVwK_4asbYdsLnirKYFAe_RWSBRT_irlFwViiMsipjY_WF-hk01wkKoYpbO2Tia6RV8LHKx3ModKXv3n6VGIlljSqdBTz3WSr4eNmk0On9_br5m6WU4A5Zf8iaEJRR8B_cuJ4Fn3OPurt2HZgKQ'
            });
            app.addLayers();
            app.map.on('click', function(e) {
                // آدرس یابی و نمایش نتیجه در یک باکس مشخص
                app.showReverseGeocode({
                    state: {
                        latlng: {
                            lat: e.latlng.lat,
                            lng: e.latlng.lng
                        },
                        zoom: 16,
                    }
                });
                app.addMarker({
                    name: 'advanced-marker',
                    latlng: {
                        lat: e.latlng.lat,
                        lng: e.latlng.lng,

                    },
                    icon: app.icons.red,
                    popup: false,
                });
                document.getElementById('lat').value = e.latlng.lat
                document.getElementById('lang').value = e.latlng.lng
            });
        });
        latt = ''
        langg = ''
    </script>
    <style>
        #app {
            position: absolute !important;
        }
    </style>
    <script>
        document.getElementById('app').style.position = 'absolute'
    </script>

    <script></script>
</body>

</html>
