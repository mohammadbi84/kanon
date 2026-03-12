<div id="annos">
    <div class="section-title-container">
        <div class="section-title">
            <img src="{{ asset('site/public/icon/vertical-line.svg') }}" aria-hidden="true" class="vertical-line"
                alt="">
            <span class="title">جدیدترین آگهی‌ها</span>
        </div>

        <div class="section-options">
            <div class="d-flex flex-column align-items-center">
                <a href="#" class="btn btn-light rounded-circle comp-link"><span
                        class="badge text-align-center">0</span></a>
            </div>
            <label class="switch2">
                <input type="checkbox" name="off" id="off">
                <span class="slider"></span>
            </label>
            <label class="switch">
                <input type="checkbox" name="hot-annos" id="hot-annos">
                <span class="slider"></span>
            </label>
        </div>
    </div>

    <div class="row row-gap-3" id="hot-annos-list">
        @foreach ($advertisements as $advertisement)
            <div class="col-md-6">
                <a href="#" class="text-reset text-decoration-none">
                    <div class="row anno-card shadow rounded-3" style="overflow: visible !important;">
                        <div class="col-6 position-relative" style="padding: 12px;min-height: 170px !important;">
                            <div class="row g-0" dir="ltr">
                                <div class="col align-content-center text-start p-0">
                                    <div class="d-flex align-items-center gap-1">
                                        <span
                                            class="text-small-1">{{ $advertisement->academy?->city->title ?? 'یزد' }}</span>
                                        <span class="">|</span>
                                        <span
                                            class="text-small-1">{{ $advertisement->academy?->phone ?? '03531231234' }}</span>
                                    </div>
                                </div>
                                <div class="col text-end p-0">
                                    <div class="d-flex justify-content-end">
                                        <h5 class="mt-2 me-2 text-align-center fw-bold" style="font-size: 16px">
                                            {{ $advertisement->academy?->title ?? 'یزد اسکیل' }}
                                        </h5>
                                        <img src="{{ asset('site/public/icon/vertical-line.svg') }}" alt="school"
                                            width="5px" height="35px">
                                    </div>
                                </div>
                            </div>
                            <p class="fw-bold mt-2 mb-1" style="font-size: 15px">{{ $advertisement->title }}</p>
                            <p style="font-size: 16px">
                                {{ $advertisement->description }}
                            </p>
                            <div class="bottom-icons border-top align-items-center align-self-end"
                                style="position: absolute;padding: 5px 12px 0 12px;bottom: 7.5px;left: 0;right: 0;"
                                dir="ltr">
                                <div class="checkbox-wrapper-13 d-flex align-items-center" dir="rtl">
                                    <input id="comp${item.id}" type="checkbox">
                                    <label for="comp${item.id}">مقایسه</label>
                                </div>
                                <small style="font-size: 11.9px;">
                                    <a type="button" class="text-decoration-none text-reset" data-id="${item.id}">
                                        <small class="like-count" style="font-size: 11.9px;">0</small>
                                        <i class="bi bi-heart ms-1 text-primary"
                                            style="position: relative;top: 2px;font-size:14px !important;"></i>
                                    </a>
                                </small style="font-size: 11.9px;">
                                <small style="font-size: 11.9px;">
                                    0
                                    <i class="bi bi-eye ms-1 text-primary" style="position: relative;top: 2px;"></i>
                                </small>
                                <small dir="rtl" style="font-size: 11.9px;">
                                    <i class="bi bi-clock ms-1 text-primary" style="position: relative;top: 2px;"></i>
                                    {{ Jdate($advertisement->created_at)->ago() }}
                                </small>
                            </div>
                        </div>
                        <div class="col-6 position-relative img ads-img-col" style="z-index: 5;overflow: visible;">
                            <div class="img-container h-100">
                                <a href="#" class="text-reset text-decoration-none">
                                    <img src="{{ asset($advertisement->image ?? 'site/public/img/no-image.png') }}"
                                        alt="${item.title}"
                                        style="object-fit: cover; width: 100%; height: 100%;max-height: 200px;">
                                </a>
                                <!-- این دیو با هاور نمایش داده می‌شود -->
                                <div class="hover-reveal border-top">
                                    <div class="bottom-icons py-0 px-1 align-self-end d-flex align-items-center"
                                        style="direction: rtl;">
                                        <a href="#" class="text-reset text-decoration-none">
                                            <small style="font-size: 11.9px" class="fw-bold">
                                                <i class="bi bi-exclamation-triangle ms-1 text-primary"
                                                    style="position: relative;top: 2px;"></i>
                                                ثبت تخلف
                                            </small>
                                        </a>
                                        <p class="text-center m-0 d-flex"
                                            style="font-size: 11.9px;direction: rtl;font-weight:bold;margin-bottom:4px">
                                            <span class="text-dark fw-bold" style="font-size: 11.9px">1403/05/08</span>
                                            <span class="text-primary fw-bold mx-1" style="font-size: 11.9px;"> الی
                                            </span>
                                            <span class="text-dark fw-bold" style="font-size: 11.9px">1403/05/20</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="discount-squer"
                                style="position: absolute; top: -5px; left: 18px; z-index: 66;">
                                <img src="{{ asset('site/public/svgs/Group 1.svg') }}" width="90" alt="discount">
                                <span class="d-flex"
                                    style="font-size: 12px; font-weight: 800; position: absolute; right: 16px; top: 7px;direction: ltr;">
                                    <span class="me-1" style="font-size: 13px;">تخفیف</span>
                                    <strong style="font-size: 12px;">10%</strong>
                                </span>
                            </div>
                            <div class="permume-squer"
                                style="position: absolute; top: -7px; right: 12px; z-index: 66;">
                                <img src="{{ asset('site/public/svgs/hot-bookmark.svg') }}" width="36"
                                    alt="discount">
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="mt-4" style="text-align: end">
        <a href="#" class="btn btn-primary">
            <span>مشاهده بیشتر</span>
            <span class="bi bi-arrow-left pe-2"></span>
        </a>
    </div>
</div>
