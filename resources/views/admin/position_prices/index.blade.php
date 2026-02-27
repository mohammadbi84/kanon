@extends('admin.layout.master')

@section('head')
@endsection

@section('content')
    <div class="card">
        <div class="card-datatable table-responsive pt-0 p-3">
            {{-- جدول پاپ‌آپ‌ها --}}
            <table class="dt-select-table positions table mt-4">
                <thead>
                    <tr></tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4 mt-0 mt-md-n2">
                        <h3 class="secondary-font">افزودن قیمت جدید</h3>
                    </div>
                    <form action="{{ route('admin.pricing.store', ['position' => $position]) }}" method="post"
                        class="add-new-record pt-0 row g-2 mt-3 p-0" id="form-add-new-record">
                        <div class="col-sm-6">
                            <label class="form-label" for="start_date">تاریخ شروع</label>
                            <div class="input-group input-group-merge">
                                <span id="start_date2" class="input-group-text"><i class="bx bx-calendar"></i></span>
                                <input type="date" id="start_date" class="form-control dt-full-name" name="start_date"
                                    placeholder="تاریخ شروع" aria-describedby="start_date2">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="end_date">تاریخ پایان</label>
                            <div class="input-group input-group-merge">
                                <span id="end_date2" class="input-group-text"><i class="bx bx-calendar"></i></span>
                                <input type="date" id="end_date" class="form-control dt-full-name" name="end_date"
                                    placeholder="تاریخ پایان" aria-describedby="end_date2">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="price_per_day">پایه قیمت روزانه (تومان)</label>
                            <div class="input-group input-group-merge">
                                <span id="price_per_day2" class="input-group-text"><i class="bx bx-coin"></i></span>
                                <input type="number" id="price_per_day" class="form-control dt-full-name"
                                    name="price_per_day" placeholder="پایه قیمت روزانه (تومان)"
                                    aria-describedby="price_per_day2">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="price_per_second">قیمت بر ثانیه اضافه</label>
                            <div class="input-group input-group-merge">
                                <span id="price_per_second2" class="input-group-text"><i class="bx bx-coin"></i></span>
                                <input type="number" id="price_per_second" class="form-control dt-full-name"
                                    name="price_per_second" placeholder="قیمت بر ثانیه اضافه"
                                    aria-describedby="price_per_second2">
                            </div>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ذخیره اطلاعات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('admin/assets/js/validation.js') }}"></script>
    <script>
        // در کد JS خود این را اضافه کنید:
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#end_date').flatpickr({
            monthSelectorType: 'static',
            locale: 'fa',
            altInput: true,
            altFormat: 'Y/m/d',
            disableMobile: true
        });
        $('#start_date').flatpickr({
            monthSelectorType: 'static',
            locale: 'fa',
            altInput: true,
            altFormat: 'Y/m/d',
            disableMobile: true
        });
    </script>
    <script>
        let dt_positions;

        $(document).ready(function() {
            // DataTable
            dt_positions = $('.positions').DataTable({
                ajax: "{{ route('admin.pricing.index', ['position' => $position]) }}",
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
                        data: "position_id",
                        title: "موقعیت",
                        render: function(data, type, full, meta) {
                            return "{{ $position->name }}";
                        },
                    },
                    {
                        data: "start_date",
                        title: "تاریخ شروع",
                    },
                    {
                        data: "end_date",
                        title: "تاریخ پایان",
                    },
                    {
                        data: "price_per_day",
                        title: "پایه قیمت روزانه",
                    },
                    {
                        data: "price_per_second",
                        title: "قیمت بر ثانیه اضافه",
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
                            <a href="#" class="btn btn-sm btn-primary"><i class="bx bxs-edit"></i></a>
                        `;

                        }
                    }
                ],
                order: [
                    [2, "desc"]
                ],
                dom: '<"card-header flex-column flex-md-row"<"head-label w-100 text-center">><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t' +
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
            $("div.head-label").html(
                `
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">قیمت های موقعیت ({{ $position->name }})</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal" >قیمت گذاری جدید</button>
                </div>
                `
            );
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
                    price_per_day: {
                        label: "پایه قیمت روزانه",
                        required: true,
                        type: "number",
                    },
                    price_per_second: {
                        label: "قیمت بر ثانیه اضافه",
                        required: false,
                        type: "number",
                    },
                },
                onSubmit: function(values) {
                    console.log("Form Data:", values);

                    // اضافه کردن CSRF token
                    values._token = $('meta[name="csrf-token"]').attr(
                        "content",
                    );

                    // ارسال Ajax
                    $.post("{{ route('admin.pricing.store', ['position' => $position]) }}", values,
                        function(res) {
                            if (res.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: "موفق!",
                                    text: res.message,
                                    timer: 1500,
                                    showConfirmButton: false,
                                });
                                dt_positions.ajax.reload(); // اگر میخوای جدول بروز بشه
                                $('#createModal').modal('hide');
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "خطا!",
                                    text: res.message,
                                    timer: 1500,
                                    showConfirmButton: false,
                                });
                            }

                        });
                },
            });
        });
    </script>
@endsection
