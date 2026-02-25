document.addEventListener("DOMContentLoaded", function () {
    const slider = tns({
        container: ".top-slider",
        items: 1,
        slideBy: "page",
        loop: true,
        controls: false,
        autoplay: false, // ما خودمون تایمر می‌ذاریم
        autoplayButtonOutput: false,
        nav: false,
        speed: 500,
    });

    const slides = document.querySelectorAll(".top-slider .item");
    const thumbs = document.querySelectorAll(".thumb-item");
    const videos = document.querySelectorAll(".top-slider video");
    const thumbsContainerMain = document.querySelector(".top-slider-thumbs");
    const thumbsContainer = document.querySelector(".top-slider-thumbs-body");

    let timeoutId = null;
    let activeVideo = null;

    function playNextSlide() {
        if (activeVideo) return; // اگه ویدیو پخش میشه، هیچ کاری نکن
        const info = slider.getInfo();
        const currentSlide = slides[info.index % slides.length];
        const duration = parseInt(currentSlide.dataset.duration) || 5000;
        timeoutId = setTimeout(() => slider.goTo("next"), duration);
    }

    function updateActiveThumb(index) {
        thumbs.forEach((t, i) => t.classList.toggle("active", i === index));
        // اسکرول خودکار برای اینکه اسلاید فعال دیده بشه
        const activeThumb = thumbs[index];
        if (activeThumb) {
            thumbsContainer.scrollTo({
                top:
                    activeThumb.offsetTop -
                    thumbsContainer.clientHeight / 2 +
                    activeThumb.clientHeight / 2 +
                    10,
                behavior: "smooth",
            });
        }
    }

    // کلیک روی thumbnail
    thumbs.forEach((t) => {
        t.addEventListener("click", () => {
            clearTimeout(timeoutId);
            slider.goTo(t.dataset.index);
        });
    });

    const videoContainers = document.querySelectorAll(
        ".video-full-container-slider",
    );

    videoContainers.forEach((container) => {
        const video = container.querySelector(".slider-video");
        const playBtn = container.querySelector(".play-pause-btn");
        const icon = playBtn.querySelector("i");

        function toggleVideo() {
            if (video.paused) {
                // اگر ویدیوی دیگه‌ای در حال پخشه، ببندش
                if (activeVideo && activeVideo !== video) {
                    activeVideo.pause();
                }

                clearTimeout(timeoutId);
                video.play();
                playBtn.classList.remove("d-flex");
                icon.classList.remove("fa-play");
                icon.classList.add("fa-pause");
                container.classList.add("playing");

                thumbsContainerMain.classList.add("d-none");

                activeVideo = video;
            } else {
                video.pause();
                icon.classList.remove("fa-pause");
                icon.classList.add("fa-play");
                playBtn.classList.add("d-flex");
                container.classList.remove("playing");
                thumbsContainerMain.classList.remove("d-none");
                activeVideo = null;
                playNextSlide();
            }
        }

        playBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            toggleVideo();
        });
        video.addEventListener("click", (e) => {
            e.stopPropagation();
            toggleVideo();
        });

        container
            .querySelector(".video-overlay")
            .addEventListener("click", toggleVideo);

        video.addEventListener("ended", function () {
            // توقف کامل
            video.pause();

            // ریست زمان
            video.currentTime = 0;

            // مجبور کردن مرورگر به ریفرش state
            video.load();

            // ریست آیکن
            icon.classList.remove("fa-pause");
            icon.classList.add("fa-play");
            container.classList.remove("playing");

            activeVideo = null;

            thumbsContainerMain.classList.remove("d-none");
            setTimeout(() => {
                slider.goTo("next");
            }, 1000);
        });
    });

    // وقتی اسلاید تغییر کرد
    slider.events.on("indexChanged", (info) => {
        const index = info.displayIndex - 1;
        updateActiveThumb(index);
        clearTimeout(timeoutId);
        playNextSlide();
    });

    // شروع اسلاید اول
    playNextSlide();
    updateActiveThumb(0);

    // دکمه های قبلی و بعدی و شمارنده
    const prevBtn = document.querySelector(".prev-slide");
    const nextBtn = document.querySelector(".next-slide");
    const currentSlideText = document.querySelector(".current-slide");

    function updateSlideNumber(index) {
        currentSlideText.textContent = index + 1; // شماره اسلاید فعلی (شروع از 1)
    }

    // تغییر شماره وقتی اسلاید تغییر می‌کند
    slider.events.on("indexChanged", (info) => {
        const index = info.displayIndex - 1;
        updateActiveThumb(index);
        updateSlideNumber(index);
        clearTimeout(timeoutId);
        playNextSlide();
    });

    // دکمه قبلی
    prevBtn.addEventListener("click", () => {
        slider.goTo("prev");
    });

    // دکمه بعدی
    nextBtn.addEventListener("click", () => {
        slider.goTo("next");
    });

    // مقدار اولیه
    updateSlideNumber(0);
});
