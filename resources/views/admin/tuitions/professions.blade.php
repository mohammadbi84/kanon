@extends('admin.layout.master')
@section('head')
    {{-- btn-go-to-top --}}
    <link rel="stylesheet" href="{{ asset('site/assets/css/btn-go-to-top.css') }}">
    <script src="{{ asset('site/assets/js/btn-go-to-top.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/nouislider/nouislider.css') }}">
    {{-- bootstrap icons --}}
    <link rel="stylesheet" href="https://lib.arvancloud.ir/bootstrap-icons/1.9.1/font/bootstrap-icons.css">
    <style>
        tr.changed {
            background: #ccffcd90 !important;
        }

        tr td {
            padding: 5px !important;
        }
    </style>
@endsection
@section('content')
    <h5 class="breadcrumb-wrapper mb-4 pt-4" style="padding: 15px 10px !important;" id="breadcrumb-wrapper">
        <a href="{{ route('admin.index') }}" class="text-muted">داشبورد</a> <span class="text-muted">/</span>
        <a href="{{ route('admin.tuitions.index') }}" class="text-muted">مدیریت نرخ شهریه</a> <span
            class="text-muted">/</span>
        <span class="">{{ $tuition->title }}</span>
        <span class="text-muted">/ درج شهریه</span>
    </h5>
    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable p-3">
            <div class="fixed-header" style="z-index: 5">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="head-label d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">مدیریت مبالغ حرفه‌ها برای شهریه : {{ $tuition->title }}</h5>
                        <small class="text-muted ms-2">(
                            تعداد : <span id="totalRecord2">0</span> ردیف /
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
                        <a href="{{ route('admin.tuitions.index') }}" class="btn btn-outline-danger">
                            انصراف
                        </a>
                        <button type="button" id="save-prices" class="btn btn-success d-none">
                            ذخیره تغییرات
                        </button>
                    </div>
                </div>
                {{-- <div class="d-flex justify-content-start align-items-center gap-2 text-muted">
                    <small class="py-3 text-white">1</small>
                </div> --}}
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
                        <th>انتشار</th>
                        <th>حضوری</th>
                        <th>مجازی</th>
                        <th>الکترونیکی</th>
                    </tr>
                </thead>
            </table>
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
                    </ul>
                </div>
            </div>
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
                    <form action="{{ route('admin.tuitions.professions.uploadExcel', ['tuition' => $tuition]) }}"
                        method="post" id="formUpload" enctype="multipart/form-data">
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
    <script src="{{ asset('admin/assets/vendor/js/dropdown-hover.js') }}"></script>
    <script>
        let unsavedPrices = {};

        function toggleSaveButton() {
            // دکمه را فقط زمانی نمایش بده که حداقل یک تغییر داشته باشیم
            $('#save-prices').toggleClass('d-none', Object.keys(unsavedPrices).length === 0);
        }

        tuitionId = {{ $tuition->id }};
        professions = $(".professions");

        dt_basic = professions.DataTable({
            ajax: {
                url: "/admin2/tuitions/" + tuitionId + "/professions",
                // این تابع قبل از شروع لود اجرا میشه
                beforeSend: function() {
                    $("#DataTables_Table_0_wrapper .dataTables_empty").hide();
                    $(".professions").closest(".card").append(`
                    <div id="custom-overlay">
                        <div class="loader-container">
                            <div class="custom-spinner"></div>
                            <span>در حال بارگزاری رکورد ها</span>
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
            autoWidth: false, // جلوگیری از محاسبه خودکار عرض
            // bAutoWidth: false,
            columns: [{
                    data: "id",
                    width: "1%"
                }, // Responsive
                {
                    data: "id",
                    visible: false
                },
                {
                    data: null,
                    title: "ردیف",
                    width: "4%"
                },
                {
                    data: "field.cluster.category.name",
                    title: "رسته",
                    width: "11%"
                },
                {
                    data: "field.cluster.name",
                    title: "خوشه",
                    width: "8%"
                },
                {
                    data: "field.name",
                    title: "رشته",
                    width: "8%"
                },
                {
                    data: "name",
                    title: "حرفه",
                    width: "15%"
                },
                {
                    data: "new_standard_code",
                    title: "کد استاندارد",
                    width: "9%"
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
                    },
                    width: "6%"
                },
                {
                    data: "",
                    title: "انتشار",
                    width: "5%"
                },
                {
                    data: "",
                    title: "حضوری",
                    width: "7%"
                },
                {
                    data: "",
                    title: "مجازی",
                    width: "7%"
                },
                {
                    data: "",
                    title: "الکترونیکی",
                    width: "7%"
                },
            ],
            columnDefs: [{
                    targets: 0,
                    searchable: false,
                    orderable: false,
                    render: function() {
                        return '<input type="checkbox" class="dt-checkboxes form-check-input mt-0 align-middle">';
                    },
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
                    targets: -4,
                    orderable: true,
                    searchable: true,
                    render: function(data, type, full, meta) {
                        if (type == 'sort') {
                            return full.active ? '1' : '0';
                        }
                        if (type === 'display') {
                            return full.active ?
                                `
                            <button data-id="${full.id}" class="btn text-success btn-icon item-toggle">
                                بله
                            </button>
                        ` :
                                `
                            <button data-id="${full.id}" class="btn text-danger btn-icon item-toggle">
                                خیر
                            </button>
                        `;
                        }
                        // برای sort و filter مقدار عددی
                        return full.active ? 'بله' : 'خیر';
                    },
                },
                {
                    targets: -3,
                    orderable: true,
                    searchable: true,
                    render: function(data, type, full, meta) {
                        priceNew = full.price_in_person ? full.price_in_person.toLocaleString('en-US') : '';
                        if (type == 'display') {
                            return `
                            <div class="custom-input-group prices ps-2 ${full.price_in_person ? 'filled' : ''}">
                                <input type="text" class="form-control price-input px-1"
                                       value="${priceNew}"
                                       data-field="price_in_person"
                                       data-id="${full.id}">
                                <span class="clear-btn" style="font-size: 1rem;left: -1px;">×</span>
                            </div>`;
                        }
                        return priceNew;
                    },
                },
                {
                    targets: -2,
                    orderable: true,
                    searchable: true,
                    render: function(data, type, full, meta) {
                        priceNew = full.price_virtual ? full.price_virtual.toLocaleString('en-US') : '';
                        if (type == 'display') {
                            return `
                            <div class="custom-input-group prices ps-2 ${full.price_virtual ? 'filled' : ''}">
                                <input type="text" class="form-control price-input px-1"
                                       value="${priceNew}"
                                       data-field="price_virtual"
                                       data-id="${full.id}">
                                <span class="clear-btn" style="font-size: 1rem;left: -1px;">×</span>
                            </div>`;
                        }
                        return priceNew;
                    },
                },
                {
                    targets: -1,
                    orderable: true,
                    searchable: true,
                    render: function(data, type, full, meta) {
                        priceNew = full.price_online ? full.price_online.toLocaleString('en-US') : '';
                        if (type == 'display') {
                            return `
                            <div class="custom-input-group prices ps-2 ${full.price_online ? 'filled' : ''}">
                                <input type="text" class="form-control price-input px-1"
                                       value="${priceNew}"
                                       data-field="price_online"
                                       data-id="${full.id}">
                                <span class="clear-btn" style="font-size: 1rem;left: -1px;">×</span>
                            </div>`;
                        }
                        return priceNew;
                    },
                },
            ],
            order: [
                [2, "asc"]
            ],
            dom: '<"card-header flex-column flex-md-row"<"dt-action-buttons text-end primary-font pt-3 pt-md-0"B>>' +
                '<"d-flex justify-content-between align-items-center table-search-fixed"<"d-flex justify-content-start align-items-center gap-3"l <\'bulk-holder2\'>><"d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t>' +
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
                let noSearchColumns = [0, ];
                let priceHeaders = [9, 10, 11];
                // **تنظیم رویداد برای اینپوت های معمولی**
                $('.professions thead tr:eq(1) th').each(function(i) {
                    $(this).removeClass('sorting');
                    $(this).removeClass('sorting_asc');
                    $(this).removeClass('sorting_desc');
                    $(this).addClass('px-2');

                    if (noSearchColumns.includes(i)) {
                        $(this).html('');
                        return;
                    }

                    var title = $(this).text();
                    $(this).html(`
                    <div class="slider-select d-flex justify-content-between gap-2">
                        <div class="custom-input-group ${priceHeaders.includes(i) ? 'prices' : ''}">
                        <input type="text" class="form-control ${priceHeaders.includes(i) ? 'price-input' : ''} px-1">
                        <label for=""></label>
                        <span class="clear-btn" onclick="clearInput(this,${i})" style="font-size: 1rem;left: -1px;">×</span>
                    </div>
                    `);
                    $('input', this).on('keyup change', function() {
                        if (i == 1) {
                            if (this.value.length > 0) {
                                dt_basic.column(i + 1).search('^' + this.value + '$', true,
                                    false).draw();
                            } else {
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

                syncPriceInputs(); // همگام‌سازی ورودی‌های شهریه
            }

        });
        let thead = $('.professions thead');
        let searchRow = thead.find('tr').clone().appendTo(thead);
        let noSearchColumns = [0, 8, 9, 10];

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
            document.querySelectorAll('.price-input').forEach(input => {
                let cursorPosition = input.selectionStart;
                let rawValue = input.value.replace(/,/g, ''); // حذف کاماهای قبلی

                // اگر چیزی غیر از عدد وارد شد، حذفش کن
                if (!/^\d*$/.test(rawValue)) {
                    rawValue = rawValue.replace(/\D/g, '');
                }

                // فرمت کردن سه‌رقمی با Intl
                let formatted = '';
                if (rawValue) {
                    formatted = new Intl.NumberFormat('en-US').format(Number(rawValue));
                }

                input.value = formatted;

                // حرکت مجدد کرسر به انتها (ساده‌ترین حالت درست)
                input.setSelectionRange(input.value.length, input.value.length);
                input.addEventListener('input', function(e) {
                    let cursorPosition = this.selectionStart;
                    let rawValue = this.value.replace(/,/g, ''); // حذف کاماهای قبلی

                    // اگر چیزی غیر از عدد وارد شد، حذفش کن
                    if (!/^\d*$/.test(rawValue)) {
                        rawValue = rawValue.replace(/\D/g, '');
                    }

                    // فرمت کردن سه‌رقمی با Intl
                    let formatted = '';
                    if (rawValue) {
                        formatted = new Intl.NumberFormat('en-US').format(Number(rawValue));
                    }

                    this.value = formatted;

                    // حرکت مجدد کرسر به انتها (ساده‌ترین حالت درست)
                    this.setSelectionRange(this.value.length, this.value.length);
                });

                // جلوگیری از حروف
                input.addEventListener('keypress', e => {
                    if (!/[0-9]/.test(e.key)) e.preventDefault();
                });
            });
        });

        // بعد از تعریف dt_basic
        dt_basic.on('draw', function() {
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

            document.querySelectorAll('.price-input').forEach(input => {
                let cursorPosition = input.selectionStart;
                let rawValue = input.value.replace(/,/g, ''); // حذف کاماهای قبلی

                // اگر چیزی غیر از عدد وارد شد، حذفش کن
                if (!/^\d*$/.test(rawValue)) {
                    rawValue = rawValue.replace(/\D/g, '');
                }

                // فرمت کردن سه‌رقمی با Intl
                let formatted = '';
                if (rawValue) {
                    formatted = new Intl.NumberFormat('en-US').format(Number(rawValue));
                }

                input.value = formatted;

                // حرکت مجدد کرسر به انتها (ساده‌ترین حالت درست)
                input.setSelectionRange(input.value.length, input.value.length);
            });


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
            $("#totalRecord2").html(totalRecords);
            $("#filteredrecord").html(filteredRecords);
            $("#selectedRecord").html(selectedCount);


            syncPriceInputs(); // به‌روزرسانی مقادیر نمایشی پس از هر draw
        });

        function syncPriceInputs() {
            dt_basic.rows({
                page: 'current'
            }).every(function() {
                var rowData = this.data();
                var $row = $(this.node());
                var id = rowData.id;

                syncSingleInput($row, 9, id, 'price_in_person', rowData);
                syncSingleInput($row, 10, id, 'price_virtual', rowData);
                syncSingleInput($row, 11, id, 'price_online', rowData);
            });
        }

        function syncSingleInput($row, colIdx, id, field, rowData) {
            var $input = $row.find('td:eq(' + colIdx + ') input');
            // اگر مقدار تغییر‌یافته در حافظه باشد از آن استفاده کند، وگرنه مقدار اصلی
            var stored = (unsavedPrices[id] && unsavedPrices[id][field] !== undefined) ?
                unsavedPrices[id][field] :
                (rowData[field] || '');
            $input.val(stored.toLocaleString('en-US'));
            // کلاس filled
            if (stored) {
                $input.parent().addClass('filled');
            } else {
                $input.parent().removeClass('filled');
            }
        }

        function getNumericPrice($input) {
            return parseFloat($input.val().replace(/,/g, '')) || 0;
        }

        // مدیریت تغییر ورودی‌های شهریه
        $(document).on('input', '.professions .prices input[data-field]', function() {
            var $input = $(this);
            var field = $input.data('field');
            var id = $input.data('id');
            var row = dt_basic.row($input.closest('tr'));
            var rowData = row.data();
            var original = parseFloat(rowData[field]) || '';
            var newVal = parseFloat($input.val()) || '';

            // اجازه فقط عدد
            // $input.val(newVal);

            // کلاس filled
            var $parent = $input.parent();
            if (newVal) {
                $parent.addClass('filled');
                $input.closest('tr').addClass('changed');
            } else {
                $parent.removeClass('filled');
                $input.closest('tr').removeClass('changed');
            }

            // بروزرسانی شیء unsavedPrices
            if (newVal !== original) {
                if (!unsavedPrices[id]) unsavedPrices[id] = {};
                newVal = getNumericPrice($input);
                unsavedPrices[id][field] = newVal;
            } else {
                if (unsavedPrices[id]) {
                    delete unsavedPrices[id][field];
                    if (Object.keys(unsavedPrices[id]).length === 0) {
                        delete unsavedPrices[id];
                    }
                }
            }

            toggleSaveButton(); // نمایش/مخفی کردن دکمه ذخیره
        });

        // مدیریت دکمه پاک‌سازی (×) در ستون‌های شهریه
        $(document).on('click', '.professions .prices .clear-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var $input = $(this).siblings('input');
            var field = $input.data('field');
            var id = $input.data('id');
            var rowData = dt_basic.row($(this).closest('tr')).data();
            var original = parseFloat(rowData[field]) || 0;

            formatted = new Intl.NumberFormat('en-US').format(Number(original));

            $input.val(formatted).trigger('input'); // رویداد input را صدا بزن تا هماهنگ شود
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

        // delete selected items----------------------------------------------------------------------------------------------------------
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
                        url: "/admin2/tuitions/" + tuitionId + "/tuitions-professions/bulk-toggle",
                        type: "POST",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr("content"),
                            ids: ids,
                            status: status,
                        },
                        success: function(res) {
                            toastr.success(res.message);

                            // حلقه زدن روی ID های ارسال شده
                            ids.forEach(function(id) {
                                var $button = dt_basic.rows().nodes().to$().find(
                                    `button.item-toggle[data-id="${id}"]`);

                                if ($button.length) {

                                    if (status) { // اگر وضعیت به 'منتشر شده' تغییر کرد

                                        $button.removeClass('text-danger').addClass(
                                            'text-success');
                                        $button.text('بله');
                                    } else { // اگر وضعیت به 'منتشر نشده' تغییر کرد

                                        $button.removeClass('text-success')
                                            .addClass('text-danger');
                                        $button.text('خیر');
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
                            toastr.error(err.responseJSON.message);
                            console.error(err);
                        },
                    });
                }
            });
        });
        // toggle one item----------------------------------------------------------------------------------------------------------------
        dt_basic.on("click", ".item-toggle", function() {
            const id = $(this).data("id");

            var button = $(this);
            var icon = button.find('i');

            if (!id) return;
            $.ajax({
                url: "/admin2/tuitions/" + tuitionId + "/" + id + "/toggle",
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
                    toastr.error(err.responseJSON.message);
                    console.error(err);
                },
            });
        });

        // تابع پاک کردن محتوا
        function clearInput(btn, col = 1) {
            const parent = btn.parentElement;
            const input = parent.querySelector("input, textarea");
            input.value = null;
            input.focus();
            parent.classList.remove("filled");

            // پاک کردن جستجوی آن ستون و رسم دوباره جدول
            dt_basic.column(col + 1).search('').draw();
        }


        // فرض کنید دکمه ذخیره دارای id="save-prices" است
        $('#save-prices').on('click', function() {
            // آرایه‌ای برای نگهداری قیمت‌های تغییر‌یافته و معتبر
            const changedPrices = [];

            // پیمایش تمام ردیف‌های جدول (فقط ردیف‌های فیلتر شده/نمایش داده شده)
            dt_basic.rows({
                search: 'applied'
            }).every(function() {
                const rowData = this.data(); // داده اصلی ردیف از سرور (شامل price_in_person و ...)
                const rowNode = this.node(); // عنصر DOM ردیف

                // یافتن input های قیمت در این ردیف (با استفاده از کلاس یا ایندکس ستون)
                // راه بهتر: استفاده از data-id یا کلاس مشخص، اما چون ستون‌ها مشخص‌اند از ایندکس استفاده می‌کنیم
                const $row = $(rowNode);
                const personInput = $row.find('td:eq(9) input'); // ستون 9: هزینه حضوری
                const virtualInput = $row.find('td:eq(10) input'); // ستون 10: هزینه مجازی
                const onlineInput = $row.find('td:eq(11) input'); // ستون 11: هزینه الکترونیکی

                // مقادیر وارد شده توسط کاربر (پیش‌فرض 0)
                const personVal = getNumericPrice(personInput) || 0;
                const virtualVal = getNumericPrice(virtualInput) || 0;
                const onlineVal = getNumericPrice(onlineInput) || 0;

                // مقادیر اصلی از سرور (اگر null بود 0 در نظر بگیرید)
                const originalPerson = parseFloat(rowData.price_in_person) || 0;
                const originalVirtual = parseFloat(rowData.price_virtual) || 0;
                const originalOnline = parseFloat(rowData.price_online) || 0;

                // آیا تغییری رخ داده است؟
                const personChanged = personVal !== originalPerson;
                const virtualChanged = virtualVal !== originalVirtual;
                const onlineChanged = onlineVal !== originalOnline;

                const anyChanged = personChanged || virtualChanged || onlineChanged;
                // آیا حداقل یک قیمت بزرگتر از 0 است؟
                const anyPositive = personVal > 0 || virtualVal > 0 || onlineVal > 0;

                // فقط اگر هم تغییر داشته باشد و هم حداقل یک قیمت > 0 باشد
                if (anyChanged && anyPositive) {
                    changedPrices.push({
                        profession_id: rowData.id,
                        price_in_person: personVal,
                        price_virtual: virtualVal,
                        price_online: onlineVal
                    });
                }
            });

            if (changedPrices.length === 0) {
                toastr.error('هیچ قیمت تغییر یافته و معتبری (بزرگتر از صفر) یافت نشد');
                return;
            }

            // ارسال به سرور
            $.ajax({
                url: `/admin2/tuitions/${tuitionId}/prices`, // مسیر ذخیره قیمت‌ها
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    prices: changedPrices
                },
                beforeSend: function() {
                    // می‌توانید دکمه را غیرفعال یا لودینگ نمایش دهید
                    $('#save-prices').prop('disabled', true).text('در حال ذخیره...');
                },
                success: function(response) {
                    toastr.success('قیمت‌ها با موفقیت ذخیره شدند');
                    unsavedPrices = {};
                    toggleSaveButton();
                    // dt_basic.ajax.reload(); // جدول رفرش می‌شود و مقادیر جدید را از سرور می‌گیرد
                },
                error: function(xhr) {
                    toastr.error('خطا در ذخیره‌سازی: ' + (xhr.responseJSON?.message || ''));
                },
                complete: function() {
                    $('#save-prices').prop('disabled', false).text('ذخیره');
                }
            });
        });
    </script>
    {{-- some shit --}}
    <script>
        window.addEventListener('scroll', function() {
            const element = document.querySelector('#breadcrumb-wrapper');
            const rect = element.getBoundingClientRect();

            // اگر فاصله از بالای viewport صفر باشد یعنی چسبیده
            if (rect.top <= 62) {
                element.classList.add('is-stuck');
            } else {
                element.classList.remove('is-stuck');
            }
        });
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
            const formActionUrl = form.attr('action');

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

                fetch('/admin2/tuitions/' + tuitionId + '/imports/') // روت بالا
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

                        fetch(`/admin2/tuitions/${tuitionId}/imports/${importId}/logs`)
                            .then(res => res.json())
                            .then(logs => {
                                if (logs.length === 0) {
                                    container.innerHTML =
                                        '<div class="ps-3 py-2 text-success">بدون خطا ✅</div>';
                                    return;
                                }

                                // جدا کردن موفق و ناموفق
                                const successLogs = [];
                                const errorLogs = [];

                                logs.forEach(log => {
                                    let rowData = typeof log.data === 'string' ? JSON
                                        .parse(log.data) : log.data;
                                    if (log.success) {
                                        successLogs.push({
                                            ...log,
                                            rowData
                                        });
                                    } else {
                                        errorLogs.push({
                                            ...log,
                                            rowData
                                        });
                                    }
                                });

                                let logsHtml = '';

                                // 🟥 بخش خطاها
                                if (errorLogs.length > 0) {
                                    logsHtml += `
                                        <div class="border rounded p-3 bg-white ${status == 1 ? 'd-none' : ''}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-danger m-0">ثبت‌های ناموفق — ${errorLogs.length} مورد</h6>
                                                <button class="btn btn-sm btn-outline-primary printBtn" data-target="${importId}" data-status="${status}">
                                                    پرینت نتایج
                                                </button>
                                            </div>
                                            <ul class="list-group list-group-flush">
                                    `;

                                    errorLogs.forEach((log, i) => {
                                        logsHtml += `
                                            <li class="list-group-item list-group-item-danger">
                                                <div>${i + 1}</div>
                                                <strong>ردیف ${log.row_number}</strong>
                                                <div>شهریه درج نگردید.</div>
                                                <div>دلیل: ${log.error_message || '—'}</div>
                                            </li>
                                        `;
                                    });

                                    logsHtml += '</ul></div>';
                                }

                                // 🟩 بخش موفق‌ها
                                if (successLogs.length > 0) {
                                    logsHtml += `
                                        <div class="border rounded p-3 mb-3 bg-white ${status == 0 ? 'd-none' : ''}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-success m-0">ثبت‌های موفق — ${successLogs.length} مورد</h6>
                                                <button class="btn btn-sm btn-outline-primary printBtn" data-target="${importId}" data-status="${status}">
                                                    پرینت نتایج
                                                </button>
                                            </div>
                                            <ul class="list-group list-group-flush">
                                    `;

                                    successLogs.forEach((log, i) => {
                                        logsHtml += `
                                            <li class="list-group-item list-group-item-success">
                                                <div>${i + 1}</div>
                                                <strong>ردیف ${log.row_number}</strong>
                                                <div>شهریه با موفقیت درج گردید.</div>
                                            </li>
                                        `;
                                    });

                                    logsHtml += '</ul></div>';
                                }

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
                    `/admin2/tuitions/${tuitionId}/print/${divId}?status=${status}`; // اگر فایل در root است
                // اگر در فولدر است: `/your-folder/print-content.html?data=${encodedContent}`

                // باز کردن صفحه پرینت در یک پنجره جدید یا tab جدید
                window.open(printUrl, '_blank');
            });

        });
    </script>
@endsection
