@extends('dashboard.layout.master')
@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/dt-global_style.css')}}">
    <!-- END PAGE LEVEL STYLES -->
@endsection
@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6 ">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>ویرایش حرفه {{$item->name}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <form action="{{ route('sanad.editpost', ['id' => $item->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- عنوان سر گروه -->
                        <div class="col-md-4">
                            {!! $errors->first('major_title', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">عنوان سر گروه</span>
                                </div>
                                <input type="text" class="form-control" name="major_title" value="{{ old('major_title', $item->major_title) }}" aria-label="Username">
                            </div>
                        </div>
                
                        <!-- عنوان -->
                        <div class="col-md-4">
                            {!! $errors->first('title', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">عنوان</span>
                                </div>
                                <input type="text" class="form-control" name="title" value="{{ old('title', $item->title) }}" aria-label="Username">
                            </div>
                        </div>
                
                        <!-- کد استاندارد -->
                        <div class="col-md-4">
                            {!! $errors->first('code', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">کد استاندارد</span>
                                </div>
                                <input type="text" class="form-control" name="code" id="code" value="{{ old('code', $item->code) }}">
                            </div>
                        </div>
                
                        <!-- مدت زمانی (زمان نظری) -->
                        @php
                            // فرض می‌کنیم مقدار زمان در فیلد date به صورت hh:mm ذخیره شده است.
                            $timeParts = explode(':', old('date', $item->date));
                            $timeHour = isset($timeParts[0]) ? $timeParts[0] : '';
                            $timeMin  = isset($timeParts[1]) ? $timeParts[1] : '';
                        @endphp
                        <div class="col-md-4">
                            {!! $errors->first('date', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">مدت زمانی</span>
                                </div>
                                <input class="form-control" onchange="timecalc()" onkeyup="timecalc()" name="date" id="teory_min" type="number" max="59" min="0" step="1" value="{{ $timeMin }}" />
                                <span style="font-size: 20px">:</span>
                                <input name="teory_hour" id="teory_hour" class="form-control" type="number" min="0" step="1" onchange="timecalc()" onkeyup="timecalc()" value="{{ $timeHour }}" />
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
                                        totalMinutes += (hour * 60) + min;
                                    });
                                    let finalHours = Math.floor(totalMinutes / 60);
                                    let finalMinutes = totalMinutes % 60;
                                    document.getElementById("sum_hour").value = finalHours;
                                    document.getElementById("sum_min").value = finalMinutes;
                                }
                                document.querySelectorAll('input[type="number"]').forEach(input => {
                                    input.addEventListener("input", timecalc);
                                });
                            });
                        </script>
                
                        <!-- نوع -->
                        <div class="col-md-4">
                            {!! $errors->first('job', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">نوع</span>
                                </div>
                                <select name="job" class="form-control">
                                    @foreach($jobs as $job)
                                        <option value="{{ $job->id }}" {{ old('job', $item->job) == $job->id ? 'selected' : '' }}>{{ $job->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                
                        <!-- تاریخ تدوین -->
                        <div class="col-md-4">
                            {!! $errors->first('update', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">تاریخ تدوین</span>
                                </div>
                                <input type="text" name="update" class="usage form-control" value="{{ old('update', $item->update) }}" aria-label="Username">
                            </div>
                        </div>
                
                        <!-- آرشیو -->
                        <div class="col-md-4">
                            {!! $errors->first('arshiv', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="arshiv" id="arshiv" value="0" {{ old('arshiv', $item->arshiv) == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="arshiv">بله</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="arshiv" id="arshiv1" value="1" {{ old('arshiv', $item->arshiv) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="arshiv1">خیر</label>
                                </div>
                            </div>
                        </div>
                
                        <!-- فایل استاندارد -->
                        <div class="col-md-4">
                            {!! $errors->first('file', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">لینک دانلود استاندارد</span>
                                </div>
                                <input type="file" name="file" class="form-control">
                                @if($item->file)
                                    <a href="{{ asset($item->file) }}" target="_blank" class="ml-2">مشاهده فایل</a>
                                @endif
                            </div>
                        </div>
                
                        <!-- دکمه ذخیره -->
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-block">به‌روزرسانی</button>
                            <br>
                        </div>
                    </div>
                </form>
                
            </div>


        </div>
    </div>

@endsection
