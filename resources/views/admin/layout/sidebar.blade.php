<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bold ms-2">یزد اسکیل</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx menu-toggle-icon d-none d-xl-block fs-4 align-middle"></i>
            <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item @if (Route::currentRouteName() == 'admin.index') active @endif">
            <a href="{{ route('admin.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>داشبورد</div>
            </a>
        </li>
        <li class="menu-item @if (Route::currentRouteName() == 'admin.categories.index' ||
                Route::currentRouteName() == 'admin.categories.edit' ||
                Route::currentRouteName() == 'admin.clusters.index' ||
                Route::currentRouteName() == 'admin.clusters.edit' ||
                Route::currentRouteName() == 'admin.fields.index' ||
                Route::currentRouteName() == 'admin.fields.edit' ||
                Route::currentRouteName() == 'admin.professions.index' ||
                Route::currentRouteName() == 'admin.professions.create' ||
                Route::currentRouteName() == 'admin.professions.edit') open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-badge-check"></i>
                <div>مدیریت استاندارد ها</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @if (Route::currentRouteName() == 'admin.categories.index' || Route::currentRouteName() == 'admin.categories.edit') active @endif">
                    <a href="{{ route('admin.categories.index') }}" class="menu-link">
                        <div>رسته ها</div>
                    </a>
                </li>
                <li class="menu-item @if (Route::currentRouteName() == 'admin.clusters.index' || Route::currentRouteName() == 'admin.clusters.edit') active @endif">
                    <a href="{{ route('admin.clusters.index') }}" class="menu-link">
                        <div>خوشه ها</div>
                    </a>
                </li>
                <li class="menu-item @if (Route::currentRouteName() == 'admin.fields.index' || Route::currentRouteName() == 'admin.fields.edit') active @endif">
                    <a href="{{ route('admin.fields.index') }}" class="menu-link">
                        <div>رشته ها</div>
                    </a>
                </li>
                <li class="menu-item @if (Route::currentRouteName() == 'admin.professions.index' || Route::currentRouteName() == 'admin.professions.edit' || Route::currentRouteName() == 'admin.professions.create') active @endif">
                    <a href="{{ route('admin.professions.index') }}" class="menu-link">
                        <div>حرفه ها</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div>سند حرفه ها</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item @if (Route::currentRouteName() == 'admin.tuitions.index' || Route::currentRouteName() == 'admin.tuitions.edit') active @endif">
            <a href="{{ route('admin.tuitions.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-coin"></i>
                <div>مدیریت نرخ شهریه</div>
            </a>
        </li>
        <li class="menu-item @if (Route::currentRouteName() == 'test' || Route::currentRouteName() == 'test') open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dollar"></i>
                <div>مدیریت امور مالی</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @if (Route::currentRouteName() == 'test') active @endif">
                    <a href="#" class="menu-link">
                        <div>نوع شغل</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item @if (Route::currentRouteName() == 'admin.popups.index' ||
                Route::currentRouteName() == 'admin.articles.index' ||
                Route::currentRouteName() == 'admin.positions.index' ||
                Route::currentRouteName() == 'admin.advertisement.index' ||
                Route::currentRouteName() == 'admin.benefit.index' ||
                Route::currentRouteName() == 'admin.bookmark.index') open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-grid-alt"></i>
                <div>بخش های سایت</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @if (Route::currentRouteName() == 'admin.positions.index') active @endif">
                    <a href="{{ route('admin.positions.index') }}" class="menu-link">
                        <div>موقعیت های آگهی</div>
                    </a>
                </li>
                <li class="menu-item @if (Route::currentRouteName() == 'admin.advertisement.index') active @endif">
                    <a href="{{ route('admin.advertisement.index') }}" class="menu-link">
                        <div>آگهی ها</div>
                    </a>
                </li>
                {{-- <li class="menu-item @if (Route::currentRouteName() == 'admin.popups.index') active @endif">
                    <a href="{{ route('admin.popups.index') }}" class="menu-link">
                        <div>پاپ آپ</div>
                    </a>
                </li> --}}
                <li class="menu-item @if (Route::currentRouteName() == 'admin.articles.index') active @endif">
                    <a href="{{ route('admin.articles.index') }}" class="menu-link">
                        <div>صفحات داخلی</div>
                    </a>
                </li>
                <li class="menu-item @if (Route::currentRouteName() == 'admin.benefit.index') active @endif">
                    <a href="{{ route('admin.benefit.index') }}" class="menu-link">
                        <div>مزایای گواهینامه ها</div>
                    </a>
                </li>
                {{-- <li class="menu-item @if (Route::currentRouteName() == 'admin.bookmark.index') active @endif">
                    <a href="{{route('admin.bookmark.index')}}" class="menu-link">
                        <div>بوکمارک</div>
                    </a>
                </li> --}}
            </ul>
        </li>
        <li class="menu-item @if (Route::currentRouteName() == 'admin.academy.index' || Route::currentRouteName() == 'admin.academy.pending') open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-badge"></i>
                <div>مدیریت اعضا</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @if (Route::currentRouteName() == 'admin.academy.index') active @endif">
                    <a href="{{ route('admin.academy.index') }}" class="menu-link">
                        <div>آموزشگاه های آزاد عضو</div>
                    </a>
                </li>
                <li class="menu-item @if (Route::currentRouteName() == 'admin.academy.pending') active @endif">
                    <a href="{{ route('admin.academy.pending') }}" class="menu-link">
                        <div>درخواست های ثبت نام</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item @if (Route::currentRouteName() == 'admin.khabar.index') active @endif">
            <a href="{{ route('admin.khabar.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-news"></i>
                <div>مدیریت اخبار</div>
            </a>
        </li>
        <li class="menu-item @if (Route::currentRouteName() == 'test' || Route::currentRouteName() == 'test') open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div>تنظیمات کلی سایت</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @if (Route::currentRouteName() == 'test') active @endif">
                    <a href="#" class="menu-link">
                        <div>نوع شغل</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
