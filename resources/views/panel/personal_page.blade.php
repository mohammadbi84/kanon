@extends('panel.layout.master')
@section('head')
    <title>ویرایش صفحه شخصی اموزشگاه</title>
    <style>
        .main-container {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background: white;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .nav-tabs .nav-link {
            color: #495057;
            font-weight: 500;
            font-size: 14px;
            border: none;
            border-bottom: 3px solid transparent;
            padding: 15px 20px;
            transition: all 0.3s;
        }

        .nav-tabs .nav-link:hover {
            border-color: transparent;
            background-color: #f8f9fa;
        }

        .nav-tabs .nav-link.active {
            color: #e69926;
            background-color: transparent;
            border-color: #e69926;
        }

        .nav-tabs {
            border-bottom: 1px solid #dee2e6;
            padding: 0 15px;
        }

        .tab-content {
            padding: 25px;
        }

        .card {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 8px;
        }

        .card-header {
            background-color: #f8f9fa;
            color: #141414;
            border-radius: 8px 8px 0 0 !important;
            /* font-weight: bold; */
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            padding: 15px 20px;
        }

        .profile-header {
            position: relative;
            height: 250px;
            overflow: hidden;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .profile-header img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-header-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.5);
            padding: 15px;
            color: white;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #e69926;
            color: white;
            margin-left: 5px;
        }

        .map-container {
            height: 300px;
            border-radius: 8px;
            overflow: hidden;
            z-index: 1;
        }

        .teacher-card {
            transition: all 0.3s;
        }

        .teacher-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .gallery-item {
            position: relative;
            margin-bottom: 15px;
            overflow: hidden;
            border-radius: 8px;
            height: 200px;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        .gallery-item .btn-remove {
            position: absolute;
            top: 5px;
            left: 5px;
        }
        .gallery-item .btn-remove {
            position: absolute;
            top: 5px;
            left: 5px;
        }

        .gallery-item .btn-edit {
            position: absolute;
            top: 5px;
            right: 5px;
        }

        .gallery-count {
            position: absolute;
            top: 5px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* استایل اینپوت های سفارشی شما */
        .autocomplete {
            position: relative;
            margin-bottom: 15px;
        }

        .autocomplete input,
        .autocomplete textarea,
        .autocomplete select {
            outline: 0px solid transparent !important;
            width: 100%;
            padding: 10px 15px 10px 10px;
            padding-left: 24px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 14px;
            background-color: #fff;
        }

        .autocomplete label {
            font-size: 15px;
            position: absolute;
            right: 15px;
            top: 21%;
            transition: 0.2s;
            pointer-events: none;
            color: #666;
        }

        .autocomplete .dropdown .active {
            background-color: #F2F9FF;
        }

        .autocomplete input:focus+label,
        .autocomplete.filled input+label,
        .autocomplete textarea:focus+label,
        .autocomplete.filled textarea+label,
        .autocomplete select:focus+label,
        .autocomplete.filled select+label {
            outline: none !important;
            border: none !important;
            top: -10px !important;
            right: 10px;
            background: white;
            padding: 0 5px;
            font-size: 0.75rem;
            color: #6c757d;
        }

        .autocomplete .clear-btn {
            display: none;
            position: absolute;
            left: 10px;
            top: 47%;
            transform: translateY(-50%);
            cursor: pointer;
            font-weight: bold;
            color: #888;
        }

        .autocomplete .dropdown {
            /* padding-bottom: 50px; */
            position: absolute;
            top: 110%;
            border-radius: 5px;
            right: 0;
            left: 0;
            border: 1px solid #ccc;
            border-top: none;
            max-height: 250px;
            overflow-y: auto;
            background: white;
            z-index: 2;
        }

        .autocomplete .dropdown::-webkit-scrollbar {
            background-color: #ffffff;
            width: 3px;
        }

        .autocomplete .dropdown::-webkit-scrollbar-thumb {
            background-color: #bfbfbf;
            border-radius: 10px;
            width: 6px;
        }

        .autocomplete .dropdown div {
            padding: 8px 10px;
            cursor: pointer;
            font-size: 14px;
        }

        .autocomplete .dropdown div:hover {
            background: #f0f0f0;
        }

        /* Leaflet map adjustments */
        .leaflet-top .leaflet-control {
            gap: 10px;
            display: grid;
        }

        .leaflet-control-zoom a {
            border-radius: 4px !important;
            /* margin-bottom: 5px; */
            color: #333 !important;
        }

        /* Custom button styles */
        .btn-primary {
            background-color: #e69926;
            border-color: #e69926;
        }

        .btn-success {
            background-color: #1cc88a;
            border-color: #1cc88a;
        }

        .btn-primary:hover,
        .btn-success:hover {
            opacity: 0.9;
        }

        .save-section {
            /* position: sticky; */
            /* bottom: 0; */
            /* background: white; */
            padding: 15px;
            border-top: 1px solid #dee2e6;
            z-index: 100;
        }

        .coordinates-info {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 10px 15px;
            margin-bottom: 15px;
            font-size: 14px;
            margin-top: 20px;
        }

        /* استایل نوار حجم */
        .storage-info {
            /* background: #f8f9fa; */
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            /* border: 1px solid #e9ecef; */
            min-width: 25%;
        }

        .storage-progress {
            height: 4px;
            border-radius: 5px;
            margin: 5px 0;
            overflow: hidden;
            background: #e3e3e3 !important;
        }

        .storage-progress-bar {
            height: 100%;
            border-radius: 5px;
            transition: width 0.3s;
        }

        .storage-details {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #6c757d;
        }

        .storage-warning {
            color: #ffc107;
            font-weight: bold;
        }

        .storage-danger {
            color: #dc3545;
            font-weight: bold;
        }

        .file-size-info {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 5px;
        }

        .gallery_count {
            top: 5px !important;
            right: 5px !important;
            border-radius: 5px;
            padding: 3px;
            background: #d5d5d5a5
        }
        /* مودال ویرایش تصویر */
        .modal-content {
            border-radius: 10px;
        }

        .modal-header {
            background-color: #4e73df;
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .image-preview-container {
            text-align: center;
            margin: 15px 0;
        }

        .image-preview {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
        }
    </style>
@endsection
@section('content')
    <div class="container wrapper py-4" style="margin-top: 70px">
        <div class="main-container">
            <div class="w-100 d-flex justify-content-between align-items-center">
                <h4 class="text-end px-4 py-4">ویرایش صفحه شخصی آموزشگاه</h4>
                <!-- نوار اطلاعات حجم -->
                <div class="storage-info">
                    <div class="d-flex justify-content-end align-items-center">
                        {{-- <span class="mb-0" style="font-size: 12px;">حجم آپلود شده: <span id="usedStorage">0</span> از
                            <span id="totalStorage">2</span>
                            مگابایت</span> --}}
                        <span id="storagePercentage" style="font-size: 12px;">0%</span>
                    </div>
                    <div class="storage-progress" dir="ltr">
                        <div id="storageProgressBar" class="storage-progress-bar bg-success" style="width: 0%"></div>
                    </div>
                    <div class="storage-details">
                        <span style="font-size: 12px;">
                            <span id="storageStatus" style="font-size: 12px;">2</span> آزاد از <span id="totalStorage"
                                style="font-size: 12px;">10</span> <span class="mx-1"
                                style="font-size: 12px;">مگابایت</span>
                        </span>
                        {{-- <span id="storageStatus">حجم آزاد: 2 مگابایت</span> --}}
                        {{-- <span id="storageAlert" class="d-none" style="font-size: 12px;">هشدار: حجم شما در حال پر شدن است</span> --}}
                    </div>
                </div>
            </div>

            <!-- تب ها -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="header-tab" data-bs-toggle="tab" data-bs-target="#header"
                        type="button" role="tab" aria-controls="header" aria-selected="true">
                        <i class="fas fa-image ms-2"></i>تصویر هدر
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button"
                        role="tab" aria-controls="basic" aria-selected="false">
                        <i class="fas fa-info-circle ms-2"></i>اطلاعات اصلی
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button"
                        role="tab" aria-controls="social" aria-selected="false">
                        <i class="fas fa-share-alt ms-2"></i>شبکه های اجتماعی
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="map-tab" data-bs-toggle="tab" data-bs-target="#map-tab-content"
                        type="button" role="tab" aria-controls="map-tab-content" aria-selected="false">
                        <i class="fas fa-map-marker-alt ms-2"></i>نقشه
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button"
                        role="tab" aria-controls="about" aria-selected="false">
                        <i class="fas fa-book-open ms-2"></i>معرفی آموزشگاه
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="teachers-tab" data-bs-toggle="tab" data-bs-target="#teachers"
                        type="button" role="tab" aria-controls="teachers" aria-selected="false">
                        <i class="fas fa-chalkboard-teacher ms-2"></i>اساتید
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery" type="button"
                        role="tab" aria-controls="gallery" aria-selected="false">
                        <i class="fas fa-photo-video ms-2"></i>گالری
                    </button>
                </li>
            </ul>

            <!-- محتوای تب ها -->
            <div class="tab-content" id="myTabContent">
                <!-- تب تصویر هدر -->
                <div class="tab-pane fade show active" id="header" role="tabpanel" aria-labelledby="header-tab">
                    <div class="profile-header border">
                        <img id="headerPreview"
                            src="https://via.placeholder.com/1200x250/e69926/ffffff?text=آموزشگاه+خود+را+اینجا+بارگذاری+کنید"
                            alt="هدر آموزشگاه">
                        <div class="profile-header-overlay">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>تصویر هدر آموزشگاه</span>
                                <div>
                                    <input type="file" id="headerUpload" accept="image/*" class="d-none"
                                        data-max-size="500">
                                    <label for="headerUpload" class="btn btn-primary btn-sm"><i
                                            class="fas fa-camera ms-1"></i> تغییر تصویر</label>
                                    <button class="btn btn-danger btn-sm" id="removeHeader"><i
                                            class="fas fa-trash ms-1"></i> حذف</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="file-size-info" id="headerFileSizeInfo"></div>
                </div>

                <!-- تب اطلاعات اصلی -->
                <div class="tab-pane fade" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="autocomplete" id="autocompleteBoxname">
                                <input type="text" id="searchInputname" name="name" oninput="nameinput('name')">
                                <label for="searchInputname" style="right: 15px;">نام آموزشگاه</label>
                                <span class="clear-btn" id="clearBtn_name" onclick="clearInput('name')">×</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="autocomplete" id="autocompleteBoxcategory">
                                <input type="text" id="searchInputcategory" name="category"
                                    oninput="nameinput('category')">
                                <label for="searchInputcategory" style="right: 15px;">دسته‌بندی آموزشگاه</label>
                                <span class="clear-btn" id="clearBtn_category" onclick="clearInput('category')">×</span>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="autocomplete" id="autocompleteBoxaddress">
                                <textarea id="searchInputaddress" name="address" rows="2" oninput="nameinput('address')"></textarea>
                                <label for="searchInputaddress" style="right: 15px;">آدرس آموزشگاه</label>
                                <span class="clear-btn" id="clearBtn_address" onclick="clearInput('address')">×</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- تب شبکه های اجتماعی -->
                <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                    <div id="socialNetworks">
                        <div class="social-item row mb-3">
                            <div class="col-md-4">
                                <div class="autocomplete" id="autocompleteBox2">
                                    <input type="text" id="searchInput2" oninput="filterOptions('2',1)"
                                        onclick="dropdownshow('2')">
                                    <label>شبکه اجتماعی</label>
                                    <span class="clear-btn" id="clearBtn_2" onclick="clearInput('2')">×</span>
                                    <div class="dropdown" id="dropdownList2" style="display: none;"></div>
                                    <input type="hidden" name="social" id="selectedId2">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="autocomplete" id="autocompleteBox1">
                                    <input type="url" class="social-url" id="searchInput1" oninput="nameinput('1')">
                                    <label style="right: 15px;">لینک شبکه اجتماعی</label>
                                    <span class="clear-btn" id="clearBtn_1" onclick="clearInput('1')">×</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-remove-social"><i
                                        class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mt-3" id="addSocial"><i
                            class="fas fa-plus-circle"></i>
                        افزودن شبکه اجتماعی</button>
                </div>

                <!-- تب نقشه -->
                <div class="tab-pane fade" id="map-tab-content" role="tabpanel" aria-labelledby="map-tab">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>برای تغییر موقعیت، روی نقشه کلیک کنید یا نشانگر را بکشید.</div>
                            <div class="" style="min-width: 250px;">
                                <!-- انتخاب شهر -->
                                <div class="city-selector mb-0">
                                    <div class="autocomplete mb-0" id="autocompleteBoxcity">
                                        <input type="text" id="searchInputcity" oninput="filterOptions('city',1)"
                                            onclick="dropdownshow('city')">
                                        <label>انتخاب شهر</label>
                                        <span class="clear-btn" id="clearBtn_city" onclick="clearInput('city')">×</span>
                                        <div class="dropdown" id="dropdownListcity" style="display: none;"></div>
                                        <input type="hidden" name="social" id="selectedIdcity">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- نقشه -->
                            <div class="map-container bg-light" id="map">
                                <!-- نقشه در اینجا لود خواهد شد -->
                            </div>

                            <!-- اطلاعات مختصات -->
                            <div class="coordinates-info">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>عرض جغرافیایی:</strong>
                                        <span id="latitudeDisplay">31.897423</span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>طول جغرافیایی:</strong>
                                        <span id="longitudeDisplay">54.356857</span>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">برای تغییر موقعیت، روی نقشه کلیک کنید یا نشانگر را
                                        بکشید.</small>
                                </div>
                            </div>

                            <input type="hidden" class="form-control" id="latitude" value="31.897423">
                            <input type="hidden" class="form-control" id="longitude" value="54.356857">

                            <div class="mt-3">
                                <button class="btn btn-primary" id="locateMe">
                                    <i class="fas fa-location-arrow"></i> پیدا کردن موقعیت من
                                </button>
                                <button class="btn btn-outline-secondary" id="resetMap">
                                    <i class="fas fa-map-marker-alt"></i> بازنشانی موقعیت
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- تب معرفی آموزشگاه -->
                <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">
                    <div class="card">
                        <div class="card-header">معرفی آموزشگاه</div>
                        <div class="card-body">
                            <textarea id="summernote" name="editordata"></textarea>
                        </div>
                    </div>
                </div>

                <!-- تب اساتید -->
                <div class="tab-pane fade" id="teachers" role="tabpanel" aria-labelledby="teachers-tab">
                    <div id="teachersList">
                        <div class="teacher-card card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="teacher-image-container text-center mb-3">
                                            <img src="https://via.placeholder.com/150/e69926/ffffff?text=تصویر+استاد"
                                                class="img-thumbnail teacher-image" alt="تصویر استاد">
                                            <input type="file" class="d-none teacher-image-input" accept="image/*"
                                                data-max-size="300">
                                            <button class="btn btn-sm btn-outline-primary mt-2 teacher-image-btn">انتخاب
                                                تصویر</button>
                                            <div class="file-size-info teacher-file-size-info"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="autocomplete" id="autocompleteBoxteacherName">
                                                    <input type="text" id="searchInputteacherName" name="teacherName"
                                                        oninput="nameinput('teacherName')">
                                                    <label for="searchInputteacherName" style="right: 15px;">نام
                                                        استاد</label>
                                                    <span class="clear-btn" id="clearBtn_teacherName"
                                                        onclick="clearInput('teacherName')">×</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="autocomplete" id="autocompleteBoxteacherDegree">
                                                    <input type="text" id="searchInputteacherDegree"
                                                        name="teacherDegree" oninput="nameinput('teacherDegree')">
                                                    <label for="searchInputteacherDegree" style="right: 15px;">مدرک
                                                        استاد</label>
                                                    <span class="clear-btn" id="clearBtn_teacherDegree"
                                                        onclick="clearInput('teacherDegree')">×</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <div class="autocomplete" id="autocompleteBoxteacherBio">
                                                    <textarea id="searchInputteacherBio" name="teacherBio" rows="3" oninput="nameinput('teacherBio')"></textarea>
                                                    <label for="searchInputteacherBio" style="right: 15px;">بیوگرافی
                                                        استاد</label>
                                                    <span class="clear-btn" id="clearBtn_teacherBio"
                                                        onclick="clearInput('teacherBio')">×</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="button" class="btn btn-danger btn-remove-teacher"><i
                                            class="fas fa-trash"></i> حذف استاد</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mt-3" id="addTeacher"><i
                            class="fas fa-plus-circle"></i> افزودن استاد جدید</button>
                </div>

                <!-- تب گالری -->
                <div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
                    <div class="row" id="galleryItems">
                    </div>
                    <div class="mt-4">
                        <input type="file" id="galleryUpload" multiple accept="image/*" class="d-none"
                            data-max-size="80000">
                        <label for="galleryUpload" class="btn btn-primary"><i class="fas fa-cloud-upload-alt"></i> آپلود
                            تصاویر جدید</label>
                    </div>
                </div>
            </div>

            <!-- دکمه های ذخیره و انصراف -->
            <div class="save-section">
                <div class="row">
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-primary mx-2" id="saveProfile"><i
                                class="fas fa-check-circle"></i> ذخیره تغییرات</button>
                        <button type="button" class="btn btn-secondary mx-2" id="cancelChanges"><i
                                class="fas fa-times-circle"></i> انصراف</button>
                    </div>
                </div>
            </div>

            <!-- مودال ویرایش تصویر گالری -->
            <div class="modal fade" id="editImageModal" tabindex="-1" aria-labelledby="editImageModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editImageModalLabel">ویرایش تصویر گالری</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="image-preview-container">
                                <img id="editImagePreview" src="" alt="تصویر برای ویرایش" class="image-preview">
                            </div>
                            <div class="mb-3">
                                <label for="editImageFile" class="form-label">انتخاب تصویر جدید</label>
                                <input class="form-control" type="file" id="editImageFile" accept="image/*">
                            </div>
                            <div class="file-size-info" id="editImageFileSizeInfo"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                            <button type="button" class="btn btn-primary" id="saveEditedImage">ذخیره تغییرات</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // متغیرهای جهانی برای نقشه
        let map, marker, defaultLatitude = 31.8974,
            defaultLongitude = 54.3569;



        let totalStorageLimit = 2 * 1024 * 1024; // 2 مگابایت به بایت
        let currentStorageUsed = 0; // حجم فعلی استفاده شده (بر حسب بایت)
        let uploadedFiles = []; // لیست فایل‌های آپلود شده

        // تابع تبدیل بایت به واحد خوانا
        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 بایت';

            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['بایت', 'کیلوبایت', 'مگابایت', 'گیگابایت'];

            const i = Math.floor(Math.log(bytes) / Math.log(k));

            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }

        // تابع به‌روزرسانی نوار حجم
        function updateStorageDisplay() {
            const percentage = (currentStorageUsed / totalStorageLimit) * 100;
            const remainingStorage = totalStorageLimit - currentStorageUsed;

            // document.getElementById('usedStorage').textContent = formatBytes(currentStorageUsed);
            document.getElementById('storagePercentage').textContent = percentage.toFixed(1) + '%';
            document.getElementById('storageProgressBar').style.width = percentage + '%';
            document.getElementById('storageStatus').textContent = formatBytes(remainingStorage);

            // تغییر رنگ نوار بر اساس درصد استفاده
            const progressBar = document.getElementById('storageProgressBar');
            if (percentage >= 90) {
                progressBar.className = 'storage-progress-bar bg-danger';
                // document.getElementById('storageAlert').classList.remove('d-none');
                // document.getElementById('storageAlert').textContent = 'هشدار: حجم شما تقریباً پر شده است!';
                // document.getElementById('storageAlert').className = 'storage-danger';
            } else if (percentage >= 75) {
                progressBar.className = 'storage-progress-bar bg-warning';
                // document.getElementById('storageAlert').classList.remove('d-none');
                // document.getElementById('storageAlert').textContent = 'هشدار: حجم شما در حال پر شدن است';
                // document.getElementById('storageAlert').className = 'storage-warning';
            } else {
                progressBar.className = 'storage-progress-bar bg-success';
                // document.getElementById('storageAlert').classList.add('d-none');
            }
        }

        // تابع بررسی حجم فایل قبل از آپلود
        function checkFileSize(file, maxSizeKB, fileType) {
            const maxSizeBytes = maxSizeKB * 1024;

            if (file.size > maxSizeBytes) {
                alert(
                    `حجم فایل ${fileType} باید کمتر از ${maxSizeKB} کیلوبایت باشد. حجم فایل انتخابی: ${formatBytes(file.size)}`
                );
                return false;
            }

            // بررسی حجم کل
            if (currentStorageUsed + file.size > totalStorageLimit) {
                const remaining = formatBytes(totalStorageLimit - currentStorageUsed);
                alert(`حجم کل آپلود شما از محدودیت 2 مگابایت بیشتر خواهد شد. حجم باقیمانده: ${remaining}`);
                return false;
            }

            return true;
        }

        // تابع افزودن فایل به لیست و به‌روزرسانی حجم
        function addFileToStorage(file, fileType, maxSizeKB) {
            if (!checkFileSize(file, maxSizeKB, fileType)) {
                return false;
            }

            // افزودن فایل به لیست
            const fileId = Date.now();
            uploadedFiles.push({
                id: fileId,
                file: file,
                type: fileType,
                size: file.size
            });

            // به‌روزرسانی حجم استفاده شده
            currentStorageUsed += file.size;
            updateStorageDisplay();

            return fileId;
        }

        // تابع حذف فایل از لیست و به‌روزرسانی حجم
        function removeFileFromStorage(fileId) {
            // alert('tettdtdttd');
            const fileIndex = uploadedFiles.findIndex(f => f.id === fileId);
            // alert(fileIndex);
            // alert(uploadedFiles);
            if (fileIndex !== -1) {
                currentStorageUsed -= uploadedFiles[fileIndex].size;
                uploadedFiles.splice(fileIndex, 1);
                updateStorageDisplay();
            }
        }




        // فعال کردن ویرایشگر متن
        $(document).ready(function() {
            updateStorageDisplay();


            $('#summernote').summernote({
                lang: 'fa-IR',
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            // فعال کردن تب ها
            const triggerTabList = document.querySelectorAll('#myTab button')
            triggerTabList.forEach(triggerEl => {
                new bootstrap.Tab(triggerEl)
            });
        });

        // مختصات شهرهای استان یزد
        const yazdCities = [{
                lat: 31.8974,
                lng: 54.3569,
                name: 'یزد'
            },
            {
                lat: 31.0290,
                lng: 55.9660,
                name: 'اردکان'
            },
            {
                lat: 32.2350,
                lng: 54.0000,
                name: 'بافق'
            },
            {
                lat: 31.5833,
                lng: 54.2000,
                name: 'تفت'
            },
            {
                lat: 32.2500,
                lng: 54.5167,
                name: 'مهریز'
            },
            {
                lat: 31.5167,
                lng: 54.1167,
                name: 'میبد'
            },
            {
                lat: 30.0594,
                lng: 55.9800,
                name: 'اشکذر'
            },
            {
                lat: 31.9333,
                lng: 54.2833,
                name: 'بهاباد'
            },
            {
                lat: 31.1833,
                lng: 53.2500,
                name: 'خاتم'
            },
            {
                lat: 31.4167,
                lng: 54.6667,
                name: 'صدوق'
            },
        ];

        // تابع مقداردهی اولیه نقشه
        function initMap(lat = defaultLatitude, lng = defaultLongitude) {
            // اگر نقشه قبلاً ایجاد شده، آن را حذف کن
            if (map) {
                map.remove();
            }

            // ایجاد نقشه با موقعیت داده شده
            map = L.map('map').setView([lat, lng], 13);

            // اضافه کردن لایه نقشه
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // ایجاد نشانگر و اضافه کردن آن به نقشه
            marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map);

            // به‌روزرسانی مختصات هنگامی که نشانگر حرکت می‌کند
            marker.on('dragend', function(e) {
                updateCoordinates(marker.getLatLng());
            });

            // اضافه کردن رویداد کلیک روی نقشه برای تغییر موقعیت نشانگر
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                updateCoordinates(e.latlng);
            });

            // به‌روزرسانی مختصات
            updateCoordinates({
                lat: lat,
                lng: lng
            });
        }

        // تابع به‌روزرسانی مختصات در فیلدها
        function updateCoordinates(coords) {
            document.getElementById('latitude').value = coords.lat.toFixed(6);
            document.getElementById('longitude').value = coords.lng.toFixed(6);
            document.getElementById('latitudeDisplay').textContent = coords.lat.toFixed(6);
            document.getElementById('longitudeDisplay').textContent = coords.lng.toFixed(6);
        }

        // تابع تغییر شهر
        function changeCity(cityName) {
            const filteredcity = yazdCities.filter(citiy => {
                if (cityName && citiy.name !== cityName) {
                    return false;
                }
                return true;
            });
            filteredcity.forEach(city => {
                initMap(city.lat, city.lng);
            });
        }

        // وقتی صفحه لود شد
        $(document).ready(function() {
            // مقداردهی اولیه نقشه
            initMap();

            // پیدا کردن موقعیت کاربر
            $('#locateMe').click(function() {
                if ("geolocation" in navigator) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        // به‌روزرسانی نقشه و نشانگر
                        map.setView([lat, lng], 15);
                        marker.setLatLng([lat, lng]);

                        // به‌روزرسانی فیلدهای مختصات
                        updateCoordinates({
                            lat: lat,
                            lng: lng
                        });
                    }, function(error) {
                        alert(
                            'دسترسی به موقعیت مکانی امکان‌پذیر نیست. لطفاً از تنظیمات مرورگر خود اجازه دسترسی به موقعیت مکانی را فعال کنید.'
                        );
                    });
                } else {
                    alert('مرورگر شما از ویژگی موقعیت‌یابی پشتیبانی نمی‌کند.');
                }
            });

            // بازنشانی نقشه به موقعیت پیش‌فرض (یزد)
            $('#resetMap').click(function() {
                initMap(defaultLatitude, defaultLongitude);
            });

            // فعال کردن تب ها
            const triggerTabList = document.querySelectorAll('#myTab button')
            triggerTabList.forEach(triggerEl => {
                new bootstrap.Tab(triggerEl)
            });
        });


        // توابع اینپوت های سفارشی شما
        function nameinput(id) {
            const input = document.getElementById("searchInput" + id);
            const box = document.getElementById("autocompleteBox" + id);
            const clearBtn = document.getElementById("clearBtn_" + id);
            if (input && input.value.length > 0) {
                box.classList.add("filled");
                if (clearBtn) clearBtn.style.display = 'block';
            } else {
                box.classList.remove("filled");
                if (clearBtn) clearBtn.style.display = 'none';
            }
        }

        function clearInput(id) {
            if (id == 'name' || id == 'reshte') {
                const box = document.getElementById("autocompleteBox" + id);
                box.classList.remove("filled");
                const input = document.getElementById("searchInput" + id);
                input.value = "";
                const clearBtn = document.getElementById("clearBtn_" + id);
                clearBtn.style.display = 'none';
            } else {
                const box = document.getElementById("autocompleteBox" + id);
                const input = document.getElementById("searchInput" + id);
                input.value = "";
                const select = document.getElementById("selectedId" + id);
                if (select) {
                    select.value = '';
                    select.dispatchEvent(new Event('input', {
                        bubbles: true
                    }));
                }
                box.classList.remove("filled");
                if (id == 'state') {
                    const box2 = document.getElementById("autocompleteBoxcity");
                    const input2 = document.getElementById("searchInputcity");
                    input2.value = "";
                    if (document.getElementById("selectedIdcity")) {
                        document.getElementById("selectedIdcity").value = "";
                    }
                    box2.classList.remove("filled");
                    const clearBtn2 = document.getElementById("clearBtn_city");
                    clearBtn2.style.display = 'none';
                }
                const clearBtn = document.getElementById("clearBtn_" + id);
                if (clearBtn) clearBtn.style.display = 'none';
            }
        }

        function dropdownshow(id) {
            filterOptions(id, 0);
            const dropdown = document.getElementById("dropdownList" + id);
            dropdown.style.display = 'block';
        }

        function hideDropdown() {
            const dropdown = document.getElementById("dropdownList" + id);

            setTimeout(() => dropdown.style.display = 'none', 150);
        }

        var socials = [{
                id: 1,
                name: "اینستاگرام"
            },
            {
                id: 2,
                name: "تلگرام"
            },
            {
                id: 3,
                name: "ایتا"
            },
            {
                id: 4,
                name: "ایمیل"
            }
        ];

        function filterOptions(divId, status) {
            const dropdown = document.getElementById("dropdownList" + divId);
            const input = document.getElementById("searchInput" + divId);
            const box = document.getElementById("autocompleteBox" + divId);
            const value = input.value.toLowerCase();
            if (divId == 'city') {
                if (status == 1) {
                    const filtered = yazdCities.filter(item => item.name.toLowerCase().startsWith(value));
                    dropdown.innerHTML = filtered.length ?
                        filtered.map(item =>
                            `<div onclick="selectItem('${item.name}', '${item.name}','${divId}')">${item.name}</div>`)
                        .join('') :
                        '<div>نتیجه‌ای یافت نشد</div>';
                } else {
                    const filtered = yazdCities;
                    dropdown.innerHTML = filtered.length ?
                        filtered.map(item =>
                            `<div onclick="selectItem('${item.name}', '${item.name}','${divId}')">${item.name}</div>`)
                        .join('') :
                        '<div>نتیجه‌ای یافت نشد</div>';
                }

            } else {
                if (status == 1) {
                    const filtered = socials.filter(item => item.name.toLowerCase().startsWith(value));
                    dropdown.innerHTML = filtered.length ?
                        filtered.map(item =>
                            `<div onclick="selectItem(${item.id}, '${item.name}','${divId}')">${item.name}</div>`)
                        .join('') :
                        '<div>نتیجه‌ای یافت نشد</div>';
                } else {
                    const filtered = socials;
                    dropdown.innerHTML = filtered.length ?
                        filtered.map(item =>
                            `<div onclick="selectItem(${item.id}, '${item.name}','${divId}')">${item.name}</div>`)
                        .join('') :
                        '<div>نتیجه‌ای یافت نشد</div>';
                }
            }
            box.classList.toggle("filled", input.value.trim() !== "");
            const firstOption = dropdown.querySelector("div");
            if (firstOption) firstOption.classList.add("active");
        }

        function selectItem(id, name, divId) {
            const input = document.getElementById("searchInput" + divId);
            const box = document.getElementById("autocompleteBox" + divId);
            const dropdown = document.getElementById("dropdownList" + divId);

            input.value = name;
            document.getElementById("selectedId" + divId).value = id;
            box.classList.add("filled");
            dropdown.style.display = 'none';
            const clearBtn = document.getElementById("clearBtn_" + divId);
            clearBtn.style.display = 'block';

            if (divId == 'city') {
                changeCity(id);
            }
        }
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

        // وقتی جایی روی صفحه کلیک شد
        document.addEventListener('click', function(e) {
            // اگر کلیک داخل جعبه autocomplete ای که dropdown داره بود، هیچی نکن
            if (e.target.closest('.autocomplete') && e.target.closest('.autocomplete').querySelector('.dropdown')) {
                return;
            }

            // در غیر این صورت، همه dropdownها بسته بشن
            document.querySelectorAll('.autocomplete .dropdown').forEach(dropdown => {
                dropdown.style.display = 'none';
            });
        });


        function getIdFromElement(el) {
            // استخراج id از onclick
            const onclick = el.getAttribute("onclick");
            const match = onclick.match(/selectItem\((\d+),/);
            return match ? parseInt(match[1]) : "";
        }

        // مدیریت آپلود تصویر هدر
        document.getElementById('headerUpload').addEventListener('change', function(e) {
            const file = e.target.files[0];

            if (addFileToStorage(file, 'header', 800000)) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('headerPreview').src = event.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                this.value = ''; // پاک کردن فایل انتخابی
            }
        });

        document.getElementById('removeHeader').addEventListener('click', function() {
            document.getElementById('headerPreview').src =
                'https://via.placeholder.com/1200x250/ddd/ddd?text=هدر+آموزشگاه';
        });

        // مدیریت شبکه های اجتماعی
        document.getElementById('addSocial').addEventListener('click', function() {
            const socialCount = document.querySelectorAll('.social-item').length + 1;
            const socialSelectCount = document.querySelectorAll('.social-item').length + 2;
            const socialHtml = `
                <div class="social-item row mb-3">
                    <div class="col-md-4">
                        <div class="autocomplete" id="autocompleteBox${socialSelectCount}">
                            <input type="text" id="searchInput${socialSelectCount}" oninput="filterOptions('${socialSelectCount}',1)"
                                onclick="dropdownshow('${socialSelectCount}')">
                            <label>شبکه اجتماعی</label>
                            <span class="clear-btn" id="clearBtn_${socialSelectCount}" onclick="clearInput('${socialSelectCount}')">×</span>
                            <div class="dropdown" id="dropdownList${socialSelectCount}" style="display: none;"></div>
                            <input type="hidden" name="${socialSelectCount}" id="selectedId${socialSelectCount}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="autocomplete" id="autocompleteBox${socialCount}">
                            <input type="url" class="social-url" id="searchInput${socialCount}" oninput="nameinput('${socialCount}')">
                            <label style="right: 15px;">لینک شبکه اجتماعی</label>
                            <span class="clear-btn" id="clearBtn_${socialCount}" onclick="clearInput('${socialCount}')">×</span>
                        </div>

                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-remove-social"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
            `;

            const div = document.createElement('div');
            div.innerHTML = socialHtml;
            document.getElementById('socialNetworks').appendChild(div);

            // اضافه کردن event listener برای دکمه حذف
            div.querySelector('.btn-remove-social').addEventListener('click', function() {
                this.closest('.social-item').remove();
            });
        });

        // مدیریت اساتید
        document.getElementById('addTeacher').addEventListener('click', function() {
            const teacherCount = document.querySelectorAll('.teacher-card').length + 1;
            const teacherHtml = `
                <div class="teacher-card card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="teacher-image-container text-center mb-3">
                                    <img src="https://via.placeholder.com/150/e69926/ffffff?text=تصویر+استاد" class="img-thumbnail teacher-image" alt="تصویر استاد">
                                    <div class="file-size-info teacher-file-size-info"></div>
                                    <input type="file" class="d-none teacher-image-input" accept="image/*">
                                    <button class="btn btn-sm btn-outline-primary mt-2 teacher-image-btn">انتخاب تصویر</button>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="autocomplete" id="autocompleteBoxteacherName${teacherCount}">
                                            <input type="text" class="teacher-name-input" oninput="nameinput('teacherName${teacherCount}')">
                                            <label style="right: 15px;">نام استاد</label>
                                            <span class="clear-btn" onclick="clearInput('teacherName${teacherCount}')">×</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="autocomplete" id="autocompleteBoxteacherDegree${teacherCount}">
                                            <input type="text" class="teacher-degree-input" oninput="nameinput('teacherDegree${teacherCount}')">
                                            <label style="right: 15px;">مدرک استاد</label>
                                            <span class="clear-btn" onclick="clearInput('teacherDegree${teacherCount}')">×</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="autocomplete" id="autocompleteBoxteacherBio${teacherCount}">
                                            <textarea class="teacher-bio-input" rows="3" oninput="nameinput('teacherBio${teacherCount}')"></textarea>
                                            <label style="right: 15px;">بیوگرافی استاد</label>
                                            <span class="clear-btn" onclick="clearInput('teacherBio${teacherCount}')">×</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-danger btn-remove-teacher"><i class="fas fa-trash"></i> حذف استاد</button>
                        </div>
                    </div>
                </div>
            `;

            const div = document.createElement('div');
            div.innerHTML = teacherHtml;
            document.getElementById('teachersList').appendChild(div);

            // اضافه کردن event listener برای دکمه حذف
            div.querySelector('.btn-remove-teacher').addEventListener('click', function() {
                this.closest('.teacher-card').remove();
            });

            // مدیریت آپلود تصویر استاد
            const imageBtn = div.querySelector('.teacher-image-btn');
            const imageInput = div.querySelector('.teacher-image-input');
            const imagePreview = div.querySelector('.teacher-image');
            const fileSizeInfo = div.querySelector('.teacher-file-size-info');

            imageBtn.addEventListener('click', function() {
                imageInput.click();
            });

            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const fileId = Date.now();
                    this.setAttribute('data-file-id', fileId);

                    if (addFileToStorage(file, 'teacher', 10000000)) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            imagePreview.src = event.target.result;
                        };
                        reader.readAsDataURL(file);

                        // نمایش اطلاعات حجم فایل
                        fileSizeInfo.textContent = `اندازه فایل: ${formatBytes(file.size)}`;
                    } else {
                        this.value = ''; // پاک کردن فایل انتخابی
                    }
                }
            });
        });


        // گاللللللرییییی
        // تابع به‌روزرسانی شماره‌گذاری تصاویر گالری
        function updateGalleryIndexes() {
            const galleryItems = document.querySelectorAll('#galleryItems .gallery-item');
            galleryItems.forEach((item, index) => {
                const countElement = item.querySelector('.gallery-count');
                if (countElement) {
                    countElement.textContent = index + 1;
                }
            });
        }

        // تابع باز کردن مودال ویرایش تصویر
        function openEditImageModal(fileId) {
            const file = uploadedFiles.find(f => f.id === fileId);
            if (!file) return;

            currentEditingImageId = fileId;

            // نمایش تصویر فعلی در مودال
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('editImagePreview').src = event.target.result;
            };
            reader.readAsDataURL(file.file);

            // نمایش اطلاعات فایل
            document.getElementById('editImageFileSizeInfo').textContent = `اندازه فعلی: ${formatBytes(file.size)}`;

            // باز کردن مودال
            const modal = new bootstrap.Modal(document.getElementById('editImageModal'));
            modal.show();
        }

        // تابع ذخیره تصویر ویرایش شده
        function saveEditedImage(newFile) {
            if (!currentEditingImageId || !newFile) return;

            const fileIndex = uploadedFiles.findIndex(f => f.id === currentEditingImageId);
            if (fileIndex === -1) return;

            // بررسی حجم فایل جدید
            if (!checkFileSize(newFile, 40000000, 'گالری')) {
                return;
            }

            // محاسبه اختلاف حجم
            const sizeDifference = newFile.size - uploadedFiles[fileIndex].size;

            // بررسی آیا حجم کل از محدودیت بیشتر می‌شود
            if (currentStorageUsed + sizeDifference > totalStorageLimit) {
                alert('حجم فایل جدید از محدودیت مجاز بیشتر خواهد شد.');
                return;
            }

            // به‌روزرسانی فایل
            uploadedFiles[fileIndex].file = newFile;
            uploadedFiles[fileIndex].size = newFile.size;

            // به‌روزرسانی حجم استفاده شده
            currentStorageUsed += sizeDifference;
            updateStorageDisplay();

            // به‌روزرسانی تصویر در گالری
            const galleryItem = document.querySelector(`.gallery-item[data-file-id="${currentEditingImageId}"]`);
            if (galleryItem) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    galleryItem.querySelector('img').src = event.target.result;
                    galleryItem.querySelector('.file-size-info').textContent = `اندازه: ${formatBytes(newFile.size)}`;
                };
                reader.readAsDataURL(newFile);
            }

            // بستن مودال
            bootstrap.Modal.getInstance(document.getElementById('editImageModal')).hide();
            currentEditingImageId = null;

            alert('تصویر با موفقیت ویرایش شد.');
        }

        // مدیریت ویرایش تصویر در مودال
        document.getElementById('editImageFile').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('editImagePreview').src = event.target.result;
                };
                reader.readAsDataURL(file);

                document.getElementById('editImageFileSizeInfo').textContent =
                    `اندازه فعلی: ${formatBytes(uploadedFiles.find(f => f.id === currentEditingImageId).size)} | اندازه جدید: ${formatBytes(file.size)}`;
            }
        });

        // مدیریت گالری تصاویر
        document.getElementById('galleryUpload').addEventListener('change', function(e) {
            const files = e.target.files;

            if (files.length > 0) {
                let validFiles = [];

                // بررسی تمام فایل‌ها
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    if (checkFileSize(file, 40000000, 'گالری')) {
                        validFiles.push(file);
                    }
                }

                // آپلود فایل‌های معتبر
                for (let i = 0; i < validFiles.length; i++) {
                    const file = validFiles[i];
                    const fileId = addFileToStorage(file, 'gallery', 40000000);
                    if (fileId) {
                        const reader = new FileReader();

                        reader.onload = function(event) {
                            // شماره تصویر بر اساس تعداد تصاویر موجود + 1
                            const currentCount = document.querySelectorAll('#galleryItems .gallery-item')
                                .length + 1;

                            const galleryHtml = `
                                <div class="gallery-item position-relative" data-file-id="${fileId}">
                                    <img src="${event.target.result}" alt="تصویر گالری" class="w-100 h-100 object-fit-cover">
                                    <span class="gallery-count">${currentCount}</span>
                                    <button class="btn btn-danger btn-sm btn-remove" data-file-id="${fileId}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <button class="btn btn-primary btn-sm btn-edit" data-file-id="${fileId}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <div class="file-size-info">اندازه: ${formatBytes(file.size)}</div>
                                </div>
                            `;

                            const div = document.createElement('div');
                            div.classList.add('col-md-3')
                            div.innerHTML = galleryHtml;
                            document.getElementById('galleryItems').appendChild(div);

                            // اضافه کردن event listener برای دکمه حذف
                            div.querySelector('.btn-remove').addEventListener('click', function() {
                                const fileId = parseInt(this.getAttribute('data-file-id'));
                                removeFileFromStorage(fileId);
                                this.closest('.col-md-3').remove();
                                updateGalleryIndexes(); // به‌روزرسانی شماره‌ها پس از حذف
                            });

                            // اضافه کردن event listener برای دکمه ویرایش
                            div.querySelector('.btn-edit').addEventListener('click', function() {
                                const fileId = parseInt(this.getAttribute('data-file-id'));
                                openEditImageModal(fileId);
                            });
                        };

                        reader.readAsDataURL(file);
                    }
                }
            }

            // پاک کردن فایل‌های انتخابی از input
            this.value = '';
        });

        // ذخیره تصویر ویرایش شده
        document.getElementById('saveEditedImage').addEventListener('click', function() {
            const fileInput = document.getElementById('editImageFile');
            if (fileInput.files.length > 0) {
                saveEditedImage(fileInput.files[0]);
            } else {
                alert('لطفاً یک تصویر جدید انتخاب کنید.');
            }
        });

        // پیدا کردن موقعیت کاربر
        document.getElementById('locateMe').addEventListener('click', function() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    // به‌روزرسانی نقشه و نشانگر
                    map.setView([lat, lng], 15);
                    marker.setLatLng([lat, lng]);

                    // به‌روزرسانی فیلدهای مختصات
                    document.getElementById('latitude').value = lat.toFixed(6);
                    document.getElementById('longitude').value = lng.toFixed(6);
                }, function(error) {
                    alert(
                        'دسترسی به موقعیت مکانی امکان‌پذیر نیست. لطفاً از تنظیمات مرورگر خود اجازه دسترسی به موقعیت مکانی را فعال کنید.'
                    );
                });
            } else {
                alert('مرورگر شما از ویژگی موقعیت‌یابی پشتیبانی نمی‌کند.');
            }
        });

        // بازنشانی نقشه به موقعیت پیش‌فرض
        document.getElementById('resetMap').addEventListener('click', function() {
            map.setView([defaultLatitude, defaultLongitude], 13);
            marker.setLatLng([defaultLatitude, defaultLongitude]);
            document.getElementById('latitude').value = defaultLatitude.toFixed(6);
            document.getElementById('longitude').value = defaultLongitude.toFixed(6);
        });

        // مدیریت دکمه های ذخیره و انصراف
        document.getElementById('saveProfile').addEventListener('click', function() {
            // بررسی حجم کل قبل از ذخیره
            if (currentStorageUsed > totalStorageLimit) {
                alert('حجم آپلود شده از محدودیت مجاز بیشتر است. لطفاً برخی فایل‌ها را حذف کنید.');
                return;
            }
            // در اینجا می‌توانید داده‌ها را جمع‌آوری و به سرور ارسال کنید
            const formData = {
                name: document.getElementById('searchInputname').value,
                category: document.getElementById('searchInputcategory').value,
                address: document.getElementById('searchInputaddress').value,
                latitude: document.getElementById('latitude').value,
                longitude: document.getElementById('longitude').value,
                description: $('#summernote').summernote('code')
            };

            console.log('داده‌های فرم:', formData);
            alert('تغییرات با موفقیت ذخیره شدند!');
        });

        document.getElementById('cancelChanges').addEventListener('click', function() {
            if (confirm('آیا از انصراف از تغییرات اطمینان دارید؟')) {
                window.location.reload();
            }
        });

        // مقداردهی اولیه event listeners برای المان های موجود
        document.querySelectorAll('.btn-remove-social').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.social-item').remove();
            });
        });

        document.querySelectorAll('.btn-remove-teacher').forEach(button => {
            button.addEventListener('click', function() {
                // حذف تصویر استاد از لیست
                const imageInput = this.closest('.teacher-card').querySelector('.teacher-image-input');
                if (imageInput && imageInput.files.length > 0) {
                    const fileId = parseInt(imageInput.getAttribute('data-file-id'));
                    if (fileId) {
                        removeFileFromStorage(fileId);
                    }
                }
                this.closest('.teacher-card').remove();
            });
        });

        document.querySelectorAll('.btn-remove').forEach(button => {
            button.addEventListener('click', function() {
                const fileId = parseInt(this.getAttribute('data-file-id'));
                if (fileId) {
                    removeFileFromStorage(fileId);
                }
                this.closest('.col-md-3').remove();
            });
        });

        // مدیریت آپلود تصویر برای استاد موجود
        document.querySelectorAll('.teacher-image-btn').forEach(button => {
            button.addEventListener('click', function() {
                this.previousElementSibling.click();
            });
        });

        document.querySelectorAll('.teacher-image-input').forEach(input => {
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const fileId = Date.now();
                    this.setAttribute('data-file-id', fileId);

                    if (addFileToStorage(file, 'teacher', 400000000)) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            const imageElement = input.previousElementSibling;
                            imageElement.src = event.target.result;
                        };
                        reader.readAsDataURL(file);

                        // نمایش اطلاعات حجم فایل
                        const fileSizeInfo = this.parentNode.querySelector('.file-size-info');
                        if (fileSizeInfo) {
                            fileSizeInfo.textContent = `اندازه فایل: ${formatBytes(file.size)}`;
                        }
                    } else {
                        this.value = ''; // پاک کردن فایل انتخابی
                    }
                }
            });
        });

        // فعال کردن اینپوت‌های موجود
        document.querySelectorAll('.autocomplete input, .autocomplete textarea, .autocomplete select').forEach(input => {
            input.addEventListener('input', function() {
                const box = this.closest('.autocomplete');
                const label = box.querySelector('label');
                const clearBtn = box.querySelector('.clear-btn');

                if (this.value.length > 0) {
                    box.classList.add("filled");
                    if (clearBtn) clearBtn.style.display = 'block';
                } else {
                    box.classList.remove("filled");
                    if (clearBtn) clearBtn.style.display = 'none';
                }
            });
        });
    </script>
@endsection
