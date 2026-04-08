@extends('admin.layout.master')

@section('head')
@endsection

@section('content')
    <h5 class="breadcrumb-wrapper mb-4">
        <a href="{{ route('admin.index') }}" class="text-muted">داشبورد</a> <span class="text-muted">/</span>
        <span class="text-muted">مدیریت استاندارد ها / </span>
        <span class="">نرخ شهریه</span>
    </h5>
    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="d-flex justify-content-end align-items-center">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
                نرخ شهریه جدید
                <i class="bx bx-plus ms-2"></i>
            </button>
            <!-- Modal -->
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
        </div>
        <div class="card-datatable table-responsive pt-0 p-3">
            {{-- جدول شهریه‌ها --}}
            <table class="dt-select-table tuitions table mt-4">
                <thead>
                    <tr></tr>
                </thead>
            </table>

            <div id="bulk-actions">
                <button id="bulk-delete" class="btn btn-danger" disabled>حذف انتخابی‌ها</button>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('admin/assets/js/validation.js') }}"></script>

    <script>
        tuitions = $(".tuitions");
        dt_basic = tuitions.DataTable({
            ajax: "/admin2/tuitions",
            columns: [{
                    data: "",
                    title: ""
                },
                {
                    data: "id",
                    title: "شناسه"
                },
                {
                    data: "id",
                    visible: false
                },
                {
                    data: "id",
                    title: "ردیف"
                },
                {
                    data: "title",
                    title: "عنوان شهریه"
                },
                {
                    data: "city.title",
                    title: "شهر"
                },
                {
                    data: "start_date",
                    title: "شروع"
                },
                {
                    data: "end_date",
                    title: "پایان"
                },
                {
                    data: "",
                    title: "عملیات"
                },
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
                        return `
                            <a href="/admin2/tuitions/${full.id}/professions" class="btn btn-sm btn-info item-details">
                                حرفه‌ها
                            </a>
                        <button class="btn btn-sm btn-warning show-certificates">
                            سند حرفه‌ها
                        </button>
                        <a href="/admin2/tuitions/${full.id}/edit" class="btn btn-sm btn-primary"><i class="bx bxs-edit"></i></a>
                        <button class="btn btn-sm btn-danger item-delete" data-id="${full.id}"><i class="bx bxs-trash"></i></button>
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
        $("#bulk-actions").appendTo(".bulk-holder");
        $("div.head-label").html(
            '<h5 class="card-title mb-0">شهریه ها</h5>' +
            '<small class="text-muted ms-2">( {{ $tuitions_count }} رکورد )</small>'
        );
        // add new record-------------------------------------------------------------------------------------------------------------
        // فرم افزودن شهریه جدید
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
        }
    </script>
@endsection
