@extends('admin.layout.master')
@section('head')
@endsection
@section('content')
    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0 p-3">
            <div class="head-label p-3"></div>
            <form action="{{ route('admin.professions.store') }}" method="post" class="add-new-record pt-0 row g-2 mt-3 px-3"
                id="form-add-new-record" enctype="multipart/form-data">
                @csrf

                {{-- فیلد نام حرفه --}}
                <div class="col-sm-12">
                    <label class="form-label" for="name">نام حرفه</label>
                    <div class="input-group input-group-merge">
                        <span id="name2" class="input-group-text">
                            <i class="bx bx-check-square"></i>
                        </span>
                        <input type="text" id="name" class="form-control dt-full-name" name="name"
                            placeholder="نام حرفه" required>
                    </div>
                </div>

                {{-- بررسی اینکه آیا field_id از URL آمده یا نه --}}
                @php
                    $fieldId = request()->get('field_id');
                @endphp

                {{-- انتخاب رشته (در صورت نبود field_id در URL) --}}
                @if (!$fieldId)
                    <div class="col-sm-12 mt-3">
                        <label class="form-label" for="field_id">انتخاب رشته</label>
                        <select id="field_id" name="field_id" class="form-select select2" required>
                            <option value="" selected disabled>انتخاب کنید...</option>
                            @foreach ($fields as $field)
                                <option value="{{ $field->id }}">{{ $field->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    {{-- اگر از URL آمده، فیلد hidden --}}
                    <input type="hidden" name="field_id" value="{{ $fieldId }}">
                @endif

                {{-- انتخاب نوع کاردانش --}}
                <div class="col-sm-12 mt-3">
                    <label class="form-label" for="kardanesh_id">نوع کاردانش</label>
                    <select id="kardanesh_id" name="kardanesh_id" class="form-select select2">
                        <option value="" selected disabled>انتخاب کنید...</option>
                        @foreach ($kardaneshes as $kardanesh)
                            <option value="{{ $kardanesh->id }}">{{ $kardanesh->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- انتخاب نوع شغل --}}
                <div class="col-sm-12 mt-3">
                    <label class="form-label" for="jobtype_id">نوع شغل</label>
                    <select id="jobtype_id" name="jobtype_id" class="form-select select2">
                        <option value="" selected disabled>انتخاب کنید...</option>
                        @foreach ($jobtypes as $jobtype)
                            <option value="{{ $jobtype->id }}">{{ $jobtype->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- فیلدهای کد استاندارد --}}
                <div class="col-sm-6 mt-3">
                    <label class="form-label" for="old_standard_code">کد استاندارد قدیم</label>
                    <input type="text" id="old_standard_code" name="old_standard_code" class="form-control"
                        placeholder="مثلاً ۱۲۳۴۵" required>
                </div>

                <div class="col-sm-6 mt-3">
                    <label class="form-label" for="new_standard_code">کد استاندارد جدید</label>
                    <input type="text" id="new_standard_code" name="new_standard_code" class="form-control"
                        placeholder="مثلاً ۹۸۷۶۵" required>
                </div>

                {{-- گروه زمان‌ها --}}
                <div class="col-12 mt-4">
                    <h6 class="border-bottom pb-2 mb-3">زمان‌بندی دوره</h6>
                </div>

                {{-- زمان نظری --}}
                <div class="col-sm-6 mt-2">
                    <label class="form-label" for="theory_hour">زمان نظری</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="number" id="theory_hour" name="theory_hour" class="form-control"
                                placeholder="ساعت" min="0" value="0">
                        </div>
                        <div class="col-6">
                            <input type="number" id="theory_minute" name="theory_minute" class="form-control"
                                placeholder="دقیقه" min="0" max="59" value="0">
                        </div>
                    </div>
                </div>

                {{-- زمان عملی --}}
                <div class="col-sm-6 mt-2">
                    <label class="form-label" for="practice_hour">زمان عملی</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="number" id="practice_hour" name="practice_hour" class="form-control"
                                placeholder="ساعت" min="0" value="0">
                        </div>
                        <div class="col-6">
                            <input type="number" id="practice_minute" name="practice_minute" class="form-control"
                                placeholder="دقیقه" min="0" max="59" value="0">
                        </div>
                    </div>
                </div>

                {{-- زمان پروژه --}}
                <div class="col-sm-6 mt-3">
                    <label class="form-label" for="project_hour">زمان پروژه</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="number" id="project_hour" name="project_hour" class="form-control"
                                placeholder="ساعت" min="0" value="0">
                        </div>
                        <div class="col-6">
                            <input type="number" id="project_minute" name="project_minute" class="form-control"
                                placeholder="دقیقه" min="0" max="59" value="0">
                        </div>
                    </div>
                </div>

                {{-- زمان کارورزی --}}
                <div class="col-sm-6 mt-3">
                    <label class="form-label" for="internship_hour">زمان کارورزی</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="number" id="internship_hour" name="internship_hour" class="form-control"
                                placeholder="ساعت" min="0" value="0">
                        </div>
                        <div class="col-6">
                            <input type="number" id="internship_minute" name="internship_minute" class="form-control"
                                placeholder="دقیقه" min="0" max="59" value="0">
                        </div>
                    </div>
                </div>

                {{-- زمان کل --}}
                <div class="col-sm-6 mt-3">
                    <label class="form-label" for="total_hour">زمان کل</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="number" id="total_hour" name="total_hour" class="form-control"
                                placeholder="ساعت" min="0" value="0">
                        </div>
                        <div class="col-6">
                            <input type="number" id="total_minute" name="total_minute" class="form-control"
                                placeholder="دقیقه" min="0" max="59" value="0">
                        </div>
                    </div>
                </div>

                {{-- تاریخ تدوین --}}
                <div class="col-sm-6 mt-3">
                    <label class="form-label" for="draft_date">تاریخ تدوین</label>
                    <input type="date" id="draft_date" name="draft_date" class="form-control">
                </div>

                {{-- سایر فیلدهای اختیاری --}}
                <div class="col-sm-6 mt-3">
                    <label class="form-label" for="education_level">حداقل تحصیلات ورودی</label>
                    <input type="text" id="education_level" name="education_level" class="form-control"
                        placeholder="مثلاً دیپلم">
                </div>

                <div class="col-sm-6 mt-3">
                    <label class="form-label" for="trainer_qualification">صلاحیت مربی</label>
                    <input type="text" id="trainer_qualification" name="trainer_qualification" class="form-control"
                        placeholder="مثلاً دارای مدرک کارشناسی">
                </div>

                {{-- آپلود فایل و تصویر --}}
                <div class="col-12 mt-4">
                    <h6 class="border-bottom pb-2 mb-3">فایل‌ها</h6>
                </div>

                <div class="col-sm-6 mt-2">
                    <label class="form-label" for="image_path">تصویر</label>
                    <input type="file" id="image_path" name="image_path" class="form-control" accept="image/*">
                    <div class="w-100 rounded" id="image-preview"></div>
                </div>

                <div class="col-sm-6 mt-2">
                    <label class="form-label" for="standard_file">فایل استاندارد</label>
                    <input type="file" id="standard_file" name="standard_file" class="form-control"
                        accept=".pdf,.doc,.docx">
                </div>

                {{-- دکمه ثبت --}}
                <div class="col-sm-12 mt-4">
                    <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ثبت</button>
                </div>
            </form>


            <table class="dt-select-table professions table">
                <thead>
                    <tr>
                        {{-- filled with ajax --}}
                    </tr>
                </thead>
            </table>
            <div id="bulk-actions" class="">
                <button id="bulk-delete" class="btn btn-danger" disabled>حذف انتخابی‌ها</button>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
