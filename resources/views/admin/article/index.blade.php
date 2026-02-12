@extends('admin.layout.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/quill/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/quill/katex.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/quill/editor-fa.css') }}">
@endsection
@section('content')
    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0 p-3">
            <form action="{{ route('admin.articles.store') }}" method="post" class="add-new-record pt-0 row g-2 mt-3 px-3"
                id="form-add-new-record">
                <div class="col-sm-12">
                    <label class="form-label" for="title">عنوان صفحه</label>
                    <div class="input-group input-group-merge">
                        <span id="title2" class="input-group-text"><i class="bx bx-check-square"></i></span>
                        <input type="text" id="title" class="form-control dt-full-name" name="title"
                            placeholder="عنوان صفحه" aria-label="John Doe" aria-describedby="title2">
                    </div>
                </div>
                <div class="col-sm-12">
                    <input type="hidden" name="body" id="body">
                    <label class="form-label">محتوای صفحه</label>
                    <div id="full-editor">
                        <h6>محتوای صفحه</h6>
                    </div>
                </div>
                <div class="col-sm-12 mt-3">
                    <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ثبت</button>
                </div>
            </form>
            <table class="dt-select-table articles table">
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
    <script src="{{ asset('admin/assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/quill/quill.js') }}"></script>
    <script>
        // در کد JS خود این را اضافه کنید:
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
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
    <script>
        dt_basic = $('.articles').DataTable({
            ajax: "/admin2/articles",
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
                    title: "شناسه"
                },
                {
                    data: "title",
                    title: "عنوان صفحه"
                },
                {
                    data: "body",
                    title: "محتوای صفحه"
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
                            // edit
                            '<a href="/admin2/articles/' +
                            full.id +
                            '"' +
                            'class="btn btn-sm btn-icon btn-primary item-edit" ' +
                            'data-id="' +
                            full.id +
                            '">' +
                            '<i class="bx bxs-edit"></i>' +
                            "</a> " +
                            // delete
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
            '<h5 class="card-title mb-0">صفحه های جانبی</h5>'
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
                        url: "/admin2/articles/delete/" + id,
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
                            dt_basic.ajax.reload(null, false);
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
                            url: "/admin2/articles/bulk-delete",
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
                                dt_basic.ajax.reload(null, false);
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
    </script>
@endsection
