@extends('admin.layout.master')
@section('head')
    {{-- btn-go-to-top --}}
    <link rel="stylesheet" href="{{ asset('site/assets/css/btn-go-to-top.css') }}">
    <script src="{{ asset('site/assets/js/btn-go-to-top.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/nouislider/nouislider.css') }}">
    {{-- bootstrap icons --}}
    <link rel="stylesheet" href="https://lib.arvancloud.ir/bootstrap-icons/1.9.1/font/bootstrap-icons.css">
@endsection
@section('content')
    <h5 class="breadcrumb-wrapper mb-4 pt-4" style="padding: 15px 10px !important;" id="breadcrumb-wrapper">
        <a href="{{ route('admin.index') }}" class="text-muted">داشبورد</a> <span class="text-muted">/</span>
        <a href="{{ route('admin.tuitions.index') }}" class="text-muted">مدیریت نرخ شهریه</a> <span
            class="text-muted">/</span>
        <span class="">{{ $tuition->title }}</span>
        <span class="text-muted">/ حرفه ها</span>
    </h5>
    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable p-3">
            <div class="fixed-header">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="head-label d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">مدیریت مبالغ حرفه‌ها برای شهریه : {{ $tuition->title }}</h5>
                        <small class="text-muted ms-2">(
                            تعداد : <span id="totalRecord2">0</span> ردیف /
                            فلیتر شده : <span id="filteredrecord">0</span> ردیف /
                            انتخاب شده : <span id="selectedRecord">0</span> ردیف )</small>
                    </div>
                    <div class="d-flex justify-content-end align-items-center gap-3">
                        <button type="button" id="save-prices" class="btn btn-primary">
                            ذخیره تغییرات
                        </button>
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-center gap-2 text-muted">
                    <small class="py-3 text-white">1</small>
                </div>
            </div>

            <table class="dt-select-table professions table table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>ردیف</th>
                        <th>رسته</th>
                        <th>خوشه</th>
                        <th>رشته</th>
                        <th>نام حرفه</th>
                        <th>کد استاندارد</th>
                        <th>انتشار</th>
                        <th>هزینه حضوری</th>
                        <th>هزینه مجازی</th>
                        <th>هزینه الکترونیکی</th>
                    </tr>
                </thead>
            </table>
            <div class="bulk-actions" id="bulk-actions2">
                <div class="btn-group action_group" style="display: none">
                    <button type="button" class="btn border dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        انتخاب عملیـات
                    </button>
                    <ul class="dropdown-menu">
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
                    </ul>
                </div>
            </div>
            <div id="bulk-actions" class="bulk-actions">
                <div class="btn-group action_group" id="" style="display: none">
                    <button type="button" class="btn border dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        انتخاب عملیـات
                    </button>
                    <ul class="dropdown-menu">
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
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <a href="#" id="btn-go-to-top" class="shadow">
        <svg width="40" height="40" viewBox="0 0 131 131" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle class="outer_circle" cx="65.5" cy="65.5" r="64" stroke="red"></circle>
        </svg>
        <span class="bi bi-arrow-up"></span>
    </a>
