function openVideoPopup(videoSrc, autoPlay = true) {
    const popupContainer = document.createElement('div')
    popupContainer.classList.add('video-popup-container')

    const video = document.createElement('video')
    video.classList.add('video')
    video.setAttribute('controls', '')
    if (autoPlay) {
        video.setAttribute('autoplay', '')
        video.setAttribute('muted', '')
    }
    video.setAttribute('src', videoSrc)
    video.addEventListener("click", (e) => {
        e.stopPropagation() // prevent parent to get click event
    })

    popupContainer.appendChild(video)
    document.body.appendChild(popupContainer)


    // prevent user to scroll page
    let previousBodyOverflow = document.body.style.overflow
    document.body.style.overflow = 'hidden'


    const closePopup = () => {
        popupContainer.remove()

        // restore scroll state
        document.body.style.overflow = previousBodyOverflow
    }

    popupContainer.addEventListener("click", closePopup)

    // set tabIndex & focus to container, to get key events
    popupContainer.tabIndex = 0
    popupContainer.focus()

    popupContainer.addEventListener('keydown', function (event) {
        const key = event.key; // const {key} = event; in ES6+
        if (key === "Escape") {
            closePopup()
        }
    });
}
