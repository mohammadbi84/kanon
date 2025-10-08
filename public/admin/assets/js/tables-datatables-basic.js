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
            categories = $(".categories"),
            clusters = $(".clusters"),
            fields = $(".fields"),
            professions = $(".professions"),
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
                            url: "/admin2/jobtype/delete/" + id,
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
                            url: "/admin2/kardanesh/delete/" + id,
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
        if (categories.length) {
            dt_basic = categories.DataTable({
                ajax: "/admin2/categories",
                columns: [
                    { data: "", title: "" }, // ستونی که برای responsive استفاده میشه
                    { data: "id", title: "شناسه" },
                    { data: "id", visible: false }, // ستون مخفی برای sort
                    { data: "id", title: "شناسه" },
                    { data: "name", title: "نام رسته" },
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
                                // clusters
                                '<a href="/admin2/clusters?category_id=' +
                                full.id +
                                '"' +
                                'class="btn btn-sm btn-success item-show" ' +
                                'data-id="' +
                                full.id +
                                '">' +
                                "خوشه ها </a> " +
                                // edit
                                '<a href="/admin2/categories/' +
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
                '<h5 class="card-title mb-0">رسته ها</h5>'
            );
            // add new record-------------------------------------------------------------------------------------------------------------
            initOffcanvasForm({
                formId: "form-add-new-record",
                // offcanvasId: "add-new-record",
                triggerSelector: ".create-new",
                fields: {
                    name: {
                        label: "نام رسته",
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
                    $.post("/admin2/categories/store", values, function (res) {
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
                            url: "/admin2/categories/delete/" + id,
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
                                url: "/admin2/categories/bulk-delete",
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
        if (clusters.length) {
            const urlParams = new URLSearchParams(window.location.search);
            const categoryId = urlParams.get("category_id");
            dt_basic = clusters.DataTable({
                ajax: {
                    url: "/admin2/clusters",
                    data: function (d) {
                        if (categoryId) {
                            d.category_id = categoryId; // ارسال category_id به سرور
                        }
                    },
                },
                columns: [
                    { data: "", title: "" }, // ستونی که برای responsive استفاده میشه
                    { data: "id", title: "شناسه" },
                    { data: "id", visible: false }, // ستون مخفی برای sort
                    { data: "id", title: "شناسه" },
                    { data: "name", title: "نام خوشه" },
                    { data: "category.name", title: "رسته مربوطه" },
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
                                // fields
                                '<a href="/admin2/fields?cluster_id=' +
                                full.id +
                                '"' +
                                'class="btn btn-sm btn-success item-show" ' +
                                'data-id="' +
                                full.id +
                                '">' +
                                "رشته ها </a> " +
                                // edit
                                '<a href="/admin2/clusters/' +
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
                '<h5 class="card-title mb-0">خوشه ها</h5>'
            );
            // add new record-------------------------------------------------------------------------------------------------------------
            initOffcanvasForm({
                formId: "form-add-new-record",
                // offcanvasId: "add-new-record",
                triggerSelector: ".create-new",
                fields: categoryId
                    ? {
                          name: {
                              label: "نام خوشه",
                              required: true,
                              type: "text",
                          },
                          category_id: {
                              type: "hidden",
                              value: categoryId, // اگر category_id از URL آمده بود
                          },
                      }
                    : {
                          name: {
                              label: "نام خوشه",
                              required: true,
                              type: "text",
                          },
                          category_id: {
                              label: "انتخاب رسته",
                              required: true,
                              type: "select",
                              options: [], // پر می‌کنیمش با ajax
                          },
                      },
                onSubmit: function (values) {
                    console.log("Form Data:", values);

                    // اضافه کردن CSRF token
                    values._token = $('meta[name="csrf-token"]').attr(
                        "content"
                    );

                    // ارسال Ajax
                    $.post("/admin2/clusters/store", values, function (res) {
                        console.log("Server Response:", res);
                        // offCanvasEl.hide();

                        dt_basic.ajax.reload(); // اگر میخوای جدول بروز بشه
                    });
                },
            });
            if (!categoryId) {
                $.get("/admin2/categories", function (res) {
                    // فرض می‌کنیم کنترلر دسته‌ها JSON برمی‌گردونه (برای ajax)
                    const select = $(
                        "#form-add-new-record select[name='category_id']"
                    );
                    select.empty();
                    res.data.forEach((cat) => {
                        select.append(
                            $("<option>", { value: cat.id, text: cat.name })
                        );
                    });
                });
            }
            if (categoryId) {
                $("div.head-label").html(
                    '<h5 class="card-title mb-0">خوشه‌های رسته شماره ' +
                        categoryId +
                        "</h5>"
                );
            } else {
                $("div.head-label").html(
                    '<h5 class="card-title mb-0">خوشه‌ها</h5>'
                );
            }

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
                            url: "/admin2/clusters/delete/" + id,
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
                                url: "/admin2/clusters/bulk-delete",
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
        if (fields.length) {
            const urlParams = new URLSearchParams(window.location.search);
            const clusterId = urlParams.get("cluster_id");
            dt_basic = fields.DataTable({
                ajax: {
                    url: "/admin2/fields",
                    data: function (d) {
                        if (clusterId) {
                            d.cluster_id = clusterId; // ارسال cluster_id به سرور
                        }
                    },
                },
                columns: [
                    { data: "", title: "" }, // ستونی که برای responsive استفاده میشه
                    { data: "id", title: "شناسه" },
                    { data: "id", visible: false }, // ستون مخفی برای sort
                    { data: "id", title: "شناسه" },
                    { data: "name", title: "نام رشته" },
                    { data: "cluster.name", title: "خوشه مربوطه" },
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
                                // professions
                                '<a href="/admin2/professions?field_id=' +
                                full.id +
                                '"' +
                                'class="btn btn-sm btn-success item-show" ' +
                                'data-id="' +
                                full.id +
                                '">' +
                                "حرفه ها </a> " +
                                // certificates
                                '<a href="/admin2/certificates?field_id=' +
                                full.id +
                                '"' +
                                'class="btn btn-sm btn-success item-show" ' +
                                'data-id="' +
                                full.id +
                                '">' +
                                "سند حرفه ها </a> " +
                                // edit
                                '<a href="/admin2/fields/' +
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
                '<h5 class="card-title mb-0">رشته ها</h5>'
            );
            // add new record-------------------------------------------------------------------------------------------------------------
            initOffcanvasForm({
                formId: "form-add-new-record",
                // offcanvasId: "add-new-record",
                triggerSelector: ".create-new",
                fields: clusterId
                    ? {
                          name: {
                              label: "نام رشته",
                              required: true,
                              type: "text",
                          },
                          cluster_id: {
                              type: "hidden",
                              value: clusterId, // اگر cluster_id از URL آمده بود
                          },
                      }
                    : {
                          name: {
                              label: "نام رشته",
                              required: true,
                              type: "text",
                          },
                          cluster_id: {
                              label: "انتخاب رسته",
                              required: true,
                              type: "select",
                              options: [], // پر می‌کنیمش با ajax
                          },
                      },
                onSubmit: function (values) {
                    console.log("Form Data:", values);

                    // اضافه کردن CSRF token
                    values._token = $('meta[name="csrf-token"]').attr(
                        "content"
                    );

                    // ارسال Ajax
                    $.post("/admin2/fields/store", values, function (res) {
                        console.log("Server Response:", res);
                        // offCanvasEl.hide();

                        dt_basic.ajax.reload(); // اگر میخوای جدول بروز بشه
                    });
                },
            });
            if (!clusterId) {
                $.get("/admin2/clusters", function (res) {
                    // فرض می‌کنیم کنترلر دسته‌ها JSON برمی‌گردونه (برای ajax)
                    const select = $(
                        "#form-add-new-record select[name='cluster_id']"
                    );
                    select.empty();
                    res.data.forEach((cat) => {
                        select.append(
                            $("<option>", { value: cat.id, text: cat.name })
                        );
                    });
                });
            }
            if (clusterId) {
                $("div.head-label").html(
                    '<h5 class="card-title mb-0">رشته‌های خوشه شماره ' +
                        clusterId +
                        "</h5>"
                );
            } else {
                $("div.head-label").html(
                    '<h5 class="card-title mb-0">رشته‌ها</h5>'
                );
            }

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
                            url: "/admin2/fields/delete/" + id,
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
                                url: "/admin2/fields/bulk-delete",
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
        if (professions.length) {
            const urlParams = new URLSearchParams(window.location.search);
            const fieldId = urlParams.get("field_id");
            const fieldName = urlParams.get("field_name");

            dt_basic = professions.DataTable({
                ajax: {
                    url: "/admin2/professions",
                    data: function (d) {
                        if (fieldId) {
                            d.field_id = fieldId; // ارسال فیلد رشته به سرور
                        }
                    },
                },
                columns: [
                    { data: "", title: "" }, // Responsive
                    { data: "id", title: "شناسه" },
                    { data: "id", visible: false },
                    { data: "name", title: "نام حرفه" },
                    { data: "field.name", title: "رشته مربوطه" },
                    { data: "kardanesh.name", title: "کاردانش" },
                    { data: "jobtype.name", title: "نوع شغل" },
                    { data: "", title: "عملیات" },
                ],
                columnDefs: [
                    {
                        className: "control",
                        orderable: false,
                        searchable: false,
                        responsivePriority: 2,
                        targets: 0,
                        render: function () {
                            return "";
                        },
                    },
                    {
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
                        targets: 3,
                    },
                    {
                        targets: -1,
                        title: "عملیات",
                        orderable: false,
                        searchable: false,
                        render: function (data, type, full) {
                            return (
                                // certificates
                                '<a href="/admin2/certificates?profession_id=' +
                                full.id +
                                "&profession_name=" +
                                encodeURIComponent(full.name) +
                                '"' +
                                'class="btn btn-sm btn-success item-show me-1">' +
                                "سند حرفه‌ها</a>" +
                                // edit
                                '<a href="/admin2/professions/' +
                                full.id +
                                '"' +
                                'class="btn btn-sm btn-icon btn-primary item-edit me-1" ' +
                                'data-id="' +
                                full.id +
                                '">' +
                                '<i class="bx bxs-edit"></i></a>' +
                                // delete
                                '<button class="btn btn-sm btn-icon btn-danger item-delete" data-id="' +
                                full.id +
                                '">' +
                                '<i class="bx bxs-trash"></i></button>'
                            );
                        },
                    },
                ],
                order: [[2, "desc"]],
                dom:
                    '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end primary-font pt-3 pt-md-0"B>>' +
                    '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t' +
                    "<'row d-flex align-items-center justify-content-between'<'col-md-4'<'bulk-holder'>><'col-md-8 d-flex justify-content-between'i p>>",
                displayLength: 10,
                lengthMenu: [10, 25, 50, 75, 100],
                buttons: [],
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function (row) {
                                var data = row.data();
                                return "جزئیات " + data["name"];
                            },
                        }),
                        type: "column",
                        renderer: function (api, rowIdx, columns) {
                            var data = $.map(columns, function (col) {
                                return col.title
                                    ? '<tr data-dt-row="' +
                                          col.rowIndex +
                                          '" data-dt-column="' +
                                          col.columnIndex +
                                          '">' +
                                          "<td>" +
                                          col.title +
                                          ":</td><td>" +
                                          col.data +
                                          "</td></tr>"
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
                select: { style: "multi" },
            });

            // انتقال اکشن‌ها
            $("#bulk-actions").appendTo(".bulk-holder");

            // عنوان جدول
            if (fieldId && fieldName) {
                $("div.head-label").html(
                    '<h5 class="card-title mb-0">حرفه‌های رشته ' +
                        fieldName +
                        "</h5>"
                );
            } else if (fieldId) {
                $("div.head-label").html(
                    '<h5 class="card-title mb-0">حرفه‌های رشته شماره ' +
                        fieldId +
                        "</h5>"
                );
            } else {
                $("div.head-label").html(
                    '<h5 class="card-title mb-0">لیست حرفه‌ها</h5>'
                );
            }

            // فرم افزودن حرفه جدید
            initOffcanvasForm({
                formId: "form-add-new-record",
                triggerSelector: ".create-new",
                fields: fieldId
                    ? {
                          name: {
                              label: "نام حرفه",
                              required: true,
                              type: "text",
                          },
                          field_id: {
                              type: "hidden",
                              value: fieldId,
                          },
                          old_standard_code: {
                              label: "کد استاندارد قدیم",
                              type: "text",
                          },
                          new_standard_code: {
                              label: "کد استاندارد جدید",
                              type: "text",
                          },
                          theory_hour: {
                              label: "ساعت نظری",
                              type: "number",
                              min: 0,
                          },
                          theory_minute: {
                              label: "دقیقه نظری",
                              type: "number",
                              min: 0,
                          },
                          practice_hour: {
                              label: "ساعت عملی",
                              type: "number",
                              min: 0,
                          },
                          practice_minute: {
                              label: "دقیقه عملی",
                              type: "number",
                              min: 0,
                          },
                          project_hour: {
                              label: "ساعت پروژه",
                              type: "number",
                              min: 0,
                          },
                          project_minute: {
                              label: "دقیقه پروژه",
                              type: "number",
                              min: 0,
                          },
                          internship_hour: {
                              label: "ساعت کارورزی",
                              type: "number",
                              min: 0,
                          },
                          internship_minute: {
                              label: "دقیقه کارورزی",
                              type: "number",
                              min: 0,
                          },
                          total_hour: {
                              label: "جمع کل ساعت",
                              type: "number",
                              min: 0,
                          },
                          total_minute: {
                              label: "جمع کل دقیقه",
                              type: "number",
                              min: 0,
                          },
                          education_level: {
                              label: "حداقل تحصیلات ورودی",
                              type: "text",
                          },
                          kardanesh_id: {
                              label: "رشته کاردانش",
                              type: "select",
                              options: [], // بعداً با Ajax پر می‌شود
                          },
                          jobtype_id: {
                              label: "نوع شغل",
                              type: "select",
                              options: [], // بعداً با Ajax پر می‌شود
                          },
                          trainer_qualification: {
                              label: "صلاحیت حرفه‌ای مربی",
                              type: "text",
                          },
                          draft_date: {
                              label: "تاریخ تدوین",
                              required: true,
                              type: "date",
                          },
                          image_path: {
                              label: "تصویر حرفه",
                              type: "file",
                              preview: true,
                              previewContainer: "image-preview",
                          },
                          standard_file: {
                              label: "فایل استاندارد",
                              type: "file",
                          },
                      }
                    : {
                          name: {
                              label: "نام حرفه",
                              required: true,
                              type: "text",
                          },
                          field_id: {
                              label: "انتخاب رشته",
                              required: true,
                              type: "select",
                              options: [],
                          },
                          old_standard_code: {
                              label: "کد استاندارد قدیم",
                              type: "text",
                          },
                          new_standard_code: {
                              label: "کد استاندارد جدید",
                              type: "text",
                          },
                          theory_hour: {
                              label: "ساعت نظری",
                              type: "number",
                              min: 0,
                          },
                          theory_minute: {
                              label: "دقیقه نظری",
                              type: "number",
                              min: 0,
                          },
                          practice_hour: {
                              label: "ساعت عملی",
                              type: "number",
                              min: 0,
                          },
                          practice_minute: {
                              label: "دقیقه عملی",
                              type: "number",
                              min: 0,
                          },
                          project_hour: {
                              label: "ساعت پروژه",
                              type: "number",
                              min: 0,
                          },
                          project_minute: {
                              label: "دقیقه پروژه",
                              type: "number",
                              min: 0,
                          },
                          internship_hour: {
                              label: "ساعت کارورزی",
                              type: "number",
                              min: 0,
                          },
                          internship_minute: {
                              label: "دقیقه کارورزی",
                              type: "number",
                              min: 0,
                          },
                          total_hour: {
                              label: "جمع کل ساعت",
                              type: "number",
                              min: 0,
                          },
                          total_minute: {
                              label: "جمع کل دقیقه",
                              type: "number",
                              min: 0,
                          },
                          education_level: {
                              label: "حداقل تحصیلات ورودی",
                              type: "text",
                          },
                          kardanesh_id: {
                              label: "رشته کاردانش",
                              type: "select",
                              options: [],
                          },
                          jobtype_id: {
                              label: "نوع شغل",
                              type: "select",
                              options: [],
                          },
                          trainer_qualification: {
                              label: "صلاحیت حرفه‌ای مربی",
                              type: "text",
                          },
                          draft_date: {
                              label: "تاریخ تدوین",
                              required: true,
                              type: "date",
                          },
                          image_path: {
                              label: "تصویر حرفه",
                              type: "file",
                              preview: true,
                              previewContainer: "image-preview",
                          },
                          standard_file: {
                              label: "فایل استاندارد",
                              type: "file",
                          },
                      },
                onSubmit: function (values) {
                    const formData = new FormData();
                    for (let key in values) {
                        formData.append(key, values[key]);
                    }
                    formData.append(
                        "_token",
                        $('meta[name="csrf-token"]').attr("content")
                    );

                    $.ajax({
                        url: "/admin2/professions/store",
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function () {
                            dt_basic.ajax.reload();
                        },
                    });
                },
            });

            // پر کردن select های مربوطه
            if (!fieldId) {
                $.get("/admin2/fields", function (res) {
                    const select = $(
                        "#form-add-new-record select[name='field_id']"
                    );
                    select.empty();
                    res.data.forEach((field) => {
                        select.append(
                            $("<option>", { value: field.id, text: field.name })
                        );
                    });
                });
            }

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
                            url: "/admin2/fields/delete/" + id,
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
                                url: "/admin2/fields/bulk-delete",
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
    // تابع جنریک برای ساخت فرم با اعتبارسنجی
    function initOffcanvasForm({ formId, triggerSelector, fields, onSubmit }) {
        let fv, offCanvasEl;

        const formEl = document.getElementById(formId);
        const triggerBtn = document.querySelector(triggerSelector);

        if (!formEl) {
            console.error(`Form element with id '${formId}' not found`);
            return;
        }

        // ساخت Ruleهای ولیدیشن داینامیک
        let validationFields = {};

        Object.entries(fields).forEach(([fieldName, fieldOptions]) => {
            validationFields[fieldName] = {
                validators: {},
                ...(fieldOptions.validationOptions || {}),
            };

            // ولیدیشن required
            if (fieldOptions.required) {
                validationFields[fieldName].validators.notEmpty = {
                    message: fieldOptions.label + " الزامی است",
                };
            }

            // ولیدیشن بر اساس type
            switch (fieldOptions.type) {
                case "email":
                    validationFields[fieldName].validators.emailAddress = {
                        message: "لطفا یک ایمیل معتبر وارد کنید",
                    };
                    break;

                case "number":
                    validationFields[fieldName].validators.integer = {
                        message: "لطفا یک عدد معتبر وارد کنید",
                    };

                    if (fieldOptions.min !== undefined) {
                        validationFields[fieldName].validators.greaterThan = {
                            min: fieldOptions.min,
                            message: `مقدار باید بیشتر از ${fieldOptions.min} باشد`,
                        };
                    }

                    if (fieldOptions.max !== undefined) {
                        validationFields[fieldName].validators.lessThan = {
                            max: fieldOptions.max,
                            message: `مقدار باید کمتر از ${fieldOptions.max} باشد`,
                        };
                    }
                    break;

                case "date":
                    validationFields[fieldName].validators.date = {
                        format: "YYYY/MM/DD",
                        message: "تاریخ معتبر نیست",
                    };
                    break;

                case "tel":
                    validationFields[fieldName].validators.stringLength = {
                        min: 11,
                        max: 11,
                        message: "شماره تلفن باید 11 رقم باشد",
                    };
                    validationFields[fieldName].validators.digits = {
                        message: "لطفا فقط عدد وارد کنید",
                    };
                    break;

                case "url":
                    validationFields[fieldName].validators.uri = {
                        message: "لطفا آدرس معتبر وارد کنید",
                    };
                    break;
            }

            // ولیدیشن stringLength اگر مشخص شده
            if (fieldOptions.minLength || fieldOptions.maxLength) {
                validationFields[fieldName].validators.stringLength = {
                    min: fieldOptions.minLength || 0,
                    max: fieldOptions.maxLength || 1000,
                    message: `تعداد کاراکتر باید بین ${
                        fieldOptions.minLength || 0
                    } تا ${fieldOptions.maxLength || 1000} باشد`,
                };
            }

            // ولیدیشن regex اگر مشخص شده
            if (fieldOptions.pattern) {
                validationFields[fieldName].validators.regexp = {
                    regexp: fieldOptions.pattern,
                    message:
                        fieldOptions.patternMessage ||
                        "قالب وارد شده معتبر نیست",
                };
            }

            // مقدار اولیه برای فیلدها
            if (fieldOptions.value !== undefined) {
                const input = formEl.querySelector(`[name="${fieldName}"]`);
                if (input) {
                    input.value = fieldOptions.value;
                }
            }

            // مقداردهی اولیه برای فیلدهای خاص
            initFieldPlugins(fieldName, fieldOptions, formEl);
        });

        // مقداردهی اولیه پلاگین‌ها برای فیلدهای خاص
        function initFieldPlugins(fieldName, fieldOptions, formEl) {
            const input = formEl.querySelector(`[name="${fieldName}"]`);
            if (!input) return;

            switch (fieldOptions.type) {
                case "date":
                    // flatpickr برای تاریخ
                    flatpickr(input, {
                        enableTime: fieldOptions.enableTime || false,
                        locale: "fa",
                        dateFormat: fieldOptions.dateFormat || "Y/m/d",
                        onChange: function () {
                            if (fv) fv.revalidateField(fieldName);
                        },
                        disableMobile: true,
                    });
                    break;

                case "select2":
                    // Select2 برای dropdown
                    $(input)
                        .select2({
                            placeholder:
                                fieldOptions.placeholder || "انتخاب کنید...",
                            allowClear: true,
                            dropdownParent:
                                $(formEl).closest(".offcanvas-body"),
                        })
                        .on("change", function () {
                            if (fv) fv.revalidateField(fieldName);
                        });
                    break;

                case "textarea":
                    // پلاگین برای textarea اگر نیاز باشد
                    if (fieldOptions.autoResize) {
                        input.addEventListener("input", function () {
                            this.style.height = "auto";
                            this.style.height = this.scrollHeight + "px";
                        });
                    }
                    break;

                case "file":
                    // پلاگین برای آپلود فایل
                    if (fieldOptions.preview) {
                        input.addEventListener("change", function (e) {
                            handleFilePreview(e, fieldOptions.previewContainer);
                        });
                    }
                    break;
            }
        }

        // ساخت Validation
        fv = FormValidation.formValidation(formEl, {
            fields: validationFields,
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    rowSelector: ".col-sm-12, .col-sm-6, .col-12",
                }),
                submitButton: new FormValidation.plugins.SubmitButton(),
                autoFocus: new FormValidation.plugins.AutoFocus(),
            },
            init: (instance) => {
                instance.on("plugins.message.placed", function (e) {
                    // مدیریت نمایش خطا برای input-group
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

                    // مدیریت نمایش خطا برای select2
                    if ($(e.element).hasClass("select2-hidden-accessible")) {
                        $(e.element)
                            .closest(".form-select")
                            .insertAdjacentElement(
                                "afterend",
                                e.messageElement
                            );
                    }
                });
            },
        });

        // وقتی فرم معتبر بود
        fv.on("core.form.valid", function () {
            const formData = new FormData(formEl);
            const values = {};

            // جمع‌آوری داده‌ها از FormData
            for (let [key, value] of formData.entries()) {
                if (fields[key] && fields[key].type === "file") {
                    // برای فایل‌ها، خود فایل را نگه می‌داریم
                    values[key] = value;
                } else {
                    values[key] = value;
                }
            }

            // اضافه کردن فیلدهای hidden و مقادیر خاص
            Object.keys(fields).forEach((fieldName) => {
                if (
                    fields[fieldName].type === "hidden" &&
                    fields[fieldName].value !== undefined
                ) {
                    values[fieldName] = fields[fieldName].value;
                }

                // برای select2 مقادیر را از المنت اصلی می‌خوانیم
                if (fields[fieldName].type === "select2") {
                    const select = formEl.querySelector(
                        `[name="${fieldName}"]`
                    );
                    if (select) {
                        values[fieldName] = select.value;
                    }
                }
            });

            if (typeof onSubmit === "function") {
                onSubmit(values, formData);
            }

            // ریست کردن فرم اگر نیاز باشد
            if (fields.resetOnSubmit !== false) {
                fv.resetForm();

                // ریست کردن select2
                Object.keys(fields).forEach((fieldName) => {
                    if (fields[fieldName].type === "select2") {
                        const select = formEl.querySelector(
                            `[name="${fieldName}"]`
                        );
                        if (select) {
                            $(select).val(null).trigger("change");
                        }
                    }
                });
            }
        });

        // مدیریت رویدادهای trigger
        if (triggerBtn) {
            triggerBtn.addEventListener("click", function () {
                // ریست کردن فرم هنگام باز کردن
                fv.resetForm();

                // مقداردهی اولیه فیلدها
                Object.entries(fields).forEach(([fieldName, fieldOptions]) => {
                    if (fieldOptions.value !== undefined) {
                        const input = formEl.querySelector(
                            `[name="${fieldName}"]`
                        );
                        if (input) {
                            input.value = fieldOptions.value;

                            // برای select2
                            if (fieldOptions.type === "select2") {
                                $(input)
                                    .val(fieldOptions.value)
                                    .trigger("change");
                            }
                        }
                    }
                });
            });
        }

        return {
            formValidation: fv,
            resetForm: () => fv.resetForm(),
            revalidateField: (fieldName) => fv.revalidateField(fieldName),
        };
    }

    // تابع کمکی برای پیش‌نمایش فایل
    function handleFilePreview(event, previewContainerId) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById(previewContainerId);

        if (!file || !previewContainer) return;

        if (file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewContainer.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-height: 200px;">`;
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.innerHTML = `<div class="alert alert-info">فایل انتخاب شده: ${file.name}</div>`;
        }
    }
});
