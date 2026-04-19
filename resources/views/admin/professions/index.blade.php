@extends('admin.layout.master')
@section('head')
    <style>
        @media print {

            /* همه چیز را به جز بخش پرینتی پنهان کن */
            @page {
                margin: 0 !important;
                /* حذف کامل margin چاپ */
            }

            body {
                margin: 0 !important;
                padding: 0 !important;
            }

            body * {
                visibility: hidden;
                /* اول همه چیز را پنهان کن */
            }

            .logs-container,
            .logs-container * {
                visibility: visible;
                /* بعد فقط بخش پرینتی و محتویاتش را آشکار کن */
            }

            .logs-container {
                position: absolute;
                /* موقعیت دهی مطلق برای اطمینان بیشتر */
                left: 0;
                top: 0;
                width: 100%;
                padding: 20px;
                margin: 0 !important;
                /* عرض کامل */
            }

            /* اگر لازم بود، استایل‌های دیگری هم اینجا اضافه کن */
            h1,
            p,
            ul {
                color: black !important;
                /* اطمینان از خوانایی */
            }
        }

        td {
            padding: 0 !important;
            text-align: center
        }

        th {
            text-align: center !important;
        }

        .table th {
            font-size: 13px !important;
        }

        tbody {
            font-size: 13px !important;
        }

        .form-control {
            font-size: 13px !important;
        }

        #custom-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(2px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
            border-radius: 8px;
        }

        .loader-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
        }

        .custom-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #e8e8e8;
            border-top: 5px solid #5a8dee;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        .loader-container span {
            color: #5a8dee;
            font-size: 16px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #btn-go-to-top .outer_circle {
            stroke: #5a8dee !important;
        }

        #btn-go-to-top span {
            position: absolute !important;
            top: 50% !important;
            left: 46% !important;
            transform: translate(-50%, -50%) rotate(90deg) !important;
        }

        #btn-go-to-top:hover .outer_circle {
            stroke: #5a8dee !important;
        }
        .table-responsive{
            overflow: unset !important;
        }
    </style>
    {{-- btn-go-to-top --}}
    <link rel="stylesheet" href="{{ asset('site/assets/css/btn-go-to-top.css') }}">
    <script src="{{ asset('site/assets/js/btn-go-to-top.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/nouislider/nouislider.css') }}">
    {{-- bootstrap icons --}}
    <link rel="stylesheet" href="https://lib.arvancloud.ir/bootstrap-icons/1.9.1/font/bootstrap-icons.css">
@endsection
@section('content')
    {{-- بررسی اینکه آیا field_id از URL آمده یا نه --}}
    @php
        $fieldId = request()->get('field_id');
    @endphp

    <h5 class="breadcrumb-wrapper mb-4">
        <a href="{{ route('admin.index') }}" class="text-muted">داشبورد</a> <span class="text-muted">/</span>
        <span class="text-muted">مدیریت استاندارد ها / </span>
        @if ($fieldId)
            <a href="{{ route('admin.categories.index') }}" class="text-muted">رسته
                {{ $field?->cluster->category->name }}</a>
            <span class="text-muted">/</span>
            <a href="{{ route('admin.clusters.index') }}" class="text-muted">خوشه {{ $field?->cluster?->name }}</a> <span
                class="text-muted">/</span>
            <a href="{{ route('admin.fields.index') }}" class="text-muted">رشته {{ $field?->name }}</a> <span
                class="text-muted">/</span>
        @endif
        <span>حرفه ها</span>
    </h5>
    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="head-label d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">لیست حرفه ها</h5>
                    <small class="text-muted ms-2">( تعداد کل : <span id="totalRecord">0</span> رکورد /
                        فلیتر شده : <span id="filteredrecord">0</span> ردیف /
                        انتخاب شده : <span id="selectedRecord">0</span> ردیف )</small>
                </div>
                <div class="d-flex justify-content-end align-items-center gap-3">
                    <div class="btn-group">
                        <button type="button" class="btn border btn-icon dropdown-toggle hide-arrow"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bx bx-menu"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalReport">گزارش
                                    گیری</button></li>
                            <li><a href="#" class="dropdown-item">دانلود فایل خام نمونه</a>
                            </li>
                            <li><button class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#modalImportExcel">آپلود اطلاعات از فایل اکسل</button></li>
                            <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="">دانلود اطلاعات در
                                    فایل اکسل</button>
                            </li>
                        </ul>
                    </div>
                    <a href="{{ route('admin.professions.create', ['fieldId' => $fieldId]) }}" class="btn btn-primary">
                        حرفه جدید
                        <i class="bx bx-plus ms-2"></i>
                    </a>
                </div>
            </div>
            <div class="bulk-actions" id="bulk-actions2">
                <div class="btn-group action_group" style="display: none">
                    <button type="button" class="btn border dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        انتخاب عملیـات
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <button class="dropdown-item bulk-toggle" data-status="1" disabled>
                                <i class=" bx bx-check"></i>
                                انتشار
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item bulk-toggle" data-status="0" disabled>
                                <i class=" bx bx-x"></i>
                                عدم انتشار
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item bulk-archive" data-status="1" disabled>
                                <i class=" bx bx-check"></i>
                                آرشیو
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item bulk-archive" data-status="0" disabled>
                                <i class=" bx bx-x"></i>
                                عدم آرشیو
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item text-danger bulk-delete" href="#">
                                <i class=" bx bx-trash"></i>
                                حذف انتخابی ها
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <table class="dt-select-table professions table table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>ردیف</th>
                        <th>رسته</th>
                        <th>خوشه</th>
                        <th>رشته</th>
                        <th>نام حرفه</th>
                        <th>کد استاندارد</th>
                        <th>مدت ساعات</th>
                        <th></th>
                        <th>انتشار</th>
                        <th>آرشیو</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
            </table>
            <div id="bulk-actions" class="bulk-actions">
                <div class="btn-group action_group" id="" style="display: none">
                    <button type="button" class="btn border dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        انتخاب عملیـات
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <button class="dropdown-item bulk-toggle" data-status="1" disabled>
                                <i class=" bx bx-check"></i>
                                انتشار
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item bulk-toggle" data-status="0" disabled>
                                <i class=" bx bx-x"></i>
                                عدم انتشار
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item bulk-archive" data-status="1" disabled>
                                <i class=" bx bx-check"></i>
                                آرشیو
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item bulk-archive" data-status="0" disabled>
                                <i class=" bx bx-x"></i>
                                عدم آرشیو
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item text-danger bulk-delete" href="#">
                                <i class=" bx bx-trash"></i>
                                حذف انتخابی ها
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalImportExcel" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title secondary-font" id="modalImportExcelTitle">آپلود حرفه ها از اکسل</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.professions.uploadExcel') }}" method="post" id="formUpload"
                        enctype="multipart/form-data">
                        @csrf
                        {{-- فیلد آپلود اکسل --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="custom-file-upload">
                                    <label for="file" class="upload-button">آپلود فایل اکسل</label>
                                    <input type="file" id="file" name="file" class="custom-file-input"
                                        style="display: none;">
                                    <span class="file-count">فایلی انتخاب نشده</span>
                                </div>
                                <div class="w-100 rounded" id="file-preview"></div>

                            </div>
                            <div class="col-sm-12 mt-3">
                                <button type="submit" id="btnSubmit" class="btn btn-primary">
                                    وارد کردن

                                </button>
                                <button id="btnSpinner" class="btn btn-primary d-none" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    درحال ذخیره
                                </button>
                            </div>
                            <div class="col-12">
                                <div id="uploadLogsContainer" class="mt-4 d-none">
                                    <div class="card">
                                        <div class="card-header bg-danger p-2 text-white">
                                            <h5 class="mb-0 text-white">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                خطاهای رخ داده در آپلود
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div id="logsList" class="pt-2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalReport" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">گزارش آپلودهای انجام شده</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="upload-list" class="list-group"></div>
                </div>
            </div>
        </div>
    </div>
    {{-- details --}}
    <div class="modal fade" id="professionDetailsModal" tabindex="-1" aria-labelledby="detailsLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsLabel">جزئیات حرفه</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                </div>
                <div class="modal-body">
                    <div id="profession-details-content" class="row gy-2"></div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal upload-file --}}
    <div class="modal fade" id="modalUpload" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title secondary-font" id="modalUploadTitle">ویرایش رسته</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.professions.upload') }}" method="post"
                        class="add-new-record pt-0 row g-2 px-3" id="form-upload-record" enctype="multipart/form-data">
                        @csrf
                        <div class="col-sm-12">
                            <input type="hidden" id="id" class="form-control" name="id">
                        </div>
                        <div class="col-sm-12">
                            <div class="custom-file-upload">
                                <label for="fileUpload" class="upload-button">آپلود فایل استاندارد</label>
                                <input type="file" id="fileUpload" name="fileUpload" class="custom-file-input"
                                    style="display: none;" accept=".pdf,.doc,.docx">
                                <span class="file-count">فایلی انتخاب نشده</span>
                            </div>
                            <div class="w-100 rounded" id="file-preview-2"></div>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ذخیره</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <a href="#" id="btn-go-to-top" class="shadow">
        <svg width="40" height="40" viewBox="0 0 131 131" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle class="outer_circle" cx="65.5" cy="65.5" r="64" stroke="red"></circle>
        </svg>
        <span class="bi bi-arrow-up"></span>
    </a>
