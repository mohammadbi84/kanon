@extends('admin.layout.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}">
    <style>
        .searchResult {
            background: #fff;
            border: 1px solid #c3c3c3;
            padding: 3px 8px;
            border-radius: 5px;
            top: 31px;
            z-index: 1;
            display: none;
        }


        .custom-file-upload {
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .upload-button {
            background-color: #5a8dee;
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .file-count {
            margin-right: 5px;
            color: #677788;
        }
    </style>
@endsection
@section('content')
    <h5 class="breadcrumb-wrapper mb-4">
        <a href="{{ route('admin.index') }}" class="text-muted">داشبورد</a> <span class="text-muted">/</span>
        <span class="text-muted">مدیریت استاندارد ها / </span>
        @if ($fieldId)
            <a href="{{ route('admin.categories.index') }}" class="text-muted">رسته {{ $field?->cluster->category->name }}</a>
            <span class="text-muted">/</span>
            <a href="{{ route('admin.clusters.index') }}" class="text-muted">خوشه {{ $field?->cluster?->name }}</a> <span
                class="text-muted">/</span>
            <a href="{{ route('admin.fields.index') }}" class="text-muted">رشته {{ $field?->name }}</a> <span
                class="text-muted">/</span>
        @endif
        <span>ایجاد حرفه جدید</span>
    </h5>
    <div class="card p-3">
        <div class="header-label p-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0">ایجاد حرفه جدید</h5>
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div class="btn-group dropstart">
                    <button class="btn border dropdown-toggle hide-arrow px-2" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bx bx-search"></i>
                    </button>
                    <ul class="dropdown-menu shadow-none p-0">
                        <div class="d-flex flex-column position-relative" style="width: 300px">
                            <div class="">
                                <div class=" custom-input-group">
                                    <input type="text" id="search" class="form-control" style="padding: 7px 15px;">
                                    <label for="search" class="form-label">جستجو با نام / کد ایسکو . . .</label>
                                </div>
                            </div>
                            <div class="position-absolute searchResult mt-3" id="searchResult">
                            </div>
                        </div>
                    </ul>
                </div>
                <a href="{{ route('admin.professions.index') }}{{$fieldId ? '?field_id='.$fieldId : ''}}" class="btn btn-custom">
                    بازگشت
                    <i class="fa fa-arrow-left ms-3"></i>
                </a>
            </div>
        </div>
        <hr class="my-3">
        <form action="{{ route('admin.professions.store') }}" method="post" class="add-new-record pt-0 g-2 mt-3 px-3"
            id="form-add-new-record" enctype="multipart/form-data">
            @csrf

            <div class="row">

                {{-- فیلد نام حرفه --}}
                <div class="col-sm-4 mb-4">
                    <div class="custom-input-group">
                        <input type="text" id="name" name="name" class="form-control">
                        <label class="form-label" for="name">نام حرفه</label>
                    </div>
                </div>

                <div class="col-sm-4 mb-4">
                    <div class="custom-input-group only-number">
                        <input type="text" id="new_standard_code" name="new_standard_code" class="form-control">
                        <label class="form-label" for="new_standard_code">کد استاندارد جدید</label>
                    </div>
                </div>

                {{-- انتخاب رشته --}}
                @if (!$fieldId)
                    <div class="col-sm-4 mb-4">
                        <div class="input-group">
                            <label class="input-group-text bg-gray-300" for="field_id">رشته</label>
                            <select id="field_id" name="field_id" class="form-select select2" required>
                                <option value="" selected disabled>انتخاب کنید . . .</option>
                                @foreach ($fields as $field)
                                    <option value="{{ $field->id }}">{{ $field->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @else
                    <div class="col-sm-4 mb-4">
                        <div class="input-group">
                            <label class="input-group-text bg-gray-300" for="">رشته</label>
                            <select id="" name="" class="form-select select2" disabled>
                                @foreach ($fields as $field)
                                    <option value="{{ $field->id }}" {{ $field->id == $fieldId ? 'selected' : '' }}>
                                        {{ $field->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="field_id" value="{{ $fieldId }}">
                @endif



            </div>

            <div class="row">
                {{-- زمان نظری --}}
                <div class="col">
                    <label class="form-label" for="theory_hour">زمان تئوری</label>
                    <div class="d-flex gap-2">
                        <div class="custom-input-group only-number ltr w-50">
                            <input type="text" id="theory_minute" name="theory_minute" class="form-control"
                                min="0" max="59">
                            <label for="">دقیقه</label>
                        </div>
                        <div class="custom-input-group only-number ltr w-50">
                            <input type="text" id="theory_hour" name="theory_hour" class="form-control" min="0"
                                max="1000">
                            <label for="">ساعت</label>
                        </div>
                    </div>
                </div>

                {{-- زمان عملی --}}
                <div class="col">
                    <label class="form-label" for="practice_hour">زمان عملی</label>
                    <div class="d-flex gap-2">
                        <div class="custom-input-group only-number ltr w-50">
                            <input type="text" id="practice_minute" name="practice_minute" class="form-control"
                                min="0" max="59">
                            <label for="">دقیقه</label>
                        </div>
                        <div class="custom-input-group only-number ltr w-50">
                            <input type="text" id="practice_hour" name="practice_hour" class="form-control"
                                min="0">
                            <label for="">ساعت</label>
                        </div>
                    </div>
                </div>

                {{-- زمان پروژه --}}
                <div class="col">
                    <label class="form-label" for="project_hour">زمان پروژه</label>
                    <div class="d-flex gap-2">
                        <div class="custom-input-group only-number ltr w-50">
                            <input type="text" id="project_minute" name="project_minute" class="form-control"
                                min="0" max="59">
                            <label for="">دقیقه</label>
                        </div>
                        <div class="custom-input-group only-number ltr w-50">
                            <input type="text" id="project_hour" name="project_hour" class="form-control"
                                min="0">
                            <label for="">ساعت</label>
                        </div>
                    </div>
                </div>

                {{-- زمان کارورزی --}}
                <div class="col">
                    <label class="form-label" for="internship_hour">زمان کارورزی</label>
                    <div class="d-flex gap-2">
                        <div class="custom-input-group only-number ltr w-50">
                            <input type="text" id="internship_minute" name="internship_minute" class="form-control"
                                min="0" max="59">
                            <label for="">دقیقه</label>
                        </div>
                        <div class="custom-input-group only-number ltr w-50">
                            <input type="text" id="internship_hour" name="internship_hour" class="form-control"
                                min="0" max="1000">
                            <label for="">ساعت</label>
                        </div>
                    </div>
                </div>

                {{-- زمان کل --}}
                <div class="col">
                    <label class="form-label" for="total_hour">زمان کل</label>
                    <div class="d-flex gap-2">
                        <div class="custom-input-group ltr w-50">
                            <input type="text" id="total_minute" disabled name="total_minute" class="form-control"
                                min="0" max="59" value="0">
                            <label for="">دقیقه</label>
                        </div>
                        <div class="custom-input-group ltr w-50">
                            <input type="text" id="total_hour" disabled name="total_hour" class="form-control"
                                min="0" value="0">
                            <label for="">ساعت</label>
                        </div>
                    </div>
                </div>
            </div>


            <div class="divider divider-dashed pt-3 pb-3">
                <div class="divider-text">دیگر جزئیات</div>
            </div>

            <div class="row">
                {{-- فیلدهای کد استاندارد --}}
                <div class="col-sm-3 mb-4">
                    <div class="custom-input-group">
                        <input type="text" id="old_standard_code" name="old_standard_code" class="form-control">
                        <label class="form-label" for="old_standard_code">کد استاندارد قدیم</label>
                    </div>
                </div>

                {{-- تاریخ تدوین --}}
                <div class="col-sm-3 mb-4">
                    <div class="custom-input-group">
                        <input type="date" id="draft_date" name="draft_date" class="form-control">
                        <label class="form-label" for="draft_date">تاریخ تدوین</label>
                    </div>
                </div>

                <div class="col-sm-3 mb-4">
                    <div class="custom-input-group">
                        <input type="text" id="trainer_qualification" name="trainer_qualification"
                            class="form-control">
                        <label class="form-label" for="trainer_qualification">صلاحیت مربی</label>
                    </div>
                </div>
                <div class="col-sm-3 mb-4">
                    <div class="custom-input-group">
                        <input type="text" id="prerequisites" name="prerequisites"
                            class="form-control">
                        <label class="form-label" for="prerequisites">پیش نیاز</label>
                    </div>
                </div>

                {{-- انتخاب نوع شغل --}}
                <div class="col-sm-4 mb-3">
                    <div class="input-group">
                        <label class="input-group-text bg-gray-300" for="jobtype_id">نوع شغل</label>
                        <select id="jobtype_id" name="jobtype_id" class="form-select select2">
                            <option value="" selected disabled>انتخاب کنید . . .</option>
                            @foreach ($jobtypes as $jobtype)
                                <option value="{{ $jobtype->id }}">{{ $jobtype->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                            data-bs-target="#jobtypeModal">
                            <i class="bx bx-plus"></i>
                        </button>
                    </div>
                </div>

                {{-- انتخاب نوع کاردانش --}}
                <div class="col-sm-4 mb-3">
                    <div class="input-group">
                        <label class="input-group-text bg-gray-300" for="kardanesh_id">نوع کار و دانش</label>
                        <select id="kardanesh_id" name="kardanesh_id" class="form-select select2">
                            <option value="" selected disabled>انتخاب کنید . . .</option>
                            @foreach ($kardaneshes as $kardanesh)
                                <option value="{{ $kardanesh->id }}">{{ $kardanesh->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                            data-bs-target="#kardaneshModal">
                            <i class="bx bx-plus"></i>
                        </button>
                    </div>
                </div>

                {{-- حداقل تحصیلات --}}
                <div class="col-sm-4">
                    <div class="input-group">
                        <label class="input-group-text bg-gray-300" for="min_education_id">حداقل تحصیلات</label>
                        <select id="min_education_id" name="min_education_id" class="form-select select2" required>
                            <option value="" selected disabled>انتخاب کنید . . .</option>
                        </select>
                        <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                            data-bs-target="#minEducationModal">
                            <i class="bx bx-plus"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row">

                {{-- فایل‌ها --}}
                <div class="divider divider-dashed pt-3 pb-3">
                    <div class="divider-text">آپلود فایل</div>
                </div>

                <div class="col-sm-6">
                    <div class="custom-file-upload">
                        <label for="image_path" class="upload-button">آپلود تصویر</label>
                        <input type="file" id="image_path" name="image_path" class="custom-file-input"
                            style="display: none;">
                        <span class="file-count">فایلی انتخاب نشده</span>
                    </div>
                    <div class="w-100 rounded" id="image-preview"></div>
                </div>

                <div class="col-sm-6">
                    <div class="custom-file-upload">
                        <label for="standard_file" class="upload-button">آپلود فایل استاندارد</label>
                        <input type="file" id="standard_file" name="standard_file" class="custom-file-input"
                            style="display: none;" accept=".pdf,.doc,.docx">
                        <span class="file-count">فایلی انتخاب نشده</span>
                    </div>
                    <div class="w-100 rounded" id="file-preview"></div>
                </div>

                {{-- دکمه ثبت --}}
                <div class="col-sm-12 my-4">
                    <button type="submit" class="btn btn-primary" name="action" value="0"
                        id="form-submit-btn">ذخیره</button>
                    <button type="submit" class="btn btn-outline-primary ms-3" name="action" value="1"
                        id="form-submit-btn">ذخیره و خروج</button>
                </div>
            </div>

        </form>
    </div>
    <!-- مدال نوع شغل -->
    <div class="modal fade" id="jobtypeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title secondary-font" id="exampleModalLabel1">مدیریت نوع شغل ها</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalCenter-jobtype">
                            نوع شغل جدید
                            <i class="bx bx-plus ms-2"></i>
                        </button>
                    </div>
                    <div class="row">
                        <div class="card-datatable table-responsive pt-0 p-3">
                            <table class="dt-select-table jobTypes table">
                                <thead>
                                    <tr>
                                        {{-- filled with ajax --}}
                                    </tr>
                                </thead>
                            </table>
                            <div id="bulk-actions-jobtype" class="">
                                <button id="bulk-delete-jobtype" class="btn btn-danger" disabled>حذف انتخابی‌ها</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit -->
    <div class="modal fade" id="modalEditJobtype" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title secondary-font" id="modalEditJobtypeTitle">ویرایش نوع شغل</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" class="add-new-record pt-0 row g-2 px-3"
                        id="form-edit-record-jobtype">
                        @csrf
                        <div class="col-sm-12">
                            <input type="hidden" id="id" class="form-control" name="id">
                        </div>
                        <div class="col-sm-12">
                            <div class="custom-input-group">
                                <input type="text" id="name" class="form-control" name="name">
                                <label class="form-label" for="name">نام نوع شغل</label>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ذخیره</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal create -->
    <div class="modal fade" id="modalCenter-jobtype" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title secondary-font" id="modalCenter-jobtypeTitle">نوع شغل جدید</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-toggle="modal"
                        data-bs-target="#jobtypeModal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.jobtype.store') }}" method="post"
                        class="add-new-record pt-0 row g-2 mt-3 px-3" id="form-add-new-jobtype">
                        <div class="col-sm-12">
                            <div class="custom-input-group">
                                <input type="text" id="name" class="form-control" name="name">
                                <label class="form-label" for="name">نام نوع شغل</label>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ثبت</button>
                            <button type="submit" class="btn btn-outline-primary data-submit me-sm-3 me-1"
                                data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#jobtypeModal">ثبت و
                                خروج</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- مدال نوع کار و دانش --}}
    <div class="modal fade" id="kardaneshModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title secondary-font" id="exampleModalLabel1">مدیریت نوع کار و دانش ها</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalCenter_kardanesh">
                            نوع کاردانش جدید
                            <i class="bx bx-plus ms-2"></i>
                        </button>
                    </div>
                    <div class="row">
                        <div class="card-datatable table-responsive pt-0 p-3">
                            <table class="dt-select-table kardanesh table">
                                <thead>
                                    <tr>
                                        {{-- filled with ajax --}}
                                    </tr>
                                </thead>
                            </table>
                            <div id="bulk-actions-kardanesh" class="">
                                <button id="bulk-delete-kardanesh" class="btn btn-danger" disabled>حذف انتخابی‌ها</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title secondary-font" id="modalEditTitle">ویرایش نوع کار و دانش</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" class="add-new-record pt-0 row g-2 px-3"
                        id="form-edit-record-kardanesh">
                        @csrf
                        <div class="col-sm-12">
                            <input type="hidden" id="id" class="form-control" name="id">
                        </div>
                        <div class="col-sm-12">
                            <div class="custom-input-group">
                                <input type="text" id="name" class="form-control" name="name">
                                <label class="form-label" for="name">نام نوع کار و دانش</label>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ذخیره</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal create -->
    <div class="modal fade" id="modalCenter_kardanesh" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title secondary-font" id="modalCenter_kardaneshTitle">نوع کاردانش جدید</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-toggle="modal"
                        data-bs-target="#kardaneshModal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" class="add-new-record pt-0 row g-2 mt-3 px-3"
                        id="form-add-new-kardanesh">
                        <div class="col-sm-12">
                            <div class="custom-input-group">
                                <input type="text" id="name" class="form-control" name="name">
                                <label class="form-label" for="name">نوع کاردانش</label>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ثبت</button>
                            <button type="submit" class="btn btn-outline-primary data-submit me-sm-3 me-1"
                                data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#kardaneshModal">ثبت و
                                خروج</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- مدال حداقل تحصیلات --}}
    <div class="modal fade" id="minEducationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title secondary-font" id="exampleModalLabel1">مدیریت حداقل تحصیلات ها</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalCenter_minEducation">
                            نوع کاردانش جدید
                            <i class="bx bx-plus ms-2"></i>
                        </button>
                    </div>
                    <div class="row">
                        <div class="card-datatable table-responsive pt-0 p-3">
                            <table class="dt-select-table minEducation table">
                                <thead>
                                    <tr>
                                        {{-- filled with ajax --}}
                                    </tr>
                                </thead>
                            </table>
                            <div id="bulk-actions-minEducation" class="">
                                <button id="bulk-delete-minEducation" class="btn btn-danger" disabled>حذف
                                    انتخابی‌ها</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit_minEducation" tabindex="1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title secondary-font" id="modalEditTitle">ویرایش حداقل تحصیلات</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" class="add-new-record pt-0 row g-2 px-3"
                        id="form-edit-record-minEducation">
                        @csrf
                        <div class="col-sm-12">
                            <input type="hidden" id="id" class="form-control" name="id">
                        </div>
                        <div class="col-sm-12">
                            <div class="custom-input-group">
                                <input type="text" id="name" class="form-control" name="name">
                                <label class="form-label" for="name">نام حداقل تحصیلات</label>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ذخیره</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal create -->
    <div class="modal fade" id="modalCenter_minEducation" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title secondary-font" id="modalCenter_minEducationTitle">حداقل تحصیلات جدید</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-toggle="modal"
                        data-bs-target="#minEducationModal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" class="add-new-record pt-0 row g-2 mt-3 px-3"
                        id="form-add-new-minEducation">
                        <div class="col-sm-12">
                            <div class="custom-input-group">
                                <input type="text" id="name" class="form-control" name="name">
                                <label class="form-label" for="name">حداقل تحصیلات</label>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ثبت</button>
                            <button type="submit" class="btn btn-outline-primary data-submit me-sm-3 me-1"
                                data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#minEducationModal">ثبت و
                                خروج</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/select2/i18n/fa.js') }}"></script>
    <script src="{{ asset('admin/assets/js/validation.js') }}"></script>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const fieldId = urlParams.get("field_id");

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
        // تابع removeFile برای حذف پیش‌نمایش تصویر
        function removeFile(button) {
            // پیدا کردن div والد که شامل عکس، نام فایل و دکمه است
            const previewDiv = button.closest('.mb-2.mt-3.border.bg-white.p-2.rounded');
            if (previewDiv) {
                previewDiv.remove();
            }

            // مهم: همچنین باید مقدار فیلد ورودی فایل را ریست کنید تا کاربر بتواند دوباره همان فایل را انتخاب کند
            const fileInput = document.getElementById('image_path');
            if (fileInput) {
                fileInput.value = '';
            }
            $("#image_path").siblings('.file-count').text('فایلی انتخاب نشده');
        }
        // پیش‌نمایش تصویر جدید
        document.getElementById('image_path').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('image-preview');

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    let sizeInKB = (file.size / 1024).toFixed(1);
                    preview.innerHTML = `
                    <div class="d-flex align-items-center justify-content-between mb-2 mt-3 border bg-white p-2 rounded">
                        <div class="d-flex align-items-center">
                            <img src="${URL.createObjectURL(file)}" alt="تصویر" width="80" class="me-3 rounded">
                            <div class="me-3">
                                <div>${file.name}</div>
                                <small class="text-muted">${sizeInKB} KB</small>
                            </div>
                        </div>
                        <button type="button" class="btn btn-label-danger btn-sm rounded-3 p-1" onclick="removeFile(this)">
                            <i class="bx bx-x"></i>
                            </button>
                    </div>
                    `;
                };
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '';
            }
        });
        // پیش‌نمایش فایل جدید
        function removeFilePdf(button) {
            // پیدا کردن div والد که شامل عکس، نام فایل و دکمه است
            const previewDiv = button.closest('.mb-2.mt-3.border.bg-white.p-2.rounded');
            if (previewDiv) {
                previewDiv.remove();
            }

            // مهم: همچنین باید مقدار فیلد ورودی فایل را ریست کنید تا کاربر بتواند دوباره همان فایل را انتخاب کند
            const fileInput = document.getElementById('standard_file');
            if (fileInput) {
                fileInput.value = '';
            }
            $("#standard_file").siblings('.file-count').text('فایلی انتخاب نشده');
        }
        document.getElementById('standard_file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('file-preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    let sizeInKB = (file.size / 1024).toFixed(1);
                    preview.innerHTML = `
                    <div class="d-flex align-items-center justify-content-between mb-2 mt-3 border bg-white p-2 rounded">
                        <div class="d-flex align-items-center">
                            <div><i class="bx bxs-file-pdf text-danger" style="font-size: 50px;"></i></div>
                            <div class="me-3">
                                <div>${file.name}</div>
                                <small class="text-muted">${sizeInKB} KB</small>
                            </div>
                        </div>
                        <button type="button" class="btn btn-label-danger btn-sm rounded-3 p-1" onclick="removeFilePdf(this)">
                            <i class="bx bx-x"></i>
                            </button>
                    </div>
                    `;
                };
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '';
            }
        });

        // فرم افزودن حرفه جدید
        initOffcanvasForm({
            formId: "form-add-new-record",
            triggerSelector: ".create-new",
            fields: fieldId ? {
                name: {
                    label: "نام حرفه",
                    required: true,
                    type: "text",
                },
                field_id: {
                    type: "hidden",
                    value: fieldId,
                    required: true,
                },
                new_standard_code: {
                    label: "کد استاندارد ایسکو",
                    type: "text",
                    required: true,
                    pattern: "^\\d{15}$",

                },
                old_standard_code: {
                    label: "کد استاندارد قدیم",
                    type: "text",
                },
                theory_hour: {
                    label: "ساعت تئوری",
                    required: true,
                    type: "number",
                    min: 0,
                },
                theory_minute: {
                    label: "دقیقه تئوری",
                    required: true,
                    type: "number",
                    min: 0,
                },
                practice_hour: {
                    label: "ساعت عملی",
                    type: "number",
                    min: 0,
                },
                practice_minute: {
                    label: "دقیقه عملی",
                    type: "number",
                    min: 0,
                },
                project_hour: {
                    label: "ساعت پروژه",
                    type: "number",
                    min: 0,
                },
                project_minute: {
                    label: "دقیقه پروژه",
                    type: "number",
                    min: 0,
                },
                internship_hour: {
                    label: "ساعت کارورزی",
                    type: "number",
                    min: 0,
                },
                internship_minute: {
                    label: "دقیقه کارورزی",
                    type: "number",
                    min: 0,
                },
                total_hour: {
                    label: "جمع کل ساعت",
                    type: "number",
                    min: 0,
                },
                total_minute: {
                    label: "جمع کل دقیقه",
                    type: "number",
                    min: 0,
                },
                education_level: {
                    label: "حداقل تحصیلات ورودی",
                    type: "text",
                },
                kardanesh_id: {
                    label: "رشته کاردانش",
                    type: "select",
                    options: [], // بعداً با Ajax پر می‌شود
                },
                jobtype_id: {
                    label: "نوع شغل",
                    type: "select",
                    options: [], // بعداً با Ajax پر می‌شود
                },
                trainer_qualification: {
                    label: "صلاحیت حرفه‌ای مربی",
                    type: "text",
                },
                prerequisites: {
                    label: "پیش نیاز",
                    type: "text",
                },
                draft_date: {
                    label: "تاریخ تدوین",
                    type: "date",
                },
                image_path: {
                    label: "تصویر حرفه",
                    type: "file",
                },
                standard_file: {
                    label: "فایل استاندارد",
                    type: "file",
                },
            } : {
                name: {
                    label: "نام حرفه",
                    required: true,
                    type: "text",
                },
                field_id: {
                    label: "انتخاب رشته",
                    required: true,
                    type: "select",
                    options: [],
                },
                old_standard_code: {
                    label: "کد استاندارد قدیم",
                    type: "text",
                },
                new_standard_code: {
                    label: "کد استاندارد جدید",
                    required: true,
                    type: "text",
                    pattern: "^\\d{15}$",
                },
                theory_hour: {
                    label: "ساعت تئوری",
                    required: true,
                    type: "number",
                    min: 0,
                },
                theory_minute: {
                    label: "دقیقه تئوری",
                    required: true,
                    type: "number",
                    min: 0,
                },
                practice_hour: {
                    label: "ساعت عملی",
                    type: "number",
                    min: 0,
                },
                practice_minute: {
                    label: "دقیقه عملی",
                    type: "number",
                    min: 0,
                },
                project_hour: {
                    label: "ساعت پروژه",
                    type: "number",
                    min: 0,
                },
                project_minute: {
                    label: "دقیقه پروژه",
                    type: "number",
                    min: 0,
                },
                internship_hour: {
                    label: "ساعت کارورزی",
                    type: "number",
                    min: 0,
                },
                internship_minute: {
                    label: "دقیقه کارورزی",
                    type: "number",
                    min: 0,
                },
                total_hour: {
                    label: "جمع کل ساعت",
                    type: "number",
                    min: 0,
                },
                total_minute: {
                    label: "جمع کل دقیقه",
                    type: "number",
                    min: 0,
                },
                education_level: {
                    label: "حداقل تحصیلات ورودی",
                    type: "text",
                },
                kardanesh_id: {
                    label: "رشته کاردانش",
                    type: "select",
                    options: [],
                },
                jobtype_id: {
                    label: "نوع شغل",
                    type: "select",
                    options: [],
                },
                trainer_qualification: {
                    label: "صلاحیت حرفه‌ای مربی",
                    type: "text",
                },
                prerequisites: {
                    label: "پیش نیاز",
                    type: "text",
                },
                draft_date: {
                    label: "تاریخ تدوین",
                    type: "date",
                },
                image_path: {
                    label: "تصویر حرفه",
                    type: "file",
                },
                standard_file: {
                    label: "فایل استاندارد",
                    type: "file",
                },
            },
            onSubmit: function(values) {
                const formData = new FormData();
                for (let key in values) {
                    formData.append(key, values[key]);
                }
                formData.append(
                    "_token",
                    $('meta[name="csrf-token"]').attr("content"),
                );

                $.ajax({
                    url: "/admin2/professions/store",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        console.log(res);
                        if (values.action == 1) {
                            window.location.href = "{{ route('admin.professions.index') }}";
                        }
                        toastr.success(res.message);
                    },
                    fail: function(ex) {
                        toastr.error(ex.responseJSON.message);
                    },
                }).fail(function(xhr) {
                    toastr.error(xhr.responseJSON.message);
                });
            },
        });

        const submitButton = document.getElementById(
            "submit-profession-form",
        );
        const submitBtn = document.getElementById("form-submit-btn");
        if (submitButton && submitBtn) {
            submitButton.addEventListener("click", function() {
                // در غیر اینصورت مستقیم submit کن
                submitBtn.click();
            });
        }

        $(document).ready(function() {
            select2 = $('.select2');
            if (select2.length) {
                select2.each(function() {
                    var $this = $(this);
                    $this.wrap('<div class="position-relative flex-grow-1"></div>').select2({
                        placeholder: 'انتخاب کنید . . .',
                        dropdownParent: $this.parent()
                    });
                });
            }

            // تابعی برای محاسبه و نمایش زمان کل
            function calculateTotalTime() {
                let totalMinutes = 0;
                let totalHours = 0;

                // محاسبه زمان تئوری
                let theoryMinutes = parseInt($('#theory_minute').val()) || 0;
                let theoryHours = parseInt($('#theory_hour').val()) || 0;
                totalMinutes += theoryMinutes;
                totalHours += theoryHours;

                // محاسبه زمان عملی
                let practiceMinutes = parseInt($('#practice_minute').val()) || 0;
                let practiceHours = parseInt($('#practice_hour').val()) || 0;
                totalMinutes += practiceMinutes;
                totalHours += practiceHours;

                // محاسبه زمان پروژه
                let projectMinutes = parseInt($('#project_minute').val()) || 0;
                let projectHours = parseInt($('#project_hour').val()) || 0;
                totalMinutes += projectMinutes;
                totalHours += projectHours;

                // محاسبه زمان کارورزی
                let internshipMinutes = parseInt($('#internship_minute').val()) || 0;
                let internshipHours = parseInt($('#internship_hour').val()) || 0;
                totalMinutes += internshipMinutes;
                totalHours += internshipHours;

                // تبدیل دقایق اضافه به ساعت
                totalHours += Math.floor(totalMinutes / 60);
                totalMinutes = totalMinutes % 60;

                // نمایش نتیجه در فیلدهای زمان کل
                $('#total_minute').val(totalMinutes);
                $('#total_hour').val(totalHours);
            }

            // رویداد 'input' برای تمام فیلدهای ساعت و دقیقه
            // این رویداد زمانی فعال میشه که مقدار هر اینپوت تغییر کنه
            $('#theory_minute, #theory_hour, #practice_minute, #practice_hour, #project_minute, #project_hour, #internship_minute, #internship_hour')
                .on('input', function() {
                    calculateTotalTime();
                });

            // محاسبه اولیه زمان کل هنگام بارگذاری صفحه
            // اگر مقادیر پیش‌فرض وجود داره، این محاسبه لازم میشه
            calculateTotalTime();

        });
        $(document).on('change', '.custom-file-input', function() {
            let fileCount = this.files.length;
            let fileCountText = fileCount === 0 ? 'فایلی انتخاب نشده' : fileCount + ' فایل انتخاب شده';
            // عنصر نمایشی که کنار این اینپوت هست رو پیدا کن
            $(this).siblings('.file-count').text(fileCountText);
        });
    </script>

    {{-- search --}}
    <script>
        $(document).ready(function() { // استفاده از jQuery برای اطمینان از بارگذاری DOM

            const searchInput = $('#search'); // المنت جستجو با استفاده از jQuery
            const searchResultDiv = $('#searchResult'); // المنت نمایش نتایج (با فرض داشتن ID)

            // بررسی وجود المنت جستجو
            if (searchInput.length === 0) {
                console.error("Element with ID 'search' not found!");
                return; // اگر المنت پیدا نشد، از ادامه کد جلوگیری کن
            }

            // اگر المنت نتایج هم لازم هست، بررسی کن
            if (searchResultDiv.length === 0) {
                console.warn("Element with ID 'searchResult' not found. Results might not display correctly.");
                // میتونی اینجا هم return کنی اگر این المنت حیاتیه
            }

            let timer = null; // تعریف timer در بیرون تابع برای جلوگیری از ایجاد چند timer همزمان

            searchInput.on("input", function(e) {
                const queryValue = $(this).val().trim(); // گرفتن مقدار input و حذف فاصله های اضافی

                // پاک کردن تایمر قبلی اگر وجود دارد
                if (timer) {
                    clearTimeout(timer);
                }

                if (queryValue !== "") {
                    // راه اندازی تایمر جدید
                    timer = setTimeout(() => {
                            $.ajax({
                                url: "/admin2/professions/search",
                                type: "get",
                                data: {
                                    q: queryValue, // ارسال مقدار جستجو
                                },
                                success: function(res) {
                                    console.log(res);

                                    if (res.success) {
                                        // اگر نتیجه ای از سرچ برگشت و باید نمایش داده بشه
                                        if (res.data && searchResultDiv.length > 0) {
                                            let html = '';
                                            // اینجا باید منطق نمایش نتایج رو اضافه کنی

                                            html += `
                                            <div class="d-flex justify-content-between align-items-center gap-3 w-100">
                                                <span>
                                                    نام: <strong>${res.data.name}</strong>
                                                </span>
                                                <span>
                                                    کد ایسکو: <strong>${res.data.new_standard_code}</strong>
                                                </span>
                                                <a href="#" class="btn btn-icon btn-primary">
                                                    <div class="bx bx-edit"></div>
                                                </a>
                                            </div>
                                            `;

                                            searchResultDiv.html(html);
                                            searchResultDiv.show();
                                            console.log("Search results:", res.data);
                                        }
                                    } else {
                                        toastr.error(res.message);
                                    }
                                },
                                error: function(err) {
                                    toastr.error('خطا در ارتباط با سرور');
                                },
                            });
                        },
                        500
                    ); // تاخیر 500 میلی ثانیه (نیم ثانیه) برای جلوگیری از درخواست های زیاد هنگام تایپ سریع
                } else {
                    // اگر فیلد خالی شد، نتایج رو پاک کن
                    if (searchResultDiv.length > 0) {
                        searchResultDiv.html(""); // پاک کردن نتایج جستجو
                        searchResultDiv.hide();

                    }
                    // اگر لازمه جدول رو هم به حالت اول برگردونی
                }
            });

        }); // پایان document.ready
    </script>

    {{-- job types --}}
    <script>
        jobTypes = $(".jobTypes");
        dt_jobtype = jobTypes.DataTable({
            ajax: "/admin2/jobtype",
            columns: [{
                    data: "",
                    title: ""
                }, // ستونی که برای responsive استفاده میشه
                {
                    data: "id",
                    title: "شناسه"
                },
                {
                    data: "id",
                    visible: false
                }, // ستون مخفی برای sort
                {
                    data: "id",
                    title: "ردیف"
                },
                {
                    data: "name",
                    title: "نام شغل"
                },
                {
                    data: "",
                    title: "عملیات"
                }, // ستون آخر برای دکمه‌ها
            ],
            columnDefs: [{
                    // For Responsive
                    className: "control",
                    orderable: false,
                    searchable: false,
                    responsivePriority: 2,
                    targets: 0,
                    render: function(data, type, full, meta) {
                        return "";
                    },
                },
                {
                    targets: 3, // ستون شماره ردیف (مطابق ایندکس خودت)
                    data: null,
                    title: "ردیف",
                    orderable: true,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return meta.row + 1; // شماره ردیف
                    },
                },
                {
                    targets: 1,
                    orderable: false,
                    render: function() {
                        return '<input type="checkbox" class="dt-checkboxes form-check-input mt-0 align-middle row-check">';
                    },
                    checkboxes: {
                        selectRow: false, // فقط با چک‌باکس، نه روی کل ردیف
                        selectAllRender: '<input type="checkbox" class="form-check-input mt-0 align-middle">',
                    },
                    responsivePriority: 4,
                },
                {
                    targets: 2,
                    searchable: false,
                    visible: false,
                },
                {
                    responsivePriority: 1,
                    targets: 4,
                },
                {
                    targets: -1,
                    title: "عملیات",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `
                                <button data-id="${full.id}" class="btn btn-sm btn-icon btn-primary item-edit-jobtype">
                                <i class="bx bxs-edit"></i>
                                </button>

                                <button class="btn btn-sm btn-icon btn-danger item-delete" data-id="${full.id}">
                                <i class="bx bxs-trash"></i>
                                </button>
                                `;
                    },
                },
            ],
            order: [
                [2, "desc"]
            ],
            dom: '<"card-header flex-column flex-md-row"<"head-label d-flex justify-content-between align-items-center text-center"><"dt-action-buttons text-end primary-font pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t' +
                "<'row d-flex align-items-center justify-content-between'<'col-md-4'<'bulk-holder'>><'col-md-8 d-flex justify-content-between'i p>>",
            displayLength: 10,
            lengthMenu: [10, 25, 50, 75, 100],
            buttons: [],
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function(row) {
                            var data = row.data();
                            return "جزئیات " + data["full_name"];
                        },
                    }),
                    type: "column",
                    renderer: function(api, rowIdx, columns) {
                        var data = $.map(columns, function(col, i) {
                            return col.title !==
                                "" // ? Do not show row in modal popup if title is blank (for check box)
                                ?
                                '<tr data-dt-row="' +
                                col.rowIndex +
                                '" data-dt-column="' +
                                col.columnIndex +
                                '">' +
                                "<td>" +
                                col.title +
                                ":" +
                                "</td> " +
                                "<td>" +
                                col.data +
                                "</td>" +
                                "</tr>" :
                                "";
                        }).join("");

                        return data ?
                            $('<table class="table"/><tbody />').append(
                                data,
                            ) :
                            false;
                    },
                },
            },
            select: {
                // Select style
                style: "multi",
            },
        });
        $("#bulk-actions-jobtype").appendTo(".bulk-holder");
        $("div.head-label").html(
            '<h5 class="card-title mb-0">لیست نوع شغل ها</h5>' +
            '<small class="text-muted ms-2">( 0 رکورد )</small>'
        );
        dt_jobtype.on('change', '.row-check', function() {
            const row = dt_jobtype.row($(this).closest('tr'));

            if (this.checked) {
                row.select();
            } else {
                row.deselect();
            }
        });
        dt_jobtype.on('user-select', function(e, dt, type, cell, originalEvent) {
            if (!$(originalEvent.target).hasClass('row-check')) {
                e.preventDefault();
            }
        });
        dt_jobtype.on('draw', function() {
            updateJobtypeSelectOptions();
        });
        // add new record-------------------------------------------------------------------------------------------------------------
        initOffcanvasForm({
            formId: "form-add-new-jobtype",
            // offcanvasId: "add-new-record",
            triggerSelector: ".create-new",
            fields: {
                name: {
                    label: "نام نوع شغل",
                    required: true,
                    type: "text",
                },
            },
            onSubmit: function(values) {
                console.log("Form Data:", values);

                // اضافه کردن CSRF token
                values._token = $('meta[name="csrf-token"]').attr(
                    "content",
                );

                // ارسال Ajax
                $.post("/admin2/jobtype/store", values, function(res) {
                    console.log("Server Response:", res);
                    // offCanvasEl.hide();

                    dt_jobtype.ajax.reload(); // اگر میخوای جدول بروز بشه
                });
            },
        });
        // delete one item----------------------------------------------------------------------------------------------------------------
        dt_jobtype.on("click", ".item-delete", function() {
            const id = $(this).data("id");

            if (!id) return;
            Swal.fire({
                title: `آیا از حذف این رکورد مطمئن هستید؟`,
                text: "این عملیات غیرقابل بازگشت است!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "بله، حذف کن!",
                cancelButtonText: "انصراف",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/admin2/jobtype/delete/" + id,
                        type: "DELETE",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr(
                                "content",
                            ),
                        },
                        success: function(res) {
                            if (res.success) {
                                toastr.success(res.message);
                            } else {
                                toastr.error(res.message);
                            }

                            dt_jobtype.ajax.reload(null, false);
                            $("#bulk-actions-jobtype #bulk-delete-jobtype").prop("disabled",
                                true);
                        },
                        error: function(err) {
                            toastr.error(err.message);

                            console.error(err);
                        },
                    });
                }
            });
        });

        // delete selected items----------------------------------------------------------------------------------------------------------
        const btnBulk = $("#bulk-actions-jobtype");
        if (btnBulk) {
            // وقتی رکورد انتخاب شد
            dt_jobtype.on("select", function(e, dt, type, indexes) {
                toggleBulkActions();
            });

            // وقتی رکورد از انتخاب خارج شد
            dt_jobtype.on("deselect", function(e, dt, type, indexes) {
                toggleBulkActions();
            });

            // تابع برای نمایش / مخفی کردن باکس عملیات
            function toggleBulkActions() {
                const selected = dt_jobtype.rows({
                    selected: true
                }).count();
                if (selected > 0) {
                    // $("#bulk-actions-jobtype").removeClass("d-none");
                    $("#bulk-actions-jobtype #bulk-delete-jobtype").prop("disabled", false);
                } else {
                    $("#bulk-actions-jobtype #bulk-delete-jobtype").prop("disabled", true);
                }
            }

            // گرفتن ID ها
            function getSelectedIds() {
                return dt_jobtype
                    .rows({
                        selected: true
                    })
                    .data()
                    .pluck("id")
                    .toArray();
            }

            btnBulk.on("click", function() {
                const ids = getSelectedIds();

                if (ids.length === 0) {
                    Swal.fire({
                        icon: "warning",
                        title: "هیچ رکوردی انتخاب نشده!",
                        confirmButtonText: "باشه",
                    });
                    return;
                }

                Swal.fire({
                    title: `آیا از حذف ${ids.length} رکورد مطمئن هستید؟`,
                    text: "این عملیات غیرقابل بازگشت است!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "بله، حذف کن!",
                    cancelButtonText: "انصراف",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin2/jobtype/bulk-delete",
                            type: "POST",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr(
                                    "content",
                                ),
                                ids: ids,
                            },
                            success: function(res) {
                                if (res.success) {
                                    toastr.success(res.message);
                                } else {
                                    toastr.error(res.message);
                                }

                                dt_jobtype.ajax.reload(null, false);
                                $("#bulk-actions-jobtype #bulk-delete-jobtype").prop("disabled",
                                    true);
                            },
                            error: function(err) {
                                toastr.error(err.message);

                                console.error(err);
                            },
                        });
                    }
                });
            });
        }

        // edit with modal -----------------------------------------------------------------------------------------------------------
        $(document).on("click", ".item-edit-jobtype", function() {
            const id = $(this).data("id");

            // لودینگ یا غیر فعال‌کردن فرم قبل از درخواست (اختیاری)
            $("#modalEditJobtype .modal-body").addClass("opacity-50");
            // نمایش مودال
            $("#modalEditJobtype").modal("show");

            $.ajax({
                url: "/admin2/jobtype/" + id,
                method: "GET",
                success: function(res) {
                    // فرض می‌کنیم سرور دیتا رو در res.data برمی‌گردونه
                    $("#modalEditJobtype #id").val(res.data.id);
                    $("#modalEditJobtype #name").val(res.data.name);
                    $("#modalEditJobtype #name").parent().addClass("filled");

                    // برگشتن فرم به حالت عادی
                    $("#modalEditJobtype .modal-body").removeClass("opacity-50");
                },
                error: function() {
                    toastr.error('خطا در ارتباط با سرور');
                }
            });

            initOffcanvasForm({
                formId: "form-edit-record-jobtype",
                // offcanvasId: "add-new-record",
                triggerSelector: ".create-new",
                fields: {
                    name: {
                        label: "نام نوع شغل",
                        required: true,
                        type: "text",
                    },
                    id: {
                        label: "ایدی نوع شغل",
                        required: true,
                        type: "hidden",
                    },
                },
                onSubmit: function(values) {
                    console.log("Form Data:", values);

                    // اضافه کردن CSRF token
                    values._token = $('meta[name="csrf-token"]').attr(
                        "content",
                    );

                    // ارسال Ajax
                    $.post("/admin2/jobtype/update", values, function(res) {
                        if (res.success) {
                            toastr.success(res.message);
                        } else {
                            toastr.error(res.message);
                        }
                        // offCanvasEl.hide();

                        dt_jobtype.ajax.reload(); // اگر میخوای جدول بروز بشه
                        $("#modalEditJobtype").modal("hide");

                    }).fail(function(xhr) {
                        toastr.error("نوع شغل با این نام وجود دارد.");
                    });
                },
            });
        });

        function updateJobtypeSelectOptions() {
            const $selectInput = $('#jobtype_id'); // ID سلکت اینپوت خود را اینجا قرار دهید

            $.ajax({
                url: "/admin2/jobtype", // آدرسی که اطلاعات سلکت را برمی‌گرداند
                type: "GET",
                dataType: "json",
                success: function(response) {
                    // ۱. خالی کردن آپشن‌های قبلی (به جز گزینه اول که مثلا "انتخاب کنید" است)
                    $selectInput.find('option:not(:first)').remove();

                    // ۲. پر کردن آپشن‌های جدید
                    $.each(response.data, function(index, item) {
                        $selectInput.append(
                            $('<option>', {
                                value: item.id,
                                text: item.name
                            })
                        );
                    });

                    // ۳. اگر از کتابخانه‌هایی مثل Select2 استفاده می‌کنید، باید آن را رفرش کنید:
                    // $selectInput.trigger('change.select2');
                },
                error: function(err) {
                    console.error("خطا در دریافت آپشن‌ها:", err);
                }
            });
        }
    </script>

    {{-- kardaneshs --}}
    <script>
        kardanesh = $(".kardanesh");
        dt_kardanesh = kardanesh.DataTable({
            ajax: "/admin2/kardanesh",
            columns: [{
                    data: "",
                    title: ""
                }, // ستونی که برای responsive استفاده میشه
                {
                    data: "id",
                    title: "شناسه"
                },
                {
                    data: "id",
                    visible: false
                }, // ستون مخفی برای sort
                {
                    data: "id",
                    title: "ردیف"
                },
                {
                    data: "name",
                    title: "نام شغل"
                },
                {
                    data: "",
                    title: "عملیات"
                }, // ستون آخر برای دکمه‌ها
            ],
            columnDefs: [{
                    // For Responsive
                    className: "control",
                    orderable: false,
                    searchable: false,
                    responsivePriority: 2,
                    targets: 0,
                    render: function(data, type, full, meta) {
                        return "";
                    },
                },
                {
                    targets: 3, // ستون شماره ردیف (مطابق ایندکس خودت)
                    data: null,
                    title: "ردیف",
                    orderable: true,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return meta.row + 1; // شماره ردیف
                    },
                },
                {
                    targets: 1,
                    orderable: false,
                    render: function() {
                        return '<input type="checkbox" class="dt-checkboxes form-check-input mt-0 align-middle row-check">';
                    },
                    checkboxes: {
                        selectRow: false, // فقط با چک‌باکس، نه روی کل ردیف
                        selectAllRender: '<input type="checkbox" class="form-check-input mt-0 align-middle">',
                    },
                    responsivePriority: 4,
                },
                {
                    targets: 2,
                    searchable: false,
                    visible: false,
                },
                {
                    responsivePriority: 1,
                    targets: 4,
                },
                {
                    targets: -1,
                    title: "عملیات",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `
                                <button data-id="${full.id}" class="btn btn-sm btn-icon btn-primary item-edit-kardanesh">
                                <i class="bx bxs-edit"></i>
                                </button>

                                <button class="btn btn-sm btn-icon btn-danger item-delete-kardanesh" data-id="${full.id}">
                                <i class="bx bxs-trash"></i>
                                </button>
                                `;
                    },
                },
            ],
            order: [
                [2, "desc"]
            ],
            dom: '<"card-header flex-column flex-md-row"<"head-label head-label-kardanesh d-flex justify-content-between align-items-center text-center"><"dt-action-buttons text-end primary-font pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t' +
                "<'row d-flex align-items-center justify-content-between'<'col-md-4'<'bulk-holder-kardanesh'>><'col-md-8 d-flex justify-content-between'i p>>",
            displayLength: 10,
            lengthMenu: [10, 25, 50, 75, 100],
            buttons: [],
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function(row) {
                            var data = row.data();
                            return "جزئیات " + data["full_name"];
                        },
                    }),
                    type: "column",
                    renderer: function(api, rowIdx, columns) {
                        var data = $.map(columns, function(col, i) {
                            return col.title !==
                                "" // ? Do not show row in modal popup if title is blank (for check box)
                                ?
                                '<tr data-dt-row="' +
                                col.rowIndex +
                                '" data-dt-column="' +
                                col.columnIndex +
                                '">' +
                                "<td>" +
                                col.title +
                                ":" +
                                "</td> " +
                                "<td>" +
                                col.data +
                                "</td>" +
                                "</tr>" :
                                "";
                        }).join("");

                        return data ?
                            $('<table class="table"/><tbody />').append(
                                data,
                            ) :
                            false;
                    },
                },
            },
            select: {
                // Select style
                style: "multi",
            },
        });
        $("#bulk-actions-kardanesh").appendTo(".bulk-holder-kardanesh");
        $("div.head-label-kardanesh").html(
            '<h5 class="card-title mb-0">لیست نوع کار و دانش ها</h5>'
        );
        dt_kardanesh.on('change', '.row-check', function() {
            const row = dt_kardanesh.row($(this).closest('tr'));

            if (this.checked) {
                row.select();
            } else {
                row.deselect();
            }
        });
        dt_kardanesh.on('user-select', function(e, dt, type, cell, originalEvent) {
            if (!$(originalEvent.target).hasClass('row-check')) {
                e.preventDefault();
            }
        });
        dt_kardanesh.on('draw', function() {
            updateKardaneshSelectOptions();
        });
        // add new record-------------------------------------------------------------------------------------------------------------
        initOffcanvasForm({
            formId: "form-add-new-kardanesh",
            // offcanvasId: "add-new-record",
            triggerSelector: ".create-new",
            fields: {
                name: {
                    label: "نام نوع کار و دانش",
                    required: true,
                    type: "text",
                },
            },
            onSubmit: function(values) {
                console.log("Form Data:", values);

                // اضافه کردن CSRF token
                values._token = $('meta[name="csrf-token"]').attr(
                    "content",
                );

                // ارسال Ajax
                $.post("/admin2/kardanesh/store", values, function(res) {
                    console.log("Server Response:", res);
                    // offCanvasEl.hide();

                    dt_kardanesh.ajax.reload(); // اگر میخوای جدول بروز بشه
                });
            },
        });
        // delete one item----------------------------------------------------------------------------------------------------------------
        dt_kardanesh.on("click", ".item-delete-kardanesh", function() {
            const id = $(this).data("id");

            if (!id) return;
            Swal.fire({
                title: `آیا از حذف این رکورد مطمئن هستید؟`,
                text: "این عملیات غیرقابل بازگشت است!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "بله، حذف کن!",
                cancelButtonText: "انصراف",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/admin2/kardanesh/delete/" + id,
                        type: "DELETE",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr(
                                "content",
                            ),
                        },
                        success: function(res) {
                            if (res.success) {
                                toastr.success(res.message);
                            } else {
                                toastr.error(res.message);
                            }

                            dt_kardanesh.ajax.reload(null, false);
                            $("#bulk-actions-kardanesh #bulk-delete-kardanesh").prop("disabled",
                                true);
                        },
                        error: function(err) {
                            toastr.error(err.message);

                            console.error(err);
                        },
                    });
                }
            });
        });

        // delete selected items----------------------------------------------------------------------------------------------------------
        const btnBulkKardanesh = $("#bulk-delete-kardanesh");
        if (btnBulkKardanesh) {
            // وقتی رکورد انتخاب شد
            dt_kardanesh.on("select", function(e, dt, type, indexes) {
                toggleBulkActions();
            });

            // وقتی رکورد از انتخاب خارج شد
            dt_kardanesh.on("deselect", function(e, dt, type, indexes) {
                toggleBulkActions();
            });

            // تابع برای نمایش / مخفی کردن باکس عملیات
            function toggleBulkActions() {
                const selected = dt_kardanesh.rows({
                    selected: true
                }).count();
                if (selected > 0) {
                    // $("#bulk-actions-kardanesh").removeClass("d-none");
                    $("#bulk-actions-kardanesh #bulk-delete-kardanesh").prop("disabled", false);
                } else {
                    $("#bulk-actions-kardanesh #bulk-delete-kardanesh").prop("disabled", true);
                }
            }

            // گرفتن ID ها
            function getSelectedIds() {
                return dt_kardanesh
                    .rows({
                        selected: true
                    })
                    .data()
                    .pluck("id")
                    .toArray();
            }

            btnBulkKardanesh.on("click", function() {
                const ids = getSelectedIds();

                if (ids.length === 0) {
                    Swal.fire({
                        icon: "warning",
                        title: "هیچ رکوردی انتخاب نشده!",
                        confirmButtonText: "باشه",
                    });
                    return;
                }

                Swal.fire({
                    title: `آیا از حذف ${ids.length} رکورد مطمئن هستید؟`,
                    text: "این عملیات غیرقابل بازگشت است!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "بله، حذف کن!",
                    cancelButtonText: "انصراف",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin2/kardanesh/bulk-delete",
                            type: "POST",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr(
                                    "content",
                                ),
                                ids: ids,
                            },
                            success: function(res) {
                                if (res.success) {
                                    toastr.success(res.message);
                                } else {
                                    toastr.error(res.message);
                                }

                                dt_kardanesh.ajax.reload(null, false);
                                $("#bulk-actions-kardanesh #bulk-delete-kardanesh").prop(
                                    "disabled", true);
                            },
                            error: function(err) {
                                toastr.error(err.message);

                                console.error(err);
                            },
                        });
                    }
                });
            });
        }

        // edit with modal -----------------------------------------------------------------------------------------------------------
        $(document).on("click", ".item-edit-kardanesh", function() {
            const id = $(this).data("id");

            // لودینگ یا غیر فعال‌کردن فرم قبل از درخواست (اختیاری)
            $("#modalEdit .modal-body").addClass("opacity-50");
            // نمایش مودال
            $("#modalEdit").modal("show");

            $.ajax({
                url: "/admin2/kardanesh/" + id,
                method: "GET",
                success: function(res) {
                    // فرض می‌کنیم سرور دیتا رو در res.data برمی‌گردونه
                    $("#modalEdit #id").val(res.data.id);
                    $("#modalEdit #name").val(res.data.name);
                    $("#modalEdit #name").parent().addClass("filled");

                    // برگشتن فرم به حالت عادی
                    $("#modalEdit .modal-body").removeClass("opacity-50");
                },
                error: function() {
                    toastr.error('خطا در ارتباط با سرور');
                }
            });

            initOffcanvasForm({
                formId: "form-edit-record-kardanesh",
                // offcanvasId: "add-new-record",
                triggerSelector: ".create-new",
                fields: {
                    name: {
                        label: "نام نوع کار و دانش",
                        required: true,
                        type: "text",
                    },
                    id: {
                        label: "ایدی نوع کار و دانش",
                        required: true,
                        type: "hidden",
                    },
                },
                onSubmit: function(values) {
                    console.log("Form Data:", values);

                    // اضافه کردن CSRF token
                    values._token = $('meta[name="csrf-token"]').attr(
                        "content",
                    );

                    // ارسال Ajax
                    $.post("/admin2/kardanesh/update", values, function(res) {
                        if (res.success) {
                            toastr.success(res.message);
                        } else {
                            toastr.error(res.message);
                        }
                        // offCanvasEl.hide();

                        dt_kardanesh.ajax.reload(); // اگر میخوای جدول بروز بشه
                        $("#modalEdit").modal("hide");

                    }).fail(function(xhr) {
                        toastr.error("نوع کار و دانش با این نام وجود دارد.");
                    });
                },
            });
        });

        function updateKardaneshSelectOptions() {
            const $selectInput = $('#kardanesh_id'); // ID سلکت اینپوت خود را اینجا قرار دهید

            $.ajax({
                url: "/admin2/kardanesh", // آدرسی که اطلاعات سلکت را برمی‌گرداند
                type: "GET",
                dataType: "json",
                success: function(response) {
                    // ۱. خالی کردن آپشن‌های قبلی (به جز گزینه اول که مثلا "انتخاب کنید" است)
                    $selectInput.find('option:not(:first)').remove();

                    // ۲. پر کردن آپشن‌های جدید
                    $.each(response.data, function(index, item) {
                        $selectInput.append(
                            $('<option>', {
                                value: item.id,
                                text: item.name
                            })
                        );
                    });

                    // ۳. اگر از کتابخانه‌هایی مثل Select2 استفاده می‌کنید، باید آن را رفرش کنید:
                    // $selectInput.trigger('change.select2');
                },
                error: function(err) {
                    console.error("خطا در دریافت آپشن‌ها:", err);
                }
            });
        }
    </script>

    {{-- minEducations --}}
    <script>
        minEducation = $(".minEducation");
        dt_minEducation = minEducation.DataTable({
            ajax: "/admin2/mineducations",
            columns: [{
                    data: "",
                    title: ""
                }, // ستونی که برای responsive استفاده میشه
                {
                    data: "id",
                    title: "شناسه"
                },
                {
                    data: "id",
                    visible: false
                }, // ستون مخفی برای sort
                {
                    data: "id",
                    title: "ردیف"
                },
                {
                    data: "name",
                    title: "نام حداقل تحصیلات"
                },
                {
                    data: "",
                    title: "عملیات"
                }, // ستون آخر برای دکمه‌ها
            ],
            columnDefs: [{
                    // For Responsive
                    className: "control",
                    orderable: false,
                    searchable: false,
                    responsivePriority: 2,
                    targets: 0,
                    render: function(data, type, full, meta) {
                        return "";
                    },
                },
                {
                    targets: 3, // ستون شماره ردیف (مطابق ایندکس خودت)
                    data: null,
                    title: "ردیف",
                    orderable: true,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return meta.row + 1; // شماره ردیف
                    },
                },
                {
                    targets: 1,
                    orderable: false,
                    render: function() {
                        return '<input type="checkbox" class="dt-checkboxes form-check-input mt-0 align-middle row-check">';
                    },
                    checkboxes: {
                        selectRow: false, // فقط با چک‌باکس، نه روی کل ردیف
                        selectAllRender: '<input type="checkbox" class="form-check-input mt-0 align-middle">',
                    },
                    responsivePriority: 4,
                },
                {
                    targets: 2,
                    searchable: false,
                    visible: false,
                },
                {
                    responsivePriority: 1,
                    targets: 4,
                },
                {
                    targets: -1,
                    title: "عملیات",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `
                                <button data-id="${full.id}" class="btn btn-sm btn-icon btn-primary item-edit-minEducation">
                                <i class="bx bxs-edit"></i>
                                </button>

                                <button class="btn btn-sm btn-icon btn-danger item-delete-minEducation" data-id="${full.id}">
                                <i class="bx bxs-trash"></i>
                                </button>
                                `;
                    },
                },
            ],
            order: [
                [2, "desc"]
            ],
            dom: '<"card-header flex-column flex-md-row"<"head-label head-label-minEducation d-flex justify-content-between align-items-center text-center"><"dt-action-buttons text-end primary-font pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t' +
                "<'row d-flex align-items-center justify-content-between'<'col-md-4'<'bulk-holder-minEducation'>><'col-md-8 d-flex justify-content-between'i p>>",
            displayLength: 10,
            lengthMenu: [10, 25, 50, 75, 100],
            buttons: [],
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function(row) {
                            var data = row.data();
                            return "جزئیات " + data["full_name"];
                        },
                    }),
                    type: "column",
                    renderer: function(api, rowIdx, columns) {
                        var data = $.map(columns, function(col, i) {
                            return col.title !==
                                "" // ? Do not show row in modal popup if title is blank (for check box)
                                ?
                                '<tr data-dt-row="' +
                                col.rowIndex +
                                '" data-dt-column="' +
                                col.columnIndex +
                                '">' +
                                "<td>" +
                                col.title +
                                ":" +
                                "</td> " +
                                "<td>" +
                                col.data +
                                "</td>" +
                                "</tr>" :
                                "";
                        }).join("");

                        return data ?
                            $('<table class="table"/><tbody />').append(
                                data,
                            ) :
                            false;
                    },
                },
            },
            select: {
                // Select style
                style: "multi",
            },
        });
        $("#bulk-actions-minEducation").appendTo(".bulk-holder-minEducation");
        $("div.head-label-minEducation").html(
            '<h5 class="card-title mb-0">لیست نوع حداقل تحصیلات ها</h5>'
        );
        dt_minEducation.on('change', '.row-check', function() {
            const row = dt_minEducation.row($(this).closest('tr'));

            if (this.checked) {
                row.select();
            } else {
                row.deselect();
            }
        });
        dt_minEducation.on('user-select', function(e, dt, type, cell, originalEvent) {
            if (!$(originalEvent.target).hasClass('row-check')) {
                e.preventDefault();
            }
        });
        dt_minEducation.on('draw', function() {
            updateminEducationSelectOptions();
        });
        // add new record-------------------------------------------------------------------------------------------------------------
        initOffcanvasForm({
            formId: "form-add-new-minEducation",
            // offcanvasId: "add-new-record",
            triggerSelector: ".create-new",
            fields: {
                name: {
                    label: "نام نوع حداقل تحصیلات",
                    required: true,
                    type: "text",
                },
            },
            onSubmit: function(values) {
                console.log("Form Data:", values);

                // اضافه کردن CSRF token
                values._token = $('meta[name="csrf-token"]').attr(
                    "content",
                );

                // ارسال Ajax
                $.post("/admin2/mineducations/store", values, function(res) {
                    console.log("Server Response:", res);
                    // offCanvasEl.hide();

                    dt_minEducation.ajax.reload(); // اگر میخوای جدول بروز بشه
                });
            },
        });
        // delete one item----------------------------------------------------------------------------------------------------------------
        dt_minEducation.on("click", ".item-delete-minEducation", function() {
            const id = $(this).data("id");

            if (!id) return;
            Swal.fire({
                title: `آیا از حذف این رکورد مطمئن هستید؟`,
                text: "این عملیات غیرقابل بازگشت است!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "بله، حذف کن!",
                cancelButtonText: "انصراف",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/admin2/mineducations/delete/" + id,
                        type: "DELETE",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr(
                                "content",
                            ),
                        },
                        success: function(res) {
                            if (res.success) {
                                toastr.success(res.message);
                            } else {
                                toastr.error(res.message);
                            }

                            dt_minEducation.ajax.reload(null, false);
                            $("#bulk-actions-minEducation #bulk-delete-minEducation").prop(
                                "disabled",
                                true);
                        },
                        error: function(err) {
                            toastr.error(err.message);

                            console.error(err);
                        },
                    });
                }
            });
        });

        // delete selected items----------------------------------------------------------------------------------------------------------
        const btnBulkminEducation = $("#bulk-delete-minEducation");
        if (btnBulkminEducation) {
            // وقتی رکورد انتخاب شد
            dt_minEducation.on("select", function(e, dt, type, indexes) {
                toggleBulkActions();
            });

            // وقتی رکورد از انتخاب خارج شد
            dt_minEducation.on("deselect", function(e, dt, type, indexes) {
                toggleBulkActions();
            });

            // تابع برای نمایش / مخفی کردن باکس عملیات
            function toggleBulkActions() {
                const selected = dt_minEducation.rows({
                    selected: true
                }).count();
                if (selected > 0) {
                    // $("#bulk-actions-minEducation").removeClass("d-none");
                    $("#bulk-actions-minEducation #bulk-delete-minEducation").prop("disabled", false);
                } else {
                    $("#bulk-actions-minEducation #bulk-delete-minEducation").prop("disabled", true);
                }
            }

            // گرفتن ID ها
            function getSelectedIds() {
                return dt_minEducation
                    .rows({
                        selected: true
                    })
                    .data()
                    .pluck("id")
                    .toArray();
            }

            btnBulkminEducation.on("click", function() {
                const ids = getSelectedIds();

                if (ids.length === 0) {
                    Swal.fire({
                        icon: "warning",
                        title: "هیچ رکوردی انتخاب نشده!",
                        confirmButtonText: "باشه",
                    });
                    return;
                }

                Swal.fire({
                    title: `آیا از حذف ${ids.length} رکورد مطمئن هستید؟`,
                    text: "این عملیات غیرقابل بازگشت است!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "بله، حذف کن!",
                    cancelButtonText: "انصراف",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin2/mineducations/bulk-delete",
                            type: "POST",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr(
                                    "content",
                                ),
                                ids: ids,
                            },
                            success: function(res) {
                                if (res.success) {
                                    toastr.success(res.message);
                                } else {
                                    toastr.error(res.message);
                                }

                                dt_minEducation.ajax.reload(null, false);
                                $("#bulk-actions-minEducation #bulk-delete-minEducation").prop(
                                    "disabled", true);
                            },
                            error: function(err) {
                                toastr.error(err.message);

                                console.error(err);
                            },
                        });
                    }
                });
            });
        }

        // edit with modal -----------------------------------------------------------------------------------------------------------
        $(document).on("click", ".item-edit-minEducation", function() {
            const id = $(this).data("id");

            // لودینگ یا غیر فعال‌کردن فرم قبل از درخواست (اختیاری)
            $("#modalEdit_minEducation .modal-body").addClass("opacity-50");
            // نمایش مودال
            $("#modalEdit_minEducation").modal("show");

            $.ajax({
                url: "/admin2/mineducations/" + id,
                method: "GET",
                success: function(res) {
                    // فرض می‌کنیم سرور دیتا رو در res.data برمی‌گردونه
                    $("#modalEdit_minEducation #id").val(res.data.id);
                    $("#modalEdit_minEducation #name").val(res.data.name);
                    $("#modalEdit_minEducation #name").parent().addClass("filled");

                    // برگشتن فرم به حالت عادی
                    $("#modalEdit_minEducation .modal-body").removeClass("opacity-50");
                },
                error: function() {
                    toastr.error('خطا در ارتباط با سرور');
                }
            });

            initOffcanvasForm({
                formId: "form-edit-record-minEducation",
                // offcanvasId: "add-new-record",
                triggerSelector: ".create-new",
                fields: {
                    name: {
                        label: "نام نوع حداقل تحصیلات",
                        required: true,
                        type: "text",
                    },
                    id: {
                        label: "ایدی نوع حداقل تحصیلات",
                        required: true,
                        type: "hidden",
                    },
                },
                onSubmit: function(values) {
                    console.log("Form Data:", values);

                    // اضافه کردن CSRF token
                    values._token = $('meta[name="csrf-token"]').attr(
                        "content",
                    );

                    // ارسال Ajax
                    $.post("/admin2/mineducations/update", values, function(res) {
                        if (res.success) {
                            toastr.success(res.message);
                        } else {
                            toastr.error(res.message);
                        }
                        // offCanvasEl.hide();

                        dt_minEducation.ajax.reload(); // اگر میخوای جدول بروز بشه
                        $("#modalEdit_minEducation").modal("hide");

                    }).fail(function(xhr) {
                        toastr.error("نوع حداقل تحصیلات با این نام وجود دارد.");
                    });
                },
            });
        });

        function updateminEducationSelectOptions() {
            const $selectInput = $('#min_education_id'); // ID سلکت اینپوت خود را اینجا قرار دهید

            $.ajax({
                url: "/admin2/mineducations", // آدرسی که اطلاعات سلکت را برمی‌گرداند
                type: "GET",
                dataType: "json",
                success: function(response) {
                    // ۱. خالی کردن آپشن‌های قبلی (به جز گزینه اول که مثلا "انتخاب کنید" است)
                    $selectInput.find('option:not(:first)').remove();

                    // ۲. پر کردن آپشن‌های جدید
                    $.each(response.data, function(index, item) {
                        $selectInput.append(
                            $('<option>', {
                                value: item.id,
                                text: item.name
                            })
                        );
                    });

                    // ۳. اگر از کتابخانه‌هایی مثل Select2 استفاده می‌کنید، باید آن را رفرش کنید:
                    // $selectInput.trigger('change.select2');
                },
                error: function(err) {
                    console.error("خطا در دریافت آپشن‌ها:", err);
                }
            });
        }
    </script>
@endsection
