function openOverlay(overlayContainerSelector) {
    let overlayContainer = document.querySelector(overlayContainerSelector)
    overlayContainer.classList.add("show")

    let list = document.querySelectorAll(`${overlayContainerSelector} .svg-container .path`)
    let animName = "pathAnim"
    let delay = 0
    // list[0].style.zIndex = 1
    list[0].style.animation = `${animName} 1s 1 both ${delay}ms`
    delay += 300
    // list[1].style.zIndex = list[0].style.zIndex + 1
    list[1].style.animation = `${animName} 1s 1 both ${delay}ms`
    delay += 400
    // list[2].style.zIndex = list[1].style.zIndex + 1
    list[2].style.animation = `${animName} 1s 1 both ${delay}ms`


    let itemsPanel = document.querySelector(`${overlayContainerSelector} .items-panel`)
    // itemsPanel.style.backgroundColor = getComputedStyle(list[2]).backgroundColor
    delay += 300
    itemsPanel.style.animation = `fadeIn 1s 1 both ${delay}ms`

    let currentOverflowState = removeBodyScroll()

    document.querySelector(`${overlayContainerSelector} .btn-close`)
        .addEventListener("click", function () {
            closeOverlay(overlayContainerSelector, currentOverflowState)
        })


    // set tabIndex & focus to container, to get key events
    overlayContainer.tabIndex = 0
    overlayContainer.focus()

    overlayContainer.addEventListener('keydown', function (event) {
        const key = event.key; // const {key} = event; in ES6+
        if (key === "Escape") {
            closeOverlay(overlayContainerSelector, currentOverflowState)
        }
    });
}

function closeOverlay(overlayContainerSelector, bodyOverflowState) { // reverse all animations
    let delay = 0

    let itemsPanel = document.querySelector(`${overlayContainerSelector} .items-panel`)
    itemsPanel.style.animation = `fadeOut 300ms 1 both ${delay}ms`

    let animName = "pathAnimReverse"
    let list = document.querySelectorAll(`${overlayContainerSelector} .svg-container .path`)

    delay += 300
    list[2].style.animation = `${animName} 1s 1 both ${delay}ms`

    delay += 400
    list[1].style.animation = `${animName} 1s 1 both ${delay}ms`

    delay += 500
    list[0].style.animation = `${animName} 1s 1 both ${delay}ms`


    list[0].addEventListener("animationend", function (e) {
        document.querySelector(overlayContainerSelector).classList.remove("show")
        restoreBodyScroll(bodyOverflowState)
    }, {once: true});
}