@endsection
@section('script')
    <script src="{{ asset('admin/assets/js/validation.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/nouislider/nouislider.js') }}"></script>
    <script>
        professions = $(".professions");
        const urlParams = new URLSearchParams(window.location.search);
        const fieldId = urlParams.get("field_id");
        const categoryId = urlParams.get("category_id");
        const fieldName = urlParams.get("field_name");

        var minTime = 0;
        var maxTime = {{ $lastTime }};

        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            var hourValue = parseFloat(data[9]) || 0;
            if (minTime === null || maxTime === null) return true;
            return hourValue >= minTime && hourValue <= maxTime;
        });
        dt_basic = professions.DataTable({
            ajax: {
                url: "/admin2/professions",
                data: function(d) {
                    if (fieldId) {
                        d.field_id = fieldId; // ارسال فیلد رشته به سرور
                    }
                    if (categoryId) {
                        d.category_id = categoryId; // ارسال فیلد رشته به سرور
                    }
                },
                // این تابع قبل از شروع لود اجرا میشه
                beforeSend: function() {
                    $("#DataTables_Table_0_wrapper .dataTables_empty").hide();
                    $(".professions").closest(".card").append(`
                    <div id="custom-overlay">
                        <div class="loader-container">
                            <div class="custom-spinner"></div>
                            <span>در حال بارگزاری {{ $professions_count }} رکورد</span>
                            <span>لطفا شکیبا باشید.</span>
                        </div>
                    </div>
                `);
                },
                // این تابع بعد از اتمام لود اجرا میشه
                complete: function() {
                    $("#custom-overlay").remove();
                }
            },
            columns: [{
                    data: "id"
                }, // Responsive
                {
                    data: "id",
                    visible: false
                },
                {
                    data: null,
                    title: "ردیف",
                },
                {
                    data: "field.cluster.category.name",
                    title: "رسته"
                },
                {
                    data: "field.cluster.name",
                    title: "خوشه"
                },
                {
                    data: "field.name",
                    title: "رشته"
                },
                {
                    data: "name",
                    title: "حرفه"
                },
                {
                    data: "new_standard_code",
                    title: "کد استاندارد",
                },
                {
                    data: "total_hour", // 8: استفاده از داده عددی
                    title: "مدت ساعت",
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return row.total_minute + " : " + row.total_hour;
                        }
                        // برای sort و filter مقدار عددی
                        return parseInt(data) || 0;
                    }
                },
                {
                    data: "total_hour",
                    visible: false
                }, // 2: مخفی ساعت عددی
                {
                    data: "",
                    title: "انتشار"
                },
                {
                    data: "",
                    title: "آرشیو"
                },
                {
                    data: "",
                    title: "عملیات"
                },
            ],
            columnDefs: [{
                    targets: 0,
                    searchable: false,
                    orderable: false,
                    render: function() {
                        return '<input type="checkbox" class="dt-checkboxes form-check-input mt-0 align-middle">';
                    }
                },
                {
                    targets: 2,
                    data: null,
                    title: "ردیف",
                    orderable: true,
                    searchable: true,
                    render: function(data, type, full, meta) {
                        // شماره ردیف سراسری (بدون وابستگی به صفحه و سورت)
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    targets: -3,
                    title: "وضعیت",
                    orderable: true,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        if (type == 'sort') {
                            return full.active ? '1' : '0';
                        }
                        return full.active ?
                            `
                            <button data-id="${full.id}" class="btn text-success btn-icon item-toggle">
                                <i class="bx bx-check"></i>
                            </button>
                        ` :
                            `
                            <button data-id="${full.id}" class="btn text-danger btn-icon item-toggle">
                                <i class="bx bx-x"></i>
                            </button>
                        `;
                    },
                },
                {
                    targets: -2,
                    orderable: true,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        if (type == 'sort') {
                            return full.archive ? '1' : '0';
                        }
                        return full.archive ?
                            `
                            <button data-id="${full.id}" class="btn text-success btn-icon item-archive">
                                <i class="bx bx-check"></i>
                            </button>
                        ` :
                            `
                            <button data-id="${full.id}" class="btn text-danger btn-icon item-archive">
                                <i class="bx bx-x"></i>
                            </button>
                        `;
                    },
                },
                {
                    targets: -1,
                    title: "عملیات",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full) {
                        return `
                            <div class="btn-group">
                                <button type="button" class="btn btn-icon dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                            <button class="dropdown-item item-details" data-item='${JSON.stringify(full)}' >
                                                جزئیات
                                            </button>
                                    </li>
                                    <li>
                                        <a href="/admin2/professions/${full.id}" class="dropdown-item item-edit">
                                            ویرایش
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="dropdown-item item-show" data-id="${full.id}">
                                            سند حرفه (0)
                                        </a>
                                    </li>
                                    <li>
                                        <button class="dropdown-item item-delete" data-id="${full.id}">
                                            حذف
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item item-upload-file" data-id="${full.id}">
                                            آپلود فایل استاندارد
                                        </button>
                                    </li>
                                    ${
                                    full.standard_file?`<li><a href="/${full.standard_file}" target="_blank" class="dropdown-item">دانلود فایل استاندارد</a></li>`:'<li><button type="button" disabled class="dropdown-item">دانلود فایل استاندارد</button></li>'
                                    }
                                </ul>
                            </div>
                            `;
                    },
                },
            ],
            order: [
                [2, "asc"]
            ],
            dom: '<"card-header flex-column flex-md-row"<"dt-action-buttons text-end primary-font pt-3 pt-md-0"B>>' +
                '<"d-flex justify-content-between align-items-center"<"d-flex justify-content-start align-items-center gap-3"l <\'bulk-holder2\'>><"d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t>' +
                "<'row d-flex align-items-center justify-content-between'<'col-md-4'<'bulk-holder'>><'col-md-8 d-flex justify-content-between'i p>>",
            displayLength: 50,
            lengthMenu: [10, 25, 50, 75, 100, 500],
            buttons: [],
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function(row) {
                            var data = row.data();
                            return "جزئیات " + data["name"];
                        },
                    }),
                    type: "column",
                    renderer: function(api, rowIdx, columns) {
                        var data = $.map(columns, function(col) {
                            return col.title ?
                                '<tr data-dt-row="' +
                                col.rowIndex +
                                '" data-dt-column="' +
                                col.columnIndex +
                                '">' +
                                "<td>" +
                                col.title +
                                ":</td><td>" +
                                col.data +
                                "</td></tr>" :
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
                style: "multi",
                selector: 'td:first-child', // انتخاب با کلیک روی چک‌باکس
                items: 'row' // انتخاب ردیف‌ها
            },
            processing: true,
            initComplete: function(settings, json) {
                // وقتی جدول کامل بارگذاری شد، این کد اجرا میشه
                var api = this.api();

                // **اضافه کردن اسلایدر و تنظیم رویداد آن**
                var priceColumnHeader = $('.professions thead tr:eq(1) th').eq(7); // ستون قیمت
                priceColumnHeader.html(`<div class="noUi-primary mb-2 d-none" id="slider-primary"></div>
                    <div class="row">
                            <div class="slider-select d-flex justify-content-between gap-2">
                                <div class="custom-input-group only-number">
                                <input type="text" id="slider-input-min" name="slider-input-min" class="form-control px-1"
                                    min="0" max="${maxTime}">
                                <label for="">از</label>
                                <span class="clear-btn" onclick="clearInput(this)" style="font-size: 1rem;left: -1px;">×</span>
                            </div>
                            <div class="custom-input-group only-number">
                                <input type="text" id="slider-input-max" name="slider-input-max" class="form-control px-1"
                                    min="0" max="${maxTime}">
                                <label for="">تا</label>
                                <span class="clear-btn" onclick="clearInput(this)" style="font-size: 1rem;left: -1px;">×</span>
                            </div>
                        </div>
                      </div>
                `);
                var slider = document.getElementById('slider-primary');
                var sliderInputMin = document.getElementById('slider-input-min');
                var sliderInputMax = document.getElementById('slider-input-max');

                if (!slider.noUiSlider) {
                    noUiSlider.create(slider, {
                        start: [0, maxTime],
                        connect: true,
                        behaviour: 'tap-drag',
                        step: 1,
                        tooltips: true,
                        range: {
                            min: 0,
                            max: maxTime
                        },
                        direction: 'ltr'
                    });

                    slider.noUiSlider.on('update', function(values) {
                        minTime = parseFloat(values[0]);
                        maxTime = parseFloat(values[1]);
                        dt_basic.draw();
                    });

                    sliderInputMin.addEventListener('input', function() {
                        max = sliderInputMax.value;
                        min = this.value;
                        if (!max) {
                            max = {{ $lastTime }};
                        }
                        if (!min) {
                            min = 0
                        }
                        slider.noUiSlider.set([min, max]);
                    });
                    sliderInputMax.addEventListener('input', function() {
                        min = sliderInputMin.value;
                        max = this.value;
                        if (!min) {
                            min = 0
                        }
                        if (!max) {
                            max = {{ $lastTime }};
                        }
                        slider.noUiSlider.set([min, max]);
                    });
                }

                let noSearchColumns = [0, 8, 9, 10];
                // **تنظیم رویداد برای اینپوت های معمولی**
                $('.professions thead tr:eq(1) th').each(function(i) {
                    $(this).removeClass('sorting');
                    $(this).removeClass('sorting_asc');
                    $(this).removeClass('sorting_desc');
                    $(this).addClass('px-2');

                    if (i == 7) return; // اسلایدر رو اینجا دیگه پردازش نکنیم

                    if (noSearchColumns.includes(i)) {
                        $(this).html('');
                        return;
                    }

                    var title = $(this).text();
                    $(this).html(`
                    <div class="slider-select d-flex justify-content-between gap-2">
                        <div class="custom-input-group">
                        <input type="text" class="form-control px-1">
                        <label for=""></label>
                        <span class="clear-btn" onclick="clearInput(this,${i})" style="font-size: 1rem;left: -1px;">×</span>
                    </div>
                    `);
                    $('input', this).on('keyup change', function() {
                        if (i == 1) {
                            if (this.value.length > 0) {
                                dt_basic.column(i + 1).search('^' + this.value + '$', true, false).draw();
                            }else{
                                dt_basic.column(i + 1).search('').draw();
                            }
                        } else {
                            dt_basic.column(i + 1).search(this.value).draw();
                        }
                    });
                });



                // چک باکس ها
                var $headerCheckbox = $(
                    '<input type="checkbox" id="select-all-page" class="form-check-input mt-0 align-middle">'
                );
                $('.professions thead tr:eq(0) th:eq(0)').html($headerCheckbox);

                // مدیریت انتخاب ردیف‌ها
                $(document).on('click', '.dt-checkboxes', function(e) {
                    e.stopPropagation();

                    var $checkbox = $(this);
                    var row = dt_basic.row($checkbox.closest('tr'));

                    if ($checkbox.prop('checked')) {
                        row.select();
                        dt_basic.column(i + 1).search(this.value).draw();
                    } else {
                        row.deselect();
                        dt_basic.column(i + 1).search(this.value).draw();
                    }
                });

                // مدیریت چک‌باکس انتخاب همه
                $(document).on('click', '#select-all-page', function(e) {
                    e.stopPropagation();

                    var isChecked = $(this).prop('checked');
                    var currentPageRows = dt_basic.rows({
                        page: 'current'
                    });

                    if (isChecked) {
                        currentPageRows.select();
                    } else {
                        currentPageRows.deselect();
                    }

                    currentPageRows.nodes().to$().find('.dt-checkboxes').prop('checked', isChecked);
                });

                // به‌روزرسانی وضعیت چک‌باکس انتخاب همه
                dt_basic.on('draw select deselect', function() {
                    var api = dt_basic;
                    var currentPageCount = api.rows({
                        page: 'current'
                    }).count();
                    var selectedCount = api.rows({
                        page: 'current',
                        selected: true
                    }).count();

                    var $selectAll = $('#select-all-page');

                    if (selectedCount === 0) {
                        $selectAll.prop('checked', false);
                        $selectAll.prop('indeterminate', false);
                    } else if (selectedCount === currentPageCount) {
                        $selectAll.prop('checked', true);
                        $selectAll.prop('indeterminate', false);
                    } else {
                        $selectAll.prop('checked', false);
                        $selectAll.prop('indeterminate', true);
                    }
                });
            }

        });
        let thead = $('.professions thead');
        let searchRow = thead.find('tr').clone().appendTo(thead);
        let noSearchColumns = [0, 8, 9, 10];

        if (window.Helpers.isNavbarFixed()) {
            var navHeight = $('#layout-navbar').outerHeight();
            new $.fn.dataTable.FixedHeader(dt_basic).headerOffset(navHeight);
        } else {
            new $.fn.dataTable.FixedHeader(dt_basic);
        }

        // انتقال اکشن‌ها
        $("#bulk-actions").appendTo(".bulk-holder");
        $("#bulk-actions2").appendTo(".bulk-holder2");
        dt_basic.on('click', '.dt-checkboxes', function() {
            const row = dt_basic.row($(this).closest('tr'));

            if (this.checked) {
                row.select();
            } else {
                row.deselect();
            }
        });
        dt_basic.on('user-select', function(e, dt, type, cell, originalEvent) {
            if (!$(originalEvent.target).hasClass('row-check')) {
                e.preventDefault();
            }
        });
        dt_basic.on('init', function(e) {
            document.querySelectorAll("input, textarea").forEach(function(element) {
                // اگر مقدار اولیه داشت، کلاس filled اضافه کن
                if (element.value.trim() !== "") {
                    element.parentElement.classList.add("filled");
                }

                // گوش دادن به رویداد input (بدون jQuery)
                element.addEventListener("input", function(e) {
                    const parent = e.target.parentElement;

                    if (e.target.value.trim() !== "") {
                        parent.classList.add("filled");
                    } else {
                        parent.classList.remove("filled");
                    }

                    if (parent.classList.contains("only-number")) {
                        e.target.value = e.target.value.replace(/[^0-9]/g, "");
                    }
                });
            });
        });

        // بعد از تعریف dt_basic
        dt_basic.on('draw', function() {
            var api = $(this).DataTable(); // یا استفاده از dt_basic مستقیم

            // تعداد رکوردهای فیلتر شده و کل
            var filteredRecords = api.rows({
                filter: 'applied'
            }).count();

            var totalRecords = api.rows().count();

            if (filteredRecords == totalRecords) {
                filteredRecords = 0
            }

            // تعداد رکوردهای انتخاب شده
            var selectedCount = api.rows({
                selected: true
            }).count();

            $("#totalRecord").html(totalRecords);
            $("#filteredrecord").html(filteredRecords);
            $("#selectedRecord").html(selectedCount);
        });

        // همچنین برای به‌روزرسانی هنگام انتخاب/لغو انتخاب ردیف‌ها
        dt_basic.on('select deselect', function() {
            var api = $(this).DataTable(); // یا استفاده از dt_basic مستقیم
            var selectedCount = api.rows({
                selected: true
            }).count();
            var filteredRecords = api.rows({
                filter: 'applied'
            }).count();
            var totalRecords = api.rows().count();

            if (filteredRecords == totalRecords) {
                filteredRecords = 0
            }

            $("#filteredrecord").html(filteredRecords);
            $("#selectedRecord").html(selectedCount);
        });

        // delete one item----------------------------------------------------------------------------------------------------------------
        dt_basic.on("click", ".item-delete", function() {
            const id = $(this).data("id");

            if (!id) return;
            // برداشتن فوکوس از روی دکمه (مهم!)
            if (document.activeElement && document.activeElement instanceof HTMLElement) {
                document.activeElement.blur();
            }


            Swal.fire({
                title: `آیا از حذف این رکورد مطمئن هستید؟`,
                text: "این عملیات غیرقابل بازگشت است!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "بله، حذف کن!",
                cancelButtonText: "انصراف",
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/admin2/professions/delete/" + id,
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

                            dt_basic.ajax.reload(null, false);
                            // $("#bulk-actions").addClass("d-none");
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
        const btnBulk = $(".bulk-delete");
        if (btnBulk) {
            // وقتی رکورد انتخاب شد
            dt_basic.on("select", function(e, dt, type, indexes) {
                toggleBulkActions();
            });

            // وقتی رکورد از انتخاب خارج شد
            dt_basic.on("deselect", function(e, dt, type, indexes) {
                toggleBulkActions();
            });

            // تابع برای نمایش / مخفی کردن باکس عملیات
            function toggleBulkActions() {
                const selected = dt_basic.rows({
                    selected: true
                }).count();
                if (selected > 0) {
                    // $("#bulk-actions").removeClass("d-none");
                    $(".bulk-actions .action_group").show();
                    $(".bulk-actions .bulk-delete").prop("disabled", false);
                    $(".bulk-actions .bulk-toggle").prop("disabled", false);
                    $(".bulk-actions .bulk-archive").prop("disabled", false);
                } else {
                    $(".bulk-actions .action_group").hide();
                    $(".bulk-actions .bulk-delete").prop("disabled", true);
                    $(".bulk-actions .bulk-toggle").prop("disabled", true);
                    $(".bulk-actions .bulk-archive").prop("disabled", true);
                }
            }

            // گرفتن ID ها
            function getSelectedIds() {
                return dt_basic
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
                    confirmButtonText: "تایید",
                    cancelButtonText: "انصراف",
                    focusConfirm: false,
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin2/professions/bulk-delete",
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

                                dt_basic.ajax.reload(null, false);
                                // $("#bulk-actions").addClass("d-none");
                            },
                            error: function(err) {
                                toastr.error(err.message);

                                console.error(err);
                            },
                        });
                    }
                });
            });

            // toggle selected
            $(".bulk-toggle").on("click", function() {
                const ids = getSelectedIds(); // فرض می‌کنیم این تابع id ردیف‌های انتخاب شده را برمی‌گرداند
                const status = $(this).data("status"); // true برای انتشار، false برای عدم انتشار

                if (ids.length === 0) {
                    Swal.fire({
                        icon: "warning",
                        title: "هیچ رکوردی انتخاب نشده!",
                        confirmButtonText: "باشه",
                    });
                    return;
                }

                Swal.fire({
                    title: `آیا از ${status ? 'انتشار' : 'عدم انتشار'} ${ids.length} رکورد مطمئن هستید؟`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "تایید",
                    cancelButtonText: "انصراف",
                    focusConfirm: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin2/professions/bulk-toggle",
                            type: "POST",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr("content"),
                                ids: ids,
                                status: status,
                            },
                            success: function(res) {
                                toastr.success(res.message);

                                // --- شروع بخش به‌روزرسانی آیکون‌ها در جدول ---
                                // حلقه زدن روی ID های ارسال شده
                                ids.forEach(function(id) {
                                    var $button = dt_basic.rows().nodes().to$().find(
                                        `button.item-toggle[data-id="${id}"]`);

                                    if ($button.length) {
                                        var $icon = $button.find('i');

                                        if (status) { // اگر وضعیت به 'منتشر شده' تغییر کرد
                                            $icon.removeClass('bx-x').addClass(
                                                'bx-check');
                                            $button.removeClass('text-danger').addClass(
                                                'text-success');
                                        } else { // اگر وضعیت به 'منتشر نشده' تغییر کرد
                                            $icon.removeClass('bx-check').addClass(
                                                'bx-x');
                                            $button.removeClass('text-success')
                                                .addClass('text-danger');
                                        }
                                    }
                                });
                                // پاک کردن انتخاب تمام ردیف‌ها
                                dt_basic.rows().deselect();

                                // یا اگر می‌خواهید چک‌باکس‌ها هم پاک شوند
                                $('.dt-checkboxes').prop('checked', false);
                                $('.select-all').prop('checked', false);
                                // --- پایان بخش به‌روزرسانی آیکون‌ها در جدول ---

                                // مخفی کردن منوی bulk actions
                                $(".bulk-actions .action_group").hide();
                                $(".bulk-actions .bulk-delete").prop("disabled", true);
                                $(".bulk-actions .bulk-toggle").prop("disabled", true);
                                $(".bulk-actions .bulk-archive").prop("disabled", true);
                            },
                            error: function(err) {
                                toastr.error("خطا در ارتباط با سرور.");
                                console.error(err);
                            },
                        });
                    }
                });
            });
            // archive
            $(".bulk-archive").on("click", function() {
                const ids = getSelectedIds();
                const status = $(this).data("status");

                if (ids.length === 0) {
                    Swal.fire({
                        icon: "warning",
                        title: "هیچ رکوردی انتخاب نشده!",
                        confirmButtonText: "باشه",
                    });
                    return;
                }

                Swal.fire({
                    title: `آیا از ${status ? 'آرشیو' : 'عدم آرشیو'} ${ids.length} رکورد مطمئن هستید؟`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "تایید",
                    cancelButtonText: "انصراف",
                    focusConfirm: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin2/professions/bulk-archive",
                            type: "POST",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr(
                                    "content"
                                ),
                                ids: ids,
                                status: status,
                            },
                            success: function(res) {
                                toastr.success(res.message);
                                // حلقه زدن روی ID های ارسال شده
                                ids.forEach(function(id) {
                                    var $button = dt_basic.rows().nodes().to$().find(
                                        `button.item-archive[data-id="${id}"]`);

                                    if ($button.length) {
                                        var $icon = $button.find('i');

                                        if (status) { // اگر وضعیت به 'منتشر شده' تغییر کرد
                                            $icon.removeClass('bx-x').addClass(
                                                'bx-check');
                                            $button.removeClass('text-danger').addClass(
                                                'text-success');
                                        } else { // اگر وضعیت به 'منتشر نشده' تغییر کرد
                                            $icon.removeClass('bx-check').addClass(
                                                'bx-x');
                                            $button.removeClass('text-success')
                                                .addClass('text-danger');
                                        }
                                    }
                                });
                                // پاک کردن انتخاب تمام ردیف‌ها
                                dt_basic.rows().deselect();

                                // یا اگر می‌خواهید چک‌باکس‌ها هم پاک شوند
                                $('.dt-checkboxes').prop('checked', false);
                                $('.select-all').prop('checked', false);
                                // --- پایان بخش به‌روزرسانی آیکون‌ها در جدول ---

                                // مخفی کردن منوی bulk actions
                                $(".bulk-actions .action_group").hide();
                                $(".bulk-actions .bulk-delete").prop("disabled", true);
                                $(".bulk-actions .bulk-toggle").prop("disabled", true);
                                $(".bulk-actions .bulk-archive").prop("disabled", true);
                            },
                            error: function(err) {
                                toastr.error("خطا در ارتباط با سرور.");

                                console.error(err);
                            },
                        });
                    }
                });
            });
        }
        // toggle one item----------------------------------------------------------------------------------------------------------------
        dt_basic.on("click", ".item-toggle", function() {
            const id = $(this).data("id");

            var button = $(this);
            var icon = button.find('i');

            if (!id) return;
            $.ajax({
                url: "/admin2/professions/" + id + "/toggle",
                type: "patch",
                data: {
                    _token: $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function(res) {
                    toastr.success(res.message);
                    if (icon.hasClass('bx-check')) {
                        icon.removeClass('bx-check').addClass('bx-x');
                        button.removeClass('text-success').addClass(
                            'text-danger'); // مثال: تغییر رنگ دکمه
                    } else {
                        icon.removeClass('bx-x').addClass('bx-check');
                        button.removeClass('text-danger').addClass(
                            'text-success'); // مثال: بازگرداندن رنگ دکمه
                    }
                },
                error: function(err) {
                    toastr.error("خطا در ارتباط با سرور.");
                    console.error(err);
                },
            });
        });
        // archive one item----------------------------------------------------------------------------------------------------------------
        dt_basic.on("click", ".item-archive", function() {
            const id = $(this).data("id");
            var button = $(this);
            var icon = button.find('i');

            if (!id) return;
            $.ajax({
                url: "/admin2/professions/" + id + "/archive",
                type: "patch",
                data: {
                    _token: $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function(res) {
                    if (icon.hasClass('bx-check')) {
                        icon.removeClass('bx-check').addClass('bx-x');
                        button.removeClass('text-success').addClass(
                            'text-danger'); // مثال: تغییر رنگ دکمه
                    } else {
                        icon.removeClass('bx-x').addClass('bx-check');
                        button.removeClass('text-danger').addClass(
                            'text-success'); // مثال: بازگرداندن رنگ دکمه
                    }
                    toastr.success(res.message);
                },
                error: function(err) {
                    toastr.error("خطا در ارتباط با سرور.");
                    console.error(err);
                },
            });
        });

        // وقتی روی دکمه جزئیات کلیک شد
        $(document).on("click", ".item-details", function() {
            const item = $(this).data("item"); // اطلاعات همون ردیف
            // اگه دیتای jQuery به صورت رشته ذخیره شده باشه، باید parse کنیم:
            const data = typeof item === "string" ? JSON.parse(item) : item;

            let html = `
                    <div class="col-md-6">
                        <div class="demo-inline-spacing mt-3">
                            <ul class="list-group">
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">نام حرفه : </strong> ${
                                    data.name
                                }
                              </li>
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">رشته مربوطه: </strong> ${
                                    data.field ? data.field.name : "-"
                                }
                              </li>
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">تاریخ تدوین: </strong> ${
                                    data.draft_date
                                        ? new Date(
                                              data.draft_date,
                                          ).toLocaleDateString("fa-IR")
                                        : "-"
                                }
                              </li>
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">کاردانش: </strong> ${
                                    data.kardanesh ? data.kardanesh.name : "-"
                                }
                              </li>
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">نوع شغل: </strong> ${
                                    data.jobtype ? data.jobtype.name : "-"
                                }
                              </li>
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">کد استاندارد جدید: </strong> ${
                                    data.new_standard_code ?? "-"
                                }
                              </li>
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">کد استاندارد قدیم: </strong> ${
                                    data.old_standard_code ?? "-"
                                }
                              </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="demo-inline-spacing mt-3">
                            <ul class="list-group">
                                <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">تحصیلات مورد نیاز: </strong> ${
                                    data.education_level ?? "-"
                                }
                              </li>
                               <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">صلاحیت مربی: </strong> ${
                                    data.trainer_qualification ?? "-"
                                }
                              </li>
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">زمان نظری: </strong> ${
                                    data.theory_hour
                                } ساعت و ${data.theory_minute} دقیقه
                              </li>
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">زمان عملی: </strong> ${
                                    data.practice_hour
                                } ساعت و ${data.practice_minute} دقیقه
                              </li>
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">زمان پروژه: </strong> ${
                                    data.project_hour
                                } ساعت و ${data.project_minute} دقیقه
                              </li>
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">زمان کارورزی:</strong> ${
                                    data.internship_hour
                                } ساعت و ${data.internship_minute} دقیقه
                              </li>
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">جمع کل: </strong> ${
                                    data.total_hour
                                } ساعت و ${data.total_minute} دقیقه
                              </li>
                            </ul>
                        </div>
                    </div>
                    ${
                        data.image_path
                            ? `<div class="col-md-6"><strong>تصویر:</strong><br><img src="/${data.image_path}" class="img-fluid rounded mt-2" style="max-width: 200px;"></div>`
                            : ""
                    }
                    ${
                        data.standard_file
                            ? `<div class="col-md-6"><strong>فایل استاندارد:</strong><br><a href="/${data.standard_file}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">دانلود فایل</a></div>`
                            : ""
                    }
                    <hr class="mt-3">
                    <div class="col-md-12"><strong>جزئیات ثبت رکورد:</strong><br>
                        <span>تاریخ و ساعت ایجاد رکورد : ${new Date(data.created_at).toLocaleString('fa-IR')}</span><br>
                        <span>تعداد دفعات ویرایش رکورد : 0</span><br>
                        <span>تاریخ و ساعت آخرین ویرایش رکورد : ${new Date(data.updated_at).toLocaleString('fa-IR')}</span><br>
                    </div>
                `;

            $("#profession-details-content").html(html);
            $("#professionDetailsModal").modal("show");
        });

        // uploadfile -----------------------------------------------------------------------------------------------------------
        $(document).on("click", ".item-upload-file", function() {
            const id = $(this).data("id");
            // نمایش مودال
            $("#modalUpload").modal("show");

            $("#modalUpload #id").val(id);
        });
        $('#form-upload-record').on('submit', function(event) {
            event.preventDefault();

            const form = $(this);
            const formActionUrl = form.attr('action') || '/admin2/professions/upload';

            $.ajax({
                url: formActionUrl,
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(response) {
                    toastr.success(response.message || 'عملیات با موفقیت انجام شد!');

                    // dt_basic.ajax.reload(null, false);

                    // console.log(response);
                    $("#modalUpload").modal("hide");
                },
                error: function(xhr, status, error) {
                    toastr.error(xhr.responseJSON?.message || 'خطایی رخ داد');
                }
            });
        });
        // پیش‌نمایش فایل جدید
        function removeFilePdf(button) {
            // پیدا کردن div والد که شامل عکس، نام فایل و دکمه است
            const previewDiv = button.closest('.mb-2.mt-3.border.bg-white.p-2.rounded');
            if (previewDiv) {
                previewDiv.remove();
            }

            // مهم: همچنین باید مقدار فیلد ورودی فایل را ریست کنید تا کاربر بتواند دوباره همان فایل را انتخاب کند
            const fileInput = document.getElementById('fileUpload');
            if (fileInput) {
                fileInput.value = '';
            }
            $("#fileUpload").siblings('.file-count').text('فایلی انتخاب نشده');
        }
        document.getElementById('fileUpload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('file-preview-2');

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

        // تابع پاک کردن محتوا
        function clearInput(btn, col = 1) {
            const parent = btn.parentElement;
            const input = parent.querySelector("input, textarea");
            input.value = null;
            input.focus();
            parent.classList.remove("filled");

            min = document.getElementById('slider-input-min').value;
            max = document.getElementById('slider-input-max').value;
            if (!min) {
                min = 0
            }
            if (!max) {
                max = {{ $lastTime }};
            }
            minTime = min;
            maxTime = max;
            // پاک کردن جستجوی آن ستون و رسم دوباره جدول
            dt_basic.column(col + 1).search('').draw();
        }
    </script>
    <script>
        $(document).on('change', '.custom-file-input', function() {
            let fileCount = this.files.length;
            let fileCountText = fileCount === 0 ? 'فایلی انتخاب نشده' : fileCount + ' فایل انتخاب شده';
            // عنصر نمایشی که کنار این اینپوت هست رو پیدا کن
            $(this).siblings('.file-count').text(fileCountText);
        });

        function removeFile(button) {
            // پیدا کردن div والد که شامل عکس، نام فایل و دکمه است
            const previewDiv = button.closest('.mb-2.mt-3.border.bg-white.p-2.rounded');
            if (previewDiv) {
                previewDiv.remove();
            }

            // مهم: همچنین باید مقدار فیلد ورودی فایل را ریست کنید تا کاربر بتواند دوباره همان فایل را انتخاب کند
            const fileInput = document.getElementById('file');
            if (fileInput) {
                fileInput.value = '';
            }
            $("#file").siblings('.file-count').text('فایلی انتخاب نشده');
        }
        document.getElementById('file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('file-preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    let sizeInKB = (file.size / 1024).toFixed(1);
                    preview.innerHTML = `
                    <div class="d-flex align-items-center justify-content-between mb-2 mt-3 border bg-white p-2 rounded">
                        <div class="d-flex align-items-center">
                            <div><i class="bx bxs-file-import text-success" style="font-size: 50px;"></i></div>
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
        $('#formUpload').on('submit', function(event) {
            event.preventDefault();

            const form = $(this);
            const formActionUrl = form.attr('action') || '/admin2/professions/uploadExcel';

            $.ajax({
                url: formActionUrl,
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                beforeSend: function(xhr) {
                    $("#btnSubmit").addClass('d-none');
                    $("#btnSpinner").removeClass('d-none');
                    // پاک کردن لاگ‌های قبلی
                    $("#uploadLogsContainer").addClass('d-none');
                    $("#logsList").empty();
                },
                success: function(response) {
                    $("#btnSubmit").removeClass('d-none');
                    $("#btnSpinner").addClass('d-none');

                    toastr.success(response.message || 'عملیات با موفقیت انجام شد!');

                    // نمایش لاگ‌ها
                    if (response.logs && response.logs.length > 0) {
                        displayUploadLogs(response.logs);
                    }
                    dt_basic.ajax.reload(null, false);

                    console.log(response);
                },
                error: function(xhr, status, error) {
                    $("#btnSubmit").removeClass('d-none');
                    $("#btnSpinner").addClass('d-none');
                    toastr.error(xhr.responseJSON?.message || 'خطایی رخ داد');
                }
            });
        });

        // تابع نمایش لاگ‌ها
        function displayUploadLogs(logs) {
            const container = $('#logsList');
            let html = '<ul class="list-group">';
            logs.forEach(function(log) {
                // تبدیل data از string به JSON برای نمایش بهتر
                let rowData = typeof log.data === 'string' ? JSON.parse(log.data) : log.data;
                if (!log.success) {
                    html += `
                        <li class="list-group-item list-group-item-danger mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>
                                    <i class="fas fa-times-circle"></i>
                                    ردیف ${log.row_number}
                                </strong>
                                <span class="badge badge-danger text-dark whitespace-unset">${log.error_message}</span>
                                <span class="badge badge-danger text-dark">کد ایسکو: ${rowData.کد_استاندارد_ایسکو}</span>
                            </div>
                        </li>
                    `;
                }
            });

            html += '</ul>';

            container.html(html);
            $("#uploadLogsContainer").removeClass('d-none');
        }
        const modal = document.getElementById('modalImportExcel');
        modal.addEventListener('hidden.bs.modal', function() {
            document.getElementById('formUpload').reset();

            const previewDiv = $("#file-preview").html(null);

            // مهم: همچنین باید مقدار فیلد ورودی فایل را ریست کنید تا کاربر بتواند دوباره همان فایل را انتخاب کند
            const fileInput = document.getElementById('file');
            if (fileInput) {
                fileInput.value = '';
            }
            $("#file").siblings('.file-count').text('فایلی انتخاب نشده');

            $("#uploadLogsContainer").addClass('d-none');
        });
    </script>
    {{-- report --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // وقتی مدال باز میشه، داده‌ها بارگذاری بشن
            const modal = document.getElementById('modalReport');
            modal.addEventListener('shown.bs.modal', loadImportList);

            function loadImportList() {
                const listContainer = document.getElementById('upload-list');
                listContainer.innerHTML = '<div class="text-center py-3">در حال بارگذاری...</div>';

                fetch('/admin2/professions/imports') // روت بالا
                    .then(res => res.json())
                    .then(imports => {
                        if (imports.length === 0) {
                            listContainer.innerHTML =
                                '<div class="text-muted text-center py-4">هنوز هیچ آپلودی انجام نشده.</div>';
                            return;
                        }

                        let html = '';
                        imports.forEach(imp => {
                            let successCount = 0;
                            let errorCount = 0;
                            const allLogs = imp.logs || []; // اطمینان از وجود logs

                            // شمارش موفق و ناموفق
                            allLogs.forEach(log => {
                                if (log.success) {
                                    successCount++;
                                } else {
                                    errorCount++;
                                }
                            });
                            html += `
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>نام فایل : ${imp.file_name}</strong>
                                    <strong class="text-muted d-block">تاریخ آپلود : ${new Date(imp.created_at).toLocaleDateString('fa-IR')}</strong>
                                    <strong class="text-muted d-block">ساعت آپلود : ${new Date(imp.created_at).toLocaleTimeString('fa-IR')}</strong>
                                </div>
                                <button class="btn btn-sm btn-outline-success view-logs-btn"
                                        data-import-id="${imp.id}" data-status="1">
                                    ثبت موفق ( ${successCount} )
                                </button>
                                <button class="btn btn-sm btn-outline-danger view-logs-btn"
                                        data-import-id="${imp.id}" data-status="0">
                                    ثبت ناموفق ( ${errorCount} )
                                </button>
                                <button class="btn btn-sm btn-outline-secondary view-logs-btn"
                                        data-import-id="${imp.id}" data-status="all">
                                    مشاهده همه ( ${imp.logs.length} )
                                </button>
                            </div>
                            <div id="logs-${imp.id}" class="mt-2 logs-container" style="display:none;"></div>
                        </div>
                    `;
                        });
                        listContainer.innerHTML = html;
                        attachLogButtons();
                    })
                    .catch(() => {
                        listContainer.innerHTML =
                            '<div class="text-danger text-center py-3">خطا در دریافت داده‌ها</div>';
                    });
            }

            function attachLogButtons() {
                document.querySelectorAll('.view-logs-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const importId = this.dataset.importId;
                        const status = this.dataset.status;
                        const container = document.getElementById('logs-' + importId);

                        // $("#printBtn").prop("disabled", false);

                        // if (container.style.display === 'block') {
                        //     container.style.display = 'none';
                        //     container.innerHTML = '';
                        //     return;
                        // }

                        container.style.display = 'block';
                        container.innerHTML =
                            '<div class="text-muted ps-3 py-2">در حال بارگذاری لاگ‌ها...</div>';

                        fetch(`/admin2/professions/imports/${importId}/logs`)
                            .then(res => res.json())
                            .then(logs => {
                                if (logs.length === 0) {
                                    container.innerHTML =
                                        '<div class="ps-3 py-2 text-success">بدون خطا ✅</div>';
                                    return;
                                }

                                // تقسیم به موفق و خطادار
                                const successLogs = [];
                                const errorLogs = [];

                                logs.forEach(log => {
                                    let rowData = typeof log.data === 'string' ? JSON
                                        .parse(log.data) : log.data;
                                    if (log.success)
                                        successLogs.push({
                                            ...log,
                                            rowData
                                        });
                                    else
                                        errorLogs.push({
                                            ...log,
                                            rowData
                                        });
                                });

                                // تابع گروه‌بندی بر اساس رشته
                                function groupByReshte(arr) {
                                    const grouped = {};
                                    arr.forEach(item => {
                                        let reshte = item.rowData.رشته ?? 'نامشخص';
                                        if (!grouped[reshte]) grouped[reshte] = [];
                                        grouped[reshte].push(item);
                                    });
                                    return grouped;
                                }

                                const groupedSuccess = groupByReshte(successLogs);
                                const groupedError = groupByReshte(errorLogs);

                                // ساخت HTML خروجی
                                let logsHtml = `
                                `;
                                // بخش خطادارها
                                if (errorLogs.length > 0) {
                                    logsHtml += `
                                        <div class="border rounded p-3 bg-white ${status == 1 ? 'd-none' : ''}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-danger mb-3">
                                                    ثبت های ناموفق — ${errorLogs.length} مورد
                                                </h6>
                                                <button class="btn btn-sm btn-outline-primary printBtn" data-target="${importId}" data-status="${status}">
                                                پرینت نتایج
                                                </button>
                                            </div>
                                    `;

                                    Object.keys(groupedError).forEach(reshte => {
                                        const group = groupedError[reshte];
                                        logsHtml += `
                                            <div class="mb-3 border rounded p-2 bg-light">
                                                <strong>رسته ${group[0].rowData.رسته ?? group[1].rowData.رسته ?? 'نامشخص'} / خوشه ${group[0].rowData.خوشه ?? group[0].rowData.خوشه ?? 'نامشخص'} / رشته ${reshte} ( ${group.length} مورد )</strong>
                                                <ul class="list-group list-group-flush mt-2">
                                        `;
                                        group.forEach((log, i) => {
                                            logsHtml += `
                                                <li class="list-group-item list-group-item-danger">
                                                    <div>${i + 1}</div>
                                                    <strong>️ردیف ${log.row_number}</strong>
                                                    <div>
                                                        حرفه ${log.rowData.حرفه} با کد ایسکو ${log.rowData.کد_استاندارد_ایسکو} درج نگردید.
                                                    </div>
                                                    <div>دلیل: ${log.error_message || '—'}</div>
                                                </li>
                                            `;
                                        });
                                        logsHtml += '</ul></div>';
                                    });
                                    logsHtml += '</div>';
                                }
                                // ✅ بخش موفق‌ها
                                if (successLogs.length > 0) {
                                    logsHtml += `
                                        <div class="border rounded p-3 mb-3 bg-white ${status == 0 ? 'd-none' : ''}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-success mb-3">
                                                    ثبت های موفق — ${successLogs.length} مورد
                                                </h6>
                                                <button class="btn btn-sm btn-outline-primary printBtn" data-target="${importId}" data-status="${status}">
                                                پرینت نتایج
                                                </button>
                                            </div>
                                    `;

                                    Object.keys(groupedSuccess).forEach(reshte => {
                                        const group = groupedSuccess[reshte];
                                        logsHtml += `
                                            <div class="mb-3 ps-3">
                                                <strong>رسته ${group[0].rowData.رسته} / خوشه ${group[0].rowData.خوشه} / رشته ${reshte} ( ${group.length} مورد )</strong>
                                                <ul class="list-group list-group-flush mt-2">
                                        `;
                                        group.forEach((log, i) => {
                                            logsHtml += `
                                            <li class="list-group-item list-group-item-success">
                                                    <div>${i + 1}</div>
                                                    <strong>ردیف ${log.row_number}</strong>
                                                    <div>
                                                        حرفه ${log.rowData.حرفه} با کد ایسکو ${log.rowData.کد_استاندارد_ایسکو} با موفقیت درج گردید.
                                                    </div>
                                                </li>
                                            `;
                                        });
                                        logsHtml += '</ul></div>';
                                    });

                                    logsHtml += '</div>';
                                }
                                // نمایش نهایی
                                container.innerHTML = logsHtml;
                            })
                            .catch(() => {
                                container.innerHTML =
                                    '<div class="text-danger p-3 py-2">خطا در بارگذاری لاگ‌ها</div>';
                            });


                    });
                });
            }

            $(document).on('click', '.printBtn', function() {
                const divId = this.dataset.target;
                const status = this.dataset.status;

                const printUrl =
                    `/admin2/professions/print/${divId}?status=${status}`; // اگر فایل در root است
                // اگر در فولدر است: `/your-folder/print-content.html?data=${encodedContent}`

                // باز کردن صفحه پرینت در یک پنجره جدید یا tab جدید
                window.open(printUrl, '_blank');
            });

        });
    </script>
@endsection
