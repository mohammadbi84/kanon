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
                <form action="{{ route('herfe.editpost', ['id' => $item->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- نام استاندارد(حرفه) -->
                        <div class="col-md-4">
                            {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">نام استاندارد(حرفه)</span>
                                </div>
                                <input value="{{ old('name', $item->name) }}" type="text" class="form-control" name="name" aria-label="Username">
                            </div>
                        </div>


<div class="col-md-4">
    {!! $errors->first('old_code', '<p class="text-danger">:message</p>') !!}
    <div class="input-group mb-4">
        <div class="input-group-prepend">
            <span class="input-group-text">کد استاندارد قدیم</span>
        </div>
        <!-- فیلد اصلی کد قدیم (readonly) -->
        <input value="{{ old('old_code',$item->old_code) }}" type="text" class="form-control" name="old_code" id="old_code" >
    </div>

</div>
<div class="col-md-4">
    {!! $errors->first('old_code', '<p class="text-danger">:message</p>') !!}
    <div class="input-group mb-4">
        <div class="input-group-prepend">
            <span class="input-group-text">کد استاندارد جدید</span>
        </div>
        <input value="{{ old('code',$item->old_code) }}" type="number" class="form-control" name="code" id="old_code" >
    </div>
</div>

                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                let oldCodeInput = document.getElementById('old_code');
                                let extraFields = document.getElementById('extraFields');

                                // نمایش/مخفی کردن فیلدهای اضافی
                                oldCodeInput.addEventListener('click', function () {
                                    extraFields.classList.toggle('d-none');
                                });

                                // به‌روزرسانی مقدار old_code با تغییر در فیلدهای اضافی
                                document.querySelectorAll('#extraFields input').forEach((input, index) => {
                                    input.addEventListener('input', function () {
                                        // فقط اعداد
                                        this.value = this.value.replace(/\D/g, '');
                                        // محدودیت تعداد کاراکتر
                                        let maxLengths = [4, 1, 3, 3, 3, 1];
                                        if (this.value.length > maxLengths[index]) {
                                            this.value = this.value.slice(0, maxLengths[index]);
                                        }
                                        let values = Array.from(document.querySelectorAll('#extraFields input')).map(f => f.value.trim()).join('');
                                        oldCodeInput.value = values;
                                    });
                                });
                            });
                        </script>

                        <!-- زمان نظری -->
                        <div class="col-md-4">
                            {!! $errors->first('teory_min', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">زمان نظری</span>
                                </div>
                                <input value="{{ old('teory_min', explode(':', $item->theory_time)[1] ?? '' ) }}" class="form-control" onchange="timecalc()" onkeyup="timecalc()" name="teory_min" id="teory_min" type="number" max="59" min="0" step="1">
                                <span style="font-size: 20px">:</span>
                                <input value="{{ old('teory_hour', explode(':', $item->theory_time)[0] ?? '' ) }}" name="teory_hour" id="teory_hour" class="form-control" type="number" min="0" step="1" onchange="timecalc()" onkeyup="timecalc()">
                            </div>
                        </div>

                        <!-- زمان عملی -->
                        <div class="col-md-4">
                            {!! $errors->first('amali_min', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">زمان عملی</span>
                                </div>
                                <input value="{{ old('amali_min', explode(':', $item->amali_time)[1]  ?? '' ) }}" class="form-control" onchange="timecalc()" onkeyup="timecalc()" name="amali_min" id="amali_min" type="number" max="59" min="0" step="1">
                                <span style="font-size: 20px">:</span>
                                <input value="{{ old('amali_hour', explode(':', $item->amali_time)[0] ?? '' ) }}" name="amali_hour" id="amali_hour" class="form-control" type="number" min="0" step="1" onchange="timecalc()" onkeyup="timecalc()">
                            </div>
                        </div>

                        <!-- زمان کارورزی -->
                        <div class="col-md-4">
                            {!! $errors->first('karvarzi_min', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">زمان کارورزی</span>
                                </div>
                                <input value="{{ old('karvarzi_min', explode(':', $item->karvarzi_time)[1] ?? '' ) }}" class="form-control" onchange="timecalc()" onkeyup="timecalc()" name="karvarzi_min" id="karvarzi_min" type="number" max="59" min="0" step="1">
                                <span style="font-size: 20px">:</span>
                                <input value="{{ old('karvarzi_hour', explode(':', $item->karvarzi_time)[0] ?? '' ) }}" name="karvarzi_hour" id="karvarzi_hour" class="form-control" type="number" min="0" step="1" onchange="timecalc()" onkeyup="timecalc()">
                            </div>
                        </div>

                        <!-- زمان پروژه -->
                        <div class="col-md-4">
                            {!! $errors->first('project_min', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">زمان پروژه</span>
                                </div>
                                <input value="{{ old('project_min', explode(':', $item->project_time)[1] ?? '' ) }}" class="form-control" onchange="timecalc()" onkeyup="timecalc()" name="project_min" id="project_min" type="number" max="59" min="0" step="1">
                                <span style="font-size: 20px">:</span>
                                <input value="{{ old('project_hour', explode(':', $item->project_time)[0] ?? '' ) }}" name="project_hour" id="project_hour" class="form-control" type="number" min="0" step="1" onchange="timecalc()" onkeyup="timecalc()">
                            </div>
                        </div>

                        <!-- جمع زمان -->
                        <div class="col-md-4">
                            {!! $errors->first('sum_min', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">جمع زمان</span>
                                </div>
                                <input value="{{ old('sum_min', explode(':', $item->total_time)[1] ?? '') }}" class="form-control" id="sum_min" name="sum_min" type="number" min="0" step="1" readonly>
                                <span style="font-size: 20px">:</span>
                                <input value="{{ old('sum_hour', explode(':', $item->total_time)[0] ?? '') }}" name="sum_hour" id="sum_hour" class="form-control" type="number" min="0" step="1" readonly>
                            </div>
                        </div>

                        <!-- نوع -->
                        <div class="col-md-4">
                            {!! $errors->first('job', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">نوع</span>
                                </div>
                                <select name="job" class="form-control">
                                    @foreach($jobs as $job)
                                        <option value="{{ $job->id }}" {{ $job->id == $item->type_id ? 'selected' : '' }}>
                                            {{ $job->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- نوع کاردانش -->
                        <div class="col-md-4">
                            {!! $errors->first('kardanesh', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">نوع کاردانش</span>
                                </div>
                                <select name="kardanesh" class="form-control">
                                    @foreach($kardaneshs as $kardanesh)
                                        <option value="{{ $kardanesh->id }}" {{ $kardanesh->id == $item->kardanesh_id ? 'selected' : '' }}>
                                            {{ $kardanesh->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- حداقل تحصیلات ورودی -->
                        <div class="col-md-4">
                            {!! $errors->first('madrak', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">حداقل تحصیلات ورودی</span>
                                </div>
                                <select name="madrak" class="form-control">
                                    <option value="1" {{ $item->min_tahsil_id == 1 ? 'selected' : '' }}>دیپلم</option>
                                    <option value="2" {{ $item->min_tahsil_id == 2 ? 'selected' : '' }}>فوق دیپلم</option>
                                    <option value="3" {{ $item->min_tahsil_id == 3 ? 'selected' : '' }}>لیسانس</option>
                                </select>
                            </div>
                        </div>

                        <!-- صلاحیت حرفه‌ای مربیان -->
                        <div class="col-md-4">
                            {!! $errors->first('salahiat', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">صلاحیت حرفه‌ای مربیان</span>
                                </div>
                                <input value="{{ old('salahiat', $item->slahiat_morabi) }}" type="text" class="form-control" name="salahiat">
                            </div>
                        </div>

                        <!-- تاریخ تدوین -->
                        <div class="col-md-4">
                            {!! $errors->first('update', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">تاریخ تدوین</span>
                                </div>
                                <input value="{{ old('update', $item->update) }}" type="text" class="form-control usage" name="update" id="datepicker0">
                            </div>
                        </div>

                        <!-- پیشنیاز -->
                        <div class="col-md-4">
                            {!! $errors->first('pish', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">پیشنیاز</span>
                                </div>
                                <select name="pish[]" multiple class="form-control">
                                    @foreach($herfes as $herfe)
                                        <option value="{{ $herfe->id }}" {{ (isset($herfe['select']) && $herfe['select'] == 1) ? 'selected' : '' }}>
                                            {{ $herfe->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- آرشیو -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold">آرشیو</label>
                            {!! $errors->first('arshiv', '<p class="text-danger">:message</p>') !!}

                            <div class="input-group mb-4">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="arshiv" id="arshiv_yes" value="1" checked>
                                    <label class="form-check-label" for="arshiv_yes">بله</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="arshiv" id="arshiv_no" value="0">
                                    <label class="form-check-label" for="arshiv_no">خیر</label>
                                </div>
                            </div>
                        </div>


                        <!-- فایل استاندارد -->
                        <div class="col-md-4">
                            {!! $errors->first('file', '<p class="text-danger">:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">آپلود استاندارد</span>
                                </div>
                                <input type="file" name="file" class="form-control" accept="application/pdf">
                                @if($item->file)
                                    <a href="{{ asset($item->file) }}" target="_blank" class="ml-2">مشاهده فایل</a>
                                @endif
                            </div>
                        </div>

                        <!-- دکمه ذخیره -->
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-block">به‌روزرسانی</button>
                        </div>
                    </div>
                </form>

                <script>
                    // تابع محاسبه زمان کل (زمان نظری، عملی، کارورزی، پروژه)
                    function timecalc() {
                        let totalMinutes = 0;
                        let fields = ["teory", "amali", "karvarzi", "project"];
                        fields.forEach(function(field) {
                            let min = parseInt(document.getElementById(field + "_min").value) || 0;
                            let hour = parseInt(document.getElementById(field + "_hour").value) || 0;
                            totalMinutes += (hour * 60) + min;
                        });
                        let finalHours = Math.floor(totalMinutes / 60);
                        let finalMinutes = totalMinutes % 60;
                        document.getElementById("sum_hour").value = finalHours;
                        document.getElementById("sum_min").value = finalMinutes;
                    }
                    document.addEventListener("DOMContentLoaded", function () {
                        document.querySelectorAll('input[type="number"]').forEach(function(input) {
                            input.addEventListener("input", timecalc);
                        });
                    });
                </script>

            </div>


        </div>
    </div>

@endsection
