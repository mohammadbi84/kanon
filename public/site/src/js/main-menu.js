function initMainMenu() {
    let mainMenu = document.querySelector(".main-menu");

    //region: make main-menu width same as search-bar width
    let screenWidth = document.body.clientWidth;
    let searchBarParentWidth = document.querySelector(".search-bar");
    if (searchBarParentWidth) {
        setCssVar(
            "--main-menu-margin",
            `${
                (screenWidth - searchBarParentWidth.parentElement.clientWidth) /
                    2 +
                12
            }px`
        );
        // alert(screenWidth);

        // alert(searchBarParentWidth.parentElement.clientWidth);
    } else {
        let containerParentWidth = document.querySelector("#navbar_container");

        setCssVar(
            "--main-menu-margin",
            `${(screenWidth - containerParentWidth.clientWidth) / 2}px`
        );

        // alert(screenWidth);
        // alert(containerParentWidth.clientWidth);
    }

    //endregion: make main-menu width same as search-bar width

    const topAd = document.querySelector(".top-ad-container");
    if (topAd) {
        mainMenu.classList.add("with-top-ad");
    }

    const scrollOffset = topAd?.clientHeight ?? 64;

    function scrollFunction(e) {
        if (
            document.body.scrollTop > scrollOffset || // For Safari
            document.documentElement.scrollTop > scrollOffset // For Chrome, Firefox, IE and Opera
        ) {
            mainMenu.classList.add("small");
            mainMenu.classList.remove("with-top-ad");
            setCssVar("--main-menu-margin-first", `20px`);
        } else {
            mainMenu.classList.remove("small");
            if (topAd) mainMenu.classList.add("with-top-ad");
            setCssVar("--main-menu-margin-first", `0px`);
        }
    }

    window.addEventListener("scroll", scrollFunction);
}

window.addEventListener("DOMContentLoaded", () => {
    initMainMenu();
});
