function moveStepIndicator(steps, stepIndicator, newIndex, prevIndex) {
    const currentStep = steps[newIndex]
    const stepIndicatorBounds = stepIndicator.getBoundingClientRect()

    const indicatorTopRelativeToParent =
        currentStep.offsetTop // top (relative to parent)
        + (currentStep.offsetHeight / 2) // height (relative to parent)
        - (stepIndicatorBounds.height / // height (not relative to parent)
            (
                2 * getScalesOfElement(stepIndicator).y // should include scale of element
            )
        )

    stepIndicator.style.top = `${indicatorTopRelativeToParent}px` // top will not include scale of element
    stepIndicator.style.left = `-${stepIndicatorBounds.width - 2}px`
}

function initAuthCard() {
    const steps = document.querySelectorAll('.steps .step')
    const stepIndicator = document.querySelector('.steps .step-indicator')


    const slider = new Splide('.splide', {
        // type: 'loop',
        drag:false,
        perPage: 1,
        perMove: 1,
        // gap: "60px",
        direction: 'rtl',
        paginationDirection: 'rtl',

        rewind: false,
        arrows: false,
        pagination: false,
    })

    const sliderIndexChangeHandler = function (newIndex, prevIndex, destIndex) {
        steps[prevIndex]?.classList?.remove('active')
        steps[newIndex]?.classList?.add('active')

        moveStepIndicator(steps, stepIndicator, newIndex, prevIndex)
    }
    slider.on('move', sliderIndexChangeHandler)

    slider.on('mounted', function () {
        // fire indexChanged handler for first item
        sliderIndexChangeHandler(0, -1)
    })

    slider.mount()


    steps.forEach(function (el, i, list) {
        el.addEventListener("click", function (e) {
            slider.go(+el.dataset.index)
            e.stopPropagation()
        }, false)
    })


    // init nav buttons
    document.querySelectorAll('.panel .nav-container .btn-nav.btn-prev:not(.hide)')
        .forEach(function (value, key, parent) {
            value.addEventListener("click", function () {
                slider.go("-1")
            })
        })
    document.querySelectorAll('.panel .nav-container .btn-nav.btn-next:not(.hide)')
        .forEach(function (value, key, parent) {
            value.addEventListener("click", function () {
                slider.go("+1")
            })
        })
}

document.addEventListener('DOMContentLoaded', function () {
    initAuthCard()
})
