@extends('dashboard.layout.master')

@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/dashboard/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/dashboard/plugins/table/datatable/dt-global_style.css') }}">
    <!-- END PAGE LEVEL STYLES -->

    <!-- Persian Datepicker CSS -->
    <link rel="stylesheet" href="https://unpkg.com/persian-datepicker@latest/dist/css/persian-datepicker.min.css" />

    <!-- Animate.css برای افکت‌های انیمیشنی -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- jQuery (در صورتی که قبلاً لود نشده باشد) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Persian Date and Persian Datepicker JS -->
    <script src="https://unpkg.com/persian-date@latest/dist/persian-date.min.js"></script>
    <script src="https://unpkg.com/persian-datepicker@latest/dist/js/persian-datepicker.min.js"></script>

    <style>
        /* استایل‌های سفارشی برای Persian Datepicker */
        .datepicker-container {
            font-family: 'Vazir', sans-serif;
        }

        .datepicker-plot-area {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            padding: 10px;
            width: 280px;
        }

        .datepicker-header {
            padding: 5px 0;
            text-align: center;
        }

        .datepicker-title {
            font-weight: bold;
        }

        .datepicker-week-days {
            display: flex;
            justify-content: space-around;
            margin-bottom: 5px;
        }

        .datepicker-week-day {
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            font-size: 0.9em;
            color: #555;
        }

        .datepicker-days {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        .datepicker-day {
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            border-radius: 4px;
            cursor: pointer;
            margin: 2px;
        }

        .datepicker-day:hover {
            background-color: #eee;
        }

        .datepicker-day-selected {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        .datepicker-day-today {
            border: 1px solid #007bff;
        }

        .datepicker-day-disabled {
            color: #ccc;
            cursor: not-allowed;
        }

        .datepicker-time-view {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 0;
            border-top: 1px solid #eee;
        }

        .datepicker-time-container {
            display: flex;
            align-items: center;
        }

        .datepicker-time-label,
        .datepicker-time-separator {
            margin: 0 5px;
        }

        .datepicker-time-input {
            width: 40px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 5px;
            font-size: 0.9em;
        }

        .datepicker-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 0.9em;
        }

        .datepicker-button:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            margin-top: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>افزودن اطلاعیه جدید</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-2">
                <form action="{{ route('topadv.addpost') }}" method="post" enctype="multipart/form-data" id="animationForm">
                    @csrf

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">عنوان</span>
                        </div>
                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
                    </div>
                    {!! $errors->first('title', '<p class="text-danger">:message</p>') !!}

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">خلاصه متن</span>
                        </div>
                        <textarea name="text" cols="30" rows="10" class="form-control">{{ old('text') }}</textarea>
                    </div>
                    {!! $errors->first('text', '<p class="text-danger">:message</p>') !!}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">رنگ متن</span>
                                </div>
                                <input type="color" class="form-control" name="text_color"
                                    value="{{ old('text_color') ?: '#000000' }}">
                            </div>
                            {!! $errors->first('text_color', '<p class="text-danger">:message</p>') !!}
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">رنگ پس‌ زمینه</span>
                                </div>
                                <input type="color" class="form-control" name="background_color"
                                    value="{{ old('background_color') ?: '#eba607' }}">

                            </div>
                            {!! $errors->first('background_color', '<p class="text-danger">:message</p>') !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="animation_type">نوع انیمیشن:</label>
                        <select class="form-control" id="animation_type" name="animation_type"
                            value="{{ old('animation_type') }}">
                            <option value="fadeInUpBig">Fade In Up Big</option>
                            <option value="fadeInDownBig">Fade In Down Big</option>
                            <option value="fadeInLeftBig">Fade In Left Big</option>
                            <option value="fadeInRightBig">Fade In Right Big</option>
                            <option value="zoomInUp">Zoom In Up</option>
                            <option value="zoomInDown">Zoom In Down</option>
                            <option value="zoomInLeft">Zoom In Left</option>
                            <option value="zoomInRight">Zoom In Right</option>
                            <option value="bounceInDown">Bounce In Down</option>
                            <option value="bounceInUp">Bounce In Up</option>
                            <option value="bounceInLeft">Bounce In Left</option>
                            <option value="bounceInRight">Bounce In Right</option>
                            <option value="rotateInDownLeft">Rotate In Down Left</option>
                            <option value="rotateInDownRight">Rotate In Down Right</option>
                            <option value="rotateInUpLeft">Rotate In Up Left</option>
                            <option value="rotateInUpRight">Rotate In Up Right</option>
                            <option value="flipInX">Flip In X</option>
                            <option value="flipInY">Flip In Y</option>
                            <option value="lightSpeedIn">Light Speed In</option>
                            <option value="rollIn">Roll In</option>
                            <option value="jackInTheBox">Jack In The Box</option>
                            <option value="hinge">Hinge</option>
                            <option value="heartBeat">Heart Beat</option>
                            <option value="pulse">Pulse</option>
                            <option value="tada">Tada</option>
                            <option value="swing">Swing</option>
                            <option value="rubberBand">Rubber Band</option>
                            <option value="jello">Jello</option>
                            <option value="bounce">Bounce</option>
                            <option value="flash">Flash</option>
                            <option value="shake">Shake</option>
                        </select>
                    </div>

                    <div id="previewText" class="mt-4">
                        <p id="animatedText" class="animate__animated">این متن پیش‌نمایش است.</p>
                    </div>
                    <br><br>

                    {{-- <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">عکس پس زمینه</span>
                        </div>
                        <input type="file" class="form-control" name="background_image">
                    </div> --}}
                    <div class="input-group mb-2">
                        <span class="input-group-btn">
                            <a id="image" data-input="imageInput" data-preview="imageHolder" class="btn btn-primary h-100 pt-2">
                                <i class="fa fa-picture-o"></i> عکس اسلایدر
                            </a>
                        </span>
                        <input id="imageInput" class="form-control" type="text" name="background_image">
                    </div>
                    <div id="imageHolder" class="mb-4" style="margin-top:15px;max-height:100px;"></div>
                    {!! $errors->first('background_image', '<p class="text-danger">:message</p>') !!}

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">لینک صفحه</span>
                        </div>
                        <input type="text" class="form-control" name="page_link" value="{{ old('page_link') }}">
                    </div>
                    {!! $errors->first('page_link', '<p class="text-danger">:message</p>') !!}

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">نوع باز شدن صفحه</span>
                        </div>
                        <select class="form-control" id="page_link_type" name="page_link_type"
                            value="{{ old('page_link_type') }}">
                            <option value="">--</option>
                            <option value="_blank">تب جدید</option>
                            <option value="_parent">قاب والد</option>
                            <option value="_self">همان قاب</option>
                            <option value="_top">بالاترین سطح</option>
                        </select>
                    </div>
                    {!! $errors->first('page_link_type', '<p class="text-danger">:message</p>') !!}

                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">تاریخ شروع</span>
                                </div>
                                <input type="text" name="start_date" class="form-control persian-date" id="start_date">
                            </div>
                            {!! $errors->first('start_date', '<p class="text-danger">:message</p>') !!}
                            <div id="start_date_error" class="error-message"></div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">تاریخ پایان</span>
                                </div>
                                <input type="text" name="end_date" class="form-control persian-date" id="end_date">
                            </div>
                            {!! $errors->first('end_date', '<p class="text-danger">:message</p>') !!}
                            <div id="end_date_error" class="error-message"></div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">مدت زمان نمایش</span>
                                </div>
                                <input type="text" name="duration" class="form-control" id="duration">
                            </div>
                            {!! $errors->first('duration', '<p class="text-danger">:message</p>') !!}
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">ذخیره</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            var startDatepicker, endDatepicker;

            // تنظیمات تقویم برای تاریخ شروع
            startDatepicker = $("#start_date").pDatepicker({
                format: 'YYYY/MM/DD HH:mm:ss',  // فرمت دلخواه
                timePicker: {
                    enabled: true,  // فعال کردن انتخاب زمان
                    second: true   // نمایش ثانیه
                },
                initialValue: false, // بدون مقدار اولیه
                onSelect: function (unix) {
                    // وقتی تاریخی در تقویم شروع انتخاب شد
                    var selectedDate = new persianDate(unix); // تبدیل به آبجکت persianDate

                    // تنظیم حداقل تاریخ برای تقویم پایان (تاریخ انتخاب شده در تقویم شروع)
                    endDatepicker.options.minDate = selectedDate.valueOf();

                    $("#start_date_error").text(""); // پاک کردن پیغام خطای قبلی (اگر وجود داشت)

                    // اگر قبلاً تاریخی در تقویم پایان انتخاب شده، بررسی می‌کنیم که معتبر باشه
                    if (endDatepicker.options.model) {
                        var endDate = new persianDate(endDatepicker.options.model).startOf('day'); // تاریخ پایان رو به ابتدای روز می‌بریم
                        var startDate = selectedDate.startOf('day'); // تاریخ شروع انتخاب شده رو هم به ابتدای روز می‌بریم

                        // اگر تاریخ پایان قبل از تاریخ شروع بود
                        if (endDate.valueOf() < startDate.valueOf()) {
                            endDatepicker.options.model = null; // مقدار تقویم پایان رو پاک می‌کنیم
                            $("#end_date_error").text("تاریخ پایان نمی‌تواند قبل از تاریخ شروع باشد."); // پیغام خطا
                        }
                    }
                }
            });

            // تنظیمات تقویم برای تاریخ پایان
            endDatepicker = $("#end_date").pDatepicker({
                format: 'YYYY/MM/DD HH:mm:ss',
                timePicker: {
                    enabled: true,
                    second: true
                },
                initialValue: false, // بدون مقدار اولیه
                onSelect: function (unix) {
                    var selectedDate = new persianDate(unix);

                    // تنظیم حداکثر تاریخ برای تقویم شروع (تاریخ انتخاب شده در تقویم پایان)
                    startDatepicker.options.maxDate = selectedDate.valueOf();

                    $("#end_date_error").text(""); // پاک کردن پیغام خطای قبلی

                    // اگر قبلاً تاریخی در تقویم شروع انتخاب شده، بررسی می‌کنیم که معتبر باشه
                    if (startDatepicker.options.model) {
                        var startDate = new persianDate(startDatepicker.options.model).startOf('day');
                        var endDate = selectedDate.startOf('day');

                        if (startDate.valueOf() > endDate.valueOf()) {
                            startDatepicker.options.model = null; // مقدار تقویم شروع رو پاک می‌کنیم
                            $("#start_date_error").text("تاریخ شروع نمی‌تواند بعد از تاریخ پایان باشد."); // پیغام خطا
                        }
                    }
                }
            });

            // بستن تقویم‌ها با کلیک بیرون از اون‌ها
            $(document).on("click", function (event) {
                // اگر روی خود فیلدهای تاریخ یا داخل تقویم کلیک نشده باشه
                if (!$(event.target).is("#start_date, #end_date") && !$(event.target).closest(".datepicker-plot-area").length) {
                    startDatepicker.hide(); // تقویم شروع رو مخفی می‌کنیم
                    endDatepicker.hide();   // تقویم پایان رو مخفی می‌کنیم
                }
            });

            // پاک کردن پیغام‌های خطا با فوکوس روی فیلدها
            $("#start_date").on("focus", function () {
                $("#start_date_error").text(""); // پیغام خطای مربوط به فیلد شروع رو پاک می‌کنیم
            });
            $("#end_date").on("focus", function () {
                $("#end_date_error").text(""); // پیغام خطای مربوط به فیلد پایان رو پاک می‌کنیم
            });

            // انیمیشن (اگر هنوز می‌خواهید استفاده کنید)
            $("#animation_type").change(function () {
                let animationClass = $(this).val();
                $("#animatedText").removeClass().addClass('animate__animated animate__' + animationClass);
                updatePreviewText();
            });

            // بروزرسانی متن پیش‌نمایش
            function updatePreviewText() {
                let userText = $("#title").val();
                $("#animatedText").text(userText ? userText : "این متن پیش‌نمایش است.");
            }

            // بروزرسانی پیش‌نمایش هنگام وارد کردن متن
            $("#title").on('input', updatePreviewText);
        });
    </script>
@endsection
@section('script')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        // در کد JS خود این را اضافه کنید:
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#image').filemanager('file');
    </script>
@endsection
