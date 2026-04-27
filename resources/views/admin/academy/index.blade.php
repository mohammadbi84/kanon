@extends('admin.layout.master')
@section('head')
    <style>
        td {
            padding: 10px 5px !important;
        }

        th {
            line-height: 16px;
            padding: 0 !important;
            padding-right: 10px !important;
            padding-bottom: 8px !important;
        }
    </style>
@endsection
@section('content')
    <h5 class="breadcrumb-wrapper mb-4 pt-4" style="padding: 15px 10px !important;" id="breadcrumb-wrapper">
        <a href="{{ route('admin.index') }}" class="text-muted">داشبورد</a> <span class="text-muted">/</span>
        <span class="text-muted">مدیریت اعضا / </span>
        <span>آموزشگاه های آزاد عضو</span>
    </h5>

    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable p-3">
            <div class="fixed-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="head-label d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">لیست آموزشگاه ها</h5>
                        <small class="text-muted ms-2">(
                            تعداد : <span id="totalRecord">0</span> ردیف /
                            فلیتر شده : <span id="filteredrecord">0</span> ردیف /
                            انتخاب شده : <span id="selectedRecord">0</span> ردیف )</small>
                    </div>
                    <a href="{{ route('admin.academy.create') }}" class="btn btn-primary">
                        آموزشگاه جدید
                        <i class="bx bx-plus ms-2"></i>
                    </a>
                </div>
                <div class="d-flex justify-content-start align-items-center gap-2 text-muted">
                    <small class="text-white">1</small>
                </div>
            </div>
            <table class="dt-select-table academies table table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>ردیف</th>
                        <th>نام</th>
                        <th>شماره شناسایی</th>
                        <th>تاریخ انقضا <br><small>( پروانه تاسیس )</small></th>
                        <th>جنسیت</th>
                        <th>نوع</th>
                        <th>مؤسس</th>
                        <th>شماره موبایل <br><small>( نام کاربری )</small></th>
                        <th>تاریخ عضویت</th>
                        <th>پایان اعتبار <br><small>( عضویت )</small></th>
                        <th>ثبت نام کننده</th>
                        <th>وضعیت</th>
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
                            <button class="dropdown-item bulk-toggle" data-status="1" disabled>
                                <i class=" bx bx-check"></i>
                                فعال سازی
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item bulk-toggle" data-status="0" disabled>
                                <i class=" bx bx-x"></i>
                                غیرفعال سازی
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
                            <button class="dropdown-item bulk-toggle" data-status="1" disabled>
                                <i class=" bx bx-check"></i>
                                فعال سازی
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item bulk-toggle" data-status="0" disabled>
                                <i class=" bx bx-x"></i>
                                غیرفعال سازی
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('admin/assets/js/validation.js') }}"></script>

    <script>
        academies = $(".academies");
        dt_basic = academies.DataTable({
            ajax: {
                url: "{{ route('admin.academy.index') }}",
                // این تابع قبل از شروع لود اجرا میشه
                beforeSend: function() {
                    $("#DataTables_Table_0_wrapper .dataTables_empty").hide();
                    $(".academies").closest(".card").append(`
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
                    width: "2%"
                },
                {
                    data: "id",
                    visible: false
                },
                {
                    data: "",
                    title: "ردیف",
                    width: "4%"
                },
                {
                    data: "name",
                    title: "نام آموزشگاه",
                    width: "11%",
                },
                {
                    data: "id_number",
                    title: "شماره شناسایی",
                    width: "6%",
                },
                {
                    data: "export_end",
                    // title: "پایان اعتبار",
                    width: "8%",
                },
                {
                    data: "gender",
                    title: "جنسیت",
                    width: "6%",
                    render: function(data, type, row) {
                        switch (data) {
                            case "both":
                                return 'برادران، خواهران';
                                break;
                            case "male":
                                return 'برادران';
                                break;
                            case "female":
                                return 'خواهران';
                                break;

                            default:
                                '--'
                                break;
                        }
                        // return data;
                    },
                },
                {
                    data: "legal_company_name",
                    title: "نوع",
                    width: "5%",
                    render: function(data, type, row) {
                        if (data) {
                            return 'حقوقی';
                        } else {
                            return 'حقیقی';
                        }
                    },
                },
                {
                    data: "",
                    title: "مؤسس",
                    width: "11%",
                },
                {
                    data: "founder_mobile",
                    width: "9%",
                    // title: "شماره موبایل",
                },
                {
                    data: "created_at",
                    title: "تاریخ عضویت",
                    width: "8%",
                    render: function(data, type, row) {
                        return new Date(data).toLocaleDateString("fa-IR");
                    },
                },
                {
                    data: "created_at",
                    width: "8%",
                    // title: "تاریخ پایان اعتبار",
                    render: function(data, type, row) {
                        // return new Date(data).toLocaleDateString("fa-IR");
                        return '--';
                    },
                },
                {
                    data: "creator",
                    title: "ثبت نام کننده",
                    width: "9%",
                    render: function(data, type, row) {
                        if (data) {
                            return 'ادمین';
                        } else {
                            return "آموزشگاه";
                        }
                    },
                },
                {
                    data: "status",
                    title: "وضعیت",
                    width: "7%",
                },
                {
                    data: "",
                    title: "عملیات",
                    width: "4%"
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
                    targets: 5,
                    orderable: true,
                    render: function(data, type, full) {
                        if (type === 'display') {
                            return `<span data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="${full.sodor_end_remain} روز باقی مانده">${full.sodor_end_status}</span>`;
                        }
                        return `${full.export_end}`;
                    }
                },
                {
                    targets: -7,
                    orderable: true,
                    render: function(data, type, full) {
                        if (full.natural_name) {
                            return `${full.natural_family}`;
                        } else {
                            return `${full.legal_manager}`;
                        }
                    }
                },
                {
                    targets: -2,
                    orderable: false,
                    render: function(data, type, full) {
                        if (full.status == 'approved') {
                            return `<button class="btn btn-sm btn-info item-toggle" data-id="${full.id}">تایید شده</button>`;
                        } else if (full.status == 'rejected') {
                            return `<button class="btn btn-sm btn-danger item-toggle" data-id="${full.id}">رد شده</button>`;
                        } else if (full.status == 'suspended') {
                            return `<button class="btn btn-sm btn-warning item-toggle" data-id="${full.id}">معلق</button>`;
                        } else {
                            return full.status;
                        }
                    }
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
                                    data-bs-toggle="dropdown" data-trigger="hover">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a href="/admin2/academy/${full.id}/show" class="dropdown-item">
                                            مشاهده پروفایل
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="dropdown-item">
                                            بازیابی کلمه عبور
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/admin2/academy/${full.id}/edit" class="dropdown-item">
                                            ویرایش
                                        </a>
                                    </li>
                                    <li>
                                        <button class="dropdown-item item-delete" data-id="${full.id}">
                                            حذف
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        `;

                    }
                }
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
                let noSearchColumns = [0, 13];
                // **تنظیم رویداد برای اینپوت های معمولی**
                $('.academies thead tr:eq(1) th').each(function(i) {
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
                $('.academies thead tr:eq(0) th:eq(0)').html($headerCheckbox);

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
        let thead = $('.academies thead');
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

        // toggle selected items----------------------------------------------------------------------------------------------------------
        const btnBulk = $(".bulk-actions");
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
                    $(".bulk-actions .action_group").show();
                    $(".bulk-actions .bulk-toggle").prop("disabled", false);
                } else {
                    $(".bulk-actions .action_group").hide();
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
                            url: "/admin2/academy/bulk-toggle",
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

        // delete one item----------------------------------------------------------------------------------------------------------------
        dt_basic.on("click", ".item-delete", function() {
            const id = $(this).data("id");

            if (!id) return;

            // برداشتن فوکوس از روی دکمه (مهم!)
            if (document.activeElement && document.activeElement instanceof HTMLElement) {
                document.activeElement.blur();
            }

            Swal.fire({
                title: `آیا از حذف این آموزشگاه مطمئن هستید؟`,
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
                        url: "/admin2/academy/delete/" + id,
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

        // toggle one item----------------------------------------------------------------------------------------------------------------
        dt_basic.on("click", ".item-toggle", function() {
            const id = $(this).data("id");

            if (!id) return;
            $.ajax({
                url: "/admin2/academy/" + id + "/toggle",
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
