@extends('dashboard.layout.master')
@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/dt-global_style.css')}}">
    <!-- END PAGE LEVEL STYLES -->

    <link type="text/css" href="{{asset('date/css/persian-datepicker.css')}}" rel="stylesheet" />

    {{--
    <script type="text/javascript" src="{{asset('date/js/jquery.min.js')}}"></script>--}}

    <script type="text/javascript" src="{{asset('date/js/persian-datepicker.js')}}"></script>

    <script type="text/javascript">
        $(function () {
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
            $("#format4").change(function () {
                $('#datepicker4').datepicker('option', { dateFormat: $(this).val() });
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
                beforeShowDay: function (date) {
                    if (date.getDay() == 5)
                        return [false, '', 'تعطیلات آخر هفته'];
                    return [true];
                }
            });
            //-----------------------------------
            // تاریخ پیشفرض
            $('#datepicker10').datepicker({
                defaultDate: new JalaliDate(1361, 4, 10)	//this means "./1361/05/10.html"
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
                onSelect: function (dateText, inst) {
                    $('#datepicker12to').datepicker('option', 'minDate', new JalaliDate(inst['selectedYear'], inst['selectedMonth'], inst['selectedDay']));
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
    {{--new calendar--}}
    <link href='{{asset("behzadidatepicker/css/normalize.css")}}' rel='stylesheet' />
    <link href='{{asset("behzadidatepicker/css/fontawesome/css/font-awesome.min.css")}}' rel='stylesheet' />
    {{--
    <link href='{{asset("behzadidatepicker/css/vertical-responsive-menu.min.css")}}' rel="stylesheet" />--}}
    <link href='{{asset("behzadidatepicker/css/style.css")}}' rel="stylesheet" />
    <link href='{{asset("behzadidatepicker/css/prism.css")}}' rel="stylesheet" />
    <link rel="stylesheet" href='{{asset("behzadidatepicker/css/persianDatepicker-default.css")}}' />
    <script src='{{asset("behzadidatepicker/js/prism.js")}}'></script>
    <script src='{{asset("behzadidatepicker/js/vertical-responsive-menu.min.js")}}'></script>
    {{--end calendar--}}
@endsection
@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/dashboard/home">خانه</a></li>
                  <li class="breadcrumb-item"><a href="#">مدریت استاندارد ها</a></li>
                  <li class="breadcrumb-item active" aria-current="page">سند ها</li>
                </ol>
              </nav>

            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6> افزودن سند حرفه جدید </h6>
                    </div>
                </div>
            </div>
            <div class="col-md-12 ">
                <form action="{{route('sanad.addpost')}}" method="post" enctype="multipart/form-data">
                    @CSRF
                    <div class="row">
                        <div class="col-md-4">
                            {!! $errors->first('reshte', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">رشته <span class="text-danger">*</span></span>
                                </div>
                                <select name="reshte" class="js-example-basic-single form-control" style="flex-grow: 1;" id="">
                                    @foreach($reshtes as $reshte)
                                        <option value="{{$reshte->id}}">{{$reshte->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            {!! $errors->first('major_title', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">عنوان سر گروه <span class="text-danger">*</span></span>
                                </div>
                                <input type="text" class="form-control" name="major_title" aria-label="Username">

                            </div>
                        </div>
                        <div class="col-md-4">
                            {!! $errors->first('title', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">عنوان <span class="text-danger">*</span></span>
                                </div>
                                <input type="text" class="form-control" name="title" aria-label="Username">

                            </div>
                        </div>
                        <div class="col-md-4">
                            {!! $errors->first('code', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">کد استاندارد <span class="text-danger">*</span></span>
                                </div>
                                <input type="text" class="form-control" name="code" id="code">
                            </div>
                        </div>




                            <div class="col-md-4">
                                {!! $errors->first('date', '<p class="text-danger" >:message</p>') !!}
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon5">مدت زمانی</span>
                                    </div>
                                    <input class="form-control" onchange="timecalc()" onkeyup="timecalc()" name="date"
                                        id="teory_min" type="number" max="59" min="0" step="1" /><span
                                        style="font-size: 20px">:</span><input name="teory_hour" id="teory_hour"
                                        class="form-control" type="number" min="0" step="1" onchange="timecalc()"
                                        onkeyup="timecalc()" />

                                </div>
                            </div>
                            <script>
                                document.addEventListener("DOMContentLoaded", function () {
                                    function timecalc() {
                                        let totalMinutes = 0;

                                        let fields = ["teory", "amali", "karvarzi", "project"];

                                        fields.forEach(field => {
                                            let min = parseInt(document.getElementById(field + "_min").value) || 0;
                                            let hour = parseInt(document.getElementById(field + "_hour").value) || 0;

                                            totalMinutes += (hour * 60) + min; // تبدیل ساعت‌ها به دقیقه و جمع زدن
                                        });

                                        let finalHours = Math.floor(totalMinutes / 60); // ساعت نهایی
                                        let finalMinutes = totalMinutes % 60; // دقیقه باقی‌مانده

                                        document.getElementById("sum_hour").value = finalHours;
                                        document.getElementById("sum_min").value = finalMinutes;
                                    }

                                    // اجرای تابع در لحظه تغییر مقدار فیلدها
                                    document.querySelectorAll('input[type="number"]').forEach(input => {
                                        input.addEventListener("input", timecalc);
                                    });
                                });
                            </script>

                            <div class="col-md-4">
                                {!! $errors->first('job', '<p class="text-danger" >:message</p>') !!}
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon5">نوع</span>
                                    </div>
                                    <select name="job" class="form-control" id="">
                                        @foreach($jobs as $job)
                                            <option value="{{$job->id}}">{{$job->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                {!! $errors->first('update', '<p class="text-danger" >:message</p>') !!}
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon5">تاریخ تدوین</span>
                                    </div>
                                    <input type="text" name="update" class="usage form-control" aria-label="Username">
                                </div>
                            </div>
                            <div class="col-md-4">
                                {!! $errors->first('arshiv', '<p class="text-danger" >:message</p>') !!}
                                <div class="input-group mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="arshiv" id="arshiv" value="0">
                                        <label class="form-check-label" for="arshiv">
                                            آرشیو
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="arshiv" id="arshiv1" value="1"
                                            checked>
                                        <label class="form-check-label" for="arshiv1">
                                            عدم آرشیو
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                {!! $errors->first('file', '<p class="text-danger" >:message</p>') !!}
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">لینک دانلود استاندارد</span>
                                    </div>
                                    <input type="file" name="file" class="form-control">

                                </div>

                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-block ">ذخیره</button>
                                <br>
                            </div>

                        </div>




                </form>
            </div>

            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>لیست نوع ها</h6>
                    </div>
                </div>
            </div>
            <div class="table-responsive mb-4 mt-4">
                <table id="default-ordering" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>شناسه</th>
                            <th>عنوان</th>

                            <th class="text-center">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $key => $item)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$item->title}}</td>

                                <td class="text-center">
                                    <div>
                                        <a href="{{route('sanad.edit', ['id' => $item->id])}}" class="btn btn-primary">مشاهده و
                                            ویرایش</a>
                                        <a href="{{route('sanad.delete', ['id' => $item->id])}}" class="btn btn-danger">حذف</a>
                                    </div>

                                </td>
                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </div>

    {{-- calc--}}
    <script src='{{asset("behzadidatepicker/js/jquery-1.10.1.min.js")}}'></script>
    <script src='{{asset("behzadidatepicker/js/persianDatepicker.js")}}'></script>
    <script>
        $(function () {
            //usage
            $(".usage").persianDatepicker();

            //themes
            $("#pdpDefault").persianDatepicker({ alwaysShow: true, });
            $("#pdpLatoja").persianDatepicker({ theme: "latoja", alwaysShow: true, });
            $("#pdpLightorang").persianDatepicker({ theme: "lightorang", alwaysShow: true, });
            $("#pdpMelon").persianDatepicker({ theme: "melon", alwaysShow: true, });
            $("#pdpDark").persianDatepicker({ theme: "dark", alwaysShow: true, });

            //size
            $("#pdpSmall").persianDatepicker({ cellWidth: 14, cellHeight: 12, fontSize: 8 });
            $("#pdpBig").persianDatepicker({ cellWidth: 78, cellHeight: 60, fontSize: 18 });

            //formatting
            $("#pdpF1").persianDatepicker({ formatDate: "YYYY/MM/DD 0h:0m:0s:ms" });
            $("#pdpF2").persianDatepicker({ formatDate: "YYYY-0M-0D" });
            $("#pdpF3").persianDatepicker({ formatDate: "YYYY-NM-DW|ND", isRTL: !0 });

            //startDate & endDate
            $("#pdpStartEnd").persianDatepicker({ startDate: "1394/11/12", endDate: "1395/5/5" });
            $("#pdpStartToday").persianDatepicker({ startDate: "today", endDate: "1410/11/5" });
            $("#pdpEndToday").persianDatepicker({ startDate: "1397/11/12", endDate: "today" });

            //selectedBefor & selectedDate
            $("#pdpSelectedDate").persianDatepicker({ selectedDate: "1404/1/1", alwaysShow: !0 });
            $("#pdpSelectedBefore").persianDatepicker({ selectedBefore: !0 });
            $("#pdpSelectedBoth").persianDatepicker({ selectedBefore: !0, selectedDate: "1395/5/5" });

            //jdate & gdate attributes
            $("#pdp-data-jdate").persianDatepicker({
                onSelect: function () {
                    alert($("#pdp-data-jdate").attr("data-gdate"));
                }
            });
            $("#pdp-data-gdate").persianDatepicker({
                showGregorianDate: true,
                onSelect: function () {
                    alert($("#pdp-data-gdate").attr("data-jdate"));
                }
            });


            //Gregorian date
            $("#pdpGregorian").persianDatepicker({ showGregorianDate: true });

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
            $("#pdpStartDateTomarrow").persianDatepicker({ startDate: p.now().addDay(1).toString("YYYY/MM/DD"), endDate: p.now().addDay(4).toString("YYYY/MM/DD") });


        });
    </script>
    {{-- end clc--}}
@endsection
