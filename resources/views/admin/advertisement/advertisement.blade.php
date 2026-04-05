@extends('admin.layout.master')

@section('head')
@endsection

@section('content')
    <div class="card">
        <div class="card-datatable table-responsive pt-0 p-3">
            {{-- جدول موقعیت ها --}}
            <table class="dt-select-table advertisement table mt-4">
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
    <div class="modal fade" id="formModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered1 modal-simple modal-add-new-cc">
            <div class="modal-content p-5">
                <div class="modal-body p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <form action="{{ route('admin.advertisement.store') }}" method="post"
                        class="add-new-record p-0 row g-2 mt-3" id="form-add-new-record">
                        @csrf
                        <input type="hidden" name="position_id" value="{{ $position->id }}">
                        {{-- عنوان --}}
                        <div class="col-sm-12">
                            <label class="form-label" for="title">عنوان آگهی</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-font"></i></span>
                                <input type="text" id="title" name="title" class="form-control"
                                    placeholder="عنوان آگهی" required>
                            </div>
                        </div>

                        {{-- متن --}}
                        @if ($position->id != 3)
                            <div class="col-sm-12">
                                <label class="form-label" for="text">متن آگهی</label>
                                <textarea id="text" name="description" class="form-control" rows="2" placeholder="متن آگهی"></textarea>
                            </div>
                        @endif

                        @if ($position->id != 2)
                            <div class="col-sm-12">
                                <label class="form-label" for="image">تصویر آگهی</label>
                                <div class="input-group">
                                    <button class="btn btn-outline-primary" type="button" id="image"
                                        data-input="image_input" data-preview="imageHolder">انتخاب عکس</button>
                                    <input type="text" id="image_input" name="image" class="form-control"
                                        placeholder="انتخاب عکس" aria-label="انتخاب عکس">
                                </div>
                                <div class="w-100" id="imageHolder"></div>
                            </div>
                        @endif
                        @if ($position->id == 3)
                            <div class="col-sm-12">
                                <label class="form-label" for="video">ویدیو آگهی</label>
                                <div class="input-group">
                                    <button class="btn btn-outline-primary" type="button" id="video"
                                        data-input="video_input" data-preview="videoHolder">انتخاب ویدیو</button>
                                    <input type="text" id="video_input" name="video" class="form-control"
                                        placeholder="انتخاب ویدیو" aria-label="انتخاب ویدیو">
                                </div>
                                <small class="text-danger">در صورت انتخاب ویدیو عکس بالا به عنوان کاور استفاده
                                    میشود.</small>
                            </div>
                        @endif
                        {{-- عنوان --}}
                        @if ($position->id != 4 and $position->id != 5)
                            <div class="col-sm-6">
                                <label class="form-label" for="duration">مدت نمایش</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-timer"></i></span>
                                    <input type="text" id="duration" name="duration" class="form-control"
                                        placeholder="مدت نمایش" required>
                                </div>
                            </div>
                        @endif

                        <!-- Basic -->
                        <div class="col-md-6 mb-4">
                            <label for="TypeaheadBasic" class="form-label">مالک</label>
                            <input id="TypeaheadBasic" class="form-control typeahead" type="text" name="academy"
                                value="ادمین" autocomplete="off" placeholder="متقاضی آگهی را وارد کنید">
                        </div>

                        <div class="col-sm-12 d-flex align-items-end mt-4">
                            <button type="submit" class="btn btn-primary w-50">ذخیره آگهی</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('admin/assets/js/validation.js') }}"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        // در کد JS خود این را اضافه کنید:
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#image').filemanager('image');
        $('#video').filemanager('file');




        var substringMatcher = function(strs) {
            return function findMatches(q, cb) {
                var matches, substrRegex;
                matches = [];
                substrRegex = new RegExp(q, 'i');
                $.each(strs, function(i, str) {
                    if (substrRegex.test(str)) {
                        matches.push(str);
                    }
                });

                cb(matches);
            };
        };
        $('.typeahead').typeahead({
            hint: false,
            highlight: true,
            minLength: 1,
            dir: 'rtl'
        }, {
            name: 'states',
            source: substringMatcher(@json($academies))
        });
    </script>
    <script>
        let dt_advertisement;

        $(document).ready(function() {
            // DataTable
            dt_advertisement = $('.advertisement').DataTable({
                ajax: "{{ route('admin.positions.advertisements', ['position' => $position, 'status' => $status]) }}",
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
                        data: "",
                        title: "متقاضی",
                        render: function(data, type, full, meta) {
                            return full.academy?.name ?? 'ادمین';
                        }
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
                        render: function(data, type, full) {
                            if (full.status == 'approved') {
                                return `<button class="btn btn-sm btn-info item-toggle" data-id="${full.id}">تایید شده</button>`;
                            } else if (full.status == 'pending_review') {
                                return `<button class="btn btn-sm btn-warning item-toggle" data-id="${full.id}">در انتظار تایید</button>`;
                            } else if (full.status == 'rejected') {
                                return `<button class="btn btn-sm btn-danger item-toggle" data-id="${full.id}">رد شده</button>`;
                            } else if (full.status == 'active') {
                                return `<button class="btn btn-sm btn-success item-toggle" data-id="${full.id}">فعال</button>`;
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
                            <a href="#" class="btn btn-sm btn-primary"><i class="bx bxs-edit"></i></a>
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
                '<h5 class="card-title mb-0">آگهی های موقعیت {{ $position->name }}</h5>' +
                `<div>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.advertisement.index') }}">بازگشت</a>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formModal">آگهی جدید</button>
                </div>`
            );


            // toggle one item----------------------------------------------------------------------------------------------------------------
            dt_advertisement.on("click", ".item-toggle", function() {
                const id = $(this).data("id");

                if (!id) return;
                $.ajax({
                    url: "/admin2/advertisement/" + id + "/toggle",
                    type: "patch",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function(res) {
                        dt_advertisement.ajax.reload(null, false);
                    },
                    error: function(err) {
                        toastr.error("مشکلی در حذف گروهی رخ داد.");

                        console.error(err);
                    },
                });
            });
        });
    </script>
@endsection
