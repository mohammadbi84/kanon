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
            articles = $(".articles"),
            bookmark = $(".bookmark"),
            professions = $(".professions"),
            tuitions = $(".tuitions"),
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
                                      data,
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
                '<h5 class="card-title mb-0">نوع شغل ها</h5>',
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
                        "content",
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
                                    "content",
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
                                        "content",
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
                                      data,
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
                '<h5 class="card-title mb-0">نوع کاردانش ها</h5>',
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
                        "content",
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
                                    "content",
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
                                        "content",
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
                                      data,
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
                '<h5 class="card-title mb-0">رسته ها</h5>',
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
                        "content",
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
                                    "content",
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
                                        "content",
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
                                      data,
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
                '<h5 class="card-title mb-0">خوشه ها</h5>',
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
                        "content",
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
                        "#form-add-new-record select[name='category_id']",
                    );
                    select.empty();
                    res.data.forEach((cat) => {
                        select.append(
                            $("<option>", { value: cat.id, text: cat.name }),
                        );
                    });
                });
            }
            if (categoryId) {
                $("div.head-label").html(
                    '<h5 class="card-title mb-0">خوشه‌های رسته شماره ' +
                        categoryId +
                        "</h5>",
                );
            } else {
                $("div.head-label").html(
                    '<h5 class="card-title mb-0">خوشه‌ها</h5>',
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
                                    "content",
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
                                        "content",
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
                                      data,
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
                '<h5 class="card-title mb-0">رشته ها</h5>',
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
                        "content",
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
                        "#form-add-new-record select[name='cluster_id']",
                    );
                    select.empty();
                    res.data.forEach((cat) => {
                        select.append(
                            $("<option>", { value: cat.id, text: cat.name }),
                        );
                    });
                });
            }
            if (clusterId) {
                $("div.head-label").html(
                    '<h5 class="card-title mb-0">رشته‌های خوشه شماره ' +
                        clusterId +
                        "</h5>",
                );
            } else {
                $("div.head-label").html(
                    '<h5 class="card-title mb-0">رشته‌ها</h5>',
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
                                    "content",
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
                                        "content",
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
                    {
                        data: "kardanesh.name",
                        title: "کاردانش",
                        render: function (data, type, row) {
                            return row.kardanesh ? row.kardanesh.name : "-";
                        },
                    },
                    {
                        data: "jobtype.name",
                        title: "نوع شغل",
                        render: function (data, type, row) {
                            return row.jobtype ? row.jobtype.name : "-";
                        },
                    },
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
                                // دکمه جزئیات
                                '<button class="btn btn-sm btn-info item-details" data-item=\'' +
                                JSON.stringify(full) +
                                '\'><i class="bx bx-info-circle"></i> جزئیات</button> ' +
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
                                      data,
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
                        "</h5>",
                );
            } else if (fieldId) {
                $("div.head-label").html(
                    '<h5 class="card-title mb-0">حرفه‌های رشته شماره ' +
                        fieldId +
                        "</h5>",
                );
            } else {
                $("div.head-label").html(
                    '<h5 class="card-title mb-0">لیست حرفه‌ها</h5>',
                );
            }
            // عنوان جدول
            if (fieldId && fieldName) {
                $("div.header-label").html(
                    '<h5 class="card-title mb-0">حرفه‌های رشته ' +
                        fieldName +
                        "</h5>" +
                        `<button type="button" class="btn btn-success" id="submit-profession-form">
                            <i class="bx bx-save"></i>
                            ثبت اطلاعات
                        </button>`,
                );
            } else if (fieldId) {
                $("div.header-label").html(
                    '<h5 class="card-title mb-0">حرفه‌های رشته شماره ' +
                        fieldId +
                        "</h5>" +
                        `<button type="button" class="btn btn-success" id="submit-profession-form">
                            <i class="bx bx-save"></i>
                            ثبت اطلاعات
                        </button>`,
                );
            } else {
                $("div.header-label").html(
                    '<h5 class="card-title mb-0">لیست حرفه‌ها</h5>' +
                        `<button type="button" class="btn btn-success" id="submit-profession-form">
                        <i class="bx bx-save"></i>
                        ثبت اطلاعات
                    </button>`,
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
                        $('meta[name="csrf-token"]').attr("content"),
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

            const submitButton = document.getElementById(
                "submit-profession-form",
            );
            const submitBtn = document.getElementById("form-submit-btn");
            if (submitButton && submitBtn) {
                submitButton.addEventListener("click", function () {
                    // در غیر اینصورت مستقیم submit کن
                    submitBtn.click();
                });
            }

            // پر کردن select های مربوطه
            if (!fieldId) {
                $.get("/admin2/fields", function (res) {
                    const select = $(
                        "#form-add-new-record select[name='field_id']",
                    );
                    select.empty();
                    res.data.forEach((field) => {
                        select.append(
                            $("<option>", {
                                value: field.id,
                                text: field.name,
                            }),
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
                            url: "/admin2/professions/delete/" + id,
                            type: "DELETE",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr(
                                    "content",
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
                                url: "/admin2/professions/bulk-delete",
                                type: "POST",
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr(
                                        "content",
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

            // وقتی روی دکمه جزئیات کلیک شد
            $(document).on("click", ".item-details", function () {
                const item = $(this).data("item"); // اطلاعات همون ردیف

                // اگه دیتای jQuery به صورت رشته ذخیره شده باشه، باید parse کنیم:
                const data = typeof item === "string" ? JSON.parse(item) : item;

                let html = `
                    <div class="col-md-6">
                        <div class="demo-inline-spacing mt-3">
                            <ul class="list-group">
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">نام حرفه : </strong> ${
                                    data.name
                                }
                              </li>
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">رشته مربوطه: </strong> ${
                                    data.field ? data.field.name : "-"
                                }
                              </li>
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">تاریخ تدوین: </strong> ${
                                    data.draft_date
                                        ? new Date(
                                              data.draft_date,
                                          ).toLocaleDateString("fa-IR")
                                        : "-"
                                }
                              </li>
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">کاردانش: </strong> ${
                                    data.kardanesh ? data.kardanesh.name : "-"
                                }
                              </li>
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">نوع شغل: </strong> ${
                                    data.jobtype ? data.jobtype.name : "-"
                                }
                              </li>
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">کد استاندارد جدید: </strong> ${
                                    data.new_standard_code ?? "-"
                                }
                              </li>
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">کد استاندارد قدیم: </strong> ${
                                    data.old_standard_code ?? "-"
                                }
                              </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="demo-inline-spacing mt-3">
                            <ul class="list-group">
                                <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">تحصیلات مورد نیاز: </strong> ${
                                    data.education_level ?? "-"
                                }
                              </li>
                               <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">صلاحیت مربی: </strong> ${
                                    data.trainer_qualification ?? "-"
                                }
                              </li>
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">زمان نظری: </strong> ${
                                    data.theory_hour
                                } ساعت و ${data.theory_minute} دقیقه
                              </li>
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">زمان عملی: </strong> ${
                                    data.practice_hour
                                } ساعت و ${data.practice_minute} دقیقه
                              </li>
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">زمان پروژه: </strong> ${
                                    data.project_hour
                                } ساعت و ${data.project_minute} دقیقه
                              </li>
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">زمان کارورزی:</strong> ${
                                    data.internship_hour
                                } ساعت و ${data.internship_minute} دقیقه
                              </li>
                              <li class="list-group-item d-flex align-items-center">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong class="me-2">جمع کل: </strong> ${
                                    data.total_hour
                                } ساعت و ${data.total_minute} دقیقه
                              </li>
                            </ul>
                        </div>
                    </div>
                    ${
                        data.image_path
                            ? `<div class="col-md-6"><strong>تصویر:</strong><br><img src="/${data.image_path}" class="img-fluid rounded mt-2" style="max-width: 200px;"></div>`
                            : ""
                    }
                    ${
                        data.standard_file
                            ? `<div class="col-md-6"><strong>فایل استاندارد:</strong><br><a href="/${data.standard_file}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">دانلود فایل</a></div>`
                            : ""
                    }
                `;

                $("#profession-details-content").html(html);
                $("#professionDetailsModal").modal("show");
            });
        }
        if (tuitions.length) {
            dt_basic = tuitions.DataTable({
                ajax: "/admin2/tuitions",
                columns: [
                    { data: "", title: "" },
                    { data: "id", title: "شناسه" },
                    { data: "id", visible: false },
                    { data: "title", title: "عنوان شهریه" },
                    { data: "city.title", title: "شهر" },
                    { data: "start_date", title: "شروع" },
                    { data: "end_date", title: "پایان" },
                    { data: "", title: "عملیات" },
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
                            return `
                            <a href="/admin2/tuitions/${full.id}/professions" class="btn btn-sm btn-info item-details">
                                <i class="bx bx-show"></i>
                                حرفه‌ها
                            </a>
                        <button class="btn btn-sm btn-warning show-certificates">
                            سند حرفه‌ها
                        </button>
                        <a href="/admin2/tuitions/${full.id}/edit" class="btn btn-sm btn-primary"><i class="bx bxs-edit"></i></a>
                        <button class="btn btn-sm btn-danger item-delete" data-id="${full.id}"><i class="bx bxs-trash"></i></button>
                    `;
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
                                      data,
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
                '<h5 class="card-title mb-0">شهریه ها</h5>',
            );
            // add new record-------------------------------------------------------------------------------------------------------------
            // فرم افزودن شهریه جدید
            initOffcanvasForm({
                formId: "form-add-new-record",
                triggerSelector: ".create-new",
                fields: {
                    title: {
                        label: "عنوان شهریه",
                        required: true,
                        type: "text",
                    },
                    city_id: {
                        label: "شهر",
                        required: true,
                        type: "select",
                        options: [], // بعداً با AJAX پر میشه
                    },
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
                },
                onSubmit: function (values) {
                    // تبدیل داده‌ها از رشته به تاریخ برای بررسی
                    const startDate = new Date(values.start_date);
                    const endDate = new Date(values.end_date);

                    // بررسی معتبر بودن تاریخ‌ها
                    if (
                        isNaN(startDate.getTime()) ||
                        isNaN(endDate.getTime())
                    ) {
                        alert(
                            "لطفاً تاریخ شروع و پایان را به درستی وارد کنید.",
                        );
                        return;
                    }

                    // بررسی اینکه تاریخ پایان بعد از شروع باشد
                    if (endDate <= startDate) {
                        alert("تاریخ پایان باید بعد از تاریخ شروع باشد.");
                        return;
                    }

                    // اضافه کردن CSRF token
                    values._token = $('meta[name="csrf-token"]').attr(
                        "content",
                    );

                    // ارسال Ajax
                    $.post("/admin2/tuitions/store", values, function (res) {
                        if (res.success) {
                            dt_basic.ajax.reload();
                        } else {
                        }
                    }).fail(function (xhr) {
                        console.error(xhr.responseText);
                    });
                },
            });

            // گرفتن لیست شهرها برای select
            $.get("/admin2/cities", function (res) {
                const citySelect = $(
                    "#form-add-new-record select[name='city_id']",
                );
                citySelect.empty();
                citySelect.append(
                    '<option value="" disabled selected>انتخاب کنید...</option>',
                );
                res.data.forEach((city) => {
                    citySelect.append(
                        $("<option>", {
                            value: city.id,
                            text: city.title,
                        }),
                    );
                });
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
                            url: "/admin2/tuitions/delete/" + id,
                            type: "DELETE",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr(
                                    "content",
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
                                url: "/admin2/tuitions/bulk-delete",
                                type: "POST",
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr(
                                        "content",
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
        if (articles.length) {
            // add new record-------------------------------------------------------------------------------------------------------------
            initOffcanvasForm({
                formId: "form-add-new-record",
                // offcanvasId: "add-new-record",
                triggerSelector: ".create-new",
                fields: {
                    title: {
                        label: "عنوان صفحه",
                        required: true,
                        type: "text",
                    },
                    body: {
                        label: "محتوای صفحه",
                        required: true,
                        type: "text",
                    },
                },
                onSubmit: function (values) {
                    // console.log("Form Data:", values);

                    // اضافه کردن CSRF token
                    values._token = $('meta[name="csrf-token"]').attr(
                        "content",
                    );

                    // ارسال Ajax
                    $.post("/admin2/articles/store", values, function (res) {
                        // console.log("Server Response:", res);
                        // offCanvasEl.hide();
                        Swal.fire({
                            icon: "success",
                            title: "موفق!",
                            text: res.success,
                            timer: 1500,
                            showConfirmButton: false,
                        });

                        dt_basic.ajax.reload(); // اگر میخوای جدول بروز بشه
                    });
                },
            });
        }
        if (bookmark.length) {
            // add new record-------------------------------------------------------------------------------------------------------------
            initOffcanvasForm({
                formId: "form-add-new-record",
                // offcanvasId: "add-new-record",
                triggerSelector: ".create-new",
                fields: {
                    title: {
                        label: "عنوان صفحه",
                        required: true,
                        type: "text",
                    },
                    body: {
                        label: "محتوای صفحه",
                        required: true,
                        type: "text",
                    },
                    start_at: {
                        label: "تاریخ شروع",
                        required: false,
                        type: "date",
                    },
                    end_at: {
                        label: "تاریخ پایان",
                        required: false,
                        type: "date",
                    },
                    active: {
                        label: "وضعیت",
                        required: true,
                        type: "select",
                    },
                    duration: {
                        label: "تایمر",
                        required: false,
                        type: "number",
                    },
                },
                onSubmit: function (values) {
                    // console.log("Form Data:", values);

                    // اضافه کردن CSRF token
                    values._token = $('meta[name="csrf-token"]').attr(
                        "content",
                    );

                    // ارسال Ajax
                    $.post("/admin2/bookmark/store", values, function (res) {
                        // console.log("Server Response:", res);
                        // offCanvasEl.hide();
                        Swal.fire({
                            icon: "success",
                            title: "موفق!",
                            text: res.success,
                            timer: 1500,
                            showConfirmButton: false,
                        });

                        dt_basic.ajax.reload(); // اگر میخوای جدول بروز بشه
                    });
                },
            });
        }
    });

    // تابع جنریک برای ساخت فرم با اعتبارسنجی
    function initOffcanvasForm({
        formId,
        triggerSelector,
        fields,
        onSubmit,
        resetOnSubmit = true,
    }) {
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
        // در بخش initFieldPlugins، برای فیلدهای عددی که دقیقه هستند بررسی اضافه کنید
        function initFieldPlugins(fieldName, fieldOptions, formEl) {
            const input = formEl.querySelector(`[name="${fieldName}"]`);
            if (!input) return;

            switch (fieldOptions.type) {
                case "date":
                    // ایجاد یک فیلد مخفی برای ذخیره تاریخ میلادی
                    const hiddenInput = document.createElement("input");
                    hiddenInput.type = "hidden";
                    hiddenInput.name = fieldName + "_miladi";
                    hiddenInput.id = fieldName + "_miladi";
                    input.parentNode.appendChild(hiddenInput);

                    // flatpickr برای تاریخ - با ذخیره میلادی
                    flatpickr(input, {
                        enableTime: fieldOptions.enableTime || false,
                        locale: "fa",
                        dateFormat: "Y/m/d", // فرمت نمایش شمسی
                        altFormat: "Y-m-d", // فرمت میلادی
                        altInput: true, // استفاده از input مخفی
                        altInputClass: "form-control miladi-date-hidden", // کلاس برای استایل
                        onChange: function (selectedDates, dateStr, instance) {
                            if (fv) fv.revalidateField(fieldName);

                            // ذخیره تاریخ میلادی در فیلد مخفی
                            if (selectedDates[0]) {
                                const miladiDate = selectedDates[0]
                                    .toISOString()
                                    .split("T")[0];
                                hiddenInput.value = miladiDate;
                                input.setAttribute(
                                    "data-miladi-date",
                                    miladiDate,
                                );
                            } else {
                                hiddenInput.value = "";
                                input.removeAttribute("data-miladi-date");
                            }
                        },
                        onReady: function (selectedDates, dateStr, instance) {
                            // مقداردهی اولیه فیلد مخفی
                            if (selectedDates[0]) {
                                const miladiDate = selectedDates[0]
                                    .toISOString()
                                    .split("T")[0];
                                hiddenInput.value = miladiDate;
                                input.setAttribute(
                                    "data-miladi-date",
                                    miladiDate,
                                );
                            }
                        },
                        disableMobile: true,
                    });
                    break;

                case "number":
                    // اگر فیلد دقیقه است (نام فیلد شامل minute باشد)
                    if (fieldName.includes("minute") || fieldOptions.isMinute) {
                        // محدودیت مستقیم روی input
                        input.addEventListener("input", function (e) {
                            let value = parseInt(e.target.value) || 0;

                            // اگر مقدار بیشتر از 59 بود، آن را به 59 محدود کن
                            if (value > 59) {
                                e.target.value = 59;
                            }

                            // اگر مقدار منفی بود، آن را به 0 محدود کن
                            if (value < 0) {
                                e.target.value = 0;
                            }
                        });

                        // همچنین برای event change
                        input.addEventListener("change", function (e) {
                            let value = parseInt(e.target.value) || 0;

                            if (value > 59) {
                                e.target.value = 59;
                            }

                            if (value < 0) {
                                e.target.value = 0;
                            }
                        });

                        // محدودیت برای کلیدهای صفحه کلید
                        input.addEventListener("keydown", function (e) {
                            // اجازه دادن فقط به کلیدهای عددی و کنترل
                            if (
                                !/^[0-9]$/.test(e.key) &&
                                ![
                                    "Backspace",
                                    "Delete",
                                    "ArrowLeft",
                                    "ArrowRight",
                                    "Tab",
                                ].includes(e.key)
                            ) {
                                e.preventDefault();
                            }
                        });
                    }
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

        // تابع برای ریست کردن کامل فرم
        function resetFormCompletely() {
            // ریست کردن اعتبارسنجی
            fv.resetForm();

            // ریست کردن تمام فیلدهای input
            const inputs = formEl.querySelectorAll(
                'input:not([type="hidden"]), textarea, select',
            );
            inputs.forEach((input) => {
                switch (input.type) {
                    case "text":
                    case "email":
                    case "tel":
                    case "url":
                    case "number":
                    case "password":
                    case "date":
                        input.value = "";
                        break;
                    case "checkbox":
                    case "radio":
                        input.checked = false;
                        break;
                    case "file":
                        input.value = "";
                        // حذف پیش‌نمایش فایل
                        const previewContainer = input
                            .closest(".col-sm-6")
                            ?.querySelector("#image-preview");
                        if (previewContainer) {
                            previewContainer.innerHTML = "";
                        }
                        break;
                }
            });

            // ریست کردن select2
            const select2Inputs = formEl.querySelectorAll("select.select2");
            select2Inputs.forEach((select) => {
                $(select).val(null).trigger("change");
            });

            // ریست کردن textarea
            const textareas = formEl.querySelectorAll("textarea");
            textareas.forEach((textarea) => {
                textarea.value = "";
                if (textarea.style.height !== "auto") {
                    textarea.style.height = "auto";
                }
            });

            // ریست کردن flatpickr
            const dateInputs = formEl.querySelectorAll("[data-fp]");
            dateInputs.forEach((dateInput) => {
                if (dateInput._flatpickr) {
                    dateInput._flatpickr.clear();
                }
            });

            console.log("فرم با موفقیت ریست شد");
        }

        // ساخت Validation
        fv = FormValidation.formValidation(formEl, {
            fields: validationFields,
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    rowSelector:
                        ".col-sm-12, .col-sm-6, .col-sm-3, .col-12, col-md-6, form-group",
                }),
                submitButton: new FormValidation.plugins.SubmitButton(),
                autoFocus: new FormValidation.plugins.AutoFocus(),
            },
            init: (instance) => {
                instance.on("plugins.message.placed", function (e) {
                    const parent = e.element.closest(
                        ".input-group, .fv-row, .form-group",
                    );
                    if (parent) {
                        parent.insertAdjacentElement(
                            "afterend",
                            e.messageElement,
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
                        `[name="${fieldName}"]`,
                    );
                    if (select) {
                        values[fieldName] = select.value;
                    }
                }
            });

            // فراخوانی تابع onSubmit
            if (typeof onSubmit === "function") {
                // استفاده از Promise برای اطمینان از اتمام عملیات قبل از ریست
                Promise.resolve(onSubmit(values, formData))
                    .then(() => {
                        // ریست کردن فرم بعد از موفقیت آمیز بودن عملیات
                        if (resetOnSubmit) {
                            setTimeout(() => {
                                resetFormCompletely();
                            }, 100);
                        }
                    })
                    .catch((error) => {
                        console.error("خطا در اجرای onSubmit:", error);
                        // در صورت خطا فرم ریست نمی‌شود
                    });
            } else {
                // اگر تابع onSubmit تعریف نشده، فقط فرم ریست شود
                if (resetOnSubmit) {
                    setTimeout(() => {
                        resetFormCompletely();
                    }, 100);
                }
            }
        });

        // مدیریت رویدادهای trigger
        if (triggerBtn) {
            triggerBtn.addEventListener("click", function () {
                // ریست کردن فرم هنگام باز کردن
                resetFormCompletely();

                // مقداردهی اولیه فیلدها در صورت نیاز
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
                        case "number":
                            validationFields[fieldName].validators.integer = {
                                message: "لطفا یک عدد معتبر وارد کنید",
                            };

                            // اگر فیلد دقیقه است
                            if (
                                fieldName.includes("minute") ||
                                fieldOptions.isMinute
                            ) {
                                validationFields[fieldName].validators.between =
                                    {
                                        min: 0,
                                        max: 59,
                                        message: "دقیقه باید بین 0 تا 59 باشد",
                                    };
                            }

                            if (fieldOptions.min !== undefined) {
                                validationFields[
                                    fieldName
                                ].validators.greaterThan = {
                                    min: fieldOptions.min,
                                    message: `مقدار باید بیشتر از ${fieldOptions.min} باشد`,
                                };
                            }

                            if (fieldOptions.max !== undefined) {
                                validationFields[
                                    fieldName
                                ].validators.lessThan = {
                                    max: fieldOptions.max,
                                    message: `مقدار باید کمتر از ${fieldOptions.max} باشد`,
                                };
                            }
                            break;

                        // ... بقیه case ها
                    }
                });
            });
        }

        return {
            formValidation: fv,
            resetForm: resetFormCompletely,
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
