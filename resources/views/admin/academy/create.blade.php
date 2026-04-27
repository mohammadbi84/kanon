@extends('admin.layout.master')

@section('head')
    <link rel="stylesheet" href="{{ asset('site/assets/css/register.css') }}">
    <link rel="stylesheet" href="https://lib.arvancloud.ir/choices.js/9.1.0/choices.min.css">
@endsection

@section('content')
    <h5 class="breadcrumb-wrapper mb-4">
        <a href="{{ route('admin.index') }}" class="text-muted">داشبورد</a> <span class="text-muted">/</span>
        <a href="{{ route('admin.academy.index') }}" class="text-muted">آموزشگاه ها</a> <span class="text-muted">/</span>
        <span class="">ثبت آموزشگاه جدید</span>
    </h5>
    <div class="card">
        <div class="card-body pt-0 p-3">
            <form action="{{ route('admin.academy.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif --}}
                <div class="row row-cols-center">
                    <div class="col">
                        <!-- اطلاعات سازمان -->
                        <div class="row rounded-4 p-3 pb-0">
                            <div class="d-flex flex-wrap align-content-center mb-2 register_title">
                                <img src="{{ asset('site/public/icon/vertical-line.svg') }}" aria-hidden="true"
                                    class="me-2" alt="">
                                <h3>مشخصات پروانه تاسیس</h3>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="autocomplete @if (old('name')) filled @endif"
                                    id="autocompleteBoxname">
                                    <input type="text" id="searchInputname" class="only-persian" name="name"
                                        value="{{ old('name') }}" oninput="nameinput('name')"
                                        @error('name')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputname">نام آموزشگاه</label>
                                    <span class="clear-btn" id="clearBtn_name" onclick="clearInput('name')"
                                        @if (old('name')) style="display:block !important" @endif>×</span>
                                </div>
                                <div class="error-message" id="error-name">فقط حروف فارسی مجاز است.</div>
                                @error('name')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete @if (old('id_number')) filled @endif"
                                    id="autocompleteBoxid_number">
                                    <input type="text" id="searchInputid_number" class="only-number" name="id_number"
                                        value="{{ old('id_number') }}" oninput="nameinput('id_number')"
                                        @error('id_number')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputid_number">شماره شناسایی</label>
                                    <span class="clear-btn" id="clearBtn_id_number" onclick="clearInput('id_number')"
                                        @if (old('id_number')) style="display:block !important" @endif>×</span>
                                </div>
                                @error('id_number')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete @if (old('export_number')) filled @endif"
                                    id="autocompleteBoxexport_number">
                                    <input type="text" id="searchInputexport_number" class="only-number-sign"
                                        name="export_number" value="{{ old('export_number') }}"
                                        oninput="nameinput('export_number')"
                                        @error('export_number')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputexport_number">شماره صدور</label>
                                    <span class="clear-btn" id="clearBtn_export_number"
                                        onclick="clearInput('export_number')"
                                        @if (old('export_number')) style="display:block !important" @endif>×</span>
                                </div>
                                @error('export_number')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete @if (old('export_start')) filled @endif"
                                    id="autocompleteBoxexport_start">
                                    <input type="text" id="searchInputexport_start" name="export_start" readonly
                                        value="{{ old('export_start') }}" oninput="nameinput('export_start')"
                                        @error('export_start')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputexport_start">تاریخ صدور</label>
                                    <span class="clear-btn" id="clearBtn_export_start" onclick="clearInput('export_start')"
                                        @if (old('export_start')) style="display:block !important" @endif>×</span>
                                </div>
                                @error('export_start')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete @if (old('export_reset')) filled @endif"
                                    id="autocompleteBoxexport_reset">
                                    <input type="text" id="searchInputexport_reset" name="export_reset" readonly
                                        value="{{ old('export_reset') }}" oninput="nameinput('export_reset')"
                                        @error('export_reset')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputexport_reset">تاریخ صدور مجدد</label>
                                    <span class="clear-btn" id="clearBtn_export_reset" onclick="clearInput('export_reset')"
                                        @if (old('export_reset')) style="display:block !important" @endif>×</span>
                                </div>
                                @error('export_reset')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete @if (old('export_end')) filled @endif"
                                    id="autocompleteBoxexport_end">
                                    <input type="text" id="searchInputexport_end" name="export_end" readonly
                                        value="{{ old('export_end') }}" oninput="nameinput('export_end')"
                                        @error('export_end')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputexport_end">تاریخ پایان اعتبار</label>
                                    <span class="clear-btn" id="clearBtn_export_end" onclick="clearInput('export_end')"
                                        @if (old('export_end')) style="display:block !important" @endif>×</span>
                                </div>
                                @error('export_end')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row g-0">
                                            <div class="col-1 p-1">
                                                <input type="radio" class="form-check-input" name="license"
                                                    id="parvane_first" {{ old('license') == 'first' ? 'checked' : '' }}
                                                    value="first" onchange="">
                                            </div>
                                            <div class="col-5 p-1">
                                                <label for="parvane_first" class="form-check-label">اولین پروانه
                                                    کسب</label>
                                            </div>
                                            <div class="col-1 p-1">
                                                <input type="radio" class="form-check-input" name="license"
                                                    id="parvane_tamdid"
                                                    {{ old('license') == 'extension' ? 'checked' : '' }} value="extension"
                                                    onchange="">
                                            </div>
                                            <div class="col-5 p-1">
                                                <label for="parvane_tamdid" class="form-check-label">تمدید پروانه
                                                    کسب</label>
                                            </div>
                                        </div>
                                        @error('license')
                                            <small class="text-danger mt-2">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="autocomplete @if (old('first_license_date')) filled @endif"
                                            id="autocompleteBoxfirst_license_date">
                                            <input type="text" id="searchInputfirst_license_date"
                                                name="first_license_date" readonly
                                                value="{{ old('first_license_date') }}"
                                                oninput="nameinput('first_license_date')"
                                                @error('first_license_date')
                                            style="border:red solid 1px"
                                            @enderror>
                                            <label for="searchInputfirst_license_date">تاریخ اولین پروانه کسب
                                                <small>(اختیاری)</small></label>
                                            <span class="clear-btn" id="clearBtn_first_license_date"
                                                onclick="clearInput('first_license_date')"
                                                @if (old('first_license_date')) style="display:block !important" @endif>×</span>
                                        </div>
                                        @error('first_license_date')
                                            <small class="text-danger mt-2">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 mt-2 pe-4">
                                <div class="row pb-0 g-0 align-content-center">
                                    <div class="col-1 mb-0 p-0 align-content-center">
                                        <p class="p-0 m-0">جنسیت : </p>
                                    </div>
                                    <div class="col-12 d-flex mb-0 p-0 align-content-center">
                                        <div class="d-flex flex-wrap align-content-center p-0">
                                            <div class="form-check form-check-inline ms-2 me-0" dir="rtl">
                                                <input type="radio" class="form-check-input" name="gender"
                                                    id="baradaran" {{ old('gender') == 'male' ? 'checked' : '' }}
                                                    value="male" onchange="handleGenderChange()">
                                            </div>
                                            <label for="baradaran" class="form-check-label me-3">برادران</label>

                                            <div class="form-check form-check-inline ms-2 me-0" dir="rtl">
                                                <input type="radio" class="form-check-input" name="gender"
                                                    id="khaharan" {{ old('gender') == 'female' ? 'checked' : '' }}
                                                    value="female" onchange="handleGenderChange()">
                                            </div>
                                            <label for="khaharan" class="form-check-label me-3">خواهران</label>

                                            <div class="form-check form-check-inline ms-2 me-0" dir="rtl">
                                                <input type="radio" class="form-check-input" name="gender"
                                                    id="mokhtalet" {{ old('gender') == 'both' ? 'checked' : '' }}
                                                    value="both" onchange="handleGenderChange()">
                                            </div>
                                            <label for="mokhtalet" class="form-check-label">برادران،خواهران <small>( دو منظوره )</small></label>
                                        </div>
                                        <div class="d-flex flex-wrap align-content-center p-0">
                                            <div class="form-check form-check-inline ms-4 me-0" dir="rtl">
                                                <input type="checkbox" class="form-check-input" name="tabsare_34"
                                                    {{ old('gender') == 'both' ? 'checked' : '' }} value="1"
                                                    id="tabsare_34" disabled>
                                            </div>
                                            <label for="tabsare_34" class="form-check-label ms-2 me-0">دارای مجوز تبصره
                                                ۳۴</label>
                                        </div>
                                    </div>
                                    @error('gender')
                                        <small class="text-danger mt-0 p-0">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <h6 class="mb-1">عناوین رشته</h6>

                            <div class="col-md-12 mb-3">
                                <!-- Select اصلی با Choices -->
                                <select id="mySelect" class="form-select mb-0" multiple name="herfe[]"
                                    @error('herfe') style="border:red solid 1px !important" @enderror>
                                    @foreach ($fields as $field)
                                        <option value="{{ $field->id }}"
                                            @if (old('herfe') && in_array($field->id, old('herfe'))) selected @endif>
                                            {{ $field->name }} ({{ $field->cluster->name }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('herfe')
                                    <small class="text-danger m-0 p-0">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-12 text-end">
                                <!-- دکمه باز کردن مدال -->
                                <button type="button" class="btn btn-primary" style="height: 48px;"
                                    data-bs-toggle="modal" data-bs-target="#herfeModal">
                                    <i class="bi bi-caret-up-fill fs-5" style="position: relative;top: 6%;"></i> انتخاب
                                    سریع
                                    از لیست
                                </button>
                            </div>

                            <!-- مدال حرفه‌ها -->
                            <div class="modal fade" id="herfeModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header d-block p-0">
                                            <div class="row g-0 p-3 mt-1" dir="rtl">
                                                <div class="col" style="text-align: right;">
                                                    <h5 class="" id="">عناوین رشته</h5>
                                                </div>
                                                <div class="col" style="text-align: left;"> <button type="button"
                                                        class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="بستن"></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            <!-- تب‌های خوشه‌ها -->
                                            <ul class="nav nav-tabs rounded-3 mb-2 mt-2 shadow align-content-center ps-3 pe-3"
                                                style="background-color: #252641;color: white;" id="khosheTabs"
                                                role="tablist">
                                                <div class="d-flex align-items-center me-2">
                                                    <strong class="mb-0">خوشه‌ها :</strong>
                                                </div>

                                                @foreach ($clusters as $index => $cluster)
                                                    <li class="nav-item " role="presentation">
                                                        <button
                                                            class="nav-link text-white p-3 {{ $index === 0 ? 'active' : '' }}"
                                                            id="tab-{{ $cluster->id }}" data-bs-toggle="tab"
                                                            data-bs-target="#khoshe-{{ $cluster->id }}" type="button">
                                                            {{ $cluster->name }} (
                                                            <small>{{ $cluster->fields()->count() }}</small> )
                                                        </button>
                                                    </li>
                                                @endforeach
                                                {{-- <div class="align-content-center">
                                                <small> مورد انتخاب شده</small>
                                            </div> --}}
                                            </ul>

                                            <!-- محتوای تب‌ها -->
                                            <div class="tab-content p-3 border-0" id="khosheTabsContent">
                                                @foreach ($clusters as $index => $cluster)
                                                    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                                                        id="khoshe-{{ $cluster->id }}" role="tabpanel">
                                                        @php
                                                            $herfes = $cluster->fields()->orderBy('name', 'asc')->get();
                                                            $half = ceil($herfes->count() / 2);
                                                            $leftHerfes = $herfes->slice(0, $half);
                                                            $rightHerfes = $herfes->slice($half);
                                                        @endphp

                                                        <div class="row">
                                                            <!-- ستون اول -->
                                                            <div class="col-md-6">
                                                                @foreach ($leftHerfes as $herfe)
                                                                    <div class="d-flex flex-wrap align-content-center p-0">
                                                                        <div class="form-check form-check-inline me-2"
                                                                            dir="rtl">
                                                                            <input type="checkbox"
                                                                                class="form-check-input herfe-checkbox"
                                                                                id="herfe-{{ $herfe->id }}"
                                                                                value="{{ $herfe->id }}"
                                                                                data-herfe-name="{{ $herfe->name }}"
                                                                                data-khoshe-name="{{ $cluster->name }}"
                                                                                @if (in_array($herfe->id, old('herfe', []))) checked @endif>
                                                                        </div>
                                                                        <label for="herfe-{{ $herfe->id }}"
                                                                            class="form-check-label">{{ $herfe->name }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            <!-- ستون دوم -->
                                                            <div class="col-md-6">
                                                                @foreach ($rightHerfes as $herfe)
                                                                    <div class="d-flex flex-wrap align-content-center p-0">
                                                                        <div class="form-check form-check-inline me-2"
                                                                            dir="rtl">
                                                                            <input type="checkbox"
                                                                                class="form-check-input herfe-checkbox"
                                                                                id="herfe-{{ $herfe->id }}"
                                                                                value="{{ $herfe->id }}"
                                                                                data-herfe-name="{{ $herfe->name }}"
                                                                                data-khoshe-name="{{ $cluster->name }}"
                                                                                @if (in_array($herfe->id, old('herfe', []))) checked @endif>
                                                                        </div>
                                                                        <label for="herfe-{{ $herfe->id }}"
                                                                            class="form-check-label">{{ $herfe->name }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="modal-footer d-block p-0">
                                            <div class="row g-0 p-3 mt-1" dir="rtl">
                                                <div class="col-8" style="text-align: right;">
                                                    <p>
                                                        انتخاب شده ها :
                                                        @foreach ($clusters as $index => $cluster)
                                                            <span class="me-2">
                                                                {{ $cluster->name }} ( <small class="selected-count"
                                                                    data-khoshe-id="{{ $cluster->id }}">0</small> )
                                                            </span>
                                                        @endforeach
                                                    </p>
                                                </div>
                                                <div class="col" style="text-align: left;">
                                                    <span>جمع کل : ( <small id="totalSelected">0</small> )</span>
                                                    <button type="button" class="btn btn-primary me-2"
                                                        id="applyHerfes">ذخیره</button>
                                                </div>
                                            </div>
                                            {{-- <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">انصراف</button> --}}

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- انتخاب نوع شخصیت -->
                        <div class="row rounded-4 p-3 pt-0 mt-0">
                            <div class="d-flex flex-wrap align-content-center mb-2 register_title">
                                <img src="{{ asset('site/public/icon/vertical-line.svg') }}" aria-hidden="true"
                                    class="me-2" alt="">
                                <h3>اطلاعات هویتی مؤسس</h3>
                            </div>
                            {{-- <h5>نوع</h5> --}}

                            <div class="d-flex flex-wrap align-content-center pe-0">
                                <div class="form-check form-check-inline me-2 me-0" dir="rtl">
                                    <input type="radio" name="haghighi" id="haghighi" value="1"
                                        class="form-check-input" {{ old('haghighi', 1) == 1 ? 'checked' : '' }}
                                        onclick="toggleForms()">
                                </div>
                                <label class="form-check-label me-4" for="haghighi">حقیقی</label>

                                <div class="form-check form-check-inline me-2" dir="rtl">
                                    <input type="radio" name="haghighi" id="hoghoghi" value="2"
                                        class="form-check-input" {{ old('haghighi') == 2 ? 'checked' : '' }}
                                        onclick="toggleForms()">
                                </div>
                                <label class="form-check-label me-4" for="hoghoghi">حقوقی</label>
                            </div>


                            <!-- فرم حقیقی -->
                            <div class="row px-0 mx-0 mt-2 " id="haghighi-form"
                                style="display:{{ old('haghighi', 1) == 1 ? '' : 'none' }}">
                                <div class="col-md-6 mb-3">
                                    <div class="autocomplete @if (old('natural_name')) filled @endif"
                                        id="autocompleteBoxnatural_name">
                                        <input type="text" id="searchInputnatural_name" class="only-persian"
                                            name="natural_name" value="{{ old('natural_name') }}"
                                            oninput="nameinput('natural_name')"
                                            @error('natural_name')
                                    style="border:red solid 1px"
                                    @enderror>
                                        <label for="searchInputnatural_name">نام</label>
                                        <span class="clear-btn" id="clearBtn_natural_name"
                                            onclick="clearInput('natural_name')"
                                            @if (old('natural_name')) style="display:block !important" @endif>×</span>
                                    </div>
                                    <div class="error-message" id="error-natural_name">فقط حروف فارسی مجاز است.</div>
                                    @error('natural_name')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="autocomplete @if (old('natural_family')) filled @endif"
                                        id="autocompleteBoxnatural_family">
                                        <input type="text" id="searchInputnatural_family" class="only-persian"
                                            name="natural_family" value="{{ old('natural_family') }}"
                                            oninput="nameinput('natural_family')"
                                            @error('natural_family')
                                    style="border:red solid 1px"
                                    @enderror>
                                        <label for="searchInputnatural_family">نام خانوادگی</label>
                                        <span class="clear-btn" id="clearBtn_natural_family"
                                            onclick="clearInput('natural_family')"
                                            @if (old('natural_family')) style="display:block !important" @endif>×</span>
                                    </div>
                                    <div class="error-message" id="error-natural_family">فقط حروف فارسی مجاز است.</div>

                                    @error('natural_family')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="autocomplete @if (old('natural_father')) filled @endif"
                                        id="autocompleteBoxnatural_father">
                                        <input type="text" id="searchInputnatural_father" class="only-persian"
                                            name="natural_father" value="{{ old('natural_father') }}"
                                            oninput="nameinput('natural_father')"
                                            @error('natural_father')
                                    style="border:red solid 1px"
                                    @enderror>
                                        <label for="searchInputnatural_father">نام پدر</label>
                                        <span class="clear-btn" id="clearBtn_natural_father"
                                            onclick="clearInput('natural_father')"
                                            @if (old('natural_father')) style="display:block !important" @endif>×</span>
                                    </div>
                                    <div class="error-message" id="error-natural_father">فقط حروف فارسی مجاز است.</div>

                                    @error('natural_father')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="autocomplete @if (old('national_code')) filled @endif"
                                        id="autocompleteBoxnational_code">
                                        <input type="text" id="searchInputnational_code" data-rule="nationalCode"
                                            class="validate-input" name="national_code" maxlength="12"
                                            value="{{ old('national_code') }}" oninput="nameinput('national_code')"
                                            @error('national_code')
                                        style="border:red solid 1px"
                                    @enderror>
                                        <label for="searchInputnational_code">شماره ملی</label>
                                        <span class="clear-btn" id="clearBtn_national_code"
                                            onclick="clearInput('national_code')"
                                            @if (old('national_code')) style="display:block !important" @endif>×</span>
                                    </div>
                                    <div class="error-message" id="error-national_code"></div>
                                    @error('national_code')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="autocomplete @if (old('national_id_number')) filled @endif"
                                        id="autocompleteBoxnational_id_number">
                                        <input type="text" id="searchInputnational_id_number" class="only-number"
                                            name="national_id_number" value="{{ old('national_id_number') }}"
                                            oninput="nameinput('national_id_number')"
                                            @error('national_id_number')
                                    style="border:red solid 1px"
                                    @enderror>
                                        <label for="searchInputnational_id_number">شماره شناسنامه</label>
                                        <span class="clear-btn" id="clearBtn_national_id_number"
                                            onclick="clearInput('national_id_number')"
                                            @if (old('national_id_number')) style="display:block !important" @endif>×</span>
                                    </div>
                                    @error('national_id_number')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="autocomplete @if (old('natural_birth_date')) filled @endif"
                                        id="autocompleteBoxnatural_birth_date">
                                        <input type="text" id="searchInputnatural_birth_date"
                                            name="natural_birth_date" readonly value="{{ old('natural_birth_date') }}"
                                            oninput="nameinput('natural_birth_date')"
                                            @error('natural_birth_date')
                                    style="border:red solid 1px"
                                    @enderror>
                                        <label for="searchInputnatural_birth_date">تاریخ تولد</label>
                                        <span class="clear-btn" id="clearBtn_natural_birth_date"
                                            onclick="clearInput('natural_birth_date')"
                                            @if (old('natural_birth_date')) style="display:block !important" @endif>×</span>
                                    </div>
                                    @error('natural_birth_date')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="autocomplete @if (old('natural_issue')) filled @endif"
                                        id="autocompleteBoxnatural_issue">
                                        <input type="text" id="searchInputnatural_issue" class="only-persian"
                                            name="natural_issue" value="{{ old('natural_issue') }}"
                                            oninput="nameinput('natural_issue')"
                                            @error('natural_issue')
                                    style="border:red solid 1px"
                                    @enderror>
                                        <label for="searchInputnatural_issue">محل صدور</label>
                                        <span class="clear-btn" id="clearBtn_natural_issue"
                                            onclick="clearInput('natural_issue')"
                                            @if (old('natural_issue')) style="display:block !important" @endif>×</span>
                                    </div>
                                    <div class="error-message" id="error-natural_issue">فقط حروف فارسی مجاز است.</div>

                                    @error('natural_issue')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    {{-- <label class="mb-2">شماره تماس</label> --}}
                                    <div class="d-flex gap-0">
                                        <!-- شماره اصلی -->
                                        <div class="autocomplete flex-grow-1 @if (old('founder_phone')) filled @endif"
                                            id="autocompleteBoxfounder_phone">
                                            <input type="text" id="searchInputfounder_phone"
                                                class="only-number validate-input" data-rule="phone" name="founder_phone"
                                                value="{{ old('founder_phone') }}" oninput="nameinput('founder_phone')"
                                                maxlength="8"
                                                @error('founder_phone') style="border:red solid 1px" @enderror>
                                            <label for="searchInputfounder_phone">شماره تلفن</label>
                                            <span class="clear-btn" id="clearBtn_founder_phone"
                                                onclick="clearInput('founder_phone')"
                                                @if (old('founder_phone')) style="display:block !important" @endif>×</span>
                                        </div>
                                        <!-- پیش شماره -->
                                        <div class="autocomplete flex-grow-0 @if (old('founder_phone_prefix')) filled @endif"
                                            style="width: 120px;" id="autocompleteBoxfounder_phone_prefix">
                                            <input type="text" id="searchInputfounder_phone_prefix"
                                                class="only-number validate-input" data-rule="prefix"
                                                name="founder_phone_prefix" maxlength="3"
                                                value="{{ old('founder_phone_prefix') }}"
                                                oninput="nameinput('founder_phone_prefix')"
                                                @error('founder_phone_prefix') style="border:red solid 1px" @enderror>
                                            <label for="searchInputfounder_phone_prefix">پیش شماره</label>
                                            <span class="clear-btn" id="clearBtn_founder_phone_prefix"
                                                onclick="clearInput('founder_phone_prefix')"
                                                @if (old('founder_phone_prefix')) style="display:block !important" @endif>×</span>
                                        </div>
                                    </div>
                                    <div class="error-message" id="error-founder_phone_prefix"></div>
                                    <div class="error-message" id="error-founder_phone"></div>
                                    @error('founder_phone_prefix')
                                        <small class="text-danger mt-2 d-block">{{ $message }}</small>
                                    @enderror

                                    @error('founder_phone')
                                        <small class="text-danger mt-2 d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="autocomplete @if (old('founder_mobile')) filled @endif"
                                        id="autocompleteBoxfounder_mobile">
                                        <input type="text" id="searchInputfounder_mobile"
                                            class="only-number validate-input" maxlength="11" data-rule="mobile"
                                            name="founder_mobile" value="{{ old('founder_mobile') }}"
                                            oninput="nameinput('founder_mobile')"
                                            @error('founder_mobile')
                                    style="border:red solid 1px"
                                    @enderror>
                                        <label for="searchInputfounder_mobile">
                                            شماره موبایل
                                            <small>(نام کاربری)</small>
                                        </label>
                                        <span class="clear-btn" id="clearBtn_founder_mobile"
                                            onclick="clearInput('founder_mobile')"
                                            @if (old('founder_mobile')) style="display:block !important" @endif>×</span>
                                    </div>
                                    <div class="error-message" id="error-founder_mobile"></div>
                                    @error('founder_mobile')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="autocomplete @if (old('founder_email')) filled @endif"
                                        id="autocompleteBoxfounder_email">
                                        <input type="email" id="searchInputfounder_email" class=""
                                            name="founder_email" value="{{ old('founder_email') }}"
                                            oninput="nameinput('founder_email')"
                                            @error('founder_email')
                                    style="border:red solid 1px"
                                    @enderror>
                                        <label for="searchInputfounder_email">
                                            ایمیل <small>(اختیاری)</small>
                                        </label>
                                        <span class="clear-btn" id="clearBtn_founder_email"
                                            onclick="clearInput('founder_email')"
                                            @if (old('founder_email')) style="display:block !important" @endif>×</span>
                                    </div>
                                    @error('founder_email')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="autocomplete @if (old('founder_address')) filled @endif"
                                        id="autocompleteBoxfounder_address">
                                        <input type="text" id="searchInputfounder_address" class="only-persian"
                                            name="founder_address" value="{{ old('founder_address') }}"
                                            oninput="nameinput('founder_address')"
                                            @error('founder_address')
                                    style="border:red solid 1px"
                                    @enderror>
                                        <label for="searchInputfounder_address">آدرس محل سکونت
                                            <small>(اختیاری)</small></label>
                                        <span class="clear-btn" id="clearBtn_founder_address"
                                            onclick="clearInput('founder_address')"
                                            @if (old('founder_address')) style="display:block !important" @endif>×</span>
                                    </div>
                                    <div class="error-message" id="error-founder_address">فقط حروف فارسی مجاز است.</div>

                                    @error('founder_address')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- فرم حقوقی -->
                            <div class="row px-0 mx-0 mt-2" id="hoghoghi-form"
                                style="display: {{ old('haghighi') == 2 ? '' : 'none' }}">
                                <div class="col-md-6 mb-3">
                                    <div class="autocomplete @if (old('legal_company_name')) filled @endif"
                                        id="autocompleteBoxlegal_company_name">
                                        <input type="text" id="searchInputlegal_company_name" class="only-persian"
                                            name="legal_company_name" value="{{ old('legal_company_name') }}"
                                            oninput="nameinput('legal_company_name')"
                                            @error('legal_company_name')
                                    style="border:red solid 1px"
                                    @enderror>
                                        <label for="searchInputlegal_company_name">نام شرکت</label>
                                        <span class="clear-btn" id="clearBtn_legal_company_name"
                                            onclick="clearInput('legal_company_name')"
                                            @if (old('legal_company_name')) style="display:block !important" @endif>×</span>
                                    </div>
                                    <div class="error-message" id="error-legal_company_name">فقط حروف فارسی مجاز است.
                                    </div>

                                    @error('legal_company_name')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="autocomplete @if (old('legal_register_number')) filled @endif"
                                        id="autocompleteBoxlegal_register_number">
                                        <input type="text" id="searchInputlegal_register_number" class="only-number"
                                            name="legal_register_number" value="{{ old('legal_register_number') }}"
                                            oninput="nameinput('legal_register_number')"
                                            @error('legal_register_number')
                                    style="border:red solid 1px"
                                    @enderror>
                                        <label for="searchInputlegal_register_number">شماره ثبت</label>
                                        <span class="clear-btn" id="clearBtn_legal_register_number"
                                            onclick="clearInput('legal_register_number')"
                                            @if (old('legal_register_number')) style="display:block !important" @endif>×</span>
                                    </div>
                                    @error('legal_register_number')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="autocomplete @if (old('register_date')) filled @endif"
                                        id="autocompleteBoxregister_date">
                                        <input type="text" id="searchInputregister_date" name="register_date" readonly
                                            value="{{ old('register_date') }}" oninput="nameinput('register_date')"
                                            @error('register_date')
                                    style="border:red solid 1px"
                                    @enderror>
                                        <label for="searchInputregister_date">تاریخ ثبت</label>
                                        <span class="clear-btn" id="clearBtn_register_date"
                                            onclick="clearInput('register_date')"
                                            @if (old('register_date')) style="display:block !important" @endif>×</span>
                                    </div>
                                    @error('register_date')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="autocomplete @if (old('legal_manager')) filled @endif"
                                        id="autocompleteBoxlegal_manager">
                                        <input type="text" id="searchInputlegal_manager" class="only-persian"
                                            name="legal_manager" value="{{ old('legal_manager') }}"
                                            oninput="nameinput('legal_manager')"
                                            @error('legal_manager')
                                    style="border:red solid 1px"
                                    @enderror>
                                        <label for="searchInputlegal_manager">مدیر عامل</label>
                                        <span class="clear-btn" id="clearBtn_legal_manager"
                                            onclick="clearInput('legal_manager')"
                                            @if (old('legal_manager')) style="display:block !important" @endif>×</span>
                                    </div>
                                    <div class="error-message" id="error-legal_manager">فقط حروف فارسی مجاز است.</div>

                                    @error('legal_manager')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    {{-- <label class="mb-2">شماره تماس</label> --}}
                                    <div class="d-flex gap-0">
                                        <!-- شماره اصلی -->
                                        <div class="autocomplete flex-grow-1 @if (old('founder_phone2')) filled @endif"
                                            id="autocompleteBoxfounder_phone2">
                                            <input type="text" id="searchInputfounder_phone2"
                                                class="only-number validate-input" data-rule="phone"
                                                name="founder_phone2" maxlength="8" value="{{ old('founder_phone2') }}"
                                                oninput="nameinput('founder_phone2')"
                                                @error('founder_phone2') style="border:red solid 1px" @enderror>
                                            <label for="searchInputfounder_phone2">شماره تلفن</label>
                                            <span class="clear-btn" id="clearBtn_founder_phone2"
                                                onclick="clearInput('founder_phone2')"
                                                @if (old('founder_phone2')) style="display:block !important" @endif>×</span>
                                        </div>
                                        <!-- پیش شماره -->
                                        <div class="autocomplete flex-grow-0 @if (old('founder_phone_prefix2')) filled @endif"
                                            style="width: 120px;" id="autocompleteBoxfounder_phone_prefix2">
                                            <input type="text" id="searchInputfounder_phone_prefix2"
                                                class="only-number validate-input" data-rule="prefix"
                                                name="founder_phone_prefix2" maxlength="3"
                                                value="{{ old('founder_phone_prefix2') }}"
                                                oninput="nameinput('founder_phone_prefix2')"
                                                @error('founder_phone_prefix2') style="border:red solid 1px" @enderror>
                                            <label for="searchInputfounder_phone_prefix2">پیش شماره</label>
                                            <span class="clear-btn" id="clearBtn_founder_phone_prefix2"
                                                onclick="clearInput('founder_phone_prefix2')"
                                                @if (old('founder_phone_prefix2')) style="display:block !important" @endif>×</span>
                                        </div>
                                    </div>
                                    <div class="error-message" id="error-founder_phone_prefix2"></div>
                                    <div class="error-message" id="error-founder_phone2"></div>
                                    @error('founder_phone_prefix2')
                                        <small class="text-danger mt-2 d-block">{{ $message }}</small>
                                    @enderror

                                    @error('founder_phone2')
                                        <small class="text-danger mt-2 d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="autocomplete @if (old('founder_mobile2')) filled @endif"
                                        id="autocompleteBoxfounder_mobile2">
                                        <input type="text" id="searchInputfounder_mobile2" maxlength="11"
                                            class="only-number validate-input" data-rule="mobile" name="founder_mobile2"
                                            value="{{ old('founder_mobile2') }}" oninput="nameinput('founder_mobile2')"
                                            @error('founder_mobile2')
                                    style="border:red solid 1px"
                                    @enderror>
                                        <label for="searchInputfounder_mobile2">
                                            شماره موبایل
                                            <small>(نام کاربری)</small>
                                        </label>
                                        <span class="clear-btn" id="clearBtn_founder_mobile2"
                                            onclick="clearInput('founder_mobile2')"
                                            @if (old('founder_mobile2')) style="display:block !important" @endif>×</span>
                                    </div>
                                    <div class="error-message" id="error-founder_mobile2"></div>
                                    @error('founder_mobile2')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="autocomplete @if (old('founder_email2')) filled @endif"
                                        id="autocompleteBoxfounder_email2">
                                        <input type="email" id="searchInputfounder_email2" class=""
                                            name="founder_email2" value="{{ old('founder_email2') }}"
                                            oninput="nameinput('founder_email2')"
                                            @error('founder_email2')
                                    style="border:red solid 1px"
                                    @enderror>
                                        <label for="searchInputfounder_email2">
                                            ایمیل <small>(اختیاری)</small>
                                        </label>
                                        <span class="clear-btn" id="clearBtn_founder_email2"
                                            onclick="clearInput('founder_email2')"
                                            @if (old('founder_email2')) style="display:block !important" @endif>×</span>
                                    </div>
                                    @error('founder_email2')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="autocomplete @if (old('founder_address')) filled @endif"
                                        id="autocompleteBoxfounder_address">
                                        <input type="text" id="searchInputfounder_address" class="only-persian"
                                            name="founder_address" value="{{ old('founder_address') }}"
                                            oninput="nameinput('founder_address')"
                                            @error('founder_address')
                                    style="border:red solid 1px"
                                    @enderror>
                                        <label for="searchInputfounder_address">آدرس شرکت <small>(اختیاری)</small></label>
                                        <span class="clear-btn" id="clearBtn_founder_address"
                                            onclick="clearInput('founder_address')"
                                            @if (old('founder_address')) style="display:block !important" @endif>×</span>
                                    </div>
                                    <div class="error-message" id="error-founder_address">فقط حروف فارسی مجاز است.</div>

                                    @error('founder_address')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- اطلاعات تماس -->
                        <div class="row rounded-4 p-3 pt-0">
                            <div class="d-flex flex-wrap align-content-center mb-2 register_title">
                                <img src="{{ asset('site/public/icon/vertical-line.svg') }}" aria-hidden="true"
                                    class="me-2" alt="">
                                <h3>اطلاعات مکان آموزشگاه</h3>
                            </div>
                            <!-- استان -->
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete filled" id="autocompleteBoxstate">
                                    <input type="text" id="searchInputstate" name="state_test" class="only-persian"
                                        oninput="filterOptions('state',1)" onclick="dropdownshow('state')"
                                        value="{{ old('state_test', 'یزد') }}"
                                        @error('state')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputstate">استان</label>
                                    <span class="clear-btn" style="display: block !important;" id="clearBtn_state"
                                        onclick="clearInput('state')">×</span>
                                    <div class="dropdown" id="dropdownListstate" style="display: none;"></div>
                                    <input type="hidden" name="state_id" id="selectedIdstate"
                                        value="{{ old('state_id', '31') }}">
                                </div>
                                <div class="error-message" id="error-state_test">فقط حروف فارسی مجاز است.</div>

                                @error('state_id')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete filled" id="autocompleteBoxcity">
                                    <input type="text" id="searchInputcity" name="city_test" class="only-persian"
                                        oninput="filterOptions('city',1)" onclick="dropdownshow('city')"
                                        value="{{ old('city_test', 'یزد') }}"
                                        @error('city_id')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputcity">شهرستان</label>
                                    <span class="clear-btn" style="display: block !important;" id="clearBtn_city"
                                        onclick="clearInput('city')">×</span>
                                    <div class="dropdown" id="dropdownListcity" style="display: none;"></div>
                                    <input type="hidden" name="city_id" id="selectedIdcity"
                                        value="{{ old('city_id', '1149') }}">
                                </div>
                                <div class="error-message" id="error-city_id">فقط حروف فارسی مجاز است.</div>

                                @error('city_id')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete @if (old('postal_code')) filled @endif"
                                    id="autocompleteBoxpostal_code">
                                    <input type="text" id="searchInputpostal_code" class="" name="postal_code"
                                        value="{{ old('postal_code') }}" oninput="formatPostalCode(this)"
                                        maxlength="11" @error('postal_code') style="border:red solid 1px" @enderror>
                                    <label for="searchInputpostal_code">کدپستی</label>
                                    <span class="clear-btn" id="clearBtn_postal_code" onclick="clearInput('postal_code')"
                                        @if (old('postal_code')) style="display:block !important" @endif>×</span>
                                </div>
                                @error('postal_code')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                {{-- <label class="mb-2">شماره تماس</label> --}}
                                <div class="d-flex gap-0">
                                    <!-- شماره اصلی -->
                                    <div class="autocomplete flex-grow-1 @if (old('phone')) filled @endif"
                                        id="autocompleteBoxphone">
                                        <input type="text" id="searchInputphone" class="only-number validate-input"
                                            data-rule="phone" name="phone" value="{{ old('phone') }}"
                                            maxlength="8" oninput="nameinput('phone')"
                                            @error('phone') style="border:red solid 1px" @enderror>
                                        <label for="searchInputphone">شماره تلفن</label>
                                        <span class="clear-btn" id="clearBtn_phone" onclick="clearInput('phone')"
                                            @if (old('phone')) style="display:block !important" @endif>×</span>
                                    </div>
                                    <!-- پیش شماره -->
                                    <div class="autocomplete flex-grow-0 @if (old('phone_prefix')) filled @endif"
                                        style="width: 120px;" id="autocompleteBoxphone_prefix">
                                        <input type="text" id="searchInputphone_prefix"
                                            class="only-number validate-input" data-rule="prefix" name="phone_prefix"
                                            maxlength="3" value="{{ old('phone_prefix') }}"
                                            oninput="nameinput('phone_prefix')"
                                            @error('phone_prefix') style="border:red solid 1px" @enderror>
                                        <label for="searchInputphone_prefix">پیش شماره</label>
                                        <span class="clear-btn" id="clearBtn_phone_prefix"
                                            onclick="clearInput('phone_prefix')"
                                            @if (old('phone_prefix')) style="display:block !important" @endif>×</span>
                                    </div>
                                </div>
                                <div class="error-message" id="error-phone_prefix"></div>
                                <div class="error-message" id="error-phone"></div>
                                @error('phone_prefix')
                                    <small class="text-danger mt-2 d-block">{{ $message }}</small>
                                @enderror

                                @error('phone')
                                    <small class="text-danger mt-2 d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                {{-- <label class="mb-2">شماره تماس</label> --}}
                                <div class="d-flex gap-0">
                                    <!-- شماره اصلی -->
                                    <div class="autocomplete flex-grow-1 @if (old('fax')) filled @endif"
                                        id="autocompleteBoxfax">
                                        <input type="text" id="searchInputfax" class="only-number validate-input"
                                            maxlength="8" data-rule="fax" name="fax" value="{{ old('fax') }}"
                                            oninput="nameinput('fax')"
                                            @error('fax') style="border:red solid 1px" @enderror>
                                        <label for="searchInputfax">فکس <small>(اختیاری)</small></label>
                                        <span class="clear-btn" id="clearBtn_fax" onclick="clearInput('fax')"
                                            @if (old('fax')) style="display:block !important" @endif>×</span>
                                    </div>
                                    <!-- پیش شماره -->
                                    <div class="autocomplete flex-grow-0 @if (old('fax_prefix')) filled @endif"
                                        style="width: 120px;" id="autocompleteBoxfax_prefix">
                                        <input type="text" id="searchInputfax_prefix"
                                            class="only-number validate-input" data-rule="prefix" name="fax_prefix"
                                            maxlength="3" value="{{ old('fax_prefix') }}"
                                            oninput="nameinput('fax_prefix')"
                                            @error('fax_prefix') style="border:red solid 1px" @enderror>
                                        <label for="searchInputfax_prefix">پیش شماره</label>
                                        <span class="clear-btn" id="clearBtn_fax_prefix"
                                            onclick="clearInput('fax_prefix')"
                                            @if (old('fax_prefix')) style="display:block !important" @endif>×</span>
                                    </div>
                                </div>
                                <div class="error-message" id="error-fax_prefix"></div>
                                <div class="error-message" id="error-fax"></div>
                                @error('fax_prefix')
                                    <small class="text-danger mt-2 d-block">{{ $message }}</small>
                                @enderror

                                @error('fax')
                                    <small class="text-danger mt-2 d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="autocomplete @if (old('mobile')) filled @endif"
                                    id="autocompleteBoxmobile">
                                    <input type="text" id="searchInputmobile" class="only-number validate-input"
                                        data-rule="mobile" name="mobile" value="{{ old('mobile') }}"
                                        oninput="nameinput('mobile')" maxlength="11"
                                        @error('mobile')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputmobile">موبایل <small>(اختیاری)</small></label>
                                    <span class="clear-btn" id="clearBtn_mobile" onclick="clearInput('mobile')"
                                        @if (old('mobile')) style="display:block !important" @endif>×</span>
                                </div>
                                <div class="error-message" id="error-mobile"></div>
                                @error('mobile')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="autocomplete @if (old('address')) filled @endif"
                                    id="autocompleteBoxaddress">
                                    <input type="text" id="searchInputaddress" class="only-persian" name="address"
                                        value="{{ old('address') }}" oninput="nameinput('address')"
                                        @error('address')
                                    style="border:red solid 1px"
                                    @enderror>
                                    <label for="searchInputaddress">آدرس</label>
                                    <span class="clear-btn" id="clearBtn_address" onclick="clearInput('address')"
                                        @if (old('address')) style="display:block !important" @endif>×</span>
                                </div>
                                <div class="error-message" id="error-address">فقط حروف فارسی مجاز است.</div>

                                @error('address')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        {{-- مستندات --}}
                        <div class="row rounded-4 p-3 pt-0 justify-content-center">
                            <div class="d-flex flex-wrap align-content-center mb-2 register_title">
                                <img src="{{ asset('site/public/icon/vertical-line.svg') }}" aria-hidden="true"
                                    class="me-2" alt="">
                                <h3>بارگذاری مستندات</h3>
                            </div>
                            <div class="col-12">
                                <div class="row g-0 rounded-3 border pt-3 mb-3" style="background-color: #f2f7ff">
                                    <div class="col-md-12 mb-2">
                                        <div class="mb-3 p-2 rounded-3" style="background-color: #f2f7ff">
                                            <span>تصویر پروانه کسب (رو)</span>
                                            <div
                                                class="border mt-2 bg-white @error('file_tasis_front') border-danger @enderror rounded-2 d-flex align-items-center mt-1">
                                                <label for="file_tasis_front" class="btn btn-primary me-2">انتخاب
                                                    فایل</label>
                                                <input type="file" id="file_tasis_front" name="file_tasis_front"
                                                    accept="image/*" style="display: none;">
                                                <span id="file_tasis_front_count" class="text-primary file-count">فایلی
                                                    انتخاب
                                                    نشده</span>
                                            </div>
                                            <div id="file_tasis_front_preview" class="mt-2"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <div class="mb-3 p-2 rounded-3" style="background-color: #f2f7ff">
                                            <span>تصویر پروانه کسب (پشت)</span>
                                            <div
                                                class="border mt-2 bg-white @error('file_tasis_back') border-danger @enderror rounded-2 d-flex align-items-center mt-1">
                                                <label for="file_tasis_back" class="btn btn-primary me-2">انتخاب
                                                    فایل</label>
                                                <input type="file" id="file_tasis_back" name="file_tasis_back"
                                                    accept="image/*" style="display: none;">
                                                <span id="file_tasis_back_count" class="text-primary file-count">فایلی
                                                    انتخاب
                                                    نشده</span>
                                            </div>
                                            <div id="file_tasis_back_preview" class="mt-2"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-0 rounded-3 border pt-3" style="background-color: #f2f7ff">
                                    <div class="col-md-12">
                                        <div class="mb-3 p-2 rounded-3" style="background-color: #f2f7ff">
                                            <span>تصاویر عناوین آموزشی <small>( اختیاری )</small></span>
                                            <div
                                                class="border mt-2 bg-white @error('file') border-danger @enderror rounded-2 d-flex align-items-center mt-1">
                                                <label class="btn btn-primary me-3">
                                                    انتخاب فایل
                                                    <input type="file" id="customFileInput" name="file[]"
                                                        class="d-none" accept="image/*" multiple>
                                                </label>
                                                <span id="fileCountText" class="me-2 text-primary">فایلی انتخاب
                                                    نشده</span>
                                                <!-- نمایش لیست فایل‌ها -->
                                            </div>
                                            <div id="fileList" class="mt-3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- دکمه ارسال -->
                        <div class="row text-center justify-content-center rounded-4 p-4 pt-1">
                            <div class="col-md-12 mb-4">
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group form-label-group in-border">
                                            <input type="text" class="form-control" name="captcha" id="captchatext"
                                                aria-label="Username" value="{{ old('captcha') }}"
                                                placeholder="کد امنیتی">
                                        </div>
                                        @error('captcha')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <div class="text-start">
                                            <span class="w-100" id="captcha">{!! captcha_img('my_custom') !!}</span>
                                            <button type="button" class="btn btn-light me-0" id="refresh-captcha">
                                                ↻
                                            </button>
                                        </div>
                                    </div>
                                    {{-- <div class="col border"></div> --}}
                                </div>
                                {{-- <div class="form-group mt-3">
                                <label for="captcha">کد کپچا را وارد نمایید:</label>


                                </div> --}}

                                <script>
                                    document.getElementById('refresh-captcha').onclick = function() {
                                        // alert('ok');
                                        fetch('/refresh-captcha')
                                            .then(res => res.text())
                                            .then(data => {
                                                document.querySelector('#captcha').innerHTML = data;
                                            });
                                        // alert('ok');
                                    };
                                </script>
                            </div>
                            <!-- Button to Open the Modal -->
                            <div class="d-flex justify-content-start align-items-center">
                                <button type="submit" class="btn btn-primary text-white me-4 shadow px-5">ثبت
                                    درخواست</button>
                                <a href="{{ route('admin.academy.index') }}"
                                    class="btn btn-danger text-white shadow px-5">انصراف</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">قوانین و مقررات</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    متن تستی
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">بستن</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        let choices;

        document.addEventListener('DOMContentLoaded', function() {
            // مقداردهی اولیه Choices
            choices = new Choices('#mySelect', {
                removeItemButton: true,
                searchEnabled: true,
                shouldSort: false,
                noResultsText: 'نتیجه‌ای پیدا نشد!',
                noChoicesText: 'هیچ گزینه‌ای موجود نیست!',
                itemSelectText: 'برای انتخاب کلیک کنید',
                placeholderValue: 'انتخاب کنید', // چون لیبل داریم، نیازی به placeholder اینجا نیست
                searchPlaceholderValue: 'جستجو...',
            });
            const modalElement = document.getElementById('herfeModal');

            // هم در باز شدن و هم بسته شدن مدال، چک‌باکس‌ها هماهنگ میشن
            modalElement.addEventListener('show.bs.modal', syncCheckboxesWithSelect);
            modalElement.addEventListener('hidden.bs.modal', syncCheckboxesWithSelect);

            function syncCheckboxesWithSelect() {
                // همه چک‌باکس‌ها رو غیرفعال می‌کنیم
                document.querySelectorAll('.herfe-checkbox').forEach(cb => cb.checked = false);

                // از روی گزینه‌های انتخاب‌شده توی سلکت، چک‌باکس مربوطه رو فعال می‌کنیم
                const selectedOptions = Array.from(document.querySelectorAll('#mySelect option')).filter(opt => opt
                    .selected);

                selectedOptions.forEach(option => {
                    const checkbox = document.querySelector(`.herfe-checkbox[value="${option.value}"]`);
                    if (checkbox) checkbox.checked = true;
                });
            }

            // دکمه اعمال در مدال
            document.getElementById('applyHerfes').addEventListener('click', function() {
                const selected = Array.from(document.querySelectorAll('.herfe-checkbox:checked')).map(cb =>
                    ({
                        id: cb.value,
                        name: cb.dataset.herfeName,
                        khoshe: cb.dataset.khosheName
                    }));

                updateCounters();
                updateMainSelect(selected);
                bootstrap.Modal.getInstance(document.getElementById('herfeModal')).hide();
            });

            // زمانی که select تغییر می‌کند (افزودن یا حذف)
            document.querySelector('#mySelect').addEventListener('change', function() {
                const selectedValues = Array.from(this.selectedOptions).map(opt => opt.value);
                document.querySelectorAll('.herfe-checkbox').forEach(cb => {
                    cb.checked = selectedValues.includes(cb.value);
                });
                updateCounters();
            });

            // وقتی چک‌باکس‌ها تغییر می‌کنند، select هم آپدیت شود
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('herfe-checkbox')) {
                    // const checked = document.querySelectorAll('.herfe-checkbox:checked');
                    // const selectedHerfes = Array.from(checked).map(cb => ({
                    //     id: cb.value,
                    //     name: cb.dataset.herfeName,
                    //     khoshe: cb.dataset.khosheName
                    // }));
                    // updateMainSelect(selectedHerfes);
                    updateCounters();
                }
            });

            // مقداردهی اولیه چک‌باکس‌ها بر اساس select
            const initialSelected = Array.from(document.querySelectorAll('#mySelect option[selected]')).map(opt =>
                opt.value);
            document.querySelectorAll('.herfe-checkbox').forEach(cb => {
                cb.checked = initialSelected.includes(cb.value);
            });

            updateCounters();
        });

        function updateMainSelect(herfes) {
            choices.removeActiveItems();
            herfes.forEach(herfe => {
                choices.setChoiceByValue(herfe.id.toString());
            });
        }

        function updateCounters() {
            const total = document.querySelectorAll('.herfe-checkbox:checked').length;
            document.getElementById('totalSelected').textContent = total;

            const counts = {};
            document.querySelectorAll('.herfe-checkbox').forEach(cb => {
                const khosheId = cb.closest('.tab-pane').id.replace('khoshe-', '');
                if (!counts[khosheId]) counts[khosheId] = 0;
                if (cb.checked) counts[khosheId]++;
            });

            document.querySelectorAll('.selected-count').forEach(el => {
                const khosheId = el.dataset.khosheId;
                el.textContent = counts[khosheId] || 0;
            });
        }
    </script>
@endsection
@section('script')
    <script src="https://lib.arvancloud.ir/choices.js/9.1.0/choices.min.js"></script>
    <script>
        $(document).ready(function() {
            const manualInputHTML = `
                <div class="manual-date-container text-end p-2">
                    <small class="datepicker_title px-1"> تایپ تاریخ </small>
                    <div class="row p-3 pt-4 border rounded-3 g-0" style="background-color: #f2f7ff">
                        <div class="col-5 p-1">
                            <div class="autocomplete">
                                <input type="text" class="manual-date-input year-input p-1" maxlength="4" style="height:40px">
                                <label style="right:6px;">سال</label>
                                <span class="clear-btn" style="display: none;left: 8px !important;">×</span>
                            </div>
                        </div>
                        <div class="col p-1">
                            <div class="autocomplete">
                                <input type="text" class="manual-date-input month-input p-1" maxlength="2" style="height:40px">
                                <label style="right:6px;">ماه</label>
                                <span class="clear-btn" style="display: none;left: 8px !important;">×</span>
                            </div>
                        </div>
                        <div class="col p-1">
                            <div class="autocomplete">
                                <input type="text" class="manual-date-input day-input p-1" maxlength="2" style="height:40px">
                                <label style="right:6px;">روز</label>
                                <span class="clear-btn" style="display: none;left: 8px !important;">×</span>
                            </div>
                        </div>
                        <div class="col-12 p-1">
                            <button class="btn-apply-date btn btn-primary btn-sm mt-2 mb-2 w-100" style="height:40px !important">اعمال تاریخ</button>
                            <small class="px-1 datepicker_alert text-danger"></small>
                        </div>
                    </div>
                </div>
            `;

            const dateInputs =
                "#searchInputexport_start, #searchInputexport_reset, #searchInputexport_end, #searchInputnatural_birth_date, #searchInputregister_date, #searchInputfirst_license_date";

            $(dateInputs).each(function() {
                const $input = $(this);

                $input.wrap(
                    '<div class="datepicker-wrapper" style="position: relative;"></div>'
                ); // هر اینپوت رو داخل یک رپر میذاریم

                $input.flatpickr({
                    locale: 'fa',
                    altInput: true,
                    altFormat: 'Y/m/d',
                    disableMobile: true
                });
                // $input.persianDatepicker({
                //     format: "YYYY/MM/DD",
                //     autoClose: false,
                //     initialValue: false,
                //     toolbox: {
                //         calendarSwitch: {
                //             enabled: true
                //         }
                //     },
                //     onShow: function() {
                //         const $datepickerPopup = $('.datepicker-plot-area:visible');

                //         if ($datepickerPopup.find('.manual-date-container').length === 0) {
                //             $datepickerPopup.append(manualInputHTML);

                //             const $yearInput = $datepickerPopup.find('.year-input');
                //             const $monthInput = $datepickerPopup.find('.month-input');
                //             const $dayInput = $datepickerPopup.find('.day-input');

                //             // فقط عدد
                //             $datepickerPopup.find('.manual-date-input').on('input', function() {
                //                 this.value = this.value.replace(/[^0-9]/g, '');
                //                 nameinputByElement(this);
                //             });

                //             // حرکت بین فیلدها
                //             $yearInput.on('input', () => {
                //                 if ($yearInput.val().length === 4) $monthInput.focus();
                //             });
                //             $monthInput.on('input', () => {
                //                 if ($monthInput.val().length === 2) $dayInput.focus();
                //             });

                //             // دکمه اعمال
                //             $datepickerPopup.find('.btn-apply-date').on('click', function() {
                //                 applyManualDate($yearInput, $monthInput, $dayInput,
                //                     $input, $datepickerPopup);
                //             });

                //             // اینتر روی روز
                //             $dayInput.on('keypress', function(e) {
                //                 if (e.which === 13) {
                //                     applyManualDate($yearInput, $monthInput, $dayInput,
                //                         $input, $datepickerPopup);
                //                 }
                //             });

                //             // دکمه پاک کردن
                //             $datepickerPopup.find('.clear-btn').on('click', function() {
                //                 const wrapper = this.closest('.autocomplete');
                //                 const input = wrapper.querySelector('input');
                //                 input.value = '';
                //                 wrapper.classList.remove('filled');
                //                 this.style.display = 'none';
                //                 input.focus();
                //             });
                //         }

                //         function injectManualBox() {
                //             const $datepickerPopup2 = $('.datepicker-plot-area:visible');
                //             if ($datepickerPopup2.find('.manual-date-container').length === 0) {
                //                 $datepickerPopup2.append(manualInputHTML);
                //                 bindManualDateEvents($datepickerPopup2);
                //             } else {

                //             }
                //         }

                //         function bindManualDateEvents($datepickerPopup) {
                //             const $yearInput = $datepickerPopup.find('.year-input');
                //             const $monthInput = $datepickerPopup.find('.month-input');
                //             const $dayInput = $datepickerPopup.find('.day-input');

                //             $datepickerPopup.find('.manual-date-input').on('input', function() {
                //                 this.value = this.value.replace(/[^0-9]/g, '');
                //                 nameinputByElement(this);
                //             });

                //             $yearInput.on('input', () => {
                //                 if ($yearInput.val().length === 4) $monthInput.focus();
                //             });
                //             $monthInput.on('input', () => {
                //                 if ($monthInput.val().length === 2) $dayInput.focus();
                //             });

                //             $datepickerPopup.find('.btn-apply-date').on('click', function() {
                //                 applyManualDate($yearInput, $monthInput, $dayInput,
                //                     $input, $datepickerPopup);
                //             });

                //             $dayInput.on('keypress', function(e) {
                //                 if (e.which === 13) {
                //                     applyManualDate($yearInput, $monthInput, $dayInput,
                //                         $input, $datepickerPopup);
                //                 }
                //             });

                //             $datepickerPopup.find('.clear-btn').on('click', function() {
                //                 const wrapper = this.closest('.autocomplete');
                //                 const input = wrapper.querySelector('input');
                //                 input.value = '';
                //                 wrapper.classList.remove('filled');
                //                 this.style.display = 'none';
                //                 input.focus();
                //             });
                //         }

                //         // injectManualBox();

                //         // وقتی کاربر ماه/سال رو عوض میکنه یا اسکرول میکنه دوباره تزریق کنیم
                //         const $datepickerContainer = $('.datepicker-container:visible');
                //         $datepickerContainer.on('click wheel', function() {
                //             setTimeout(injectManualBox, 100); // کمی تاخیر برای رندر شدن
                //         });
                //     },
                //     onSelect: function(unix) {
                //         nameinput($input.attr("id"));
                //     },
                // });

                // // وقتی روی اینپوت کلیک شد و باکس بسته بود، دوباره بازش کن
                // $input.on('click', function() {
                //     const $datepickerPopup = $('.datepicker-plot-area');
                //     if ($datepickerPopup.length === 0) {
                //         $input.persianDatepicker('show');
                //     } else {
                //         $datepickerPopup.css('display', 'block');
                //     }
                // });
            });

            function applyManualDate($yearInput, $monthInput, $dayInput, $inputElement, $datepickerPopup) {
                const year = $yearInput.val().trim();
                const month = $monthInput.val().trim().padStart(2, '0');
                const day = $dayInput.val().trim().padStart(2, '0');
                const dateStr = `${year}/${month}/${day}`;

                if (isValidPersianDate(dateStr)) {
                    $inputElement.val(dateStr);
                    $datepickerPopup.find('.datepicker_alert').text('');
                    nameinput($inputElement.attr("id"));
                    $datepickerPopup.css('display', 'none'); // فقط همین پاپ‌آپ بسته بشه
                } else {
                    $datepickerPopup.find('.datepicker_alert').text('مقادیر وارد شده صحیح نمیباشد');
                    $yearInput.focus();
                }
            }

            function isValidPersianDate(dateStr) {
                if (!/^1[3-4]\d{2}\/(0[1-9]|1[0-2])\/(0[1-9]|[12]\d|3[01])$/.test(dateStr)) return false;
                const [y, m, d] = dateStr.split('/').map(Number);
                if ([4, 6, 9, 11].includes(m) && d > 30) return false;
                if (m === 12 && d > 29) return false;
                return true;
            }

            function nameinputByElement(inputElement) {
                const wrapper = inputElement.closest('.autocomplete');
                const clearBtn = wrapper.querySelector('.clear-btn');
                if (inputElement.value.length > 0) {
                    wrapper.classList.add("filled");
                    clearBtn.style.display = 'block';
                } else {
                    wrapper.classList.remove("filled");
                    clearBtn.style.display = 'none';
                }
            }
        });
    </script>
    <script>
        function toggleForms() {
            const isHaghighi = document.getElementById("haghighi").checked;
            document.getElementById("haghighi-form").style.display = isHaghighi ? "flex" : "none";
            document.getElementById("hoghoghi-form").style.display = isHaghighi ? "none" : "flex";

            const isHoghoghi = document.getElementById("hoghoghi").checked;
            document.getElementById("haghighi-form").style.display = isHoghoghi ? "none" : "flex";
            document.getElementById("hoghoghi-form").style.display = isHoghoghi ? "flex" : "none";
        }

        function handleGenderChange() {
            const mokhtalet = document.getElementById("mokhtalet").checked;
            const checkbox = document.getElementById("tabsare_34");

            if (mokhtalet) {
                checkbox.checked = true;
                // checkbox.disabled = true;
            } else {
                checkbox.checked = false;
                // checkbox.disabled = false;
            }
        }

        // cities
        function changeostan(elem) {
            id = elem.value
            states = {!! json_encode($states->toArray()) !!}
            for (i = 0; i < states.length; i++) {
                if (id == states[i].id)
                    cities = states[i].cities
            }
            options = ''
            for (j = 0; j < cities.length; j++) {
                options += '<option value="' + cities[j].id + '">' + cities[j].title + '</option>'
            }
            document.getElementById('city').innerHTML = options

        }
    </script>
    {{-- inputs script --}}
    <script>
        $(document).on("input", ".only-persian", function() {
            let value = $(this).val();
            let inputField = $(this);
            let name = inputField.attr('name');
            let errorMsg = $("#error-" + name);

            // الگوی حروف انگلیسی (به جز اعداد و نقطه)
            let englishLettersPattern = /[A-Za-z]/;

            if (englishLettersPattern.test(value.replace(/[0-9۰-۹\.]/g, ''))) {
                // اگر حروف انگلیسی غیر از اعداد و نقطه وجود داشت
                inputField.addClass("border-danger shake");
                errorMsg.show();

                setTimeout(function() {
                    inputField.removeClass('shake');
                }, 300);
            } else {
                // اگر فقط فارسی، اعداد یا نقطه بود
                inputField.removeClass("border-danger");
                errorMsg.hide();
            }

            // حذف حروف غیرمجاز (نگه داشتن حروف فارسی، فاصله، اعداد انگلیسی/فارسی و نقطه)
            let filteredValue = value.replace(/[^\u0600-\u06FF\s0-9۰-۹\.]/g, '');
            inputField.val(filteredValue);

            // مدیریت ظاهر جعبه و دکمه حذف
            const box = document.getElementById("autocompleteBox" + name);
            const clearBtn = document.getElementById("clearBtn_" + name);
            if (filteredValue.length > 0) {
                box.classList.add("filled");
                clearBtn.style.display = 'block';
            } else {
                box.classList.remove("filled");
                clearBtn.style.display = 'none';
            }
        });


        $(document).on("input", ".only-number", function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            let name = $(this).attr('name');
            const box = document.getElementById("autocompleteBox" + name);
            const clearBtn = document.getElementById("clearBtn_" + name);
            let value2 = $(this).val();
            if (value2.length > 0) {
                box.classList.add("filled");
                clearBtn.style.display = 'block';
            } else {
                box.classList.remove("filled");
                clearBtn.style.display = 'none';
            }
        });
        $(document).on("input", ".only-number-sign", function() {
            this.value = this.value.replace(/[^0-9+\-*/.]/g, '');
            let name = $(this).attr('name');
            const box = document.getElementById("autocompleteBox" + name);
            const clearBtn = document.getElementById("clearBtn_" + name);
            let value2 = $(this).val();
            if (value2.length > 0) {
                box.classList.add("filled");
                clearBtn.style.display = 'block';
            } else {
                box.classList.remove("filled");
                clearBtn.style.display = 'none';
            }
        });



        $(document).ready(function() {
            const $licenseRadio = $('input[name="license"]');
            const $dateInput = $('#searchInputfirst_license_date');
            const picker = $dateInput[0]?._flatpickr; // نمونه flatpickr
            const $sourceDateInput = $('#searchInputexport_start'); // منبع تاریخ (در صورت نیاز)

            $licenseRadio.on('change', function() {
                const selected = $(this).val(); // 'first' یا 'extension'

                if (selected === 'first') {
                    // دریافت مقدار از منبع (در صورت وجود) یا هشدار
                    const dateValue = $sourceDateInput.val();
                    if (!dateValue) {
                        alert('لطفاً ابتدا تاریخ شروع را تکمیل کنید.');
                        // رادیوباکس را به حالت تمدید برگردانید تا کاربر مجبور به پر کردن شود
                        $('#parvane_tamdid').prop('checked', true).trigger('change');
                        return;
                    }

                    // غیرفعال کردن flatpickr و readonly
                    picker.setDate(dateValue);
                    $("#autocompleteBoxfirst_license_date").addClass('filled');
                    $dateInput.prop('disabled', true).prop('readonly', true);
                    if (picker) {
                        picker.set('clickOpens', false);
                        picker.set('allowInput', false);
                        picker.close(); // بستن تقویم در صورت باز بودن
                    }

                } else if (selected === 'extension') {
                    // فعال‌سازی دوباره
                    if (picker) {
                        picker.set('clickOpens', true);
                        picker.set('allowInput', true);
                        // picker.enable();
                    }
                    $dateInput.prop('readonly', false);
                    picker.clear();
                    // (اختیاری) می‌توانید مقدار را خالی کنید
                    // $dateInput.val('');
                    // flatpickr را پاک کنید: picker.clear();
                }
            });

            // اگر مقدار old('license') برابر 'first' باشد، حالت اولیه را فعال کند
            if ($licenseRadio.filter(':checked').val() === 'first') {
                $licenseRadio.trigger('change');
            }
        });
    </script>
    <script>
        const states = @json($states);

        function nameinput(id) {
            if (id == 'searchInputexport_start') {
                const input = document.getElementById("searchInputexport_start");
                const box = document.getElementById("autocompleteBoxsodor_start");
                const clearBtn = document.getElementById("clearBtn_sodor_start");
                if (input.value.length > 0) {
                    const $datepickerPopup = $('.datepicker-plot-area:visible');
                    $datepickerPopup.css('display', 'none');
                    box.classList.add("filled");
                    clearBtn.style.display = 'block';
                } else {
                    box.classList.remove("filled");
                    clearBtn.style.display = 'none';
                }
            } else if (id == 'export_reset') {
                const input = document.getElementById("searchInputexport_reset");
                const box = document.getElementById("autocompleteBoxexport_reset");
                const clearBtn = document.getElementById("clearBtn_export_reset");
                if (input.value.length > 0) {
                    const $datepickerPopup = $('.datepicker-plot-area:visible');
                    $datepickerPopup.css('display', 'none');
                    box.classList.add("filled");
                    clearBtn.style.display = 'block';
                } else {
                    box.classList.remove("filled");
                    clearBtn.style.display = 'none';
                }
            } else if (id == 'searchInputfirst_license_date') {} else if (id == 'searchInputexport_end') {
                const input = document.getElementById("searchInputexport_end");
                const box = document.getElementById("autocompleteBoxsodor_end");
                const clearBtn = document.getElementById("clearBtn_sodor_end");
                if (input.value.length > 0) {
                    const $datepickerPopup = $('.datepicker-plot-area:visible');
                    $datepickerPopup.css('display', 'none');
                    box.classList.add("filled");
                    clearBtn.style.display = 'block';
                } else {
                    box.classList.remove("filled");
                    clearBtn.style.display = 'none';
                }
            } else if (id == 'searchInputfirst_license_date') {
                const input = document.getElementById("searchInputfirst_license_date");
                const box = document.getElementById("autocompleteBoxparvane_date");
                const clearBtn = document.getElementById("clearBtn_parvane_date");
                if (input.value.length > 0) {
                    const $datepickerPopup = $('.datepicker-plot-area:visible');
                    $datepickerPopup.css('display', 'none');
                    box.classList.add("filled");
                    clearBtn.style.display = 'block';
                } else {
                    box.classList.remove("filled");
                    clearBtn.style.display = 'none';
                }
            } else if (id == 'searchInputnatural_birth_date') {
                const input = document.getElementById("searchInputnatural_birth_date");
                const box = document.getElementById("autocompleteBoxnatural_birth_date");
                const clearBtn = document.getElementById("clearBtn_natural_birth_date");
                if (input.value.length > 0) {
                    const $datepickerPopup = $('.datepicker-plot-area:visible');
                    $datepickerPopup.css('display', 'none');
                    box.classList.add("filled");
                    clearBtn.style.display = 'block';
                } else {
                    box.classList.remove("filled");
                    clearBtn.style.display = 'none';
                }
            } else if (id == 'searchInputregister_date') {
                const input = document.getElementById("searchInputregister_date");
                const box = document.getElementById("autocompleteBoxregister_date");
                const clearBtn = document.getElementById("clearBtn_register_date");
                if (input.value.length > 0) {
                    const $datepickerPopup = $('.datepicker-plot-area:visible');
                    $datepickerPopup.css('display', 'none');
                    box.classList.add("filled");
                    clearBtn.style.display = 'block';
                } else {
                    box.classList.remove("filled");
                    clearBtn.style.display = 'none';
                }
            } else {
                const input = document.getElementById("searchInput" + id);
                const box = document.getElementById("autocompleteBox" + id);
                const clearBtn = document.getElementById("clearBtn_" + id);
                if (input.value.length > 0) {
                    box.classList.add("filled");
                    clearBtn.style.display = 'block';
                } else {
                    box.classList.remove("filled");
                    clearBtn.style.display = 'none';
                }
            }
        }

        function clearInput(id) {

            const box = document.getElementById("autocompleteBox" + id);
            box.classList.remove("filled");
            const input = document.getElementById("searchInput" + id);
            input.value = "";
            const clearBtn = document.getElementById("clearBtn_" + id);
            clearBtn.style.display = 'none';

            if (id == 'state') {
                const box2 = document.getElementById("autocompleteBoxcity");
                const input2 = document.getElementById("searchInputcity");
                input2.value = "";
                document.getElementById("selectedIdcity").value = "";
                box2.classList.remove("filled");
                const clearBtn2 = document.getElementById("clearBtn_city");
                clearBtn2.style.display = 'none';
            }
        }
    </script>
    <script>
        function dropdownshow(id) {
            filterOptions(id, 0);
            const dropdown = document.getElementById("dropdownList" + id);
            dropdown.style.display = 'block';
        }

        function hideDropdown() {
            const dropdown = document.getElementById("dropdownList" + id);
            setTimeout(() => dropdown.style.display = 'none', 150);
        }

        function filterOptions(divId, status) {
            const dropdown = document.getElementById("dropdownList" + divId);
            const input = document.getElementById("searchInput" + divId);
            const box = document.getElementById("autocompleteBox" + divId);
            const value = input.value.toLowerCase();
            if (divId == "city") {
                city = document.getElementById("selectedIdstate").value;
                $.ajax({
                    url: '/states/' + city, //  URL جدید
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {

                        if (status == 1) {
                            const filtered = data.filter(item => item.title.toLowerCase().startsWith(value));
                            dropdown.innerHTML = filtered.length ?
                                filtered.map((item, index) =>
                                    `<div class="${index === 0 ? 'active' : ''}" onclick="selectItem(${item.id}, '${item.title}','${divId}')">${item.title}</div>`
                                ).join('') :
                                '<div>نتیجه‌ای یافت نشد</div>';
                        } else {
                            const filtered = data;
                            dropdown.innerHTML = filtered.length ?
                                filtered.map((item, index) =>
                                    `<div class="${index === 0 ? 'active' : ''}" onclick="selectItem(${item.id}, '${item.title}','${divId}')">${item.title}</div>`
                                ).join('') :
                                '<div>نتیجه‌ای یافت نشد</div>';
                        }

                        box.classList.toggle("filled", input.value.trim() !== "");
                    }
                });

                box.classList.toggle("filled", input.value.trim() !== "");
            } else if (divId == "state") {

                if (status == 1) {
                    const filtered = states.filter(item => item.title.toLowerCase().includes(value));
                    dropdown.innerHTML = filtered.length ?
                        filtered.map(item =>
                            `<div onclick="selectItem(${item.id}, '${item.title}','${divId}')">${item.title}</div>`)
                        .join('') :
                        '<div>نتیجه‌ای یافت نشد</div>';
                } else {
                    const filtered = states;
                    dropdown.innerHTML = filtered.length ?
                        filtered.map(item =>
                            `<div onclick="selectItem(${item.id}, '${item.title}','${divId}')">${item.title}</div>`)
                        .join('') :
                        '<div>نتیجه‌ای یافت نشد</div>';
                }

                box.classList.toggle("filled", input.value.trim() !== "");
            }
            const firstOption = dropdown.querySelector("div");
            if (firstOption) firstOption.classList.add("active");
        }

        function selectItem(id, name, divId) {
            const input = document.getElementById("searchInput" + divId);
            const box = document.getElementById("autocompleteBox" + divId);
            const dropdown = document.getElementById("dropdownList" + divId);


            if (divId == "state") {
                $('selectedId').change(function() { // به تغییرات در لیست *استان* گوش میدیم
                    var cityId = $(this).val(); //  مقدار (ID) *استان* انتخاب شده
                    if (cityId) {
                        $.ajax({
                            url: '/states/' + cityId, //  URL جدید
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                const filtered = data.filter(item => item.title.toLowerCase().includes(
                                    value));
                                dropdown.innerHTML = filtered.length ?
                                    filtered.map(item =>
                                        `<div onclick="selectItem(${item.id}, '${item.title}','${divId}')">${item.title}</div>`
                                    )
                                    .join('') :
                                    '<div>نتیجه‌ای یافت نشد</div>';
                                box.classList.toggle("filled", input.value.trim() !== "");
                            }
                        });
                    } else {
                        $('#state').empty();
                        $('#state').append(
                            '<option value="">شهرستان</option>'); //اگر استانی انتخاب *نشد*، شهرستان ها خالی
                    }
                });
                clearInput('city');
            }

            input.value = name;
            document.getElementById("selectedId" + divId).value = id;
            box.classList.add("filled");
            dropdown.style.display = 'none';
            const clearBtn = document.getElementById("clearBtn_" + divId);
            clearBtn.style.display = 'block';
        }

        // function clearInput(id) {
        //     if (id == 'name') {
        //         const box = document.getElementById("autocompleteBoxname");
        //         box.classList.remove("filled");
        //         const input = document.getElementById("searchInputname");
        //         input.value = "";
        //         const clearBtn = document.getElementById("clearBtn_name");
        //         clearBtn.style.display = 'none';
        //     } else {
        //         const box = document.getElementById("autocompleteBox" + id);
        //         const input = document.getElementById("searchInput" + id);
        //         input.value = "";
        //         document.getElementById("selectedId" + id).value = "";
        //         box.classList.remove("filled");
        //         if (id == 'state') {
        //             const box2 = document.getElementById("autocompleteBoxcity");
        //             const input2 = document.getElementById("searchInputcity");
        //             input2.value = "";
        //             document.getElementById("selectedIdcity").value = "";
        //             box2.classList.remove("filled");
        //             const clearBtn2 = document.getElementById("clearBtn_city");
        //             clearBtn2.style.display = 'none';
        //         }
        //         const clearBtn = document.getElementById("clearBtn_" + id);
        //         clearBtn.style.display = 'none';
        //         filterOptions(id, 0);
        //     }
        // }

        // بستن لیست با کلیک خارج از آن
        document.addEventListener("click", function(e) {
            const box1 = document.getElementById("autocompleteBoxstate");
            const box2 = document.getElementById("autocompleteBoxcity");
            const box3 = document.getElementById("autocompleteBoxgroup");
            const box4 = document.getElementById("autocompleteBoxherfe");
            const dropdown1 = document.getElementById("dropdownListstate");
            const dropdown2 = document.getElementById("dropdownListcity");
            const dropdown3 = document.getElementById("dropdownListgroup");
            const dropdown4 = document.getElementById("dropdownListherfe");


            if (box1 && !box1.contains(e.target)) {
                dropdown1.style.display = "none";
            }
            if (box2 && !box2.contains(e.target)) {
                dropdown2.style.display = "none";
            }
            if (box3 && !box3.contains(e.target)) {
                dropdown3.style.display = "none";
            }
            if (box4 && !box4.contains(e.target)) {
                dropdown4.style.display = "none";
            }
        });

        document.querySelectorAll("input[id^='searchInput']").forEach(input => {
            input.addEventListener("keydown", function(e) {
                const id = this.id.replace("searchInput", "");
                const dropdown = document.getElementById("dropdownList" + id);
                const items = dropdown.querySelectorAll("div");
                const active = dropdown.querySelector(".active");
                let index = Array.from(items).indexOf(active);

                if (e.key === "ArrowDown") {
                    e.preventDefault();
                    if (index < items.length - 1) {
                        if (active) active.classList.remove("active");
                        items[index + 1].classList.add("active");
                        items[index + 1].scrollIntoView({
                            block: "nearest"
                        });
                    }
                }

                if (e.key === "ArrowUp") {
                    e.preventDefault();
                    if (index > 0) {
                        if (active) active.classList.remove("active");
                        items[index - 1].classList.add("active");
                        items[index - 1].scrollIntoView({
                            block: "nearest"
                        });
                    }
                }

                if (e.key === "Enter") {
                    e.preventDefault();
                    if (active) {
                        const idValue = getIdFromElement(active); // تابع استخراج id
                        const name = active.textContent.trim();
                        selectItem(idValue, name, id);
                    }
                }
            });
        });

        function getIdFromElement(el) {
            // استخراج id از onclick
            const onclick = el.getAttribute("onclick");
            const match = onclick.match(/selectItem\((\d+),/);
            return match ? parseInt(match[1]) : "";
        }
    </script>
    {{-- validation --}}
    <script>
        $(document).ready(function() {
            $(document).on("blur", ".validate-input", function() {
                let inputField = $(this);
                let rule = inputField.data("rule");
                let value = inputField.val();
                let name = inputField.attr('name');
                let errorMsg = $("#error-" + name);

                let isValid = validateInput(rule, value);
                if (!isValid.status) {
                    // اگر فیلد نامعتبر بود
                    inputField.addClass("border-danger shake");
                    errorMsg.text(isValid.message).show();

                    setTimeout(function() {
                        inputField.removeClass('shake');
                    }, 300);
                } else {
                    // اگر معتبر بود
                    inputField.removeClass("border-danger");
                    errorMsg.hide();
                }
            });
        });

        function checkCodeMeli(code) {
            // حذف خط تیره‌ها از کد ملی
            code = code.replace(/-/g, '');

            // بررسی اولیه
            if (isNaN(code)) return false;
            if (code === "") return false;
            if (code.length !== 10) return false;

            // بررسی صحت الگوریتم کد ملی
            let sum = 0;
            for (let i = 0; i < 9; i++) {
                sum += parseInt(code[i]) * (10 - i);
            }

            const remainder = sum % 11;
            const controlDigit = parseInt(code[9]);

            // شرایط صحت کد ملی
            return (remainder < 2 && controlDigit === remainder) ||
                (remainder >= 2 && controlDigit === (11 - remainder));
        }

        function isValidIranianNationalCode(input) {
            // حذف همه خط تیره‌ها و فضاها
            const code = input.replace(/[- ]/g, '');

            // بررسی طول کد
            if (code.length !== 10) return false;

            // بررسی اینکه همه ارقام یکسان نباشند
            if (/^(\d)\1{9}$/.test(code)) return false;

            // محاسبه مجموع کنترل
            let sum = 0;
            for (let i = 0; i < 9; i++) {
                sum += parseInt(code.charAt(i)) * (10 - i);
            }

            const remainder = sum % 11;
            const controlDigit = parseInt(code.charAt(9));

            // اعتبارسنجی نهایی
            return (remainder < 2 && controlDigit === remainder) ||
                (remainder >= 2 && controlDigit === (11 - remainder));
        }

        // تابع اعتبارسنجی مرکزی
        function validateInput(rule, value) {
            // alert(value);
            if (value.length == 0) {
                return {
                    status: true
                }
            } else {
                switch (rule) {
                    case 'mobile':
                        if (!/^09\d{9}$/.test(value)) {
                            return {
                                status: false,
                                message: "شماره موبایل باید با 09 شروع شده و 11 رقمی باشد."
                            };
                        }
                        break;
                    case 'nationalCode':
                        if (!isValidIranianNationalCode(value)) {
                            return {
                                status: false,
                                message: "کد ملی وارد شده معتبر نیست."
                            };
                        }
                        break;
                    case 'prefix':
                        if (!/^\d{3}$/.test(value)) {
                            return {
                                status: false,
                                message: "پیش شماره باید 3 رقمی باشد."
                            };
                        }
                        break;
                    case 'fax':
                        if (!/^\d{8}$/.test(value)) {
                            return {
                                status: false,
                                message: "فکس باید 8 رقمی باشد."
                            };
                        }
                        break;
                    case 'phone':
                        if (!/^\d{8}$/.test(value)) {
                            return {
                                status: false,
                                message: "شماره تلفن باید 8 رقمی باشد."
                            };
                        }
                        break;
                }
                return {
                    status: true
                };
            }
        }
    </script>
    {{-- فایل عناوین آموزشی --}}
    <script>
        $(document).on('change', '.custom-file-input', function() {
            let fileCount = this.files.length;
            let fileCountText = fileCount === 0 ? 'فایلی انتخاب نشده' : fileCount + ' فایل انتخاب شده';
            // عنصر نمایشی که کنار این اینپوت هست رو پیدا کن
            $(this).siblings('.file-count').text(fileCountText);
        });

        // files select
        let selectedFiles = [];

        $('#customFileInput').on('change', function(event) {
            let files = Array.from(event.target.files);
            selectedFiles = selectedFiles.concat(files);

            updateFileList();
        });

        function updateFileList() {
            if (selectedFiles.length === 0) {
                $('#fileCountText').text('فایلی انتخاب نشده');
                $('#customFileInput').val('');
                $('#fileList').empty();
                return;
            }

            $('#fileCountText').text(selectedFiles.length + ' فایل انتخاب شده');

            let html = '';
            selectedFiles.forEach((file, index) => {
                let sizeInKB = (file.size / 1024).toFixed(1);
                html += `
            <div class="d-flex align-items-center justify-content-between mb-2 border bg-white p-2 rounded">
                <div class="d-flex align-items-center">
                    <img src="${URL.createObjectURL(file)}" alt="تصویر" width="50px" class="me-3 rounded">
                    <div class="me-3">
                        <div>${file.name}</div>
                        <small class="text-muted">${sizeInKB} KB</small>
                    </div>
                </div>
                <button type="button" class="btn btn-close text-danger btn-sm" onclick="removeFiles(${index})"></button>
            </div>
        `;
            });
            $('#fileList').html(html);
            // alert('ok');
        }

        function removeFiles(index) {
            // alert('ok');
            selectedFiles.splice(index, 1);
            // alert('ok');
            updateFileList();
            // alert('ok');
        }
    </script>
    <script>
        $('#file_tasis_front').on('change', function(event) {
            let file = event.target.files[0];
            if (file) {
                let sizeInKB = (file.size / 1024).toFixed(1);
                $('#file_tasis_front_count').text('1 فایل انتخاب شده');

                let html = `
            <div class="d-flex align-items-center justify-content-between mb-2 border bg-white p-2 rounded">
                <div class="d-flex align-items-center">
                    <img src="${URL.createObjectURL(file)}" alt="تصویر" width="50px" class="me-3 rounded">
                    <div class="me-3">
                        <div>${file.name}</div>
                        <small class="text-muted">${sizeInKB} KB</small>
                    </div>
                </div>
                <button type="button" class="btn btn-close text-danger btn-sm" onclick="removeFile('front')"></button>
            </div>
        `;
                $('#file_tasis_front_preview').html(html);
            }
        });

        $('#file_tasis_back').on('change', function(event) {
            let file = event.target.files[0];
            if (file) {
                let sizeInKB = (file.size / 1024).toFixed(1);
                $('#file_tasis_back_count').text('1 فایل انتخاب شده');

                let html = `
            <div class="d-flex align-items-center justify-content-between mb-2 border bg-white p-2 rounded">
                <div class="d-flex align-items-center">
                    <img src="${URL.createObjectURL(file)}" alt="تصویر" width="50px" class="me-3 rounded">
                    <div class="me-3">
                        <div>${file.name}</div>
                        <small class="text-muted">${sizeInKB} KB</small>
                    </div>
                </div>
                <button type="button" class="btn btn-close text-danger btn-sm" onclick="removeFile('back')"></button>
            </div>
        `;
                $('#file_tasis_back_preview').html(html);
            }
        });

        function removeFile(type) {
            if (type === 'front') {
                $('#file_tasis_front').val('');
                $('#file_tasis_front_count').text('فایلی انتخاب نشده');
                $('#file_tasis_front_preview').empty();
            } else if (type === 'back') {
                $('#file_tasis_back').val('');
                $('#file_tasis_back_count').text('فایلی انتخاب نشده');
                $('#file_tasis_back_preview').empty();
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nationalCodeInput = document.getElementById('searchInputnational_code');
            // فرمت کردن کد ملی هنگام تایپ
            nationalCodeInput.addEventListener('input', function(e) {
                // حذف همه خط تیره‌های موجود
                let value = this.value.replace(/-/g, '');

                // اضافه کردن خط تیره در موقعیت‌های مورد نظر
                if (value.length > 3) {
                    value = value.substring(0, 3) + '-' + value.substring(3);
                }
                if (value.length > 10) {
                    value = value.substring(0, 10) + '-' + value.substring(10);
                }

                // محدود کردن طول به 12 کاراکتر (با احتساب خط تیره‌ها)
                this.value = value.substring(0, 12);

                // فراخوانی تابع nameinput که در کد شما وجود دارد
                nameinput('national_code');
            });

            // حذف خط تیره‌ها قبل از ارسال فرم
            const form = nationalCodeInput.closest('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    nationalCodeInput.value = nationalCodeInput.value.replace(/-/g, '');
                });
            }
        });
        // تابع فرمت کردن کد پستی
        function formatPostalCode(input) {
            // حذف همه خط تیره‌های موجود
            let value = input.value.replace(/-/g, '');

            // محدود کردن به 10 رقم (بدون خط تیره)
            value = value.substring(0, 10);

            // اضافه کردن خط تیره بعد از 5 رقم
            if (value.length > 5) {
                value = value.substring(0, 5) + '-' + value.substring(5);
            }

            // اعمال مقدار فرمت شده
            input.value = value;

            // فراخوانی تابع nameinput که در کد شما وجود دارد
            nameinput('postal_code');
        }

        // حذف خط تیره قبل از ارسال فرم
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function() {
                    const postalInput = document.getElementById('searchInputpostal');
                    postalInput.value = postalInput.value.replace(/-/g, '');
                });
            }
        });
    </script>
@endsection