@endsection
@section('script')
    <script src="{{ asset('admin/assets/js/validation.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/nouislider/nouislider.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/js/dropdown-hover.js') }}"></script>
    <script>
        tuitionId = {{ $tuition->id }};
        professions = $(".professions");

        dt_basic = professions.DataTable({
            ajax: {
                url: "/admin2/tuitions/" + tuitionId + "/professions",
                // این تابع قبل از شروع لود اجرا میشه
                beforeSend: function() {
                    $("#DataTables_Table_0_wrapper .dataTables_empty").hide();
                    $(".professions").closest(".card").append(`
                    <div id="custom-overlay">
                        <div class="loader-container">
                            <div class="custom-spinner"></div>
                            <span>در حال بارگزاری رکورد ها</span>
                            <span>لطفا شکیبا باشید.</span>
                        </div>
                    </div>
                `);
                },
                // این تابع بعد از اتمام لود اجرا میشه
                complete: function() {
                    $("#custom-overlay").remove();
                }
            },
            autoWidth: false, // جلوگیری از محاسبه خودکار عرض
            // bAutoWidth: false,
            columns: [{
                    data: "id",
                    width: "1%"
                }, // Responsive
                {
                    data: "id",
                    visible: false
                },
                {
                    data: null,
                    title: "ردیف",
                    width: "3%"
                },
                {
                    data: "field.cluster.category.name",
                    title: "رسته",
                    width: "10%"
                },
                {
                    data: "field.cluster.name",
                    title: "خوشه",
                    width: "7%"
                },
                {
                    data: "field.name",
                    title: "رشته",
                    width: "8%"
                },
                {
                    data: "name",
                    title: "حرفه",
                    width: "14%"
                },
                {
                    data: "new_standard_code",
                    title: "کد استاندارد",
                    width: "9%"
                },
                {
                    data: "",
                    title: "انتشار",
                    width: "4%"
                },
                {
                    data: "",
                    title: "هزینه حضوری",
                    width: "8%"
                },
                {
                    data: "",
                    title: "هرینه مجازی",
                    width: "8%"
                },
                {
                    data: "",
                    title: "هزینه الکترونیکی",
                    width: "8%"
                },
            ],
            columnDefs: [{
                    targets: 0,
                    searchable: false,
                    orderable: false,
                    render: function() {
                        return '<input type="checkbox" class="dt-checkboxes form-check-input mt-0 align-middle">';
                    },
                },
                {
                    targets: 2,
                    data: null,
                    title: "ردیف",
                    orderable: true,
                    searchable: true,
                    render: function(data, type, full, meta) {
                        // شماره ردیف سراسری (بدون وابستگی به صفحه و سورت)
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    targets: -4,
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
                    targets: -3,
                    orderable: true,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `
                        <div class="custom-input-group only-number ${full.price_in_person ? 'filled' : ''}">
                            <input type="text" class="form-control px-1" value="${full.price_in_person}">
                            <span class="clear-btn" onclick="clearInput(this)" style="font-size: 1rem;left: -1px;">×</span>
                        </div>
                        `;
                    },
                },
                {
                    targets: -2,
                    orderable: true,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `
                        <div class="custom-input-group only-number ${full.price_virtual ? 'filled' : ''}">
                            <input type="text" class="form-control px-1" value="${full.price_virtual}">
                            <span class="clear-btn" onclick="clearInput(this)" style="font-size: 1rem;left: -1px;">×</span>
                        </div>
                        `;
                    },
                },
                {
                    targets: -1,
                    orderable: true,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `
                        <div class="custom-input-group only-number ${full.price_online ? 'filled' : ''}">
                            <input type="text" class="form-control px-1" value="${full.price_online}">
                            <span class="clear-btn" onclick="clearInput(this)" style="font-size: 1rem;left: -1px;">×</span>
                        </div>
                        `;
                    },
                },
            ],
            order: [
                [2, "asc"]
            ],
            dom: '<"card-header flex-column flex-md-row"<"dt-action-buttons text-end primary-font pt-3 pt-md-0"B>>' +
                '<"d-flex justify-content-between align-items-center table-search-fixed"<"d-flex justify-content-start align-items-center gap-3"l <\'bulk-holder2\'>><"d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t>' +
                "<'row d-flex align-items-center justify-content-between'<'col-md-4'<'bulk-holder'>><'col-md-8 d-flex justify-content-between'i p>>",
            displayLength: 50,
            lengthMenu: [10, 25, 50, 75, 100, 500],
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
                style: "multi",
                selector: 'td:first-child', // انتخاب با کلیک روی چک‌باکس
                items: 'row' // انتخاب ردیف‌ها
            },
            processing: true,
            initComplete: function(settings, json) {
                let noSearchColumns = [0, 8, 9, 10, 11];
                // **تنظیم رویداد برای اینپوت های معمولی**
                $('.professions thead tr:eq(1) th').each(function(i) {
                    $(this).removeClass('sorting');
                    $(this).removeClass('sorting_asc');
                    $(this).removeClass('sorting_desc');
                    $(this).addClass('px-2');

                    if (noSearchColumns.includes(i)) {
                        $(this).html('');
                        return;
                    }

                    var title = $(this).text();
                    $(this).html(`
                    <div class="slider-select d-flex justify-content-between gap-2">
                        <div class="custom-input-group">
                        <input type="text" class="form-control px-1">
                        <label for=""></label>
                        <span class="clear-btn" onclick="clearInput(this,${i})" style="font-size: 1rem;left: -1px;">×</span>
                    </div>
                    `);
                    $('input', this).on('keyup change', function() {
                        if (i == 1) {
                            if (this.value.length > 0) {
                                dt_basic.column(i + 1).search('^' + this.value + '$', true,
                                    false).draw();
                            } else {
                                dt_basic.column(i + 1).search('').draw();
                            }
                        } else {
                            dt_basic.column(i + 1).search(this.value).draw();
                        }
                    });
                });



                // چک باکس ها
                var $headerCheckbox = $(
                    '<input type="checkbox" id="select-all-page" class="form-check-input mt-0 align-middle">'
                );
                $('.professions thead tr:eq(0) th:eq(0)').html($headerCheckbox);

                // مدیریت انتخاب ردیف‌ها
                $(document).on('click', '.dt-checkboxes', function(e) {
                    e.stopPropagation();

                    var $checkbox = $(this);
                    var row = dt_basic.row($checkbox.closest('tr'));

                    if ($checkbox.prop('checked')) {
                        row.select();
                        dt_basic.column(i + 1).search(this.value).draw();
                    } else {
                        row.deselect();
                        dt_basic.column(i + 1).search(this.value).draw();
                    }
                });

                // مدیریت چک‌باکس انتخاب همه
                $(document).on('click', '#select-all-page', function(e) {
                    e.stopPropagation();

                    var isChecked = $(this).prop('checked');
                    var currentPageRows = dt_basic.rows({
                        page: 'current'
                    });

                    if (isChecked) {
                        currentPageRows.select();
                    } else {
                        currentPageRows.deselect();
                    }

                    currentPageRows.nodes().to$().find('.dt-checkboxes').prop('checked', isChecked);
                });

                // به‌روزرسانی وضعیت چک‌باکس انتخاب همه
                dt_basic.on('draw select deselect', function() {
                    var api = dt_basic;
                    var currentPageCount = api.rows({
                        page: 'current'
                    }).count();
                    var selectedCount = api.rows({
                        page: 'current',
                        selected: true
                    }).count();

                    var $selectAll = $('#select-all-page');

                    if (selectedCount === 0) {
                        $selectAll.prop('checked', false);
                        $selectAll.prop('indeterminate', false);
                    } else if (selectedCount === currentPageCount) {
                        $selectAll.prop('checked', true);
                        $selectAll.prop('indeterminate', false);
                    } else {
                        $selectAll.prop('checked', false);
                        $selectAll.prop('indeterminate', true);
                    }
                });
            }

        });
        let thead = $('.professions thead');
        let searchRow = thead.find('tr').clone().appendTo(thead);
        let noSearchColumns = [0, 8, 9, 10];

        // انتقال اکشن‌ها
        $("#bulk-actions").appendTo(".bulk-holder");
        $("#bulk-actions2").appendTo(".bulk-holder2");
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
        dt_basic.on('init', function(e) {
            document.querySelectorAll("input, textarea").forEach(function(element) {
                // اگر مقدار اولیه داشت، کلاس filled اضافه کن
                if (element.value.trim() !== "") {
                    element.parentElement.classList.add("filled");
                }

                // گوش دادن به رویداد input (بدون jQuery)
                element.addEventListener("input", function(e) {
                    const parent = e.target.parentElement;

                    if (e.target.value.trim() !== "") {
                        parent.classList.add("filled");
                    } else {
                        parent.classList.remove("filled");
                    }

                    if (parent.classList.contains("only-number")) {
                        e.target.value = e.target.value.replace(/[^0-9]/g, "");
                    }
                });
            });
        });

        // بعد از تعریف dt_basic
        dt_basic.on('draw', function() {
            document.querySelectorAll("input, textarea").forEach(function(element) {
                // اگر مقدار اولیه داشت، کلاس filled اضافه کن
                if (element.value.trim() !== "") {
                    element.parentElement.classList.add("filled");
                }

                // گوش دادن به رویداد input (بدون jQuery)
                element.addEventListener("input", function(e) {
                    const parent = e.target.parentElement;

                    if (e.target.value.trim() !== "") {
                        parent.classList.add("filled");
                    } else {
                        parent.classList.remove("filled");
                    }

                    if (parent.classList.contains("only-number")) {
                        e.target.value = e.target.value.replace(/[^0-9]/g, "");
                    }
                });
            });


            var api = $(this).DataTable(); // یا استفاده از dt_basic مستقیم

            // تعداد رکوردهای فیلتر شده و کل
            var filteredRecords = api.rows({
                filter: 'applied'
            }).count();

            var totalRecords = api.rows().count();

            if (filteredRecords == totalRecords) {
                filteredRecords = 0
            }

            // تعداد رکوردهای انتخاب شده
            var selectedCount = api.rows({
                selected: true
            }).count();

            $("#totalRecord").html(totalRecords);
            $("#totalRecord2").html(totalRecords);
            $("#filteredrecord").html(filteredRecords);
            $("#selectedRecord").html(selectedCount);
        });

        // همچنین برای به‌روزرسانی هنگام انتخاب/لغو انتخاب ردیف‌ها
        dt_basic.on('select deselect', function() {
            var api = $(this).DataTable(); // یا استفاده از dt_basic مستقیم
            var selectedCount = api.rows({
                selected: true
            }).count();
            var filteredRecords = api.rows({
                filter: 'applied'
            }).count();
            var totalRecords = api.rows().count();

            if (filteredRecords == totalRecords) {
                filteredRecords = 0
            }

            $("#filteredrecord").html(filteredRecords);
            $("#selectedRecord").html(selectedCount);
        });

        // delete selected items----------------------------------------------------------------------------------------------------------
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
                $(".bulk-actions .action_group").show();
                $(".bulk-actions .bulk-delete").prop("disabled", false);
                $(".bulk-actions .bulk-toggle").prop("disabled", false);
                $(".bulk-actions .bulk-archive").prop("disabled", false);
            } else {
                $(".bulk-actions .action_group").hide();
                $(".bulk-actions .bulk-delete").prop("disabled", true);
                $(".bulk-actions .bulk-toggle").prop("disabled", true);
                $(".bulk-actions .bulk-archive").prop("disabled", true);
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

        // toggle selected
        $(".bulk-toggle").on("click", function() {
            const ids = getSelectedIds(); // فرض می‌کنیم این تابع id ردیف‌های انتخاب شده را برمی‌گرداند
            const status = $(this).data("status"); // true برای انتشار، false برای عدم انتشار

            if (ids.length === 0) {
                Swal.fire({
                    icon: "warning",
                    title: "هیچ رکوردی انتخاب نشده!",
                    confirmButtonText: "باشه",
                });
                return;
            }

            Swal.fire({
                title: `آیا از ${status ? 'انتشار' : 'عدم انتشار'} ${ids.length} رکورد مطمئن هستید؟`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "تایید",
                cancelButtonText: "انصراف",
                focusConfirm: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/admin2/tuitions/" + tuitionId + "/tuitions-professions/bulk-toggle",
                        type: "POST",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr("content"),
                            ids: ids,
                            status: status,
                        },
                        success: function(res) {
                            toastr.success(res.message);

                            // حلقه زدن روی ID های ارسال شده
                            ids.forEach(function(id) {
                                var $button = dt_basic.rows().nodes().to$().find(
                                    `button.item-toggle[data-id="${id}"]`);

                                if ($button.length) {
                                    var $icon = $button.find('i');

                                    if (status) { // اگر وضعیت به 'منتشر شده' تغییر کرد
                                        $icon.removeClass('bx-x').addClass(
                                            'bx-check');
                                        $button.removeClass('text-danger').addClass(
                                            'text-success');
                                    } else { // اگر وضعیت به 'منتشر نشده' تغییر کرد
                                        $icon.removeClass('bx-check').addClass(
                                            'bx-x');
                                        $button.removeClass('text-success')
                                            .addClass('text-danger');
                                    }
                                }
                            });
                            // پاک کردن انتخاب تمام ردیف‌ها
                            dt_basic.rows().deselect();

                            // یا اگر می‌خواهید چک‌باکس‌ها هم پاک شوند
                            $('.dt-checkboxes').prop('checked', false);
                            $('.select-all').prop('checked', false);
                            // --- پایان بخش به‌روزرسانی آیکون‌ها در جدول ---

                            // مخفی کردن منوی bulk actions
                            $(".bulk-actions .action_group").hide();
                            $(".bulk-actions .bulk-delete").prop("disabled", true);
                            $(".bulk-actions .bulk-toggle").prop("disabled", true);
                            $(".bulk-actions .bulk-archive").prop("disabled", true);
                        },
                        error: function(err) {
                            toastr.error(err.responseJSON.message);
                            console.error(err);
                        },
                    });
                }
            });
        });
        // toggle one item----------------------------------------------------------------------------------------------------------------
        dt_basic.on("click", ".item-toggle", function() {
            const id = $(this).data("id");

            var button = $(this);
            var icon = button.find('i');

            if (!id) return;
            $.ajax({
                url: "/admin2/tuitions/" + tuitionId + "/" + id + "/toggle",
                type: "patch",
                data: {
                    _token: $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function(res) {
                    toastr.success(res.message);
                    if (icon.hasClass('bx-check')) {
                        icon.removeClass('bx-check').addClass('bx-x');
                        button.removeClass('text-success').addClass(
                            'text-danger'); // مثال: تغییر رنگ دکمه
                    } else {
                        icon.removeClass('bx-x').addClass('bx-check');
                        button.removeClass('text-danger').addClass(
                            'text-success'); // مثال: بازگرداندن رنگ دکمه
                    }
                },
                error: function(err) {
                    toastr.error(err.responseJSON.message);
                    console.error(err);
                },
            });
        });

        // تابع پاک کردن محتوا
        function clearInput(btn, col = 1) {
            const parent = btn.parentElement;
            const input = parent.querySelector("input, textarea");
            input.value = null;
            input.focus();
            parent.classList.remove("filled");

            // پاک کردن جستجوی آن ستون و رسم دوباره جدول
            dt_basic.column(col + 1).search('').draw();
        }


        // فرض کنید دکمه ذخیره دارای id="save-prices" است
        $('#save-prices').on('click', function() {
            // آرایه‌ای برای نگهداری قیمت‌های تغییر‌یافته و معتبر
            const changedPrices = [];

            // پیمایش تمام ردیف‌های جدول (فقط ردیف‌های فیلتر شده/نمایش داده شده)
            dt_basic.rows({
                search: 'applied'
            }).every(function() {
                const rowData = this.data(); // داده اصلی ردیف از سرور (شامل price_in_person و ...)
                const rowNode = this.node(); // عنصر DOM ردیف

                // یافتن input های قیمت در این ردیف (با استفاده از کلاس یا ایندکس ستون)
                // راه بهتر: استفاده از data-id یا کلاس مشخص، اما چون ستون‌ها مشخص‌اند از ایندکس استفاده می‌کنیم
                const $row = $(rowNode);
                const personInput = $row.find('td:eq(8) input'); // ستون 9: هزینه حضوری
                const virtualInput = $row.find('td:eq(9) input'); // ستون 10: هزینه مجازی
                const onlineInput = $row.find('td:eq(10) input'); // ستون 11: هزینه الکترونیکی

                // مقادیر وارد شده توسط کاربر (پیش‌فرض 0)
                const personVal = parseFloat(personInput.val()) || 0;
                const virtualVal = parseFloat(virtualInput.val()) || 0;
                const onlineVal = parseFloat(onlineInput.val()) || 0;

                // مقادیر اصلی از سرور (اگر null بود 0 در نظر بگیرید)
                const originalPerson = parseFloat(rowData.price_in_person) || 0;
                const originalVirtual = parseFloat(rowData.price_virtual) || 0;
                const originalOnline = parseFloat(rowData.price_online) || 0;

                // آیا تغییری رخ داده است؟
                const personChanged = personVal !== originalPerson;
                const virtualChanged = virtualVal !== originalVirtual;
                const onlineChanged = onlineVal !== originalOnline;

                const anyChanged = personChanged || virtualChanged || onlineChanged;
                // آیا حداقل یک قیمت بزرگتر از 0 است؟
                const anyPositive = personVal > 0 || virtualVal > 0 || onlineVal > 0;

                // فقط اگر هم تغییر داشته باشد و هم حداقل یک قیمت > 0 باشد
                if (anyChanged && anyPositive) {
                    changedPrices.push({
                        profession_id: rowData.id,
                        price_in_person: personVal,
                        price_virtual: virtualVal,
                        price_online: onlineVal
                    });
                }
            });

            if (changedPrices.length === 0) {
                toastr.error('هیچ قیمت تغییر یافته و معتبری (بزرگتر از صفر) یافت نشد');
                return;
            }

            // ارسال به سرور
            $.ajax({
                url: `/admin2/tuitions/${tuitionId}/prices`, // مسیر ذخیره قیمت‌ها
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    prices: changedPrices
                },
                beforeSend: function() {
                    // می‌توانید دکمه را غیرفعال یا لودینگ نمایش دهید
                    $('#save-prices').prop('disabled', true).text('در حال ذخیره...');
                },
                success: function(response) {
                    toastr.success('قیمت‌ها با موفقیت ذخیره شدند');
                    dt_basic.ajax.reload(); // به‌روزرسانی جدول برای نمایش مقادیر جدید
                },
                error: function(xhr) {
                    toastr.error('خطا در ذخیره‌سازی: ' + (xhr.responseJSON?.message || ''));
                },
                complete: function() {
                    $('#save-prices').prop('disabled', false).text('ذخیره');
                }
            });
        });
    </script>
    {{-- some shit --}}
    <script>
        window.addEventListener('scroll', function() {
            const element = document.querySelector('#breadcrumb-wrapper');
            const rect = element.getBoundingClientRect();

            // اگر فاصله از بالای viewport صفر باشد یعنی چسبیده
            if (rect.top <= 62) {
                element.classList.add('is-stuck');
            } else {
                element.classList.remove('is-stuck');
            }
        });
    </script>
@endsection
