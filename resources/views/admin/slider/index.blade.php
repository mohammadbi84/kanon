@extends('admin.layout.master')

@section('head')
@endsection

@section('content')
    <div class="card">
        <div class="card-datatable table-responsive pt-0 p-3">
            <div class="head-label p-3"></div>

            {{-- فرم افزودن پاپ‌آپ جدید --}}
            <form action="{{ route('admin.slider.store') }}" method="post" class="add-new-record pt-0 row g-2 mt-3 px-3"
                id="form-add-new-record">
                @csrf
                {{-- عنوان --}}
                <div class="col-sm-12">
                    <label class="form-label" for="name">عنوان اسلایدر</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-font"></i></span>
                        <input type="text" id="name" name="name" class="form-control" placeholder="عنوان پاپ‌آپ"
                            required>
                    </div>
                </div>

                {{-- وضعیت --}}
                <div class="col-sm-3">
                    <label class="form-label" for="type">وضعیت</label>
                    <select id="type" name="type" class="form-select">
                        <option value="1">نمایش</option>
                        <option value="0">عدم نمایش</option>
                    </select>
                </div>

                <div class="col-sm-12">
                    <button class="btn btn-outline-primary" type="button" id="image" data-input="popup_image"
                        data-preview="imageHolder">عکس جدید</button>
                    <input type="text" id="popup_image" name="image" class="form-control"
                        placeholder="نام کاربری گیرنده" aria-label="Recipient's username" aria-describedby="button-addon2">
                </div>

                <div class="col-sm-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">ثبت</button>
                </div>
            </form>

            {{-- جدول پاپ‌آپ‌ها --}}
            <table class="dt-select-table sliders table mt-4">
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
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('admin/assets/js/validation.js') }}"></script>
    <script>
        // در کد JS خود این را اضافه کنید:
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#image').filemanager('file');
    </script>
    <script>
        let dt_sliders;

        $(document).ready(function() {
            // DataTable
            dt_sliders = $('.sliders').DataTable({
                ajax: "{{ route('admin.slider.index') }}",
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
                    }, // ستون مخفی برای sort
                    {
                        data: "id",
                        title: "شناسه"
                    },
                    {
                        data: "sort",
                        title: "چیدمان"
                    },
                    {
                        data: "title",
                        title: "عنوان"
                    },
                    {
                        data: "text",
                        title: "متن"
                    },
                    {
                        data: "start_date",
                        title: "تاریخ شروع"
                    },
                    {
                        data: "end_date",
                        title: "تاریخ پایان"
                    },
                    {
                        data: "status",
                        title: "وضعیت",
                        render: d => d ? "فعال" : "غیرفعال"
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
                        orderable: false,
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
                        targets: -2,
                        orderable: false,
                    },
                    {
                        targets: -1,
                        title: "عملیات",
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full) {
                            return `
                            <a href="/admin2/slider/edit/${full.id}" class="btn btn-sm btn-primary"><i class="bx bxs-edit"></i></a>
                            <button class="btn btn-sm btn-danger item-delete" data-id="${full.id}"><i class="bx bxs-trash"></i></button>
                        `;
                        }
                    }
                ],
                order: [
                    [2, "desc"]
                ],
                dom: '<"card-header flex-column flex-md-row"<"head-label text-center">><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t' +
                    "<'row d-flex align-items-center justify-content-between'<'col-md-4'<'bulk-holder'>><'col-md-8 d-flex justify-content-between'i p>>",
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
                                    data
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
                '<h5 class="card-title mb-0">پاپ آپ ها</h5>'
            );
            // delete one item----------------------------------------------------------------------------------------------------------------
            dt_sliders.on("click", ".item-delete", function() {
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
                            url: "{{ route('admin.slider.destroy', '') }}/" + id,
                            type: "DELETE",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr(
                                    "content"
                                ),
                            },
                            success: function(res) {
                                Swal.fire({
                                    icon: "success",
                                    title: "موفق!",
                                    text: "رکورد با موفقیت حذف شدند.",
                                    timer: 2000,
                                    timerProgressBar: true,
                                    showConfirmButton: false,
                                });
                                dt_sliders.ajax.reload(null, false);
                                $("#bulk-actions").addClass("d-none");
                            },
                            error: function(err) {
                                Swal.fire({
                                    icon: "error",
                                    title: "خطا!",
                                    text: "مشکلی در حذف رخ داد.",
                                });
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
                dt_sliders.on("select", function(e, dt, type, indexes) {
                    toggleBulkActions();
                });

                // وقتی رکورد از انتخاب خارج شد
                dt_sliders.on("deselect", function(e, dt, type, indexes) {
                    toggleBulkActions();
                });

                // تابع برای نمایش / مخفی کردن باکس عملیات
                function toggleBulkActions() {
                    const selected = dt_sliders.rows({
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
                    return dt_sliders
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
                                url: "/admin2/sliders/bulk-delete",
                                type: "POST",
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr(
                                        "content"
                                    ),
                                    ids: ids,
                                },
                                success: function(res) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "موفق!",
                                        text: "رکوردها با موفقیت حذف شدند.",
                                        timer: 2000,
                                        timerProgressBar: true,
                                        showConfirmButton: false,
                                    });
                                    dt_sliders.ajax.reload(null, false);
                                    $("#bulk-actions").addClass("d-none");
                                },
                                error: function(err) {
                                    Swal.fire({
                                        icon: "error",
                                        title: "خطا!",
                                        text: "مشکلی در حذف گروهی رخ داد.",
                                    });
                                    console.error(err);
                                },
                            });
                        }
                    });
                });
            }
        });

        // form validation
        document.addEventListener("DOMContentLoaded", function() {
            // add new record-------------------------------------------------------------------------------------------------------------
            // فرم افزودن پاپ آپ جدید
            initOffcanvasForm({
                formId: "form-add-new-record",
                // offcanvasId: "add-new-record",
                triggerSelector: ".create-new",
                fields: {
                    title: {
                        label: "عنوان پاپ‌آپ",
                        required: true,
                        type: "text",
                    },
                    text: {
                        label: "متن پاپ‌آپ",
                        required: true,
                        type: "text",
                    },
                    start_date: {
                        label: "تاریخ شروع",
                        required: false,
                        type: "date",
                    },
                    end_date: {
                        label: "تاریخ پایان",
                        required: false,
                        type: "date",
                    },
                    sort: {
                        label: "ترتیب چیدمان",
                        required: true,
                        type: "number",
                    },
                    status: {
                        label: "وضعیت",
                        required: true,
                        type: "select",
                        options: [{
                                value: 1,
                                text: "فعال"
                            },
                            {
                                value: 0,
                                text: "غیرفعال"
                            },
                        ],
                    },
                },
                onSubmit: function(values) {
                    console.log("Form Data:", values);

                    // اضافه کردن CSRF token
                    values._token = $('meta[name="csrf-token"]').attr(
                        "content",
                    );

                    // ارسال Ajax
                    $.post("/admin2/sliders", values, function(res) {
                        console.log("Server Response:", res);
                        // offCanvasEl.hide();
                        Swal.fire({
                            icon: "success",
                            title: "موفق!",
                            text: res.success,
                            timer: 1500,
                            showConfirmButton: false,
                        });
                        dt_sliders.ajax.reload(); // اگر میخوای جدول بروز بشه
                    });
                },
            });
        });
    </script>
@endsection
