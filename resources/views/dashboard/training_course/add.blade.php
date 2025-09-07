@extends('dashboard.layout.master')
@section('head')

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
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>افزودن استاندارد آموزشی جدید</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-2">
                <form action="{{route('course.addpost')}}" method="post" enctype="multipart/form-data">
                    @CSRF
                    {!! $errors->first('name', '<p class="text-danger" >:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">عنوان</span>
                        </div>
                        <input type="text" class="form-control" name="name" aria-label="Username" value="{{ old('name') }}">
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">استاد</span>
                        </div>
                        <input type="text" class="form-control" name="teacher" aria-label="Username" value="{{ old('teacher') }}">
                    </div>

                    {!! $errors->first('description', '<p class="text-danger" >:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">توضیحات</span>
                        </div>
                        <textarea name="description" id="" cols="30" rows="10"
                            class="form-control">{{ old('description') }}</textarea>
                    </div>

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">تاریخ</span>
                        </div>
                        <input type="text" name="date" class="form-control persian-date" id="date" value="{{ old('date') }}">
                    </div>
                    {!! $errors->first('date', '<p class="text-danger">:message</p>') !!}
                    <div id="date_error" class="error-message"></div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">عکس</span>
                        </div>
                        <input type="file" class="form-control" name="image">
                    </div>
                    {!! $errors->first('image', '<p class="text-danger">:message</p>') !!}


                    <button type="submit" class="btn btn-success ">ذخیره</button>

                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            var datepicker;

            // تنظیمات تقویم
            datepicker = $("#date").pDatepicker({
                format: 'YYYY/MM/DD HH:mm:ss',  // فرمت دلخواه
                timePicker: {
                    enabled: true,  // فعال کردن انتخاب زمان
                    second: true   // نمایش ثانیه
                },
                initialValue: false, // بدون مقدار اولیه
                onSelect: function (unix) {
                    $("#date_error").text(""); // پاک کردن پیغام خطا
                }
            });

            // بستن تقویم با کلیک بیرون از اون
            $(document).on("click", function (event) {
                // اگر روی خود فیلد تاریخ یا داخل تقویم کلیک نشده باشه
                if (!$(event.target).is("#date") && !$(event.target).closest(".datepicker-plot-area").length) {
                    datepicker.hide(); // تقویم رو مخفی می‌کنیم
                }
            });

            // پاک کردن پیغام خطا با فوکوس روی فیلد
            $("#date").on("focus", function () {
                $("#date_error").text(""); // پیغام خطا رو پاک می‌کنیم
            });
        });
    </script>
@endsection