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
    const thumbsContainer = document.querySelector(".top-slider-thumbs-body");

    let timeoutId = null;
    let isVideoPlaying = false;

    function playNextSlide() {
        if (isVideoPlaying) return; // اگه ویدیو پخش میشه، هیچ کاری نکن
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

    // مدیریت ویدیوها
    videos.forEach((video) => {
        const container = video.closest(".video-container");
        const overlay = container.querySelector(".video-overlay");
        const cover = container.querySelector(".video-cover");
        const playBtn = container.querySelector(".btn-play");
        const stopButton = container.querySelector(".btn-stop");

        overlay.addEventListener("click", () => {
            if (isVideoPlaying) {
                playBtn.style.display = "flex";
                cover.style.display = "block";
                video.classList.add("d-none");
                video.pause();
                playNextSlide();
                isVideoPlaying = false;
            } else {
                playBtn.style.display = "none";
                cover.style.display = "none";
                video.classList.remove("d-none");
                video.play();
                clearTimeout(timeoutId);
                isVideoPlaying = true;
            }
        });

        video.addEventListener("ended", () => {
            stopButton.style.display = "none";
            playBtn.style.display = "flex";
            cover.style.display = "block";
            video.classList.add("d-none");
            isVideoPlaying = false;
            setTimeout(() => slider.goTo("next"), 500);
        });
        video.addEventListener("click", () => {
            if (isVideoPlaying) {
                playBtn.style.display = "flex";
                cover.style.display = "block";
                video.classList.add("d-none");
                video.pause();
                isVideoPlaying = false;
                playNextSlide();
            } else {
                playBtn.style.display = "none";
                cover.style.display = "none";
                video.classList.remove("d-none");
                video.play();
                clearTimeout(timeoutId);
                isVideoPlaying = true;
            }
        });
        overlay.addEventListener("mouseover", () => {
            if (isVideoPlaying) {
                stopButton.style.display = "flex"; // نمایش دکمه وقتی ویدیو پلی است
            } else {
                stopButton.style.display = "none"; // وقتی پلی نیست مخفی بمونه
            }
        });

        overlay.addEventListener("mouseleave", () => {
            stopButton.style.display = "none"; // وقتی موس خارج شد، دکمه رو مخفی کن
        });

        // دکمه Stop که فقط با هاور ظاهر می‌شود
        stopButton.addEventListener("click", function (e) {
            e.stopPropagation();
            if (isVideoPlaying) {
                playBtn.style.display = "flex";
                cover.style.display = "block";
                video.classList.add("d-none");
                video.pause();
                isVideoPlaying = false;
                playNextSlide();
            } else {
                playBtn.style.display = "none";
                cover.style.display = "none";
                video.classList.remove("d-none");
                video.play();
                clearTimeout(timeoutId);
                isVideoPlaying = true;
            }
        });
        // overlay.addEventListener("click", function () {
        //     if (isVideoPlaying) {
        //         video.pause();
        //         playBtn.style.display = "flex";
        //         isVideoPlaying = false;
        //     } else {
        //         video.play();
        //         playBtn.style.display = "none";
        //         isVideoPlaying = true;
        //     }
        // });
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
