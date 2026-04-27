@extends('admin.layout.master')
@section('head')
    <style>
        td {
            padding: 10px 8px !important;
        }

        .select2-container--default .select2-results>.select2-results__options {
            max-height: 15.5rem !important;
            overflow-y: auto;
            margin-left: 5px;
        }

        /* اطمینان از نمایش dropdown بالای همه عناصر */
        .select2-container--default .select2-dropdown,
        .select2-container--bootstrap-5 .select2-dropdown {
            z-index: 99999 !important;
        }

        /* اگر داخل مودال هستید */
        .modal .select2-dropdown {
            z-index: 1056 !important;
            /* بالاتر از مودال بوت‌استرپ */
        }

        /* رفع مشکل overflow */
        .modal-body {
            overflow: visible !important;
        }

        .select2-container {
            z-index: 99999 !important;
        }

        .onelone {
            display: -webkit-box !important;
            overflow: hidden !important;
            line-clamp: 2;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}">
@endsection
@section('content')
    <h5 class="breadcrumb-wrapper mb-4 pt-4" style="padding: 15px 10px !important;" id="breadcrumb-wrapper">
        <a href="{{ route('admin.index') }}" class="text-muted">داشبورد</a> <span class="text-muted">/</span>
        <span>مدیریت نرخ شهریه</span>
    </h5>

    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable p-3">
            <div class="fixed-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="head-label d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">لیست نرخ شهریه ها</h5>
                        <small class="text-muted ms-2">(
                            تعداد : <span id="totalRecord">0</span> ردیف /
                            فلیتر شده : <span id="filteredrecord">0</span> ردیف /
                            انتخاب شده : <span id="selectedRecord">0</span> ردیف )</small>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
                        نرخ شهریه جدید
                        <i class="bx bx-plus ms-2"></i>
                    </button>
                </div>
                <div class="d-flex justify-content-start align-items-center gap-2 text-muted">
                    <small class="py-3 text-white">1</small>
                </div>
            </div>
            <table class="dt-select-table tuitions table table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>ردیف</th>
                        <th>عنوان</th>
                        <th>استان</th>
                        <th>شهرستان</th>
                        <th>شروع</th>
                        <th>پایان</th>
                        <th>انتشار</th>
                        <th>جزئیات</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
            </table>
            <div id="bulk-actions" class="bulk-actions">
                <div class="btn-group action_group" id="action_group" style="display: none">
                    <button type="button" class="btn border dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        انتخاب عملیـات
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <button class="dropdown-item text-danger bulk-delete" id="bulk-delete" href="#">
                                <i class=" bx bx-trash"></i>
                                حذف انتخابی ها
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="bulk-actions2" class="bulk-actions">
                <div class="btn-group action_group" id="action_group" style="display: none">
                    <button type="button" class="btn border dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        انتخاب عملیـات
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <button class="dropdown-item text-danger bulk-delete" id="bulk-delete" href="#">
                                <i class=" bx bx-trash"></i>
                                حذف انتخابی ها
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal create -->
    <div class="modal fade" id="modalCenter" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title secondary-font" id="modalCenterTitle">نرخ شهریه جدید</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- فرم افزودن شهریه --}}
                    <form action="{{ route('admin.tuitions.store') }}" method="post"
                        class="add-new-record pt-0 row g-2 mt-3 px-3" id="form-add-new-record">
                        @csrf

                        {{-- عنوان شهریه --}}
                        <div class="col-sm-12">
                            <div class="custom-input-group">
                                <input type="text" id="title" class="form-control" name="title">
                                <label class="form-label" for="title">عنوان شهریه</label>
                                <span class="clear-btn" onclick="clearInput(this)">×</span>
                            </div>
                        </div>

                        {{-- بازه زمانی --}}
                        <div class="col-sm-6 mt-3">
                            <div class="custom-input-group">
                                <input type="date" id="start_date" name="start_date" class="form-control">
                                <label class="form-label" for="start_date">تاریخ شروع</label>
                                <span class="clear-btn" onclick="clearInput(this)">×</span>
                            </div>
                        </div>

                        <div class="col-sm-6 mt-3">
                            <div class="custom-input-group">
                                <input type="date" id="end_date" name="end_date" class="form-control">
                                <label class="form-label" for="end_date">تاریخ پایان</label>
                                <span class="clear-btn" onclick="clearInput(this)">×</span>
                            </div>
                        </div>

                        {{-- انتخاب استان --}}
                        <div class="col-sm-12 mt-3">
                            <label class="form-label" for="state_id">انتخاب استان</label>
                            <select id="state_id" name="state_id" class="form-select select2" disabled>
                                <option value="" disabled selected>انتخاب کنید...</option>
                            </select>
                        </div>

                        {{-- انتخاب شهر --}}
                        <div class="col-sm-12 mt-3">
                            <label class="form-label" for="city_id">انتخاب شهرستان</label>
                            <select id="city_id" name="city_ids[]" class="form-select select2" multiple disabled
                                required>
                            </select>
                        </div>

                        {{-- دکمه ثبت --}}
                        <div class="col-sm-12 mt-3">
                            <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ثبت</button>
                            <button type="submit" class="btn btn-outline-primary data-submit me-sm-3 me-1"
                                data-bs-dismiss="modal">ثبت و خروج</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title secondary-font" id="modalEditTitle">ویرایش شهریه</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" class="add-new-record pt-0 row g-2 px-3" id="form-edit-record">
                        @csrf
                        <div class="col-sm-12">
                            <input type="hidden" id="id" class="form-control" name="id">
                        </div>
                        {{-- عنوان شهریه --}}
                        <div class="col-sm-12">
                            <div class="custom-input-group">
                                <input type="text" id="title2" class="form-control" name="title">
                                <label class="form-label" for="title">عنوان شهریه</label>
                                <span class="clear-btn" onclick="clearInput(this)">×</span>
                            </div>
                        </div>
                        {{-- بازه زمانی --}}
                        <div class="col-sm-6 mt-3">
                            <div class="custom-input-group">
                                <input type="date" id="start_date2" name="start_date" class="form-control">
                                <label class="form-label" for="start_date2">تاریخ شروع</label>
                                <span class="clear-btn" onclick="clearInput(this)">×</span>
                            </div>
                        </div>

                        <div class="col-sm-6 mt-3">
                            <div class="custom-input-group">
                                <input type="date" id="end_date2" name="end_date" class="form-control">
                                <label class="form-label" for="end_date2">تاریخ پایان</label>
                                <span class="clear-btn" onclick="clearInput(this)">×</span>
                            </div>
                        </div>
                        {{-- انتخاب استان --}}
                        <div class="col-sm-12 mt-3">
                            <label class="form-label" for="state_id">انتخاب استان</label>
                            <select id="state_id2" name="state_id" class="form-select select2" disabled>
                                <option value="" disabled selected>انتخاب کنید...</option>
                            </select>
                        </div>

                        {{-- انتخاب شهر --}}
                        <div class="col-sm-12 mt-3">
                            <label class="form-label" for="city_id">انتخاب شهرستان</label>
                            <select id="city_id2" name="city_ids[]" class="form-select select2" multiple disabled
                                required>
                            </select>
                        </div>

                        <div class="col-sm-12 mt-3">
                            <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ذخیره</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('admin/assets/js/validation.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/select2/i18n/fa.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/js/dropdown-hover.js') }}"></script>
    <script>
        const start_date2 = document.querySelector('#start_date2');
        if (start_date2) {
            start_date2.flatpickr({
                monthSelectorType: 'static',
                locale: 'fa',
                altInput: true,
                altFormat: 'Y/m/d',
                disableMobile: true
            });
        }
        const end_date2 = document.querySelector('#end_date2');
        if (end_date2) {
            end_date2.flatpickr({
                monthSelectorType: 'static',
                locale: 'fa',
                altInput: true,
                altFormat: 'Y/m/d',
                disableMobile: true
            });
        }
        const start_date = document.querySelector('#start_date');
        if (start_date) {
            start_date.flatpickr({
                monthSelectorType: 'static',
                locale: 'fa',
                altInput: true,
                altFormat: 'Y/m/d',
                disableMobile: true
            });
        }
        const end_date = document.querySelector('#end_date');
        if (end_date) {
            end_date.flatpickr({
                monthSelectorType: 'static',
                locale: 'fa',
                altInput: true,
                altFormat: 'Y/m/d',
                disableMobile: true
            });
        }

        function isEndDatePassed(dateStr) {
            if (!dateStr) return false;
            const parts = dateStr.split('-');
            if (parts.length !== 3) return false;
            const endDate = new Date(parts[0], parts[1] - 1, parts[2]);
            const today = new Date();
            endDate.setHours(0, 0, 0, 0);
            today.setHours(0, 0, 0, 0);
            return endDate < today;
        }
        tuitions = $(".tuitions");
        dt_basic = tuitions.DataTable({
            ajax: {
                url: "/admin2/tuitions",
                // این تابع قبل از شروع لود اجرا میشه
                beforeSend: function() {
                    $("#DataTables_Table_0_wrapper .dataTables_empty").hide();
                    $(".tuitions").closest(".card").append(`
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
            columns: [{
                    data: "id",
                    title: "",
                    width: "5%"
                },
                {
                    data: "id",
                    visible: false
                },
                {
                    data: "",
                    title: "ردیف",
                    width: "8%"
                },
                {
                    data: "title",
                    title: "عنوان",
                    width: "20%"
                },
                {
                    data: "state.title",
                    title: "استان",
                    width: "11%"
                },
                {
                    data: "cities",
                    title: "شهرستان",
                    width: "16%",
                    render: function(data, type, row) {
                        // برای نمایش در جدول
                        if (type === 'display') {
                            if (Array.isArray(data) && data.length > 0) {
                                return `
                                <div class="onelone" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="${data.map(city => city.title).join('، ')}" >
                                    ${data.map(city => city.title).join('، ')}
                                </div>
                                `;
                            }
                            return '—';
                        }
                        // برای مرتب‌سازی و جستجو: یک رشته ساده از نام شهرها
                        if (type === 'sort' || type === 'filter') {
                            if (Array.isArray(data)) {
                                return data.map(city => city.title).join(' ');
                            }
                            return '';
                        }
                        // برای سایر موارد (مثلاً type === 'type')
                        return data;
                    },
                },
                {
                    data: "start_date",
                    title: "شروع اعتبار",
                    width: "7%",
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return new Date(data).toLocaleDateString('fa-IR');
                        }
                        // برای sort و filter مقدار عددی
                        return parseInt(data) || 0;
                    },
                },
                {
                    data: "end_date",
                    title: "پایان اعتبار",
                    width: "7%",
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return new Date(data).toLocaleDateString('fa-IR');
                        }
                        // برای sort و filter مقدار عددی
                        return parseInt(data) || 0;
                    },
                },
                {
                    data: "",
                    title: "انتشار",
                    width: "7%"
                },
                {
                    data: "",
                    title: "جزئیات",
                    width: "15%"
                },
                {
                    data: "",
                    title: "عملیات",
                    width: "5%"
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
                    targets: 2, // ستون شماره ردیف (مطابق ایندکس خودت)
                    data: null,
                    title: "ردیف",
                    orderable: true,
                    searchable: true,
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
                    responsivePriority: 1,
                    targets: 4,
                },
                {
                    targets: -3,
                    title: "انتشار",
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
                    targets: -2, // جزئیات
                    title: "جزئیات",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        const isPast = isEndDatePassed(full.end_date);
                        if (isPast) {
                            return `
                            <a href="/admin2/tuitions/${full.id}/professions" class="btn btn-sm btn-secondary px-1 item-details">
                                مشاهده شهریه‌ها
                            </a>`;
                        } else {
                            return `
                            <a href="/admin2/tuitions/${full.id}/professions" class="btn btn-sm btn-info item-details">
                                درج و ویرایش شهریه
                            </a>`;
                        }
                    },
                },
                {
                    targets: -1, // عملیات
                    title: "عملیات",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        const isPast = isEndDatePassed(full.end_date);
                        const editButton = !isPast ?
                            `<li>
                                <button class="dropdown-item item-edit" data-id="${full.id}">
                                    ویرایش
                                </button>
                            </li>` :
                            '';

                        return `
                            <div class="btn-group">
                                <button type="button" class="btn btn-icon dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown" data-trigger="hover">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    ${editButton}
                                    <li>
                                        <button class="dropdown-item item-delete" data-id="${full.id}">
                                            حذف
                                        </button>
                                    </li>
                                </ul>
                            </div>`;
                    },
                },
            ],
            order: [
                [2, "asc"]
            ],
            dom: '<"card-header flex-column flex-md-row"<"dt-action-buttons text-end primary-font pt-3 pt-md-0"B>>' +
                '<"d-flex justify-content-between align-items-center table-search-fixed"<"d-flex justify-content-start align-items-center gap-3"l <\'bulk-holder2\'>><"d-flex justify-content-center justify-content-md-end"f>><t>' +
                +
                "<'row d-flex align-items-center justify-content-between'<'col-md-4'<'bulk-holder'>><'col-md-8 d-flex justify-content-between'i p>>",
            displayLength: 10,
            lengthMenu: [10, 25, 50, 75, 100, 500],
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
                style: "multi",
                selector: 'td:first-child', // انتخاب با کلیک روی چک‌باکس
                items: 'row' // انتخاب ردیف‌ها
            },
            initComplete: function(settings, json) {
                let noSearchColumns = [0, 7, 8, 9];
                // **تنظیم رویداد برای اینپوت های معمولی**
                $('.tuitions thead tr:eq(1) th').each(function(i) {
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
                    <div class="custom-input-group">
                        <input type="text" class="form-control px-1">
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
                $('.tuitions thead tr:eq(0) th:eq(0)').html($headerCheckbox);

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
        let thead = $('.tuitions thead');
        let searchRow = thead.find('tr').clone().appendTo(thead);

        $("#bulk-actions").appendTo(".bulk-holder");
        $("#bulk-actions2").appendTo(".bulk-holder2");
        dt_basic.on('draw', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

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

        // تابع پاک کردن محتوا
        function clearInput(btn, col = 1) {
            const parent = btn.parentElement;
            const input = parent.querySelectorAll("input, textarea");
            parent.querySelectorAll("input, textarea").forEach(function(input) {
                input.value = null;
            });
            parent.classList.remove("filled");

            // پاک کردن جستجوی آن ستون و رسم دوباره جدول
            dt_basic.column(col + 1).search('').draw();
        }
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
                focusConfirm: false,
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/admin2/tuitions/delete/" + id,
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
                } else {
                    $(".bulk-actions .action_group").hide();
                    $(".bulk-actions .bulk-delete").prop("disabled", true);
                    $(".bulk-actions .bulk-toggle").prop("disabled", true);
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

            // delete
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
                    focusConfirm: false,
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin2/tuitions/bulk-delete",
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
                                $("#bulk-actions #bulk-delete").prop("disabled", true);
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
                    title: `آیا از تغییر وضعیت ${ids.length} رکورد مطمئن هستید؟`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "تایید",
                    cancelButtonText: "انصراف",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin2/tuitions/bulk-toggle",
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
                                dt_basic.ajax.reload(null, false);
                                $("#bulk-actions .bulk-toggle").prop("disabled", true);
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

            if (!id) return;
            $.ajax({
                url: "/admin2/tuitions/" + id + "/toggle",
                type: "patch",
                data: {
                    _token: $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function(res) {
                    dt_basic.ajax.reload(null, false);
                    toastr.success(res.message);
                },
                error: function(err) {
                    toastr.error("خطا در ارتباط با سرور.");
                    console.error(err);
                },
            });
        });

        // add new record-------------------------------------------------------------------------------------------------------------
        initOffcanvasForm({
            formId: "form-add-new-record",
            triggerSelector: ".create-new",
            fields: {
                title: {
                    label: "عنوان شهریه",
                    required: true,
                    type: "text",
                },
                state_id: {
                    label: "استان",
                    required: true,
                    type: "select",
                    options: [], // گزینه‌ها پویا هستند
                },
                city_ids: {
                    label: "شهرها",
                    required: true,
                    type: "select",
                    options: [],
                    multiple: true,
                },
                start_date: {
                    label: "تاریخ شروع",
                    required: true,
                    type: "date",
                },
                end_date: {
                    label: "تاریخ پایان",
                    required: true,
                    type: "date",
                },
            },
            onSubmit: function(values) {
                // 1. اعتبارسنجی تاریخ‌ها
                const startDate = new Date(values.start_date);
                const endDate = new Date(values.end_date);
                if (isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
                    toastr.error('لطفاً تاریخ شروع و پایان را به درستی وارد کنید');
                    return;
                }
                if (endDate <= startDate) {
                    toastr.error('تاریخ پایان باید بعد از تاریخ شروع باشد');
                    return;
                }

                const selectedCities = $('#city_id').val() || []; // آرایه‌ای از کدهای شهر

                // 3. جایگزینی در شیء values
                values.city_ids = selectedCities; // نام بدون براکت برای هماهنگی با بک‌اند
                delete values['city_ids[]']; // حذف کلید اضافی که تابع ایجاد کرده بود

                // 4. افزودن CSRF token
                values._token = $('meta[name="csrf-token"]').attr('content');

                // 5. ارسال به سرور
                $.post("/admin2/tuitions/store", values, function(res) {
                    if (res.success) {
                        dt_basic.ajax.reload();
                    } else {
                        toastr.error(res.message || 'خطایی رخ داد');
                    }
                }).fail(function(xhr) {
                    console.error(xhr.responseText);
                    toastr.error('خطا در ارتباط با سرور');
                });
            }
        });

        // edit with modal -----------------------------------------------------------------------------------------------------------
        // متغیرهای سراسری برای Select2‌های داخل مودال
        let modalStateSelect, modalCitySelect;
        let selectedCities;
        // آماده‌سازی اولیه Select2‌ها (یک‌بار هنگام بارگذاری صفحه)
        $(document).ready(function() {
            modalStateSelect = $('#modalEdit #state_id2').select2({
                placeholder: 'استان را انتخاب کنید',
                allowClear: true,
                width: '100%',
            });

            modalCitySelect = $('#modalEdit #city_id2').select2({
                placeholder: 'شهرها را انتخاب کنید',
                allowClear: true,
                width: '100%',
                multiple: true,
                closeOnSelect: false // با این گزینه، باکس پس از انتخاب بسته نمی‌شود
            });

            // پاک‌سازی فرم هنگام بستن مودال
            $('#modalEdit').on('hidden.bs.modal', function() {
                $('#form-edit-record')[0].reset();
                modalStateSelect.val(null).trigger('change');
                modalCitySelect.val(null).trigger('change');
                resetCityOptions();
            });
        });

        // کمکی برای ریست کردن گزینه‌های شهر
        function resetCityOptions() {
            modalCitySelect.empty().append('<option value="" disabled>ابتدا استان را انتخاب کنید</option>').prop('disabled',
                true).trigger('change');
        }

        // بارگذاری استان‌ها در Select2
        function populateStateSelect(states, selectedId) {
            modalStateSelect.empty();
            modalStateSelect.append('<option value="" disabled>انتخاب کنید...</option>');
            $.each(states, function(i, state) {
                modalStateSelect.append(new Option(state.title, state.id));
            });
            modalStateSelect.val(selectedId).trigger('change');
        }

        // بارگذاری شهرها بر اساس استان انتخاب‌شده
        function populateCitySelect(cities, selectedIds) {
            modalCitySelect.empty();
            if (cities.length === 0) {
                modalCitySelect.append('<option value="" disabled>هیچ شهری موجود نیست</option>');
            } else {
                $.each(cities, function(i, city) {
                    const isSelected = selectedCities.some(function(sel) {
                        return sel.id === city;
                    });
                    // console.log(selectedCities);
                    // console.log(isSelected);
                    // console.log(city);

                    modalCitySelect.append($('<option>', {
                        value: city,
                        text: i,
                        selected: isSelected
                    }));
                });
            }
            // modalCitySelect.val(selectedIds).trigger('change');
            modalCitySelect.prop('disabled', false);
        }

        // کلیک روی دکمه ویرایش
        $(document).on('click', '.item-edit', function() {
            const id = $(this).data('id');

            $('#modalEdit .modal-body').addClass('opacity-50');
            $('#modalEdit').modal('show');

            $.ajax({
                url: `/admin2/tuitions/${id}/edit`,
                method: 'GET',
                success: function(res) {
                    const d = res.data;

                    $('#modalEdit #id').val(d.id);
                    const startPicker = $('#modalEdit #start_date2')[0]
                        ._flatpickr; // یا .data('flatpickr')
                    if (startPicker) {
                        startPicker.setDate(d.startMiladi);
                        $('#modalEdit #start_date2').closest('.custom-input-group').addClass('filled');
                    }

                    const endPicker = $('#modalEdit #end_date2')[0]._flatpickr;
                    if (endPicker) {
                        endPicker.setDate(d.endMiladi);
                        $('#modalEdit #end_date2').closest('.custom-input-group').addClass('filled');
                    }
                    $('#modalEdit #title2').val(d.title).parent().addClass('filled');

                    // پر کردن استان‌ها
                    populateStateSelect(res.states, d.state_id);

                    // ذخیره شهرهای انتخاب‌شده فعلی در attribute برای بارگذاری اولیه
                    selectedCities = res.cities;
                    // بارگذاری شهرها بر اساس استان فعلی

                    $.each(res.cities, function(i, city) {
                        modalCitySelect.append($('<option>', {
                            value: city.id,
                            text: city.title,
                            selected: true,
                        }));
                    });
                    modalCitySelect.val('').trigger('change');
                    modalCitySelect.prop('disabled', false);

                    // غیرفعال‌سازی استان برای جلوگیری از تغییر (می‌توانید در صورت نیاز فعال بگذارید)
                    // چون تاریخ ثابت است، اجازه تغییر استان می‌دهیم
                    modalStateSelect.prop('disabled', false);

                    $('#modalEdit .modal-body').removeClass('opacity-50');
                },
                error: function() {
                    toastr.error('خطا در بارگذاری اطلاعات');
                    $('#modalEdit').modal('hide');
                }
            });
        });

        // تغییر استان -> بارگذاری شهرهای همان استان با AJAX
        $('#state_id2').on('change', function() {
            const stateId = $(this).val();
            const startDate = $('#modalEdit #start_date2').val();
            const endDate = $('#modalEdit #end_date2').val();
            const tuitionId = $('#modalEdit #id').val();

            if (!stateId) {
                resetCityOptions();
                return;
            }

            // غیرفعال کردن شهرها تا زمان بارگذاری
            modalCitySelect.prop('disabled', true).empty().append('<option>در حال بارگذاری...</option>').trigger(
                'change');

            // فراخوانی مسیر مشابه available-cities اما با در نظر گرفتن tuitionId برای خروج
            $.ajax({
                url: '/admin2/tuitions/available-cities-for-edit',
                data: {
                    state_id: stateId,
                    start_date: startDate,
                    end_date: endDate,
                    tuition_id: tuitionId
                },
                success: function(cities) {
                    populateCitySelect(cities, []); // بدون انتخاب قبلی
                },
                error: function() {
                    toastr.error('خطا در بارگذاری شهرها');
                    resetCityOptions();
                }
            });
        });
        $("#start_date2").add("#end_date2").on('change', function() {
            const stateId = $('#modalEdit #state_id2').val();
            const startDate = $('#modalEdit #start_date2').val();
            const endDate = $('#modalEdit #end_date2').val();
            const tuitionId = $('#modalEdit #id').val();

            if (!stateId) {
                resetCityOptions();
                return;
            }

            // غیرفعال کردن شهرها تا زمان بارگذاری
            modalCitySelect.prop('disabled', true).empty().append('<option>در حال بارگذاری...</option>').trigger(
                'change');

            // فراخوانی مسیر مشابه available-cities اما با در نظر گرفتن tuitionId برای خروج
            $.ajax({
                url: '/admin2/tuitions/available-cities-for-edit',
                data: {
                    state_id: stateId,
                    start_date: startDate,
                    end_date: endDate,
                    tuition_id: tuitionId
                },
                success: function(cities) {
                    populateCitySelect(cities, []); // بدون انتخاب قبلی
                },
                error: function() {
                    toastr.error('خطا در بارگذاری شهرها');
                    resetCityOptions();
                }
            });
        });

        // ارسال فرم
        $('#form-edit-record').on('submit', function(e) {
            e.preventDefault();
            const id = $('#modalEdit #id').val();
            const values = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                _method: 'PUT', // شبیه‌سازی PUT
                title: $('#modalEdit #title2').val(),
                start_date: $('#modalEdit #start_date2').val(),
                end_date: $('#modalEdit #end_date2').val(),
                state_id: modalStateSelect.val(),
                city_ids: modalCitySelect.val()
            };

            $.ajax({
                url: `/admin2/tuitions/${id}`,
                method: 'POST', // با _method: PUT
                data: values,
                success: function(res) {
                    toastr.success(res.message);
                    $('#modalEdit').modal('hide');
                    dt_basic.ajax.reload();
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON?.message || 'خطا در ذخیره‌سازی');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            const $startDate = $('#start_date');
            const $endDate = $('#end_date');
            const $stateSelect = $('#state_id');
            const $citySelect = $('#city_id');

            $citySelect.select2({
                placeholder: 'شهرها را انتخاب کنید',
                allowClear: false,
                width: '100%',
                multiple: true,
                closeOnSelect: false // با این گزینه، باکس پس از انتخاب بسته نمی‌شود
            });

            // تابع غیرفعال/فعال کردن select استان
            function toggleStateSelect(enable) {
                $stateSelect.prop('disabled', !enable);
                if (!enable) {
                    $stateSelect.empty().append(
                        '<option value="" disabled selected>ابتدا بازه زمانی را انتخاب کنید</option>');
                }
            }

            // بارگذاری استان‌های آزاد
            function loadAvailableStates() {
                const start = $startDate.val();
                const end = $endDate.val();

                if (!start || !end) {
                    toggleStateSelect(false);
                    return;
                }

                $.ajax({
                    url: '{{ route('admin.tuitions.available-states') }}',
                    data: {
                        start_date: start,
                        end_date: end
                    },
                    beforeSend: function() {
                        $stateSelect.prop('disabled', true);
                        $stateSelect.empty().append('<option>در حال بارگذاری...</option>');
                    },
                    success: function(states) {
                        $stateSelect.empty();
                        if (states.length === 0) {
                            $stateSelect.append(
                                '<option value="" disabled>هیچ استانی در این بازه آزاد نیست</option>'
                            );
                            $stateSelect.prop('disabled', true);
                        } else {
                            $stateSelect.append(
                                '<option value="" disabled selected>انتخاب کنید...</option>');
                            $.each(states, function(i, state) {
                                $stateSelect.append($('<option>', {
                                    value: state.id,
                                    text: state.title
                                }));
                            });
                            $stateSelect.prop('disabled', false);
                        }
                    },
                    error: function() {
                        toastr.error('خطا در بارگذاری استان‌ها');
                        toggleStateSelect(false);
                    }
                });
            }

            function initCitySelectEvents() {
                // حذف event های قبلی برای جلوگیری از اجرای چندباره
                $citySelect.off('select2:select select2:unselect');

                $citySelect.on('select2:select', function(e) {
                    var selectedVal = e.params.data.id;

                    if (selectedVal === 'all_cities') {
                        // انتخاب "همه شهرها"
                        $citySelect.val('all_cities').trigger('change');
                        // غیرفعال کردن گزینه‌های دیگر
                        $citySelect.find('option').each(function() {
                            if ($(this).val() !== 'all_cities' && $(this).val() !== '') {
                                $(this).prop('disabled', true);
                            }
                        });

                        // اگر dropdown باز است، ببند و دوباره باز کن تا تغییرات نمایش یابد
                        if ($citySelect.select2('isOpen')) {
                            $citySelect.select2('close');
                            setTimeout(function() {
                                $citySelect.select2('open');
                            }, 0);
                        }
                    } else {
                        // انتخاب یک شهر عادی
                        var currentVal = $citySelect.val() || [];
                        // اگر "همه شهرها" در لیست انتخاب‌ها بود، آن را حذف کن
                        if (currentVal.indexOf('all_cities') !== -1) {
                            // فعال‌سازی مجدد همه گزینه‌ها
                            $citySelect.find('option').prop('disabled', false);
                            // حذف all_cities از انتخاب‌ها
                            var newVal = currentVal.filter(function(v) {
                                return v !== 'all_cities';
                            });
                            // اگر شهر جدید انتخاب شده، آن را هم اضافه کن
                            if (newVal.indexOf(selectedVal) === -1) {
                                newVal.push(selectedVal);
                            }
                            $citySelect.val(newVal).trigger('change');

                            // به‌روزرسانی ظاهری در صورت باز بودن dropdown
                            if ($citySelect.select2('isOpen')) {
                                $citySelect.select2('close');
                                setTimeout(function() {
                                    $citySelect.select2('open');
                                }, 0);
                            }
                        }
                    }
                });

                $citySelect.on('select2:unselect', function(e) {
                    var unselectedVal = e.params.data.id;
                    if (unselectedVal === 'all_cities') {
                        // برداشتن "همه شهرها" → فعال کردن دوباره تمام گزینه‌ها
                        $citySelect.find('option').prop('disabled', false);

                        // به‌روزرسانی ظاهری
                        if ($citySelect.select2('isOpen')) {
                            $citySelect.select2('close');
                            setTimeout(function() {
                                $citySelect.select2('open');
                            }, 0);
                        }
                    }
                });
            }

            // بارگذاری شهرهای آزاد بر اساس استان انتخاب‌شده
            function loadAvailableCities(stateId) {
                const start = $startDate.val();
                const end = $endDate.val();

                if (!stateId) {
                    $citySelect.empty().append(
                        '<option value="" disabled selected>ابتدا استان را انتخاب کنید</option>').prop(
                        'disabled', true);
                    // اگر Select2 فعال است، آن را به‌روزرسانی کن
                    if ($citySelect.hasClass('select2-hidden-accessible')) {
                        $citySelect.trigger('change.select2');
                    }
                    return;
                }

                $.ajax({
                    url: '{{ route('admin.tuitions.available-cities') }}',
                    data: {
                        start_date: start,
                        end_date: end,
                        state_id: stateId
                    },
                    beforeSend: function() {
                        $citySelect.prop('disabled', true);
                        $citySelect.empty().append('<option>در حال بارگذاری...</option>');
                        if ($citySelect.hasClass('select2-hidden-accessible')) {
                            $citySelect.trigger('change.select2');
                        }
                    },
                    success: function(cities) {

                        $citySelect.empty();

                        if (cities.length === 0) {
                            $citySelect.append(
                                '<option value="" disabled>هیچ شهری در این بازه آزاد نیست</option>'
                            );
                            $citySelect.prop('disabled', true);
                        } else {
                            $citySelect.append(
                                $('<option>', {
                                    value: 'all_cities',
                                    text: 'همه شهرستان ها'
                                })
                            );
                            $.each(cities, function(i, city) {
                                $citySelect.append(
                                    $('<option>', {
                                        value: city.id,
                                        text: city.title
                                    })
                                );
                            });

                            $citySelect.prop('disabled', false);
                        }

                        // ✅ فقط این خط کافیست
                        $citySelect.trigger('change');
                        initCitySelectEvents();
                    },
                    error: function() {
                        toastr.error('خطا در بارگذاری شهرستان ها');

                        $citySelect.empty().append(
                            '<option value="" disabled selected>خطا در بارگذاری</option>').prop(
                            'disabled', true);
                        if ($citySelect.hasClass('select2-hidden-accessible')) {
                            $citySelect.select2('destroy');
                            $citySelect.select2({
                                placeholder: 'شهرها را انتخاب کنید',
                                allowClear: true
                            });
                        }
                    }
                });
            }

            // رویداد تغییر تاریخ‌ها
            $startDate.add($endDate).on('change', function() {
                // اگر هر دو تاریخ انتخاب شده باشند
                if ($startDate.val() && $endDate.val()) {
                    loadAvailableStates();
                    $citySelect.empty();
                } else {
                    toggleStateSelect(false);
                }
            });

            // رویداد تغییر استان
            $stateSelect.on('change', function() {
                const stateId = $(this).val();
                loadAvailableCities(stateId);
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
@endsection
