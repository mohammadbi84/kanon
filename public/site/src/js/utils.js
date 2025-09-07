function removeAllChildren(parentObj) {
    while (parentObj.lastChild) {
        parentObj.removeChild(parentObj.lastChild)
    }
}


function getCssVar(name) {
    return getComputedStyle(document.documentElement).getPropertyValue(name)
}

function setCssVar(name, value) {
    document.documentElement.style.setProperty(name, value)
}


function setTooltip(element, text, placement = "top") {
    element.title = text
    // element.dataset.bsOriginalTitle = text
    element.dataset.bsToggle = "tooltip"
    element.dataset.bsPlacement = placement
    element.dataset.bsHtml = 'true'

    bootstrap.Tooltip.getOrCreateInstance(element).hide() // hide previous tooltip
    new bootstrap.Tooltip(element) // create new tooltip
}

function removeAllTooltips() {
    document.querySelectorAll('.tooltip').forEach(value => {
        value.remove()
    })
}


function copyTextFromElement(elementId) {
    if (!elementId.startsWith("#"))
        elementId = `#${elementId}`

    let element = document.querySelector(elementId)
    let textToCopy = element.textContent.trim()

    copyText(textToCopy)
}

function copyText(text) {
    if (!navigator.clipboard) {
        let textArea = document.createElement("textarea")
        // textArea.style.display = 'none' // won't select and copy if was hidden
        textArea.value = text
        document.body.appendChild(textArea)
        textArea.select()
        document.execCommand("Copy")
        textArea.remove()
    } else {
        navigator.clipboard.writeText(text)
            .then(
                function () {
                    // alert("کپی شد!") // success
                })
            .catch(
                function () {
                    alert("خطا در کپی!") // error
                }
            )
    }
}


function getScrollPercent(offsetTop) { // main source from: https://stackoverflow.com/a/8028584
    const h = document.documentElement,
        b = document.body,
        st = 'scrollTop',
        sh = 'scrollHeight';

    return Math.max( // Math.max() with zero, to avoid negative percents
        ((h[st] || b[st]) - offsetTop) // current top - offset
        /
        (
            ((h[sh] || b[sh]) - offsetTop) // max height - offset
            -
            h.clientHeight // current viewport height
        )
        * 100,
        0);
}


function centerInParent(parent, child) { // from : https://stackoverflow.com/a/76997944
    const parentRect = parent.getBoundingClientRect();
    const childRect = child.getBoundingClientRect();

    parent.scrollLeft += (childRect.left - parentRect.left) - (parent.clientWidth / 2);
    parent.scrollTop += (childRect.top - parentRect.top) - (parent.clientHeight / 2);
}


function removeBodyScroll() {
    let currentOverflow = getComputedStyle(document.body).overflow
    document.body.style.overflow = "hidden"
    return currentOverflow
}

function restoreBodyScroll(previousOverflowState) {
    document.body.style.overflow = previousOverflowState ?? "auto"
}

function getScalesOfElement(element) {
    // guides from: https://stackoverflow.com/a/74545790 & https://stackoverflow.com/a/26893663

    // getBoundingClientRect() will return scaled width & height which user see in browser
    const {width, height} = element.getBoundingClientRect()
    return {
        x: width / element.offsetWidth, // offsetWidth is not-scaled width
        y: height / element.offsetHeight // offsetHeight is not-scaled height
    }
}

