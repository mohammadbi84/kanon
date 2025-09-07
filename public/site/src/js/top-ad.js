function initTopAd() {
    document.querySelector('.top-ad-container .btn-close')
        ?.addEventListener("click", () => {
            document.querySelector('.top-ad-container').classList.add("close")
            setCssVar("--top-ad-height", "0px") // to update other elements like 'main menu'
        })

    if (!document.querySelector('.top-ad-container'))
        setCssVar("--top-ad-height", "0px") // to update other elements like 'main menu'
}

window.addEventListener("DOMContentLoaded", () => {
    initTopAd()
})