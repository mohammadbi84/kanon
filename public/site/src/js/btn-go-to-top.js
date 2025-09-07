// function initBtnGoToTop() {
//     const btnGoToTop = document.querySelector('#btn-go-to-top');
//     const btnGoToTopCircle = document.querySelector('#btn-go-to-top svg .outer_circle');
//     const scrollOffset = 200

//     if (btnGoToTop) {
//         window.addEventListener("scroll", function () {
//             if (document.body.scrollTop > scrollOffset // For Safari
//                 || document.documentElement.scrollTop > scrollOffset // For Chrome, Firefox, IE and Opera
//             ) {
//                 btnGoToTop.classList.add('show');
//             } else {
//                 btnGoToTop.classList.remove('show');
//             }

//             const scrollPercent = getScrollPercent(scrollOffset)
//             console.log(scrollPercent)

//             btnGoToTopCircle.style.strokeDashoffset =
//                 410 // minimum stroke-dashoffset (no stroke)
//                 - (scrollPercent * 410 / 100)
//         })
//     }
// }

// window.addEventListener("DOMContentLoaded", function () {
//     initBtnGoToTop()
// })

function initBtnGoToTop() {
    const btnGoToTop = document.querySelector("#btn-go-to-top");
    const btnGoToTopCircle = document.querySelector(
        "#btn-go-to-top svg .outer_circle"
    );
    const scrollOffset = 200;

    if (btnGoToTop) {
        window.addEventListener("scroll", function () {
            const scrollTop =
                document.documentElement.scrollTop || document.body.scrollTop;
            const windowHeight = window.innerHeight;
            const docHeight = document.documentElement.scrollHeight;

            // نمایش دکمه
            if (scrollTop > scrollOffset) {
                btnGoToTop.classList.add("show");
            } else {
                btnGoToTop.classList.remove("show");
            }

            // درصد پیشرفت اسکرول
            const scrollPercent = getScrollPercent(scrollOffset);
            btnGoToTopCircle.style.strokeDashoffset =
                410 - (scrollPercent * 410) / 100;

            // اگر به انتهای صفحه رسیدی → فاصله‌ی بیشتر بگیره
            if (scrollTop + windowHeight >= docHeight - 20) {
                btnGoToTop.classList.add("at-bottom");
            } else {
                btnGoToTop.classList.remove("at-bottom");
            }
        });
    }
}

window.addEventListener("DOMContentLoaded", function () {
    initBtnGoToTop();
});
