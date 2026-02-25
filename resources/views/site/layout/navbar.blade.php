<header>
    <!-- بوکمارک -->
    @php
        $bookmarks = App\Models\Bookmark::active()->orderBy('sort', 'asc')->get();
    @endphp
    @if ($bookmarks->count() > 0)
        <div class="bookmark-container">
            <div class="bookmark expanded" id="bookmark">
                <div class="swiper" id="bookmarkSlider">
                    <div class="swiper-wrapper">
                        @foreach ($bookmarks as $bookmark)
                            <div class="swiper-slide bookmark-content px-0" style="height: {{ $bookmark->height }}px;"
                                data-height="{{ $bookmark->height }}" data-delay="{{ $bookmark->duration }}">
                                <div class="bookmark-item">
                                    <!-- محتوای body که می‌تواند شامل عکس یا بک‌گراند باشد -->
                                    <div class="bookmark-media">
                                        {!!  $bookmark->body !!}
                                    </div>

                                    <!-- عنوان روی محتوا -->
                                    {{-- @if ($bookmark->show_title)
                                        <div class="bookmark-title-overlay">
                                            {{ app()->getLocale() == 'fa' ? $bookmark->title_fa : $bookmark->title_en }}
                                        </div>
                                    @endif --}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button class="btn btn-close bg-light" id="bookmarkToggle"></button>
            </div>
        </div>

        @if ($bookmarks->count() == 1)
            @php
                $height = $bookmarks->first()->height;
            @endphp
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    fixedHeight = {{ $height }};
                    setCssVar("--bookmark-height", `${fixedHeight}px`, );
                });
            </script>
        @endif
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // تنظیم ارتفاع و موقعیت بر اساس محتوا
                const bookmarkMedia = document.querySelectorAll('.bookmark-media');

                bookmarkMedia.forEach(media => {
                    const content = media.innerHTML.trim();

                    // اگر محتوا عکس یا ویدیو است
                    if (content.startsWith('<img') || content.startsWith('<video')) {
                        media.style.position = 'relative';
                        media.style.overflow = 'hidden';
                    }

                    // اگر محتوا div با بک‌گراند است
                    if (content.includes('background:')) {
                        const div = media.querySelector('div');
                        if (div) {
                            div.style.width = '100%';
                            div.style.height = '100%';
                            div.style.backgroundSize = 'cover';
                            div.style.backgroundPosition = 'center';
                        }
                    }
                });
            });
            let swiper = new Swiper("#bookmarkSlider", {
                loop: true,
                speed: 600,
                effect: "fade",
                fadeEffect: {
                    crossFade: true
                },
                autoplay: {
                    delay: 3000, // مقدار اولیه دلخواه
                    disableOnInteraction: false,
                },
                pagination: false,
                watchOverflow: false,
                on: {
                    init: function() {
                        // وقتی swiper mount شد، delay اولین اسلاید رو اعمال کن
                        let firstSlide = this.slides[this.activeIndex];
                        let delay = firstSlide.dataset.delay;
                        let height = firstSlide.dataset.height;
                        setCssVar("--bookmark-height", `${height}px`, );
                        if (delay) {
                            this.params.autoplay.delay = parseInt(delay);
                            this.autoplay.start();
                        }
                    },
                    slideChangeTransitionEnd: function() {
                        let activeSlide = this.slides[this.activeIndex];
                        let delay = activeSlide.dataset.delay;
                        let height = activeSlide.dataset.height;
                        setCssVar("--bookmark-height", `${height}px`, );

                        if (delay) {
                            this.params.autoplay.delay = parseInt(delay);
                            this.autoplay.start();
                        }
                    }
                }
            });
        </script>
    @else
        <div class="bookmark-container">
            <div class="bookmark collapsed" style="height: 5px;background: var(--primary-color);" id="bookmark">
                <div class="bookmark-content">
                    <div class="bookmark-text d-flex align-items-center justify-content-start h-100 gap-3">
                        <button class="btn btn-close bg-light" id="bookmarkToggle"></button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- navbar -->
    <div class="main-menu rounded-3">
        <nav class="navbar navbar-expand-lg">
            <div class="container position-relative" id="navbar_container">
                <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
                    <img src="{{ asset('site/public/img/logo-yazdskill2.png') }}" alt="website logo">
                </a>
                <button class="navbar-toggler" type="button" id="mobileMenuToggle">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0 px-0">
                        <!-- دکمه دسته‌بندی‌ها -->
                        <div class="categories-dropdown d-flex" id="categoryTrigger">
                            <button class="categories-btn">
                                <i class="fas fa-bars"></i>
                                آموزشگاه ها
                            </button>
                        </div>
                        <li class="nav-item">
                            <a class="nav-link" href="#">دوره ها</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">خبر ها</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">درباره ما</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">فرصت های شغلی</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">مدرس شوید</a>
                        </li>
                    </ul>
                    <!-- cart language, favorites and login ================================================================================================================== -->
                    <div class="d-flex gap-1 align-items-center justify-content-center position-relative">
                        <div class="compare-container">
                            <a href="#" class="cart-btn">
                                <span class="bi bi-search"></span>
                            </a>
                        </div>
                        @php
                            if (session()->has('cart')) {
                                $cart = session('cart');
                                $sum = 0;
                                $list = ['products' => [], 'models' => [], 'quantities' => []];
                                foreach ($cart as $productID => $value) {
                                    foreach ($value as $model => $data) {
                                        $class = 'App\\' . $model;
                                        $product = $class::find($productID);
                                        // if ($product->visibility == 1) {
                                        array_push($list['products'], $product);
                                        array_push($list['models'], $model);
                                        array_push($list['quantities'], $data['quantity']);
                                        $sum = $sum + $data['quantity'];
                                        // }
                                    }
                                }
                            }
                        @endphp
                        <!-- منوی دراپ‌داون با انیمیشن -->
                        <div class="cart-container">
                            <a href="#" class="cart-btn">
                                <span class="cart-badge shopping-cart-badge">{{ $sum ?? 0 }}</span>
                                <span class="bi bi-basket"></span>
                            </a>
                        </div>
                        <!-- ورود و ثبت نام -->
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="button-container d-flex justify-content-center align-items-center">
                                <a href="/login" class="btn btn-icon login-btn">ورود</a>
                                @if (isset($register_message) and $register_message->status == 1)
                                    <a data-bs-toggle="modal" data-bs-target="#registermessageModal"
                                        class="btn btn-icon register-btn">ثبت نام</a>
                                @else
                                    <a href="{{ route('register') }}" class="btn btn-icon register-btn">ثبت نام</a>
                                @endif
                                <div class="background-slide"></div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- منوی سبد خرید --}}
                <div class="cart-dropdown">
                    <div class="cart-header">
                        <span class="mb-0">سبد خرید</span>
                        <span class="text-muted cart-items-count">{{ $sum ?? 0 }} کالا</span>
                    </div>

                    <div class="cart-items" id="navbarCartList">
                        @php
                            $price = 0;
                            $off = 0;
                            $totalQuantity = 0;
                        @endphp
                        @isset($cart)

                            @foreach ($cart as $productId => $productData)
                                @foreach ($productData as $model => $item)
                                    @php
                                        $class = 'App\\' . $model;
                                        $product = $class::find($productId);

                                        if (!$product) {
                                            continue;
                                        }

                                        $quantity = $item['quantity'];
                                        $totalQuantity += $quantity;

                                        // محاسبه قیمت
                                        $p = $product->prices->where('local', 'تومان')->first();
                                        $cartPrice = 0;
                                        $cartOff = 0;

                                        if ($p->offPrice > 0) {
                                            if ($p->offType == 'مبلغ') {
                                                $cartPrice = $p->price - $p->offPrice;
                                                $cartOff = $p->offPrice;
                                                $price += ($p->price - $p->offPrice) * $quantity;
                                                $off += $cartOff * $quantity;
                                            } elseif ($p->offType == 'درصد') {
                                                $cartPrice = $p->price - $p->price * ($p->offPrice / 100);
                                                $cartOff = $p->price * ($p->offPrice / 100);
                                                $price += ($p->price - $p->price * ($p->offPrice / 100)) * $quantity;
                                                $off += $cartOff * $quantity;
                                            }
                                        } else {
                                            $cartPrice = $p->price;
                                            $price += $p->price * $quantity;
                                        }

                                        // تولید عنوان محصول
                                        $title = $product->title;
                                        if (isset($product->color_design->design->title)) {
                                            $title .= ' طرح ' . $product->color_design->design->title;
                                        }
                                        if (isset($product->color_design->color->color)) {
                                            $title .= ' رنگ ' . $product->color_design->color->color;
                                        }

                                        // آدرس تصویر
                                        $image = $product->images->first()
                                            ? asset('storage/images/' . $product->images->first()->name)
                                            : '/images/no-image.png';

                                        // لینک محصول
                                        $productUrl = '#';
                                        switch ($model) {
                                            case 'Tablecloth':
                                                $productUrl = route('tablecloth.show', [$product->id]);
                                                break;
                                        }

                                        $basePrice = $p->price;
                                        $baseOffPrice = $p->offPrice;
                                        $offType = $p->offType;

                                        if ($p->offPrice > 0) {
                                            if ($p->offType == 'مبلغ') {
                                                $cartPrice = $p->price - $p->offPrice;
                                            } elseif ($p->offType == 'درصد') {
                                                $cartPrice = $p->price - $p->price * ($p->offPrice / 100);
                                            }
                                        } else {
                                            $cartPrice = $p->price;
                                        }
                                    @endphp

                                    <div class="cart-item" data-id="{{ $productId }}"
                                        data-model="{{ $model }}" data-base-price="{{ $basePrice }}"
                                        data-base-off-price="{{ $baseOffPrice }}" data-off-type="{{ $offType }}">
                                        <img src="{{ $image }}" alt="{{ $title }}"
                                            class="cart-item-image">
                                        <div class="cart-item-content">
                                            <div class="cart-item-title">{{ Str::limit($title, 22) }}</div>
                                            <div class="cart-item-price">
                                                @if ($cartOff > 0)
                                                    <span class="cart-item-old-price">{{ $p->offPrice }}</span>
                                                @endif <small class="fs-10 text-muted">جمع
                                                    جزء : </small>
                                                {{ number_format($cartPrice * $quantity) }} تومان
                                            </div>
                                            <div class="quantity-controls">
                                                <button class="decrease" data-model="{{ $model }}"
                                                    data-id="{{ $productId }}">-</button>
                                                <span class="count item-quantity">{{ $quantity }}</span>
                                                <button class="increase" data-model="{{ $model }}"
                                                    data-id="{{ $productId }}">+</button>
                                                <a href="#" class="delete-item me-3" data-id="{{ $productId }}"
                                                    data-model="{{ $model }}">
                                                    <i class="fa-solid fa-close text-danger"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        @endisset
                    </div>

                    <div class="cart-footer">
                        <div class="cart-actions justify-content-between align-items-center">
                            <span class="cart-total-price">
                                <span class="text-muted fs-10">مبلغ قابل پرداخت</span><br>
                                {{ number_format($price ?? 0) }}
                                تومان</span>
                            <a href="#" class="btn-checkout">مشاهده سبد خرید</a>
                        </div>
                    </div>
                </div>
                {{-- منوی پروفایل --}}
                <div class="profile-dropdown">
                    <div class="profile-items px-4 py-3" id="navbarprofileList">
                        <li class=" list-unstyled mb-3">
                            <a class="dropdown-item" href="#">
                                <i class="fa-solid fa-user ms-1 top-0"></i>
                                <span>{{ __('menu.profile') }}</span>
                            </a>
                        </li>
                        <li class=" list-unstyled">
                            <a class="dropdown-item text-danger" href="#"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-arrow-right-from-bracket ms-1 top-0"></i>
                                <span>{{ __('menu.logout') }}</span>
                            </a>
                            <form id="logout-form" action="#" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </div>
                </div>
                {{-- منوی مقایسه ها --}}
                <div class="compare-dropdown">
                    <div class="favorites-header">
                        <span class="mb-0">لیست مقایسه</span>
                        <span class="text-muted compare-items-count" id="compare-items-count">
                            @if (session()->has('compares'))
                                {{ count(session('compares')['product']) }} کالا
                            @else
                                0 کالا
                            @endif
                        </span>
                    </div>

                    <div class="compare-items" id="navbarCompareList">
                        @if (session('compares') != null)
                            @foreach (session('compares')['product'] as $compare)
                                <div class="compare-item" data-id="{{ $compare->id }}"
                                    data-model="{{ substr($compare->category->model, 4) }}">
                                    @php $image = $compare->images->first(); @endphp
                                    <img src="{{ asset('storage/images/thumbnails/' . $image['name']) }}"
                                        alt="product" class="favorites-item-image">
                                    <div class="favorites-item-content">
                                        <div class="favorites-item-title">
                                            {{ $compare->category->title }} طرح
                                            {{ $compare->color_design->design->title }} رنگ
                                            {{ $compare->color_design->color->color }}
                                        </div>
                                        <div class="favorites-item-price">
                                            @if ($compare->quantity > 0)
                                                @php
                                                    $price = $compare->prices->where('local', 'تومان')->first();
                                                @endphp
                                                @if ($price->offPrice > 0)
                                                    @if ($price->offType == 'مبلغ')
                                                        <span
                                                            class="favorites-item-old-price">{{ number_format($price->price - $price->offPrice) }}</span>
                                                    @elseif($price->offType == 'درصد')
                                                        <span
                                                            class="favorites-item-old-price">{{ number_format($price->price - $price->price * ($price->offPrice / 100)) }}</span>
                                                    @endif
                                                    {{ number_format($price->price) }}
                                                    تومان
                                                @else
                                                    {{ number_format($price->price) }}
                                                    تومان
                                                @endif
                                            @else
                                                ناموجود
                                            @endif
                                        </div>
                                        <div
                                            class="d-flex justify-content-start gap-2 align-items-center w-100 bg-white">
                                            <button class="delete-btn close" data-id="{{ $compare->id }}"><i
                                                    class="fa-solid fa-close text-danger"></i></button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="cart-footer">
                        <div class="cart-actions justify-content-end align-items-center">
                            <a href="#" class="btn-checkout">مشاهده لیست</a>
                        </div>
                    </div>
                </div>
                {{-- منوی علاقه مندی ها --}}
                @if (Auth::check())
                    <div class="favorites-dropdown">
                        <div class="favorites-header">
                            <span class="mb-0">{{ __('menu.favorites') }}</span>
                            <span class="text-muted favorites-items-count"
                                id="favorites-items-count">0 کالا</span>
                        </div>

                        <div class="favorites-items" id="navbarFavoritesList">

                        </div>

                        <div class="cart-footer">
                            <div class="cart-actions justify-content-end align-items-center">
                                <a href="#" class="btn-checkout">مشاهده
                                    لیست</a>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- منوی دسته‌بندی برای دسکتاپ -->
                <div class="category-menu" id="categoryMenu">
                    <div class="category-content">
                        <div class="row">

                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!-- آکاردئون موبایل -->
    <div class="mobile-category-menu" id="mobileCategoryMenu">
        <div class="mobile-category-header">
            <span>{{ __('main.title') }}</span>
            <button type="button" id="closeMobileMenu" class="btn-close"></button>
        </div>
        <div class="mobile-category-content">
            <!-- ورود و ثبت نام -->
            <div class="flex justify-center items-center mb-2">
                <div class="button-container border border-secondary rounded text-center p-2">
                    @if (!Auth::check())
                        <a href="#" class="text-muted text-decoration-none px-1">
                            {{ __('menu.login') }}
                        </a>
                        |
                        <a href="#" class="text-muted text-decoration-none px-1">
                            {{ __('menu.register') }}
                        </a>
                        <i class="fa-solid fa-arrow-right-to-bracket me-1"></i>
                    @else
                        <a href="#" class="text-muted text-decoration-none px-1">
                            <i class="fa-solid fa-user me-1"></i>
                            {{ Auth::user()->name }} {{ Auth::user()->family }}
                        </a>
                    @endif
                </div>
            </div>
            <div class="mobile-main-category py-3">
                <a href="#" class="text-reset text-decoration-none fw-bold">
                    <img src="{{ asset('shop/assets/svgs/cart.svg') }}" alt="cart" width="24">
                    {{ __('menu.cart') }}
                </a>
            </div>
            <div class="mobile-main-category py-3">
                <a class="nav-link fw-bold" href="#specials">
                    <img src="{{ asset('shop/assets/svgs/badge-percent.svg') }}" alt="hots" width="18">
                    {{ __('menu.amazing') }}</a>
            </div>
            <div class="mobile-main-category py-3">
                <a class="nav-link fw-bold"
                    href="http://www.termehsalari.com/store#newest">{{ __('menu.newest') }}</a>

            </div>
            <div class="mobile-main-category py-3">
                <a class="nav-link fw-bold"
                    href="http://www.termehsalari.com/store#products">{{ __('menu.bestSeller') }}</a>

            </div>
            <div class="mobile-main-category py-3">
                <a class="nav-link fw-bold"
                    href="http://www.termehsalari.com/store#branchs">{{ __('menu.branchs') }}</a>
            </div>
            <div class="mobile-main-category py-3">
                <a class="nav-link fw-bold" href="#">{{ __('menu.aboutUs') }}</a>
            </div>
        </div>
    </div>
    <!-- overlay برای بستن منوی موبایل -->
    <div class="overlay" id="overlay"></div>
