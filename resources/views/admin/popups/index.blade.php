@extends('admin.layout.master')

@section('head')
@endsection

@section('content')
    <div class="card">
        <div class="card-datatable table-responsive pt-0 p-3">
            <div class="head-label p-3"></div>

            {{-- فرم افزودن پاپ‌آپ جدید --}}
            <form action="{{ route('admin.popups.store') }}" method="post" class="add-new-record pt-0 row g-2 mt-3 px-3"
                id="form-add-new-record">
                @csrf
                {{-- عنوان --}}
                <div class="col-sm-12">
                    <label class="form-label" for="title">عنوان پاپ‌آپ</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-font"></i></span>
                        <input type="text" id="title" name="title" class="form-control" placeholder="عنوان پاپ‌آپ"
                            required>
                    </div>
                </div>

                {{-- متن --}}
                <div class="col-sm-12">
                    <label class="form-label" for="text">متن پاپ‌آپ</label>
                    <textarea id="text" name="text" class="form-control" rows="2" placeholder="متن پاپ‌آپ"></textarea>
                </div>

                {{-- تاریخ شروع و پایان --}}
                <div class="col-sm-6">
                    <label class="form-label" for="start_date">تاریخ شروع</label>
                    <input type="date" id="start_date" name="start_date" class="form-control">
                </div>

                <div class="col-sm-6">
                    <label class="form-label" for="end_date">تاریخ پایان</label>
                    <input type="date" id="end_date" name="end_date" class="form-control">
                </div>

                {{-- وضعیت --}}
                <div class="col-sm-6">
                    <label class="form-label" for="status">وضعیت</label>
                    <select id="status" name="status" class="form-select">
                        <option value="1">فعال</option>
                        <option value="0">غیرفعال</option>
                    </select>
                </div>

                <div class="col-sm-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">ثبت</button>
                </div>
            </form>

            {{-- جدول پاپ‌آپ‌ها --}}
            <table class="dt-select-table popups table mt-4">
                <thead>
                    <tr></tr>
                </thead>
            </table>

            <div id="bulk-actions">
                <button id="bulk-delete" class="btn btn-danger" disabled>حذف انتخابی‌ها</button>
            </div>
        </div>
    </div>

    {{-- مدال مدیریت عکس‌ها --}}
    <div class="modal fade" id="popupFilesModal" tabindex="-1" aria-labelledby="popupFilesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="popupFilesModalLabel">مدیریت تصاویر پاپ‌آپ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="popup_id">
                    <div class="mb-3">
                        <div class="input-group">
                            <button class="btn btn-outline-primary" type="button" id="image" data-input="popup_image"
                                data-preview="imageHolder">عکس جدید</button>
                            <input type="text" id="popup_image" name="image" class="form-control"
                                placeholder="نام کاربری گیرنده" aria-label="Recipient's username"
                                aria-describedby="button-addon2">
                        </div>
                        <div class="text-end">
                            <button id="uploadImageBtn" class="btn btn-success mt-2">آپلود</button>
                        </div>
                    </div>
                    <div id="popupImagesList" class="row g-3"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
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
        let dt_popups;

        $(document).ready(function() {
            // DataTable
            dt_popups = $('.popups').DataTable({
                ajax: "{{ route('admin.popups.index') }}",
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
                            <button class="btn btn-sm btn-info manage-files" data-id="${full.id}">مدیریت عکس‌ها</button>
                            <a href="/admin2/popups/edit/${full.id}" class="btn btn-sm btn-primary">ویرایش</a>
                            <button class="btn btn-sm btn-danger item-delete" data-id="${full.id}">حذف</button>
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
            dt_popups.on("click", ".item-delete", function() {
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
                            url: "{{ route('admin.popups.destroy', '') }}/" + id,
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
                                dt_popups.ajax.reload(null, false);
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
                dt_popups.on("select", function(e, dt, type, indexes) {
                    toggleBulkActions();
                });

                // وقتی رکورد از انتخاب خارج شد
                dt_popups.on("deselect", function(e, dt, type, indexes) {
                    toggleBulkActions();
                });

                // تابع برای نمایش / مخفی کردن باکس عملیات
                function toggleBulkActions() {
                    const selected = dt_popups.rows({
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
                    return dt_popups
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
                                url: "/admin2/popups/bulk-delete",
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
                                    dt_popups.ajax.reload(null, false);
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

            // مدیریت عکس‌ها --------------------------------------------------------
            $(document).on("click", ".manage-files", function() {
                const id = $(this).data("id");
                $("#popup_id").val(id);
                $("#popupFilesModal").modal("show");

                loadPopupFiles(id);
            });

            // آپلود تصویر جدید
            $("#uploadImageBtn").click(function() {
                const popupId = $("#popup_id").val();
                const file = $('#popup_image').val();
                const formData = new FormData();
                formData.append("file", file);
                formData.append("popup_id", popupId);
                formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

                $.ajax({
                    url: "/admin2/popups/upload/" + popupId,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        Swal.fire("موفق!", "تصویر با موفقیت آپلود شد.", "success");
                        $("#popup_image").val("");
                        loadPopupFiles(popupId);
                    },
                    error: function() {
                        Swal.fire("خطا!", "آپلود تصویر با خطا مواجه شد.", "error");
                    }
                });
            });

            // بارگذاری تصاویر پاپ‌آپ
            function loadPopupFiles(popupId) {
                $("#popupImagesList").html('<p class="text-center text-muted">در حال بارگذاری...</p>');
                $.get(`/admin2/popups/showImages/${popupId}`, function(res) {
                    if (res.data.length === 0) {
                        $("#popupImagesList").html(
                            '<p class="text-center text-muted">هیچ تصویری وجود ندارد.</p>');
                        return;
                    }

                    let html = "";
                    res.data.forEach(file => {
                        html += `
                        <div class="col-md-4 text-center">
                            <div class="card p-2">
                                <img src="${file.url}" class="img-fluid rounded mb-2" style="height:150px;object-fit:cover;">
                                <div>
                                    <button class="btn btn-sm btn-warning toggle-status" data-id="${file.id}">
                                        ${file.status ? 'غیرفعال کن' : 'فعال کن'}
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-file" data-id="${file.id}">حذف</button>
                                </div>
                            </div>
                        </div>
                    `;
                    });
                    $("#popupImagesList").html(html);
                });
            }

            // تغییر وضعیت عکس
            $(document).on("click", ".toggle-status", function() {
                const id = $(this).data("id");
                $.post(`/admin2/popups/status/${id}`, {
                    _token: $('meta[name="csrf-token"]').attr("content")
                }, function() {
                    Swal.fire("موفق!", "وضعیت تصویر تغییر کرد.", "success");
                    loadPopupFiles($("#popup_id").val());
                });
            });

            // حذف عکس
            $(document).on("click", ".delete-file", function() {
                const id = $(this).data("id");
                Swal.fire({
                    title: "حذف تصویر؟",
                    text: "آیا مطمئن هستید؟",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "بله، حذف کن",
                    cancelButtonText: "انصراف"
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.popups.image.delete', '') }}/" + id,
                            type: "DELETE",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr("content")
                            },
                            success: function() {
                                Swal.fire("موفق!", "تصویر حذف شد.", "success");
                                loadPopupFiles($("#popup_id").val());
                            },
                            error: function() {
                                Swal.fire("خطا!", "مشکلی در حذف تصویر رخ داد.",
                                    "error");
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
