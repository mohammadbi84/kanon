@extends('admin.layout.master')

@section('head')
@endsection

@section('content')
    <div class="card">
        <div class="card-datatable table-responsive pt-0 p-3">
            {{-- جدول پاپ‌آپ‌ها --}}
            <table class="dt-select-table academy table mt-4">
                <thead>
                    <tr></tr>
                </thead>
            </table>

            <div id="bulk-actions">
                <button class="btn btn-info bulk-toggle" data-status="1" disabled>فعال کردن</button>
                <button class="btn btn-danger bulk-toggle" data-status="0" disabled>غیرفعال کردن</button>
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
        let dt_academy;

        $(document).ready(function() {
            // DataTable
            dt_academy = $('.academy').DataTable({
                ajax: "{{ route('admin.academy.index') }}",
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
                        data: "name",
                        title: "نام آموزشگاه"
                    },
                    {
                        data: "phone",
                        title: "شماره تلفن",
                    },
                    {
                        data: "status",
                        title: "وضعیت",
                    },
                    {
                        data: "",
                        title: "عملیات"
                    },
                ],
                columnDefs: [
                    {
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
                            <a href="/admin2/academy/${full.id}/edit" class="btn btn-sm btn-primary"><i class="bx bxs-edit"></i></a>
                            <a href="#" class="btn btn-sm btn-success">مشاهده پروفایل</a>
                        `;

                        }
                    }
                ],
                order: [
                    [2, "desc"]
                ],
                dom: '<"card-header flex-column flex-md-row"<"head-label text-center d-flex justify-content-between align-items-center w-100">><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t' +
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
                '<h5 class="card-title mb-0">آموزشگاه های تایید شده</h5>'
                +
                '<a href="/admin2/academy/create" class="btn btn-info">آموزشگاه جدید</a>'
            );

            // toggle selected items----------------------------------------------------------------------------------------------------------
            const btnBulk = $(".bulk-toggle");
            if (btnBulk) {
                // وقتی رکورد انتخاب شد
                dt_academy.on("select", function(e, dt, type, indexes) {
                    toggleBulkActions();
                });

                // وقتی رکورد از انتخاب خارج شد
                dt_academy.on("deselect", function(e, dt, type, indexes) {
                    toggleBulkActions();
                });

                // تابع برای نمایش / مخفی کردن باکس عملیات
                function toggleBulkActions() {
                    const selected = dt_academy.rows({
                        selected: true
                    }).count();
                    if (selected > 0) {
                        // $("#bulk-actions").removeClass("d-none");
                        $("#bulk-actions .bulk-toggle").prop("disabled", false);
                    } else {
                        $("#bulk-actions .bulk-toggle").prop("disabled", true);
                    }
                }

                // گرفتن ID ها
                function getSelectedIds() {
                    return dt_academy
                        .rows({
                            selected: true
                        })
                        .data()
                        .pluck("id")
                        .toArray();
                }

                btnBulk.on("click", function() {
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
                            dt_academy.ajax.reload(null, false);
                            $("#bulk-actions .bulk-toggle").prop("disabled", true);
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
                });
            }
        });
    </script>
@endsection
