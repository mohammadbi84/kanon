@extends('admin.layout.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/quill/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/quill/katex.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/quill/editor-fa.css') }}">
@endsection
@section('content')
    <h5 class="breadcrumb-wrapper mb-4">
        <a href="{{ route('admin.index') }}" class="text-muted">داشبورد</a> <span class="text-muted">/</span>
        <span class="">اخبار</span>
    </h5>
    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0 p-3">
            <form action="{{ route('admin.khabar.store') }}" method="post" class="add-new-record pt-0 row g-2 mt-3 px-3"
                id="form-add-new-record">
                <div class="col-sm-12">
                    <label class="form-label" for="title">عنوان خبر</label>
                    <div class="input-group input-group-merge">
                        <input type="text" id="title" class="form-control dt-full-name" name="title"
                            placeholder="عنوان خبر" aria-label="John Doe" aria-describedby="title2">
                    </div>
                </div>
                <div class="col-sm-12">
                    <input type="hidden" name="body" id="body">
                    <label class="form-label">متن اصلی خبر</label>
                    <div id="full-editor">
                    </div>
                </div>
                {{-- تاریخ شروع و پایان --}}
                <div class="col-sm-3">
                    <label class="form-label" for="start_at">تاریخ شروع</label>
                    <input type="date" id="start_at" name="start_at" class="form-control">
                </div>

                <div class="col-sm-3">
                    <label class="form-label" for="end_at">تاریخ پایان</label>
                    <input type="date" id="end_at" name="end_at" class="form-control">
                </div>

                {{-- وضعیت --}}
                <div class="col-sm-3">
                    <label class="form-label" for="status">وضعیت</label>
                    <select id="status" name="status" class="form-select">
                        <option value="1">فعال</option>
                        <option value="0">غیرفعال</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label class="form-label" for="cover">عکس کاور</label>
                    <div class="input-group">
                        <button class="btn btn-outline-primary" type="button" id="cover" data-input="cover_input"
                            data-preview="coverHolder">انتخاب عکس</button>
                        <input type="text" id="cover_input" name="cover" class="form-control" placeholder="انتخاب عکس"
                            aria-label="انتخاب عکس">
                    </div>
                </div>
                <div class="col-sm-12 mt-3">
                    <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ثبت</button>
                </div>
            </form>
            <table class="dt-select-table khabar table">
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
    {{-- مدال مدیریت عکس‌ها --}}
    <div class="modal fade" id="khabarFilesModal" tabindex="-1" aria-labelledby="khabarFilesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="khabarFilesModalLabel">مدیریت تصاویر پاپ‌آپ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="khabar_id">
                    <div class="mb-3">
                        <div class="input-group">
                            <button class="btn btn-outline-primary" type="button" id="image"
                                data-input="khabar_image" data-preview="imageHolder">عکس جدید</button>
                            <input type="text" id="khabar_image" name="image" class="form-control"
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
    <script src="{{ asset('admin/assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/quill/quill.js') }}"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('admin/assets/js/validation.js') }}"></script>
    <script>
        // در کد JS خود این را اضافه کنید:
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#cover').filemanager('file');
        $('#image').filemanager('file');
        $('#start_at').flatpickr({
            enableTime: true,
            locale: 'fa',
            altInput: true,
            altFormat: 'Y/m/d - H:i',
            disableMobile: true
        });
        $('#end_at').flatpickr({
            enableTime: true,
            locale: 'fa',
            altInput: true,
            altFormat: 'Y/m/d - H:i',
            disableMobile: true
        });
    </script>
    {{-- text editor --}}
    <script>
        const fullToolbar = [
            [{
                    font: []
                },
                {
                    size: []
                }
            ],
            ['bold', 'italic', 'underline', 'strike'],
            [{
                    color: []
                },
                {
                    background: []
                }
            ],
            [{
                    script: 'super'
                },
                {
                    script: 'sub'
                }
            ],
            [{
                    header: '1'
                },
                {
                    header: '2'
                },
                'blockquote',
                'code-block'
            ],
            [{
                    list: 'ordered'
                },
                {
                    list: 'bullet'
                },
                {
                    indent: '-1'
                },
                {
                    indent: '+1'
                }
            ],
            [{
                    direction: 'rtl'
                },
                {
                    align: []
                }
            ],
            ['link', 'image', 'video', 'formula'],
            ['clean']
        ];
        const fullEditor = new Quill('#full-editor', {
            bounds: '#full-editor',
            placeholder: 'چیزی بنویسید ...',
            modules: {
                formula: true,
                toolbar: fullToolbar
            },
            theme: 'snow'
        });
        const hiddenInput = document.querySelector('#body');

        fullEditor.on('text-change', function() {
            hiddenInput.value = fullEditor.root.innerHTML;
        });
    </script>
    {{-- table --}}
    <script>
        dt_basic = $('.khabar').DataTable({
            ajax: "/admin2/khabar",
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
                    data: "title",
                    title: "عنوان خبر"
                },
                {
                    data: "start_at",
                    title: "تاریخ شروع"
                },
                {
                    data: "end_at",
                    title: "تاریخ پایان"
                },
                {
                    data: "status",
                    title: "وضعیت",
                    render: d => d ? "فعال" : "غیرفعال",
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
                            <button class="btn btn-sm btn-info manage-files" data-id="${full.id}"><i class="bx bxs-image"></i></button>
                            <a href="/admin2/khabar/${full.id}" class="btn btn-sm btn-primary"><i class="bx bxs-edit"></i></a>
                            <button class="btn btn-sm btn-danger item-delete" data-id="${full.id}"><i class="bx bxs-trash"></i></button>
                        `;
                    },
                },
            ],
            order: [
                [2, "desc"]
            ],
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end primary-font pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t' +
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
            '<h5 class="card-title mb-0">اخبار</h5>'
        );

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
                        url: "/admin2/khabar/delete/" + id,
                        type: "DELETE",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        success: function(res) {
                            toastr.success("رکورد با موفقیت حذف شد.");

                            dt_basic.ajax.reload(null, false);
                            $("#bulk-actions").addClass("d-none");
                        },
                        error: function(err) {
                            toastr.error("خطایی در حذف رخ داد.");

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
                            url: "/admin2/khabar/bulk-delete",
                            type: "POST",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr(
                                    "content"
                                ),
                                ids: ids,
                            },
                            success: function(res) {
                                toastr.success("رکورد ها با موفقیت حذف شدند.");

                                dt_basic.ajax.reload(null, false);
                                $("#bulk-actions").addClass("d-none");
                            },
                            error: function(err) {
                                toastr.error("خطایی در حذف گروهی رخ داد.");

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
            $("#khabar_id").val(id);
            $("#khabarFilesModal").modal("show");

            loadPopupFiles(id);
        });

        // آپلود تصویر جدید
        $("#uploadImageBtn").click(function() {
            const khabarId = $("#khabar_id").val();
            const file = $('#khabar_image').val();
            const formData = new FormData();
            formData.append("file", file);
            formData.append("khabar_id", khabarId);
            formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

            $.ajax({
                url: "/admin2/khabar/upload/" + khabarId,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    toastr.success("تصویر با موفقیت آپلود شد.");
                    $("#khabar_image").val("");
                    loadPopupFiles(khabarId);
                },
                error: function() {
                    toastr.success("خطایی در آپلود تصویر رخ داد.");
                }
            });
        });

        // بارگذاری تصاویر پاپ‌آپ
        function loadPopupFiles(khabarId) {
            $("#popupImagesList").html('<p class="text-center text-muted">در حال بارگذاری...</p>');
            $.get(`/admin2/khabar/showImages/${khabarId}`, function(res) {
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
                                    ${file.status ? '<button class="btn btn-sm btn-success toggle-status" data-id="'+file.id+'">فعال</button>' : '<button class="btn btn-sm btn-warning toggle-status" data-id="'+file.id+'">غیرفعال</button>'}
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
            $.post(`/admin2/khabar/status/${id}`, {
                _token: $('meta[name="csrf-token"]').attr("content")
            }, function() {
                toastr.success("وضعیت عکس با موفقیت تغییر کرد.");
                loadPopupFiles($("#khabar_id").val());
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
                        url: "{{ route('admin.khabar.image.delete', '') }}/" + id,
                        type: "DELETE",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr("content")
                        },
                        success: function() {
                            toastr.success("تصویر با موفقیت حذف شد.");

                            loadPopupFiles($("#khabar_id").val());
                        },
                        error: function() {
                            toastr.success("مشکلی در حذف تصویر رخ داد.");
                        }
                    });
                }
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // add new record-------------------------------------------------------------------------------------------------------------
            // فرم افزودن پاپ آپ جدید
            initOffcanvasForm({
                formId: "form-add-new-record",
                // offcanvasId: "add-new-record",
                triggerSelector: ".create-new",
                fields: {
                    title: {
                        label: "عنوان خبر",
                        required: true,
                        type: "text",
                    },
                    text: {
                        label: "متن خبر",
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
                    cover: {
                        label: "عکس خبر",
                        required: false,
                        type: "text",
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
                    $.post("/admin2/khabar/store", values, function(res) {
                        console.log("Server Response:", res);
                        // offCanvasEl.hide();
                        toastr.success("آگهی با موفقیت ذخیره شد.");

                        dt_basic.ajax.reload(); // اگر میخوای جدول بروز بشه
                    });
                },
            });
        });
    </script>
@endsection
