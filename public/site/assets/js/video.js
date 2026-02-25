document.addEventListener("DOMContentLoaded", function () {
    const video = document.getElementById("fullscreen-video");

    const playPauseBtn = document.querySelector("#play-pause-btn");
    const playIcon = playPauseBtn.querySelector("i");
    const videoContainer = document.querySelector(".video-full-container-main");
    const videoOverlay = document.querySelector(".video-overlay2");

    // تابع پخش/توقف ویدیو
    function togglePlayPause() {
        if (video.paused) {
            playPauseBtn.style.display = "none";
            video.play();
            playIcon.classList.remove("fa-play");
            playIcon.classList.add("fa-pause");
            videoContainer.classList.add("playing");
        } else {
            playPauseBtn.style.display = "flex";
            video.pause();
            playIcon.classList.remove("fa-pause");
            playIcon.classList.add("fa-play");
            videoContainer.classList.remove("playing");
        }
    }
    // وقتی ویدیو تموم شد
    video.addEventListener("ended", function () {
        // توقف کامل
        video.pause();

        // ریست زمان
        video.currentTime = 0;

        // مجبور کردن مرورگر به ریفرش state
        video.load();

        // ریست آیکن
        playIcon.classList.remove("fa-pause");
        playIcon.classList.add("fa-play");

        // حذف کلاس playing
        videoContainer.classList.remove("playing");
    });

    // رویداد کلیک روی دکمه پلی/پاز
    playPauseBtn.addEventListener("click", function (e) {
        e.stopPropagation();
        togglePlayPause();
    });

    // رویداد کلیک روی ویدیو
    video.addEventListener("click", function (e) {
        e.stopPropagation();
        togglePlayPause();
    });
    // رویداد کلیک روی ویدیو
    videoOverlay.addEventListener("click", function (e) {
        e.stopPropagation();
        togglePlayPause();
    });

    // رویداد کلیک روی خود ویدیو
    videoContainer.addEventListener("click", function (e) {
        e.stopPropagation();
        togglePlayPause();
    });

    // تنظیم ویدیو برای حالت تمام صفحه در مرورگرهای مختلف
    function enterFullscreen() {
        if (videoContainer.requestFullscreen) {
            videoContainer.requestFullscreen();
        } else if (videoContainer.mozRequestFullScreen) {
            videoContainer.mozRequestFullScreen();
        } else if (videoContainer.webkitRequestFullscreen) {
            videoContainer.webkitRequestFullscreen();
        } else if (videoContainer.msRequestFullscreen) {
            videoContainer.msRequestFullscreen();
        }
    }

    // برای نمایش بهتر، ویدیو را در حالت بی‌صدا تنظیم کردم
    // اگر می‌خواهید صدا داشته باشد، ویژگی 'muted' را از تگ ویدیو حذف کنید
});
