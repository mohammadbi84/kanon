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
                    fieldOptions.patternMessage || "قالب وارد شده معتبر نیست",
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
                            input.setAttribute("data-miladi-date", miladiDate);
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
                            input.setAttribute("data-miladi-date", miladiDate);
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
                        dropdownParent: $(formEl).closest(".offcanvas-body"),
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
                    parent.insertAdjacentElement("afterend", e.messageElement);
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
                const select = formEl.querySelector(`[name="${fieldName}"]`);
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
                            validationFields[fieldName].validators.between = {
                                min: 0,
                                max: 59,
                                message: "دقیقه باید بین 0 تا 59 باشد",
                            };
                        }

                        if (fieldOptions.min !== undefined) {
                            validationFields[fieldName].validators.greaterThan =
                                {
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
