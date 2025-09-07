@extends('site.layout.master')
@section('head')
    <title>اخبار</title>
    <style>
        .khabar-container {
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
            margin-bottom: 20px;
            padding: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .khabar-item {
            display: flex;
            /* gap: 15px; */
        }

        .khabar-image-main-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .khabar-content {
            flex: 1;
        }

        .khabar-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .khabar-text {
            font-size: 14px;
            color: #555;
        }

        .khabar-images-small {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .khabar-image-small img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .khabar-media-small {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .khabar-media-item {
            width: 60px;
            height: 60px;
            border-radius: 5px;
            border: 1px solid #ddd;
            overflow: hidden;
        }

        .khabar-media-item img,
        .khabar-media-item video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
    <style>
        .khabar-text-box {
            border-radius: 8px;
            padding: 10px;
            overflow-wrap: break-word;
            max-width: 100%;
            word-break: break-word;
        }

        .khabar-text-box .full-text,
        .khabar-text-box .short-text {
            white-space: pre-wrap;
            overflow-wrap: break-word;
        }

        .khabar-actions {
            margin-top: 10px;
        }

        .khabar-actions .btn {
            margin-top: 5px;
            padding: 8px 15px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .khabar-actions .btn:hover {
            background-color: #007bff;
            color: #fff;
        }

        .khabar-meta {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            font-size: 14px;
            color: #6c757d;
        }

        .khabar-meta i {
            margin-right: 5px;
        }

        .copy-notification {
            position: fixed;
            top: 10px;
            right: 20px;
            background-color: #28a745;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .copy-notification.show {
            opacity: 1;
        }

        .copy-notification span {
            font-weight: bold;
        }

        .login-btn {
            background-color: transparent !important;
            width: 70px !important;
            /* border: 1px solid black; */

        }

        .register-btn {
            color: white !important;
            /* background-color: transparent; */
            background-color: #ffffff00 !important;
            /* border: 1px solid black; */
            border: none;
            width: 70px !important;

        }

        .navbar-expand-lg .container {
            padding: 0 var(--main-menu-margin-first) !important;
        }

        .background-slide {
            position: absolute;
            width: 70px;
            /* اندازه بزرگ‌تر برای هر دو دکمه */
            height: 44px;
            background-color: #EBA607;
            border-radius: 0.5rem;
            right: 80px;
            top: 6px;
            z-index: -1;
            transition: transform 0.5s cubic-bezier(0, -0.55, 0, 1);
        }

        .login-btn,
        .register-btn {
            position: relative;
            z-index: 1;
        }

        .login-btn:hover {
            transition-delay: 50ms;
            color: white !important;
            background-color: #ffffff00 !important;
        }

        .login-btn:hover~.background-slide {
            /* transform: translateX(calc(74% + 1rem)); */
            transform: translateX(74px);
            /* width: 50px; */
            /* height: 45px; */
            /* right: 147px; */
            /* top: 2px; */
        }

        .login-btn:hover~.register-btn {
            transition-delay: 0.1s;
            background-color: #ffffff;
            border: none;
            color: black !important;
        }

        .register-btn:hover {
            background-color: transparent;
            border-color: #2563eb;
        }
    </style>
@endsection
@section('content')
    <div class="container wrapper d-flex align-items-center justify-content-center mb-5" style="margin-top: 120px !important">
        <div class="news-list">
            @foreach ($news as $item)
                <div class="khabar-container border">
                    <div class="khabar-item row">
                        @php
                            $media = json_decode($item->media, true) ?? [];
                            $firstImage = $media[0] ?? null;
                            $otherImages = array_slice($media, 1);
                        @endphp
                        <div class="col-md-4">
                            <div class="khabar-image-main">
                                <a href="javascript:void(0)" class="image-link"
                                    data-image-src="{{ asset($item->cover ? $item->cover : $item->images()->first()->image_path) }}"><img
                                        class="khabar-image-main-cover"
                                        src="{{ asset($item->cover ? $item->cover : $item->images()->first()->image_path) }}"
                                        alt="تصویر خبر {{ $item->title }}"></a>
                                <div class="row g-0">
                                    @foreach ($item->images as $images)
                                        <div class="col p-1">
                                            <a href="javascript:void(0)" class="image-link"
                                                data-image-src="{{ asset($images->image_path) }}">
                                                <img src="{{ asset($images->image_path) }}"
                                                    alt="تصویر خبر {{ $item->title }}" class="w-100">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="khabar-content">
                                <h2 class="khabar-title">{{ $item->title }}</h2>

                                @php
                                    $plainText = strip_tags($item->text);
                                    $words = explode(' ', $plainText);
                                    $shortText = implode(' ', array_slice($words, 0, 20));
                                    $publishDate = \Morilog\Jalali\Jalalian::fromDateTime($item->publish_at)->format(
                                        'H:i Y/m/d',
                                    );
                                    $shortUrl = route('home'); // Assuming a route to view the post
                                @endphp

                                <div class="khabar-text-box" id="khabar-{{ $item->id }}">
                                    <div class="short-text">{{ $item->short ?? $shortText }}...</div>
                                    <div class="full-text d-none">
                                        <div class="">
                                            {!! $item->text !!}
                                        </div>
                                        <div class="row border">
                                            @if (isset($item->media))
                                                <video width="100%" controls>
                                                    <source src="{{ asset($item->media) }}" type="video/mp4">
                                                    مرورگر شما از ویدیو پشتیبانی نمی‌کند.
                                                </video>
                                            @endif

                                            @foreach ($item->images as $images)
                                                <div class="col-md-4">
                                                    <a href="/{{ $images->image_path }}"><img
                                                            src="{{ asset($images->image_path) }}"
                                                            alt="تصویر خبر {{ $item->title }}" class="w-100"></a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <a href="javascript:void(0);" class="toggle-btn text-primary"
                                        onclick="toggleText({{ $item->id }}, this)">بیشتر بخوانید</a>

                                    <div class="khabar-meta">
                                        <span class="views"><i class="bi bi-eye"></i> {{ $item->views_count }}
                                            بازدید</span>
                                        <span class="date"><i class="bi bi-clock"></i>
                                            {{ $publishDate }}</span>
                                    </div>

                                    {{-- <div class="khabar-actions">
                                            <button class="btn btn-outline-primary btn-sm"
                                                onclick="copyLink('{{ $shortUrl }}', {{ $item->id }})">
                                                <i class="bi bi-link"></i> کپی لینک
                                            </button>
                                        </div>
                                        <div class="copy-notification" id="copy-notification-{{ $item->id }}">
                                            <span>لینک کپی شد!</span>
                                        </div> --}}
                                </div>
                                <script>
                                    function toggleText(id, btn) {
                                        const container = document.getElementById(`khabar-${id}`);
                                        const shortText = container.querySelector('.short-text');
                                        const fullText = container.querySelector('.full-text');

                                        const showingFull = !fullText.classList.contains('d-none');

                                        if (showingFull) {
                                            fullText.classList.add('d-none');
                                            shortText.classList.remove('d-none');
                                            btn.innerText = 'بیشتر بخوانید';
                                        } else {
                                            fullText.classList.remove('d-none');
                                            shortText.classList.add('d-none');
                                            btn.innerText = 'بستن';
                                        }
                                    }

                                    function copyLink(link, id) {
                                        // Create a temporary input element to copy the link to clipboard
                                        const tempInput = document.createElement('input');
                                        tempInput.value = link;
                                        document.body.appendChild(tempInput);
                                        tempInput.select();
                                        document.execCommand('copy');
                                        document.body.removeChild(tempInput);

                                        // Show the notification that the link is copied
                                        const notification = document.getElementById('copy-notification-' + id);
                                        notification.classList.add('show');

                                        // Hide the notification after 2 seconds
                                        setTimeout(() => {
                                            notification.classList.remove('show');
                                        }, 2000);
                                    }
                                    // modal image
                                    $(document).ready(function() {
                                        // وقتی روی لینک عکس کلیک شد
                                        $('.image-link').click(function() {
                                            // دریافت آدرس عکس از data-image-src
                                            var imageSrc = $(this).data('image-src');

                                            // تنظیم عکس در مودال
                                            $('#modalImage').attr('src', imageSrc);

                                            // نمایش مودال
                                            var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
                                            imageModal.show();
                                        });

                                        // وقتی مودال بسته شد، عکس را حذف کنیم تا اگر عکس بعدی لود نشده بود، عکس قبلی نمایش داده نشود
                                        $('#imageModal').on('hidden.bs.modal', function() {
                                            $('#modalImage').attr('src', '');
                                        });
                                    });
                                </script>


                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body text-center">
                                        <img id="modalImage" src="" class="img-fluid" alt="تصویر بزرگ">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">بستن</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (count($otherImages) > 0)
                        <div class="khabar-media-small">
                            @foreach ($otherImages as $mediaItem)
                                <div class="khabar-media-item">
                                    @php
                                        $extension = pathinfo($mediaItem, PATHINFO_EXTENSION);
                                    @endphp

                                    @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                        <a href="/{{ $mediaItem }}"><img src="{{ asset($mediaItem) }}"
                                                alt="تصویر خبر"></a>
                                    @elseif(in_array(strtolower($extension), ['mp4', 'webm', 'ogg']))
                                        <video controls>
                                            <source src="{{ asset($mediaItem) }}" type="video/{{ $extension }}">
                                            مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.
                                        </video>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('script')
@endsection
