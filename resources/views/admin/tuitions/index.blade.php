@extends('admin.layout.master')
@section('head')
<style>
    td{
        padding: 5px 8px !important;
    }
</style>
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
            </div>
            <table class="dt-select-table tuitions table table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>ردیف</th>
                        <th>عنوان نرخ شهریه</th>
                        <th>شهر</th>
                        <th>شروع</th>
                        <th>پایان</th>
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
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
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
                            </div>
                        </div>

                        {{-- انتخاب شهر --}}
                        <div class="col-sm-12 mt-3">
                            <label class="form-label" for="city_id">انتخاب شهر</label>
                            <select id="city_id" name="city_id" class="form-select select2" required>
                                <option value="" disabled selected>انتخاب کنید...</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- بازه زمانی --}}
                        <div class="col-sm-6 mt-3">
                            <label class="form-label" for="start_date">تاریخ شروع</label>
                            <input type="date" id="start_date" name="start_date" class="form-control">
                        </div>

                        <div class="col-sm-6 mt-3">
                            <label class="form-label" for="end_date">تاریخ پایان</label>
                            <input type="date" id="end_date" name="end_date" class="form-control">
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
@endsection
@section('script')
    <script src="{{ asset('admin/assets/js/validation.js') }}"></script>

    <script>
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
                    title: "نام نرخ شهریه",
                    width: "27%"
                },
                {
                    data: "city.title",
                    title: "شهر",
                    width: "11%"
                },
                {
                    data: "start_date",
                    title: "شروع",
                    width: "11%"
                },
                {
                    data: "end_date",
                    title: "پایان",
                    width: "11%"
                },
                {
                    data: "",
                    title: "جزئیات",
                    width: "17%"
                },
                {
                    data: "",
                    title: "عملیات",
                    width: "10%"
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
                    targets: -2,
                    title: "جزئیات",
                    className: "td-start",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `
                            <a href="/admin2/tuitions/${full.id}/professions" class="btn btn-sm btn-info item-details">
                                حرفه‌ها
                            </a>
                            <button class="btn btn-sm btn-warning show-certificates">
                                سند حرفه‌ها
                            </button>
                                `;
                    },
                },
                {
                    targets: -1,
                    title: "عملیات",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `
                                <a href="/admin2/tuitions/${full.id}/edit" class="btn btn-sm btn-primary"><i class="bx bxs-edit"></i></a>
                                <button class="btn btn-sm btn-danger item-delete" data-id="${full.id}"><i class="bx bxs-trash"></i></button>
                                `;
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
                let noSearchColumns = [0,6,7];
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
            const input = parent.querySelector("input, textarea");
            input.value = null;
            input.focus();
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
                city_id: {
                    label: "شهر",
                    required: true,
                    type: "select",
                    options: [], // بعداً با AJAX پر میشه
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
                // تبدیل داده‌ها از رشته به تاریخ برای بررسی
                const startDate = new Date(values.start_date);
                const endDate = new Date(values.end_date);

                // بررسی معتبر بودن تاریخ‌ها
                if (
                    isNaN(startDate.getTime()) ||
                    isNaN(endDate.getTime())
                ) {
                    alert(
                        "لطفاً تاریخ شروع و پایان را به درستی وارد کنید.",
                    );
                    return;
                }

                // بررسی اینکه تاریخ پایان بعد از شروع باشد
                if (endDate <= startDate) {
                    alert("تاریخ پایان باید بعد از تاریخ شروع باشد.");
                    return;
                }

                // اضافه کردن CSRF token
                values._token = $('meta[name="csrf-token"]').attr(
                    "content",
                );

                // ارسال Ajax
                $.post("/admin2/tuitions/store", values, function(res) {
                    if (res.success) {
                        dt_basic.ajax.reload();
                    } else {}
                }).fail(function(xhr) {
                    console.error(xhr.responseText);
                });
            },
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
