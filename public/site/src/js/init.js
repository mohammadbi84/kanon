function initEventsSlider(intervalMs = -1) {
    // add more fake items
    // const sliderItem = document.querySelector("#events-slider .splide__slide");
    // for (let i = 0, max = 5; i < max; i++) {
    //     sliderItem.querySelector(".text-title-3").textContent = (
    //         i + 1
    //     ).toString();
    //     sliderItem.parentNode.appendChild(sliderItem.cloneNode(true));
    // }
    // sliderItem.remove();

    // make slider & related items ltr
    document.querySelector(
        "#events-slider .section-title-container .section-options"
    ).style.direction = "ltr";
    document.querySelector("#events-slider .splide__track").style.direction =
        "ltr";
    document.querySelector(
        "#events-slider .splide__pagination"
    ).style.direction = "ltr";

    const perPage = 5;

    const slider = new Splide("#events-slider", {
        // type: 'loop', // to not clone slides

        autoplay: "pause",
        intersection: {
            // autoplay only when slider is in viewport
            inView: {
                autoplay: intervalMs > 0,
            },
            outView: {
                autoplay: false,
            },
        },
        interval: 5000,
        pauseOnHover: false,

        perPage: perPage,
        rewind: true,
        focus: 0,
        perMove: 1,
        arrows: false,
        gap: "1.3rem",
        padding: "0.5rem",
        direction: "ltr",
        paginationDirection: "ltr",
    });


    // resume autoplay after click on pagination buttons
    slider.on("pagination:mounted", function (data) {
        // `items` contains all dot items
        data.items.forEach(function (item) {
            item.button.addEventListener("click", function (event) {
                slider.Components.Autoplay.play();
            });
        });
    });

    slider.mount(window.splide.Extensions);

    document
        .querySelector("#events-slider .nav-btn.next")
        .addEventListener("click", function (e) {
            const ctrl = slider.Components.Controller;
            const slides = slider.Components.Slides;

            let toSlide = ctrl.getIndex() + perPage;
            let slidesCount = slides.getLength(true); // exclude clone slides
            ctrl.go(Math.min(slidesCount, toSlide));
        });
    document
        .querySelector("#events-slider .nav-btn.prev")
        .addEventListener("click", function (e) {
            const ctrl = slider.Components.Controller;
            const slides = slider.Components.Slides;

            let toSlide = ctrl.getIndex() - perPage;
            let slidesCount = slides.getLength(true); // exclude clone slides
            ctrl.go(Math.max(0, toSlide));
        });

    return slider;
}
// function initAnnos() {
//     const annoItem = document.querySelector("#annos .col-md-6")
//     for (let i = 0, max = 4; i < max - 1; i++) {
//         annoItem.parentNode.appendChild(annoItem.cloneNode(true))
//     }
// }

// function initAdvantages() {
//     const advantageItem = document.querySelector("#advantages .col-md-4")
//     for (let i = 0, max = 6; i < max - 1; i++) {
//         advantageItem.parentNode.appendChild(advantageItem.cloneNode(true))
//     }
// }

function initSpecialOffersSlider(intervalMs = -1) {
    const advantageItem = document.querySelector(
        "#special-offers .splide__slide"
    );
    // for (let i = 0, max = 6; i < max - 1; i++) {
    //     advantageItem.parentNode.appendChild(advantageItem.cloneNode(true));
    // }

    const slider = new Splide("#special-offers", {
        type: "loop",

        autoplay: "pause",
        intersection: {
            // autoplay only when slider is in viewport
            inView: {
                autoplay: intervalMs > 0,
            },
            outView: {
                autoplay: false,
            },
        },
        interval: intervalMs,
        pauseOnHover: false,

        perPage: 1,
        rewind: false,
        focus: 0,
        perMove: 1,
        arrows: false,
        // gap: "60px",
        direction: "ltr",
        paginationDirection: "ltr",
    });

    // resume autoplay after click on pagination buttons
    slider.on("pagination:mounted", function (data) {
        // `items` contains all dot items
        data.items.forEach(function (item) {
            item.button.addEventListener("click", function (event) {
                slider.Components.Autoplay.play();
            });
        });
    });

    slider.mount(window.splide.Extensions);

    return slider;
}

// function initCourses() {
//     const courseItem = document.querySelector("#courses .col-md-6")
//     for (let i = 0, max = 4; i < max - 1; i++) {
//         courseItem.parentNode.appendChild(courseItem.cloneNode(true))
//     }
// }

// function initHotAnnosSwitch() {
//     const hotAnnos = document.querySelector("#annos #hot-annos");
//     hotAnnos.addEventListener("change", function () {
//         alert(`hot annos: ${hotAnnos.checked}`);
//     });
// }

window.addEventListener("DOMContentLoaded", function () {
    initEventsSlider(2000);
    // initAnnos();
    // initAdvantages();
    initSpecialOffersSlider(4000);
    // initCourses();
    // initHotAnnosSwitch();
    document.querySelector("#btn-news").addEventListener("click", function (e) {
        e.preventDefault();
        openOverlay(".overlay-container");
    });
});
