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
                    <li class="breadcrumb-item"><a href="/dashboard/standard/list">رسته {{$raste->name}}</a></li>
                    <li class="breadcrumb-item"><a href="/dashboard/khoshe/list">خوشه {{$khoshe->name}}</a></li>
                    <li class="breadcrumb-item"><a href="/dashboard/group/list/{{$khoshe->id}}">گروه {{$reshte->name}}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">حرفه ها</li>
                </ol>
            </nav>
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6> افزودن حرفه جدید به {{$reshte->name}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-12 ">
                <form action="{{route('herfe.addpost', ['id' => $reshte->id])}}" method="post"
                    enctype="multipart/form-data">
                    @CSRF
                    <div class="row">
                        <div class="col-md-4">
                            {!! $errors->first('name', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">نام استاندارد(حرفه)</span>
                                </div>
                                <input type="text" class="form-control" name="name" aria-label="Username">

                            </div>
                        </div>
                        <div class="col-md-4">
                            {!! $errors->first('old_code', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">کد استاندارد قدیم</span>
                                </div>
                                <input type="text" class="form-control" name="old_code" id="old_code">
                            </div>
                        </div>
                        <div class="col-md-4">
                            {!! $errors->first('old_code', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">کد استاندارد جدید</span>
                                </div>
                                <input type="text" class="form-control" name="code" id="old">
                            </div>
                        </div>

                        <script>
                            document.getElementById('old').addEventListener('keypress', function (event) {
                                const charCode = event.which || event.keyCode;
                                // فقط اجازه ورود اعداد (کد ASCII بین 48 و 57)
                                if (charCode < 48 || charCode > 57) {
                                    event.preventDefault();
                                }
                            });
                        </script>
                        <div class="col-md-4">
                            {!! $errors->first('teory_min', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">زمان نظری</span>
                                </div>
                                <input class="form-control" onchange="timecalc()" onkeyup="timecalc()" name="teory_min"
                                    placeholder="دقیقه" id="teory_min" type="number" max="59" min="0" step="1" /><span
                                    style="font-size: 20px">:</span><input name="teory_hour" id="teory_hour"
                                    placeholder="ساعت" class="form-control" type="number" min="0" step="1"
                                    onchange="timecalc()" onkeyup="timecalc()" />

                            </div>
                        </div>
                        <div class="col-md-4">
                            {!! $errors->first('amali_min', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">زمان عملی</span>
                                </div>
                                <input class="form-control" onchange="timecalc()" onkeyup="timecalc()" name="amali_min"
                                    placeholder="دقیقه" id="amali_min" type="number" max="59" min="0" step="1" /><span
                                    style="font-size: 20px">:</span><input name="amali_hour" id="amali_hour"
                                    placeholder="ساعت" class="form-control" type="number" min="0" step="1"
                                    onchange="timecalc()" onkeyup="timecalc()" />

                            </div>
                        </div>
                        <div class="col-md-4">
                            {!! $errors->first('karvarzi_min', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">زمان کارورزی</span>
                                </div>
                                <input class="form-control" onchange="timecalc()" onkeyup="timecalc()" name="karvarzi_min"
                                    placeholder="دقیقه" id="karvarzi_min" type="number" max="59" min="0" step="1" /><span
                                    style="font-size: 20px">:</span><input name="karvarzi_hour" id="karvarzi_hour"
                                    placeholder="ساعت" class="form-control" type="number" min="0" step="1"
                                    onchange="timecalc()" onkeyup="timecalc()" />

                            </div>
                        </div>
                        <div class="col-md-4">
                            {!! $errors->first('project_min', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">زمان پروژه</span>
                                </div>
                                <input onchange="timecalc()" onkeyup="timecalc()" class="form-control" name="project_min"
                                    placeholder="دقیقه" id="project_min" type="number" max="59" min="0" step="1" /><span
                                    style="font-size: 20px">:</span><input name="project_hour" id="project_hour"
                                    placeholder="ساعت" class="form-control" type="number" min="0" step="1"
                                    onchange="timecalc()" onkeyup="timecalc()" />

                            </div>
                        </div>
                        <div class="col-md-4">
                            {!! $errors->first('sum_min', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">جمع زمان</span>
                                </div>
                                <input class="form-control" id="sum_min" name="sum_min" type="number" min="0" step="1"
                                    placeholder="دقیقه" readonly />
                                <span style="font-size: 20px">:</span>
                                <input name="sum_hour" id="sum_hour" class="form-control" type="number" min="0" step="1"
                                    placeholder="ساعت" readonly />
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
                                <select name="job" class="js-example-basic-single form-control" style="flex-grow: 1;" id="">
                                    @foreach($jobs as $job)
                                        <option value="{{$job->id}}">{{$job->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            {!! $errors->first('kardanesh', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">نوع کاردانش</span>
                                </div>
                                <select name="kardanesh" class="js-example-basic-single form-control" style="flex-grow: 1;"
                                    id="">
                                    @foreach($kardaneshs as $kardanesh)
                                        <option value="{{$kardanesh->id}}">{{$kardanesh->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            {!! $errors->first('madrak', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">حداقل تحصیلات ورودی</span>
                                </div>
                                <select name="madrak" class="js-example-basic-single form-control" style="flex-grow: 1;"
                                    id="">
                                    <option value="1">دیپلم</option>
                                    <option value="2">فوق دیپلم</option>
                                    <option value="2">لیسانی</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            {!! $errors->first('salahiat', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">صلاحیت حرفه ای مربیان</span>
                                </div>
                                <input type="text" class="form-control" name="salahiat" aria-label="Username">

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
                            {!! $errors->first('pish', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">پیشنیاز</span>
                                </div>

                                <select name="pish[]" id="" multiple class="form-control">

                                    @foreach($herfes as $herfe)
                                        <option value="{{$herfe->id}}">{{$herfe->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        {{-- <div class="col-md-4">
                            <label class="form-label fw-bold">آرشیو</label>
                            {!! $errors->first('arshiv', '<p class="text-danger">:message</p>') !!}

                            <div class="input-group mb-4">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="arshiv" id="arshiv_yes" value="1"
                                        checked>
                                    <label class="form-check-label" for="arshiv_yes">بله</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="arshiv" id="arshiv_no" value="0">
                                    <label class="form-check-label" for="arshiv_no">خیر</label>
                                </div>
                            </div>
                        </div> --}}

                        <div class="col-md-4">
                            {!! $errors->first('file', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">بارگزاری استاندارد</span>
                                </div>
                                <input type="file" name="file" class="form-control" accept="application/pdf">

                            </div>

                        </div>
                        <div class="col-md-4">
                            {!! $errors->first('file', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">بارگزاری تصویر</span>
                                </div>
                                <input type="file" name="pic" class="form-control" >
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-block ">ذخیره</button>

                        </div>

                    </div>




                </form>
            </div>

            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>لیست استاندارد</h6>
                    </div>
                </div>
            </div>
            <div class="table-responsive mb-4 mt-4">
                <form id="bulk-delete-form" method="POST" action="{{ route('herfe.bulk-delete') }}">
                    @csrf
                
                    <table id="default-ordering" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all"></th>
                                <th>ردیف</th>
                                <th>نام استاندارد</th>
                                <th>کد استاندارد قدیم</th>
                                <th>کد استاندارد جدید</th>
                                <th>جمع ساعت</th>
                                <th class="text-center">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $key => $item)
                                <tr>
                                    <td><input type="checkbox" name="selected_items[]" value="{{ $item->id }}"></td>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->old_code }}</td>
                                    <td>{{ $item->code }}</td>
                                    <td>{{ $item->total_time }}</td>
                                    <td class="text-center">
                                        <a href="/{{ $item->file }}" class="btn btn-success">دانلود استاندارد</a>
                                        <a href="{{ route('herfe.edit', ['id' => $item->id]) }}" class="btn btn-primary">مشاهده و ویرایش</a>
                                        <a href="{{ route('herfe.delete', ['id' => $item->id]) }}" class="btn btn-danger">حذف</a>
                                        <a class="btn btn-primary" type="button" data-toggle="modal" data-target="#item{{ $item->id }}">
                                            جزئیات
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                     
                    
                        </tbody>
                    </table>
                
                    <button type="submit" class="btn btn-danger mt-2">حذف انتخاب‌شده‌ها</button>
                </form>
                               {{-- مودال‌ها خارج از جدول --}}
                               @foreach($items as $key => $item)
                               <div class="modal fade bd-example-modal-xl" id="item{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="item{{$item->id}}" aria-hidden="true">
                                   <div class="modal-dialog modal-xl" role="document">
                                       <div class="modal-content border-0 shadow">
       
                                           <div class="modal-header bg-primary text-white">
                                               <h5 class="modal-title" id="itemLabel{{$item->id}}">
                                                   جزئیات استاندارد: <strong>{{ $item->name }}</strong>
                                               </h5>
                                               <button type="button" class="close text-white" data-dismiss="modal" aria-label="بستن">
                                                   <span aria-hidden="true">&times;</span>
                                               </button>
                                           </div>
                           
                                           <div class="modal-body">
                                               <div class="row">
                                                   {{-- اطلاعات سمت چپ --}}
                                                   <div class="col-md-6 mb-3">
                                                       <div class="border rounded p-3 h-100">
                                                           <h6 class="text-center mb-3 text-secondary">مشخصات کلی</h6>
                                                           <ul class="list-group list-group-flush">
                                                               <li class="list-group-item"><strong>نوع :</strong> {{ $item['jobtype']->name }}</li>
                                                               <li class="list-group-item"><strong>نوع کاردانش :</strong> {{ $item['kardaneshe']->name }}</li>
                                                               <li class="list-group-item"><strong>سطح تحصیلات :</strong> {{ $item->min_tahsil_id}}</li>
                                                               <li class="list-group-item"><strong>تاریخ تدوین: </strong> {{ $item->update }}</li>
                                                               <li class="list-group-item"><strong>زمان نظری:</strong> {{ $item->theory_time }} </li>
                                                               <li class="list-group-item"><strong>زمان عملی:</strong> {{ $item->amali_time}} </li>
                                                               <li class="list-group-item"><strong>زمان کارورزی:</strong> {{ $item->karvarzi_time}} </li>
                                                               <li class="list-group-item"><strong>زمان پروژه:</strong> {{ $item->project_time}} </li>
                                                           </ul>
                                                       </div>
                                                   </div>
                           
                                                   {{-- اطلاعات سمت راست --}}
                                                   <div class="col-md-6 mb-3">
                                                       <div class="border rounded p-3 h-100">
                                                           <h6 class="text-center mb-3 text-secondary">فایل و لینک‌ها</h6>
                                                           <p><strong>نام استاندارد:</strong> {{ $item->name }}</p>
                                                           <a href="/{{ $item->file }}" class="btn btn-success btn-block mb-2">دانلود فایل استاندارد</a>
                                                           <a href="{{ route('herfe.edit', ['id' => $item->id]) }}" class="btn btn-info btn-block mb-2">مشاهده و ویرایش</a>
                                                           <a href="{{ route('herfe.delete', ['id' => $item->id]) }}" class="btn btn-danger btn-block">حذف</a>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                           
                                           <div class="modal-footer justify-content-between">
                                               <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                           </div>
                           
                                       </div>
                                   </div>
                               </div>  
                           @endforeach
                <script>
                    document.getElementById('select-all').addEventListener('change', function (e) {
                        let checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
                        checkboxes.forEach(cb => cb.checked = e.target.checked);
                    });
                </script>
                            
                
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