</header>


<script>
    // مدیریت هاور روی سبد خرید
    let cartTimeout;
    $('.cart-container').hover(
        function() {
            clearTimeout(cartTimeout);
            $('.cart-dropdown').css({
                'opacity': '1',
                'visibility': 'visible',
                'transform': 'translateY(0)'
            });
        },
        function() {
            cartTimeout = setTimeout(function() {
                $('.cart-dropdown').css({
                    'opacity': '0',
                    'visibility': 'hidden',
                    'transform': 'translateY(10px)'
                });
            }, 200);
        }
    );
    // جلوگیری از بستن وقتی هاور روی منو است
    $('.cart-dropdown').hover(
        function() {
            clearTimeout(cartTimeout);
        },
        function() {
            cartTimeout = setTimeout(function() {
                $('.cart-dropdown').css({
                    'opacity': '0',
                    'visibility': 'hidden',
                    'transform': 'translateY(10px)'
                });
            }, 200);
        }
    );
    let profileTimeout;
    $('.profile-container').hover(
        function() {
            clearTimeout(profileTimeout);
            $('.profile-dropdown').css({
                'opacity': '1',
                'visibility': 'visible',
                'transform': 'translateY(0)'
            });
        },
        function() {
            profileTimeout = setTimeout(function() {
                $('.profile-dropdown').css({
                    'opacity': '0',
                    'visibility': 'hidden',
                    'transform': 'translateY(10px)'
                });
            }, 200);
        }
    );
    // جلوگیری از بستن وقتی هاور روی منو است
    $('.profile-dropdown').hover(
        function() {
            clearTimeout(profileTimeout);
        },
        function() {
            profileTimeout = setTimeout(function() {
                $('.profile-dropdown').css({
                    'opacity': '0',
                    'visibility': 'hidden',
                    'transform': 'translateY(10px)'
                });
            }, 200);
        }
    );
    let compareTimeout;
    $('.compare-container').hover(
        function() {
            clearTimeout(compareTimeout);
            $('.compare-dropdown').css({
                'opacity': '1',
                'visibility': 'visible',
                'transform': 'translateY(0)'
            });
        },
        function() {
            compareTimeout = setTimeout(function() {
                $('.compare-dropdown').css({
                    'opacity': '0',
                    'visibility': 'hidden',
                    'transform': 'translateY(10px)'
                });
            }, 200);
        }
    );
    // جلوگیری از بستن وقتی هاور روی منو است
    $('.compare-dropdown').hover(
        function() {
            clearTimeout(compareTimeout);
        },
        function() {
            compareTimeout = setTimeout(function() {
                $('.compare-dropdown').css({
                    'opacity': '0',
                    'visibility': 'hidden',
                    'transform': 'translateY(10px)'
                });
            }, 200);
        }
    );
</script>
