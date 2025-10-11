@extends('admin.layout.master')
@section('head')
@endsection
@section('content')
    <div class="card">
        <div class="header-label p-3 d-flex justify-content-between align-items-center">
            <h5>ویرایش حرفه {{ $profession->name }}</h5>
        </div>
        <form action="{{ route('admin.professions.update', $profession->id) }}" method="post"
            class="add-new-record p-3 pt-0 row g-2" id="form-edit-record" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- فیلد نام حرفه --}}
            <div class="col-sm-12">
                <label class="form-label" for="name">نام حرفه</label>
                <div class="input-group input-group-merge">
                    <span id="name2" class="input-group-text">
                        <i class="bx bx-check-square"></i>
                    </span>
                    <input type="text" id="name" name="name" class="form-control dt-full-name"
                        placeholder="نام حرفه" value="{{ old('name', $profession->name) }}" required>
                </div>
            </div>

            {{-- انتخاب رشته --}}
            <div class="col-sm-12 mt-3">
                <label class="form-label" for="field_id">انتخاب رشته</label>
                <select id="field_id" name="field_id" class="form-select select2" required>
                    <option value="" disabled>انتخاب کنید...</option>
                    @foreach ($fields as $field)
                        <option value="{{ $field->id }}" {{ $profession->field_id == $field->id ? 'selected' : '' }}>
                            {{ $field->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- انتخاب نوع کاردانش --}}
            <div class="col-sm-12 mt-3">
                <label class="form-label" for="kardanesh_id">نوع کاردانش</label>
                <select id="kardanesh_id" name="kardanesh_id" class="form-select select2">
                    <option value="" selected disabled>انتخاب کنید...</option>
                    @foreach ($kardaneshes as $kardanesh)
                        <option value="{{ $kardanesh->id }}"
                            {{ $profession->kardanesh_id == $kardanesh->id ? 'selected' : '' }}>
                            {{ $kardanesh->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- انتخاب نوع شغل --}}
            <div class="col-sm-12 mt-3">
                <label class="form-label" for="jobtype_id">نوع شغل</label>
                <select id="jobtype_id" name="jobtype_id" class="form-select select2">
                    <option value="" selected disabled>انتخاب کنید...</option>
                    @foreach ($jobtypes as $jobtype)
                        <option value="{{ $jobtype->id }}"
                            {{ $profession->jobtype_id == $jobtype->id ? 'selected' : '' }}>
                            {{ $jobtype->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- فیلدهای کد استاندارد --}}
            <div class="col-sm-6 mt-3">
                <label class="form-label" for="old_standard_code">کد استاندارد قدیم</label>
                <input type="text" id="old_standard_code" name="old_standard_code" class="form-control"
                    placeholder="مثلاً ۱۲۳۴۵" value="{{ old('old_standard_code', $profession->old_standard_code) }}"
                    required>
            </div>

            <div class="col-sm-6 mt-3">
                <label class="form-label" for="new_standard_code">کد استاندارد جدید</label>
                <input type="text" id="new_standard_code" name="new_standard_code" class="form-control"
                    placeholder="مثلاً ۹۸۷۶۵" value="{{ old('new_standard_code', $profession->new_standard_code) }}"
                    required>
            </div>

            {{-- گروه زمان‌ها --}}
            <div class="col-12 mt-4">
                <h6 class="border-bottom pb-2 mb-3">زمان‌بندی دوره</h6>
            </div>

            {{-- زمان نظری --}}
            <div class="col-sm-6 mt-2">
                <label class="form-label" for="theory_hour">زمان نظری</label>
                <div class="input-group form-group p-0">
                    <input type="number" id="theory_hour" name="theory_hour" class="form-control" placeholder="ساعت"
                        min="0" value="{{ old('theory_hour', $profession->theory_hour) }}">
                    <span class="input-group-text"> : </span>
                    <input type="number" id="theory_minute" name="theory_minute" class="form-control" placeholder="دقیقه"
                        min="0" max="59" value="{{ old('theory_minute', $profession->theory_minute) }}">
                </div>
            </div>

            {{-- زمان عملی --}}
            <div class="col-sm-6 mt-2">
                <label class="form-label" for="practice_hour">زمان عملی</label>
                <div class="input-group form-group p-0">
                    <input type="number" id="practice_hour" name="practice_hour" class="form-control" placeholder="ساعت"
                        min="0" value="{{ old('practice_hour', $profession->practice_hour) }}">
                    <span class="input-group-text"> : </span>
                    <input type="number" id="practice_minute" name="practice_minute" class="form-control"
                        placeholder="دقیقه" min="0" max="59"
                        value="{{ old('practice_minute', $profession->practice_minute) }}">
                </div>
            </div>

            {{-- زمان پروژه --}}
            <div class="col-sm-6 mt-3">
                <label class="form-label" for="project_hour">زمان پروژه</label>
                <div class="input-group form-group p-0">
                    <input type="number" id="project_hour" name="project_hour" class="form-control" placeholder="ساعت"
                        min="0" value="{{ old('project_hour', $profession->project_hour) }}">
                    <span class="input-group-text"> : </span>
                    <input type="number" id="project_minute" name="project_minute" class="form-control"
                        placeholder="دقیقه" min="0" max="59"
                        value="{{ old('project_minute', $profession->project_minute) }}">
                </div>
            </div>

            {{-- زمان کارورزی --}}
            <div class="col-sm-6 mt-3">
                <label class="form-label" for="internship_hour">زمان کارورزی</label>
                <div class="input-group form-group p-0">
                    <input type="number" id="internship_hour" name="internship_hour" class="form-control"
                        placeholder="ساعت" min="0"
                        value="{{ old('internship_hour', $profession->internship_hour) }}">
                    <span class="input-group-text"> : </span>
                    <input type="number" id="internship_minute" name="internship_minute" class="form-control"
                        placeholder="دقیقه" min="0" max="59"
                        value="{{ old('internship_minute', $profession->internship_minute) }}">
                </div>
            </div>

            {{-- زمان کل --}}
            <div class="col-sm-6 mt-3">
                <label class="form-label" for="total_hour">زمان کل</label>
                <div class="input-group form-group p-0">
                    <input type="number" id="total_hour" name="total_hour" class="form-control" placeholder="ساعت"
                        min="0" value="{{ old('total_hour', $profession->total_hour) }}">
                    <span class="input-group-text"> : </span>
                    <input type="number" id="total_minute" name="total_minute" class="form-control"
                        placeholder="دقیقه" min="0" max="59"
                        value="{{ old('total_minute', $profession->total_minute) }}">
                </div>
            </div>

            {{-- تاریخ تدوین --}}
            <div class="col-sm-6 mt-3">
                <label class="form-label" for="draft_date">تاریخ تدوین</label>
                <input type="text" class="form-control" name="draft_date" placeholder="YYYY/MM/DD"
                    id="draft_date" value="{{ old('draft_date', $profession->draft_date) }}">

            </div>

            {{-- سایر فیلدها --}}
            <div class="col-sm-6 mt-3">
                <label class="form-label" for="education_level">حداقل تحصیلات ورودی</label>
                <input type="text" id="education_level" name="education_level" class="form-control"
                    placeholder="مثلاً دیپلم" value="{{ old('education_level', $profession->education_level) }}">
            </div>

            <div class="col-sm-6 mt-3">
                <label class="form-label" for="trainer_qualification">صلاحیت مربی</label>
                <input type="text" id="trainer_qualification" name="trainer_qualification" class="form-control"
                    placeholder="مثلاً دارای مدرک کارشناسی"
                    value="{{ old('trainer_qualification', $profession->trainer_qualification) }}">
            </div>

            {{-- فایل‌ها --}}
            <div class="col-12 mt-4">
                <h6 class="border-bottom pb-2 mb-3">فایل‌ها</h6>
            </div>

            <div class="col-sm-6 mt-2">
                <label class="form-label" for="image_path">تصویر</label>
                <input type="file" id="image_path" name="image_path" class="form-control" accept="image/*">

                {{-- نمایش تصویر فعلی --}}
                @if ($profession->image_path)
                    <div class="mt-2">
                        <label class="form-label">تصویر فعلی:</label>
                        <div class="border rounded p-2">
                            <img src="{{ asset($profession->image_path) }}" alt="تصویر حرفه" class="img-thumbnail"
                                style="max-height: 150px;">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image"
                                    value="1">
                                <label class="form-check-label text-danger" for="remove_image">
                                    حذف تصویر
                                </label>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="w-100 rounded mt-2" id="image-preview"></div>
            </div>

            <div class="col-sm-6 mt-2">
                <label class="form-label" for="standard_file">فایل استاندارد</label>
                <input type="file" id="standard_file" name="standard_file" class="form-control"
                    accept=".pdf,.doc,.docx">

                {{-- نمایش فایل فعلی --}}
                @if ($profession->standard_file)
                    <div class="mt-2">
                        <label class="form-label">فایل فعلی:</label>
                        <div class="border rounded p-2">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-file bx-md me-2"></i>
                                <div>
                                    <a href="{{ asset($profession->standard_file) }}" target="_blank"
                                        class="text-primary">
                                        مشاهده فایل
                                    </a>
                                    <div class="form-check mt-1">
                                        <input class="form-check-input" type="checkbox" name="remove_standard_file"
                                            id="remove_standard_file" value="1">
                                        <label class="form-check-label text-danger" for="remove_standard_file">
                                            حذف فایل
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- دکمه‌های ثبت و انصراف --}}
            <div class="col-sm-12 mt-4">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">بروزرسانی</button>
                    <a href="{{ route('admin.professions.index') }}" type="button" class="btn btn-secondary">انصراف</a>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        const flatpickrDate2 = document.querySelector('#draft_date');
        if (flatpickrDate2) {
            flatpickrDate2.flatpickr({
                monthSelectorType: 'static',
                locale: 'fa',
                altInput: true,
                altFormat: 'Y/m/d',
                disableMobile: true
            });
        }
        // پیش‌نمایش تصویر جدید
        document.getElementById('image_path').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('image-preview');

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<div class="mt-2">
                <label class="form-label">پیش‌نمایش تصویر جدید:</label>
                <img src="${e.target.result}" class="img-thumbnail" style="max-height: 150px;">
            </div>`;
                };
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '';
            }
        });
    </script>
@endsection
