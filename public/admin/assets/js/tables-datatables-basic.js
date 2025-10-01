/**
 * DataTables Basic
 */

"use strict";

let dt_basic;

document.addEventListener("DOMContentLoaded", function () {
    // datatable (jquery)
    $(function () {
        var dt_basic_table = $(".datatables-basic"),
            dt_complex_header_table = $(".dt-complex-header"),
            dt_row_grouping_table = $(".dt-row-grouping"),
            dt_multilingual_table = $(".dt-multilingual"),
            // my tables
            jobTypes = $(".jobTypes");

        // DataTable with buttons
        // --------------------------------------------------------------------
        if (jobTypes.length) {
            dt_basic = jobTypes.DataTable({
                ajax: "/admin2/jobtype",
                columns: [
                    { data: "", title: "" }, // ستونی که برای responsive استفاده میشه
                    { data: "id", title: "شناسه" },
                    { data: "id", visible: false }, // ستون مخفی برای sort
                    { data: "id", title: "شناسه" },
                    { data: "name", title: "نام شغل" },
                    { data: "", title: "عملیات" }, // ستون آخر برای دکمه‌ها
                ],
                columnDefs: [
                    {
                        // For Responsive
                        className: "control",
                        orderable: false,
                        searchable: false,
                        responsivePriority: 2,
                        targets: 0,
                        render: function (data, type, full, meta) {
                            return "";
                        },
                    },
                    {
                        // For Checkboxes
                        targets: 1,
                        orderable: false,
                        render: function () {
                            return '<input type="checkbox" class="dt-checkboxes form-check-input mt-0 align-middle">';
                        },
                        checkboxes: {
                            selectAllRender:
                                '<input type="checkbox" class="form-check-input mt-0 align-middle">',
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
                        render: function (data, type, full, meta) {
                            return (
                                '<a href="/admin2/jobtype/' +
                                full.id +
                                '/edit" ' +
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
                order: [[2, "asc"]],
                dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end primary-font pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                displayLength: 10,
                lengthMenu: [10, 25, 50, 75, 100],
                buttons: [],
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function (row) {
                                var data = row.data();
                                return "جزئیات " + data["full_name"];
                            },
                        }),
                        type: "column",
                        renderer: function (api, rowIdx, columns) {
                            var data = $.map(columns, function (col, i) {
                                return col.title !== "" // ? Do not show row in modal popup if title is blank (for check box)
                                    ? '<tr data-dt-row="' +
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
                                          "</tr>"
                                    : "";
                            }).join("");

                            return data
                                ? $('<table class="table"/><tbody />').append(
                                      data
                                  )
                                : false;
                        },
                    },
                },
            });
            $("div.head-label").html(
                '<h5 class="card-title mb-0">نوع شغل ها</h5>'
            );
        }

        // Add New record
        // ? Remove/Update this code as per your requirements

        // Delete Record
        // روی جدول EventListener می‌ذاریم
        // روی جدول EventListener می‌ذاریم
        dt_basic.on("click", ".item-delete", function () {
            const id = $(this).data("id");

            if (!id) return;

            if (confirm("آیا از حذف این رکورد مطمئن هستید؟")) {
                $.ajax({
                    url: `/admin2/jobtype/delete/${id}`,
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function (res) {
                        dt_basic.ajax.reload(null, false); // ریفرش جدول بدون از دست رفتن صفحه
                    },
                    error: function (err) {
                        alert("خطا در حذف رکورد");
                        console.error(err);
                    },
                });
            }
        });

        $(".datatables-basic tbody").on("click", ".delete-record", function () {
            dt_basic.row($(this).parents("tr")).remove().draw();
        });

        // Complex Header DataTable
        // --------------------------------------------------------------------

        if (dt_complex_header_table.length) {
            var dt_complex = dt_complex_header_table.DataTable({
                ajax: assetsPath + "json/table-datatable.json",
                columns: [
                    { data: "full_name" },
                    { data: "email" },
                    { data: "city" },
                    { data: "post" },
                    { data: "salary" },
                    { data: "status" },
                    { data: "" },
                ],
                columnDefs: [
                    {
                        // Label
                        targets: -2,
                        render: function (data, type, full, meta) {
                            var $status_number = full["status"];
                            var $status = {
                                1: {
                                    title: "کنونی",
                                    class: "bg-label-primary",
                                },
                                2: {
                                    title: "حرفه‌ای",
                                    class: " bg-label-success",
                                },
                                3: {
                                    title: "رد شده",
                                    class: " bg-label-danger",
                                },
                                4: {
                                    title: "استعفا داده",
                                    class: " bg-label-warning",
                                },
                                5: {
                                    title: "درخواست داده",
                                    class: " bg-label-info",
                                },
                            };
                            if (
                                typeof $status[$status_number] === "undefined"
                            ) {
                                return data;
                            }
                            return (
                                '<span class="badge rounded-pill ' +
                                $status[$status_number].class +
                                '">' +
                                $status[$status_number].title +
                                "</span>"
                            );
                        },
                    },
                    {
                        // Actions
                        targets: -1,
                        title: "عمل‌ها",
                        orderable: false,
                        render: function (data, type, full, meta) {
                            return (
                                '<div class="d-inline-block">' +
                                '<a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></a>' +
                                '<div class="dropdown-menu dropdown-menu-end m-0">' +
                                '<a href="javascript:;" class="dropdown-item">جزئیات</a>' +
                                '<a href="javascript:;" class="dropdown-item">بایگانی</a>' +
                                '<div class="dropdown-divider"></div>' +
                                '<a href="javascript:;" class="dropdown-item text-danger delete-record">حذف</a>' +
                                "</div>" +
                                "</div>" +
                                '<a href="javascript:;" class="btn btn-sm btn-icon item-edit"><i class="bx bxs-edit"></i></a>'
                            );
                        },
                    },
                ],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                displayLength: 7,
                lengthMenu: [7, 10, 25, 50, 75, 100],
            });
        }

        // Row Grouping
        // --------------------------------------------------------------------

        var groupColumn = 2;
        if (dt_row_grouping_table.length) {
            var groupingTable = dt_row_grouping_table.DataTable({
                ajax: assetsPath + "json/table-datatable.json",
                columns: [
                    { data: "" },
                    { data: "full_name" },
                    { data: "post" },
                    { data: "email" },
                    { data: "city" },
                    { data: "start_date" },
                    { data: "salary" },
                    { data: "status" },
                    { data: "" },
                ],
                columnDefs: [
                    {
                        // For Responsive
                        className: "control",
                        orderable: false,
                        targets: 0,
                        searchable: false,
                        render: function (data, type, full, meta) {
                            return "";
                        },
                    },
                    { visible: false, targets: groupColumn },
                    {
                        // Label
                        targets: -2,
                        render: function (data, type, full, meta) {
                            var $status_number = full["status"];
                            var $status = {
                                1: {
                                    title: "کنونی",
                                    class: "bg-label-primary",
                                },
                                2: {
                                    title: "حرفه‌ای",
                                    class: " bg-label-success",
                                },
                                3: {
                                    title: "رد شده",
                                    class: " bg-label-danger",
                                },
                                4: {
                                    title: "استعفا داده",
                                    class: " bg-label-warning",
                                },
                                5: {
                                    title: "درخواست داده",
                                    class: " bg-label-info",
                                },
                            };
                            if (
                                typeof $status[$status_number] === "undefined"
                            ) {
                                return data;
                            }
                            return (
                                '<span class="badge rounded-pill ' +
                                $status[$status_number].class +
                                '">' +
                                $status[$status_number].title +
                                "</span>"
                            );
                        },
                    },
                    {
                        // Actions
                        targets: -1,
                        title: "عمل‌ها",
                        orderable: false,
                        searchable: false,
                        render: function (data, type, full, meta) {
                            return (
                                '<div class="d-inline-block">' +
                                '<a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></a>' +
                                '<div class="dropdown-menu dropdown-menu-end m-0">' +
                                '<a href="javascript:;" class="dropdown-item">جزئیات</a>' +
                                '<a href="javascript:;" class="dropdown-item">بایگانی</a>' +
                                '<div class="dropdown-divider"></div>' +
                                '<a href="javascript:;" class="dropdown-item text-danger delete-record">حذف</a>' +
                                "</div>" +
                                "</div>" +
                                '<a href="javascript:;" class="btn btn-sm btn-icon item-edit"><i class="bx bxs-edit"></i></a>'
                            );
                        },
                    },
                ],
                order: [[groupColumn, "asc"]],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                displayLength: 7,
                lengthMenu: [7, 10, 25, 50, 75, 100],
                drawCallback: function (settings) {
                    var api = this.api();
                    var rows = api.rows({ page: "current" }).nodes();
                    var last = null;

                    api.column(groupColumn, { page: "current" })
                        .data()
                        .each(function (group, i) {
                            if (last !== group) {
                                $(rows)
                                    .eq(i)
                                    .before(
                                        '<tr class="group"><td colspan="8">' +
                                            group +
                                            "</td></tr>"
                                    );

                                last = group;
                            }
                        });
                },
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function (row) {
                                var data = row.data();
                                return "جزئیات " + data["full_name"];
                            },
                        }),
                        type: "column",
                        renderer: function (api, rowIdx, columns) {
                            var data = $.map(columns, function (col, i) {
                                return col.title !== "" // ? Do not show row in modal popup if title is blank (for check box)
                                    ? '<tr data-dt-row="' +
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
                                          "</tr>"
                                    : "";
                            }).join("");

                            return data
                                ? $('<table class="table"/><tbody />').append(
                                      data
                                  )
                                : false;
                        },
                    },
                },
            });

            // Order by the grouping
            $(".dt-row-grouping tbody").on("click", "tr.group", function () {
                var currentOrder = groupingTable.order()[0];
                if (
                    currentOrder[0] === groupColumn &&
                    currentOrder[1] === "asc"
                ) {
                    groupingTable.order([groupColumn, "desc"]).draw();
                } else {
                    groupingTable.order([groupColumn, "asc"]).draw();
                }
            });
        }
        // Filter form control to default size
        // ? setTimeout used for multilingual table initialization
        setTimeout(() => {
            $(".dataTables_filter .form-control").removeClass(
                "form-control-sm"
            );
            $(".dataTables_length .form-select").removeClass("form-select-sm");
        }, 300);
    });

    // تابع جنریک برای ساخت فرم با اعتبارسنجی
    // تابع جنریک برای ساخت فرم با اعتبارسنجی
    function initOffcanvasForm({ formId, triggerSelector, fields, onSubmit }) {
        let fv, offCanvasEl;

        const formEl = document.getElementById(formId);
        // const offCanvasElement = document.getElementById(offcanvasId);
        const triggerBtn = document.querySelector(triggerSelector);

        if (!formEl) return;

        // مقداردهی offCanvasEl در اینجا
        // offCanvasEl = new bootstrap.Offcanvas(offCanvasElement);

        // باز کردن Offcanvas
        // document.addEventListener("click", function (e) {
        //     if (e.target.closest(".create-new")) {
        //         // دکمه اضافه رکورد کلیک شد
        //         offCanvasEl.show(); // استفاده از متغیر از پیش تعریف شده
        //     }
        // });

        // ساخت Ruleهای ولیدیشن داینامیک
        let validationFields = {};
        Object.entries(fields).forEach(([fieldName, fieldOptions]) => {
            validationFields[fieldName] = { validators: {} };

            if (fieldOptions.required) {
                validationFields[fieldName].validators.notEmpty = {
                    message: fieldOptions.label + " الزامی است",
                };
            }

            if (fieldOptions.type === "email") {
                validationFields[fieldName].validators.emailAddress = {
                    message: "لطفا یک ایمیل معتبر وارد کنید",
                };
            }

            if (fieldOptions.type === "date") {
                validationFields[fieldName].validators.date = {
                    format: "YYYY/MM/DD",
                    message: "تاریخ معتبر نیست",
                };

                // flatpickr برای تاریخ
                flatpickr(formEl.querySelector(`[name="${fieldName}"]`), {
                    enableTime: false,
                    locale: "fa",
                    dateFormat: "Y/m/d",
                    onChange: function () {
                        fv.revalidateField(fieldName);
                    },
                    disableMobile: true,
                });
            }
        });

        // ساخت Validation
        fv = FormValidation.formValidation(formEl, {
            fields: validationFields,
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    rowSelector: ".col-sm-12",
                }),
                submitButton: new FormValidation.plugins.SubmitButton(),
                autoFocus: new FormValidation.plugins.AutoFocus(),
            },
            init: (instance) => {
                instance.on("plugins.message.placed", function (e) {
                    if (
                        e.element.parentElement.classList.contains(
                            "input-group"
                        )
                    ) {
                        e.element.parentElement.insertAdjacentElement(
                            "afterend",
                            e.messageElement
                        );
                    }
                });
            },
        });

        // وقتی فرم معتبر بود
        fv.on("core.form.valid", function () {
            const values = {};
            Object.keys(fields).forEach((fieldName) => {
                let input = formEl.querySelector(`[name="${fieldName}"]`);
                values[fieldName] = input ? input.value : "";
                input.value = "";
            });

            if (typeof onSubmit === "function") {
                onSubmit(values);
            } else {
                // offCanvasEl.hide();
            }
        });
    }

    initOffcanvasForm({
        formId: "form-add-new-record",
        // offcanvasId: "add-new-record",
        triggerSelector: ".create-new",
        fields: {
            name: {
                label: "نام نوع شغل",
                required: true,
                type: "text",
            },
        },
        onSubmit: function (values) {
            console.log("Form Data:", values);

            // اضافه کردن CSRF token
            values._token = $('meta[name="csrf-token"]').attr("content");

            // ارسال Ajax
            $.post("/admin2/jobtype/store", values, function (res) {
                console.log("Server Response:", res);
                // offCanvasEl.hide();

                dt_basic.ajax.reload(); // اگر میخوای جدول بروز بشه
            });
        },
    });
});
