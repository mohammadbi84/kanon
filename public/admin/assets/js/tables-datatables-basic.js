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
            jobTypes = $(".jobTypes"),
            kardanesh = $(".kardanesh");

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
                            selectRow: true,
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
                                '"' +
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
                order: [[2, "desc"]],
                dom:
                    '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end primary-font pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t' +
                    "<'row d-flex align-items-center justify-content-between'<'col-md-4'<'bulk-holder'>><'col-md-8 d-flex justify-content-between'i p>>",
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
                select: {
                    // Select style
                    style: "multi",
                },
            });
            $("#bulk-actions").appendTo(".bulk-holder");
            $("div.head-label").html(
                '<h5 class="card-title mb-0">نوع شغل ها</h5>'
            );
            // add new record-------------------------------------------------------------------------------------------------------------
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
                    values._token = $('meta[name="csrf-token"]').attr(
                        "content"
                    );

                    // ارسال Ajax
                    $.post("/admin2/jobtype/store", values, function (res) {
                        console.log("Server Response:", res);
                        // offCanvasEl.hide();

                        dt_basic.ajax.reload(); // اگر میخوای جدول بروز بشه
                    });
                },
            });
            // delete one item----------------------------------------------------------------------------------------------------------------
            dt_basic.on("click", ".item-delete", function () {
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
                            url: "/admin2/jobtype/delete/"+id,
                            type: "DELETE",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr(
                                    "content"
                                ),
                            },
                            success: function (res) {
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
                            error: function (err) {
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

            // delete selected items----------------------------------------------------------------------------------------------------------
            const btnBulk = $("#bulk-delete");
            if (btnBulk) {
                // وقتی رکورد انتخاب شد
                dt_basic.on("select", function (e, dt, type, indexes) {
                    toggleBulkActions();
                });

                // وقتی رکورد از انتخاب خارج شد
                dt_basic.on("deselect", function (e, dt, type, indexes) {
                    toggleBulkActions();
                });

                // تابع برای نمایش / مخفی کردن باکس عملیات
                function toggleBulkActions() {
                    const selected = dt_basic.rows({ selected: true }).count();
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
                        .rows({ selected: true })
                        .data()
                        .pluck("id")
                        .toArray();
                }

                btnBulk.on("click", function () {
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
                                url: "/admin2/jobtype/bulk-delete",
                                type: "POST",
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr(
                                        "content"
                                    ),
                                    ids: ids,
                                },
                                success: function (res) {
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
                                error: function (err) {
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
        }
        if (kardanesh.length) {
            dt_basic = kardanesh.DataTable({
                ajax: "/admin2/kardanesh",
                columns: [
                    { data: "", title: "" }, // ستونی که برای responsive استفاده میشه
                    { data: "id", title: "شناسه" },
                    { data: "id", visible: false }, // ستون مخفی برای sort
                    { data: "id", title: "شناسه" },
                    { data: "name", title: "نوع کاردانش" },
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
                            selectRow: true,
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
                                '<a href="/admin2/kardanesh/' +
                                full.id +
                                '"' +
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
                order: [[2, "desc"]],
                dom:
                    '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end primary-font pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t' +
                    "<'row d-flex align-items-center justify-content-between'<'col-md-4'<'bulk-holder'>><'col-md-8 d-flex justify-content-between'i p>>",
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
                select: {
                    // Select style
                    style: "multi",
                },
            });
            $("#bulk-actions").appendTo(".bulk-holder");
            $("div.head-label").html(
                '<h5 class="card-title mb-0">نوع کاردانش ها</h5>'
            );
            // add new record-------------------------------------------------------------------------------------------------------------
            initOffcanvasForm({
                formId: "form-add-new-record",
                // offcanvasId: "add-new-record",
                triggerSelector: ".create-new",
                fields: {
                    name: {
                        label: "نام نوع کاردانش",
                        required: true,
                        type: "text",
                    },
                },
                onSubmit: function (values) {
                    console.log("Form Data:", values);

                    // اضافه کردن CSRF token
                    values._token = $('meta[name="csrf-token"]').attr(
                        "content"
                    );

                    // ارسال Ajax
                    $.post("/admin2/kardanesh/store", values, function (res) {
                        console.log("Server Response:", res);
                        // offCanvasEl.hide();

                        dt_basic.ajax.reload(); // اگر میخوای جدول بروز بشه
                    });
                },
            });
            // delete one item----------------------------------------------------------------------------------------------------------------
            dt_basic.on("click", ".item-delete", function () {
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
                            url: "/admin2/kardanesh/delete/"+id,
                            type: "DELETE",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr(
                                    "content"
                                ),
                            },
                            success: function (res) {
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
                            error: function (err) {
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
                dt_basic.on("select", function (e, dt, type, indexes) {
                    toggleBulkActions();
                });

                // وقتی رکورد از انتخاب خارج شد
                dt_basic.on("deselect", function (e, dt, type, indexes) {
                    toggleBulkActions();
                });

                // تابع برای نمایش / مخفی کردن باکس عملیات
                function toggleBulkActions() {
                    const selected = dt_basic.rows({ selected: true }).count();
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
                        .rows({ selected: true })
                        .data()
                        .pluck("id")
                        .toArray();
                }

                btnBulk.on("click", function () {
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
                                url: "/admin2/kardanesh/bulk-delete",
                                type: "POST",
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr(
                                        "content"
                                    ),
                                    ids: ids,
                                },
                                success: function (res) {
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
                                error: function (err) {
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
        }
    });

    // تابع جنریک برای ساخت فرم با اعتبارسنجی
    function initOffcanvasForm({ formId, triggerSelector, fields, onSubmit }) {
        let fv, offCanvasEl;

        const formEl = document.getElementById(formId);
        const triggerBtn = document.querySelector(triggerSelector);

        if (!formEl) return;

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
});
