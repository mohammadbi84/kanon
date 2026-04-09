@extends('admin.layout.master')
@section('head')
@endsection
@section('content')
    {{-- بررسی اینکه آیا field_id از URL آمده یا نه --}}
    @php
        $fieldId = request()->get('field_id');
    @endphp

    <h5 class="breadcrumb-wrapper mb-4">
        <a href="{{ route('admin.index') }}" class="text-muted">داشبورد</a> <span class="text-muted">/</span>
        @if ($fieldId)
            <a href="{{ route('admin.categories.index') }}" class="text-muted">رسته {{ $field?->cluster->category->name }}</a>
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
        <div class="card-datatable table-responsive">
            <div class="d-flex justify-content-end align-items-center gap-3">
                <div class="btn-group">
                    <button type="button" class="btn border btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bx bx-menu"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="javascript:void(0);">خروجی اکسل</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);">ورودی اکسل</a></li>
                    </ul>
                </div>
                <a href="{{ route('admin.professions.create', ['fieldId' => $fieldId]) }}" class="btn btn-primary">
                    حرفه جدید
                    <i class="bx bx-plus ms-2"></i>
                </a>
            </div>
            <table class="dt-select-table professions table">
                <thead>
                    <tr>
                        {{-- filled with ajax --}}
                    </tr>
                </thead>
            </table>
            <div id="bulk-actions" class="">
                <div class="btn-group" id="action_group" style="display: none">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        انتخاب عملیـات
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <button class="dropdown-item text-danger" id="bulk-delete" href="#">
                                <i class=" bx bx-trash"></i>
                                حذف انتخابی ها
                            </button>
                        </li>
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
                                {{-- <i class=" bx bx-check"></i> --}}
                                آرشیو
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item bulk-archive" data-status="0" disabled>
                                {{-- <i class=" bx bx-x"></i> --}}
                                عدم آرشیو
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="professionDetailsModal" tabindex="-1" aria-labelledby="detailsLabel" aria-hidden="true">
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
@endsection
@section('script')
    <script src="{{ asset('admin/assets/js/validation.js') }}"></script>
    <script>
        professions = $(".professions");
        const urlParams = new URLSearchParams(window.location.search);
        const fieldId = urlParams.get("field_id");
        const fieldName = urlParams.get("field_name");

        dt_basic = professions.DataTable({
            ajax: {
                url: "/admin2/professions",
                data: function(d) {
                    if (fieldId) {
                        d.field_id = fieldId; // ارسال فیلد رشته به سرور
                    }
                },
            },
            columns: [{
                    data: "id"
                }, // Responsive
                {
                    data: "id",
                    visible: false
                },
                {
                    data: "id",
                    title: "ردیف"
                },
                {
                    data: "field.name",
                    title: "نام رشته"
                },
                {
                    data: "name",
                    title: "نام حرفه"
                },
                {
                    data: "new_standard_code",
                    title: "کد استاندارد",
                },
                {
                    data: "",
                    title: "جمع ساعات",
                    render: function(data, type, row) {
                        return row.total_hour + " : " + row.total_minute;
                    },
                },
                {
                    data: "",
                    title: "فایل استاندارد",
                    render: function(data, type, row) {
                        return `
                        <a href="/${row.standard_file}" target="_blank" class="btn btn-sm btn-outline-danger">
                            دانلود
                            </a>
                        `;
                    },
                },
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
                    // For Checkboxes
                    targets: 0,
                    searchable: false,
                    orderable: false,
                    render: function() {
                        return '<input type="checkbox" class="dt-checkboxes form-check-input mt-0 align-middle">';
                    },
                    checkboxes: {
                        selectRow: true,
                        selectAllRender: '<input type="checkbox" class="form-check-input mt-0 align-middle">'
                    }
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
                    targets: 3,
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
                    orderable: false,
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
                           <button class="btn btn-sm btn-info item-details" data-item='${JSON.stringify(full)}' >
                            جزئیات
                            </button>

                            <a href="/admin2/certificates?field_id=${full.id}" class="btn btn-sm btn-success item-show" data-id="${full.id}">
                            سند حرفه (0)
                            </a>

                            <a href="/admin2/professions/${full.id}" class="btn btn-sm btn-icon btn-primary item-edit" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="<small>ویرایش</small>">
                            <i class="bx bxs-edit"></i>
                            </a>

                            <button class="btn btn-sm btn-icon btn-danger item-delete" data-id="${full.id}" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="<small>حذف</small>">
                            <i class="bx bxs-trash"></i>
                            </button>
                            `;
                    },
                },
            ],
            order: [
                [2, "desc"]
            ],
            dom: '<"card-header flex-column flex-md-row"<"head-label d-flex justify-content-between align-items-center text-center"><"dt-action-buttons text-end primary-font pt-3 pt-md-0"B>>' +
                '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t' +
                "<'row d-flex align-items-center justify-content-between'<'col-md-4'<'bulk-holder'>><'col-md-8 d-flex justify-content-between'i p>>",
            displayLength: 10,
            lengthMenu: [10, 25, 50, 75, 100],
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
                style: "multi"
            },
        });
        if (window.Helpers.isNavbarFixed()) {
            var navHeight = $('#layout-navbar').outerHeight();
            new $.fn.dataTable.FixedHeader(dt_basic).headerOffset(navHeight);
        } else {
            new $.fn.dataTable.FixedHeader(dt_basic);
        }

        // انتقال اکشن‌ها
        $("#bulk-actions").appendTo(".bulk-holder");

        // عنوان جدول
        $("div.head-label").html(
            '<h5 class="card-title mb-0">لیست حرفه ها</h5>' +
            '<small class="text-muted ms-2">( {{ $professions_count }} رکورد )</small>'
        );

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
        const btnBulk = $("#bulk-delete");
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
                    $("#bulk-actions #action_group").show();
                    $("#bulk-actions #bulk-delete").prop("disabled", false);
                    $("#bulk-actions .bulk-toggle").prop("disabled", false);
                    $("#bulk-actions .bulk-archive").prop("disabled", false);
                } else {
                    $("#bulk-actions #action_group").hide();
                    $("#bulk-actions #bulk-delete").prop("disabled", true);
                    $("#bulk-actions .bulk-toggle").prop("disabled", true);
                    $("#bulk-actions .bulk-archive").prop("disabled", true);
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
                    confirmButtonText: "بله، حذف کن!",
                    cancelButtonText: "انصراف",
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

                $.ajax({
                    url: "/admin2/professions/bulk-toggle",
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
                        dt_basic.ajax.reload(null, false);
                        $("#bulk-actions .bulk-archive").prop("disabled", true);
                    },
                    error: function(err) {
                        toastr.error("خطا در ارتباط با سرور.");

                        console.error(err);
                    },
                });
            });
        }
        // toggle one item----------------------------------------------------------------------------------------------------------------
        dt_basic.on("click", ".item-toggle", function() {
            const id = $(this).data("id");

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
                    dt_basic.ajax.reload(null, false);
                    toastr.success(res.message);
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
                    dt_basic.ajax.reload(null, false);
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
                        <span>تاریخ و ساعت ایجاد رکورد : ${data.created_at}</span><br>
                        <span>تعداد دفعات ویرایش رکورد : 0</span><br>
                        <span>تاریخ و ساعت آخرین ویرایش رکورد : ${data.updated_at}</span><br>
                    </div>
                `;

            $("#profession-details-content").html(html);
            $("#professionDetailsModal").modal("show");
        });
    </script>
@endsection
