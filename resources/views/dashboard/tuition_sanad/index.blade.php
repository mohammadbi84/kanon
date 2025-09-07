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
                    <li class="breadcrumb-item"><a href="#">پیکر بندی</a></li>
                    <li class="breadcrumb-item"><a href="/dashboard/tuition">نرخ شهریه</a></li>
                    <li class="breadcrumb-item active" aria-current="page">سند حرفه</li>
                </ol>
            </nav>
            <br>
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>مدیریت نرخ شهریه</h6>
                        <a href="{{ route('tuition_sanad.create') }}" class="btn btn-primary">افزودن نرخ جدید</a>
                        <br> <br>
                    </div>
                </div>
            </div>
            <div class="table-responsive mb-4 mt-4">
                <div id="statusMessage"></div>
                <form id="tuitionForm" method="POST">

                <table id="default-ordering" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>نام سند حرفه</th>
                            <th>کد استاندارد</th>
                            <th>مدت زمان</th>
                            <th>مبلغ حضوری</th>
                            <th>مبلغ مجازی</th>
                            <th>مبلغ الکترونیکی</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>

                            @foreach ($tuitionHerfes as $tuition)
                                <tr>
                                    <td>{{ $tuition->year }}</td>
                                    <td>{{ $tuition->sanad->title }}</td>
                                    <td>{{ $tuition->standard_code }}</td>
                                    <td>{{ $tuition->duration }}</td>
                                    <td>
                                        <input type="text" name="in_person_fee[{{ $tuition->id }}]"
                                            value="{{ number_format($tuition->in_person_fee) }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="online_fee[{{ $tuition->id }}]"
                                            value="{{ number_format($tuition->online_fee) }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="electronic_fee[{{ $tuition->id }}]"
                                            value="{{ number_format($tuition->electronic_fee) }}" class="form-control">
                                    </td>
                                    <td>
                                        <a href="{{ route('tuition_sanad.delete', $tuition->id) }}" type="submit" class="btn btn-danger" onclick="return confirm('آیا مطمئن هستید؟')">حذف</a>

                                        
                                    </td>
                                </tr>
                            @endforeach

                    </tbody>
                    @if (@count($tuitionHerfes)> 0)
                    <tfoot>
                        <button type="button"  onclick="return confirm('ایا از بروزرسانی قیمت مطمئن هستید؟')" id="updateButton" class="btn btn-success">بروزرسانی قیمت</button>
                    </tfoot>
                    @endif
                    
                </table>
            </form>

            </div>
        </div>
    </div>

    {{-- calc--}}
    <script src='{{asset("behzadidatepicker/js/jquery-1.10.1.min.js")}}'></script>
    <script src='{{asset("behzadidatepicker/js/persianDatepicker.js")}}'></script>
    <script>
        $(document).ready(function () {
            $('#updateButton').click(function () {
                // گرفتن داده‌های فرم
                var formData = $('#tuitionForm').serialize();

                $.ajax({
                    url: "{{ route('tuition_sanad.updateAll') }}",
                    type: "POST",
                    data: formData,
                    success: function (response) {
                        // نمایش پیام موفقیت یا خطا
                        $('#statusMessage').html('<div class="alert alert-success">' + response.message + '</div>');
                    },
                    error: function (xhr) {
                        // نمایش پیام خطا
                        $('#statusMessage').html('<div class="alert alert-danger">مشکلی پیش آمده است، لطفا دوباره تلاش کنید.</div>');
                    }
                });
            });
        });

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