@extends('admin.layout.master')
@section('head')
@endsection
@section('content')
    <h5 class="breadcrumb-wrapper mb-4">
        <a href="{{ route('admin.index') }}" class="text-muted">داشبورد</a> <span class="text-muted">/</span>
        <span class="text-muted">مدیریت استاندارد ها / </span>
        <span class="">نوع کاردانش</span>
    </h5>
    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="d-flex justify-content-end align-items-center">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
                نوع کاردانش جدید
                <i class="bx bx-plus ms-2"></i>
            </button>
            <!-- Modal -->
            <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title secondary-font" id="modalCenterTitle">نوع کاردانش جدید</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.jobtype.store') }}" method="post"
                                class="add-new-record pt-0 row g-2 mt-3 px-3" id="form-add-new-record">
                                <div class="col-sm-12">
                                    <div class="custom-input-group">
                                        <input type="text" id="name" class="form-control" name="name">
                                        <label class="form-label" for="name">نوع کاردانش</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-3">
                                    <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ثبت</button>
                                    <button type="submit" class="btn btn-outline-primary data-submit me-sm-3 me-1"
                                        data-bs-toggle="modal">ثبت و خروج</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-datatable table-responsive pt-0 p-3">
            <table class="dt-select-table kardanesh table">
                <thead>
                    <tr>
                        {{-- filled with ajax --}}
                    </tr>
                </thead>
            </table>
            <div id="bulk-actions" class="">
                <button id="bulk-delete" class="btn btn-danger" disabled>حذف انتخابی‌ها</button>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('admin/assets/js/validation.js') }}"></script>

    <script>
        kardanesh = $(".kardanesh");
        dt_basic = kardanesh.DataTable({
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
                    title: "نوع کاردانش"
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
                    // For Checkboxes
                    targets: 1,
                    orderable: false,
                    render: function() {
                        return '<input type="checkbox" class="dt-checkboxes form-check-input mt-0 align-middle">';
                    },
                    checkboxes: {
                        selectRow: true,
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
                        return (
                            '<a href="/admin2/kardanesh/' +
                            full.id +
                            '"' +
                            'class="btn btn-sm btn-icon btn-primary item-edit" ' +
                            'data-id="' +
                            full.id +
                            '">' +
                            '<i class="bx bxs-edit"></i>' +
                            "</a> " +
                            '<button class="btn btn-sm btn-icon btn-danger item-delete" ' +
                            'data-id="' +
                            full.id +
                            '">' +
                            '<i class="bx bxs-trash"></i>' +
                            "</button>"
                        );
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
        $("#bulk-actions").appendTo(".bulk-holder");
        $("div.head-label").html(
            '<h5 class="card-title mb-0">نوع کاردانش ها</h5>' +
            '<small class="text-muted ms-2">( {{ $kardaneshs_count }} رکورد )</small>'
        );
        // add new record-------------------------------------------------------------------------------------------------------------
        initOffcanvasForm({
            formId: "form-add-new-record",
            // offcanvasId: "add-new-record",
            triggerSelector: ".create-new",
            fields: {
                name: {
                    label: "نام نوع کاردانش",
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

                    dt_basic.ajax.reload(); // اگر میخوای جدول بروز بشه
                });
            },
        });
        // delete one item----------------------------------------------------------------------------------------------------------------
        dt_basic.on("click", ".item-delete", function() {
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

                            dt_basic.ajax.reload(null, false);
                            $("#bulk-actions").addClass("d-none");
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
                    $("#bulk-actions #bulk-delete").prop("disabled", false);
                } else {
                    $("#bulk-actions #bulk-delete").prop("disabled", true);
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
        }
    </script>
@endsection
