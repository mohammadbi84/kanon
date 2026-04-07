
// مقداردهی اولیه برای بررسی محتوای از پیش پر شده
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("input, textarea").forEach(function (element) {
        // اگر مقدار اولیه داشت، کلاس filled اضافه کن
        if (element.value.trim() !== "") {
            element.parentElement.classList.add("filled");
        }

        // گوش دادن به رویداد input (بدون jQuery)
        element.addEventListener("input", function (e) {
            const parent = e.target.parentElement;

            if (e.target.value.trim() !== "") {
                parent.classList.add("filled");
            } else {
                parent.classList.remove("filled");
            }
        });
    });
});
