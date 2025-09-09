@extends('site.layout.master')
@section('head')
    <title>آموزشگاه ها روی نقشه</title>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- login btn --}}
    <style>
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

        /* inputs */
        .autocomplete {
            position: relative;
            /* width: 300px; */
        }

        .autocomplete input,
        .autocomplete textarea {
            outline: 0px solid transparent !important;
            width: 100%;
            padding: 10px 15px 10px 10px;
            padding-left: 24px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px
        }

        .autocomplete label {
            font-size: 15px;
            position: absolute;
            right: 15px;
            top: 21%;
            transition: 0.2s;
            pointer-events: none;
            color: #666;
        }

        .autocomplete .dropdown .active {
            background-color: #F2F9FF;
        }

        .autocomplete input:focus+label,
        .autocomplete.filled input+label,
        .autocomplete textarea:focus+label,
        .autocomplete.filled textarea+label {
            outline: none !important;
            border: none !important;
            top: -10px !important;
            right: 10px;
            background: white;
            padding: 0 5px;
            font-size: 0.75rem;
            color: #6c757d;
        }

        .autocomplete .clear-btn {
            display: none;
            position: absolute;
            left: 10px;
            top: 47%;
            transform: translateY(-50%);
            cursor: pointer;
            font-weight: bold;
            color: #888;
        }

        .map-card {
            font-family: 'Vazir FD', sans-serif !important;
        }

        .leaflet-popup-content {
            margin: 0 !important;
        }

        .leaflet-popup-close-button {
            display: none !important;
        }

        .institute-label {
            width: auto !important;
            min-width: 120px;
            margin-top: 14px !important;
        }
    </style>
    <style>
        .leaflet-touch .leaflet-control-attribution,
        .leaflet-touch .leaflet-control-layers,
        .leaflet-touch .leaflet-bar {
            display: none;
        }

        footer {
            display: none;
        }

        #map {
            /* position: absolute; */
            /* top: 0; */
            /* right: 0; */
            /* bottom: 0; */
            /* left: 0; */
            z-index: 1;
            height: 88.5vh;
        }

        .sidebar {
            /* position: absolute; */
            /* top: 77px; */
            /* right: 0; */
            /* bottom: 0; */
            /* width: 300px; */
            height: 88.5vh;
            background-color: #fff;
            /* opacity: 0.85; */
            z-index: 1;
            padding: 20px;
            overflow-y: auto;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar::-webkit-scrollbar {
            background-color: #ffffff;
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track-piece {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background-color: #EBA607;
            border-radius: 10px;
            width: 4px;
        }

        .filter-section {
            margin-bottom: 15px;
            padding-bottom: 10px;
            /* border-bottom: 1px solid #eee; */
        }

        .form-check-input:checked {
            background-color: #EBA607 !important;
            border-color: #EBA607 !important;
        }

        .filter-title {
            position: absolute;
            padding: 0 3px;
            top: -10px;
            /* bottom: 13px; */
            right: 10px;
            background: white;
            display: inline;
            color: #6c757d;
            font-size: 15px !important;
        }

        .form-label {
            font-weight: 500;
            color: #000;
        }

        .form-check-label {
            color: #000;
            font-size: 14px;
        }

        /* استایل برای Select2 به صورت راست چین */
        .select2-container--default .select2-selection--multiple,
        .select2-container--default .select2-selection--single {
            text-align: right;
            padding: 5px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            text-align: right;
            margin-left: 5px;
            margin-right: 0;
        }

        /* استایل برای مارکرهای نقشه */
        .institute-marker {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            font-family: 'Vazir FD';
            background-color: rgba(255, 255, 255, 0.8);
            padding: 3px 8px;
            border-radius: 10px;
            border: 1px solid #ccc;
            white-space: nowrap;
            text-shadow: 0 0 3px white, 0 0 5px white;
        }

        .city-control {
            padding: 5px 10px;
            background: white;
            border-radius: 4px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.4);
            cursor: pointer;
            margin-bottom: 10px;
        }

        /* برای مارکر هایلایت شده */
        .search-highlight {
            animation: pulse 1.5s infinite;
            border-radius: 50%;
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.8);
            z-index: 1000 !important;
        }

        /* برای لیبل هایلایت شده */
        .search-highlight-label {
            margin-top: 14px !important;
            /* animation: pulse 1.5s infinite; */
            height: auto !important;
            min-width: 120px !important;
            border: 2px solid #ff9800 !important;
            border-radius: 11px;
            font-weight: bold;
            z-index: 1000 !important;
        }

        /* انیمیشن پالس */
        @keyframes pulse {
            0% {
                /* transform: scale(1); */
                box-shadow: 0 0 5px rgba(255, 215, 0, 0.8);
            }

            50% {
                /* transform: scale(1.15); */
                box-shadow: 0 0 25px rgba(255, 215, 0, 1);
            }

            100% {
                /* transform: scale(1); */
                box-shadow: 0 0 5px rgba(255, 215, 0, 0.8);
            }
        }


        .marker-animate {
            animation: markerPulse 1.5s infinite ease-in-out;
        }

        @keyframes markerPulse {
            0% {
                /* transform: scale(1); */
                filter: drop-shadow(0 0 2px #111f4c);
            }

            50% {
                /* transform: scale(1.3); */
                filter: drop-shadow(0 0 10px #111f4c);
            }

            100% {
                /* transform: scale(1); */
                filter: drop-shadow(0 0 2px #111f4c);
            }
        }


        .autocomplete .dropdown {
            /* padding-bottom: 50px; */
            position: absolute;
            top: 110%;
            border-radius: 5px;
            right: 0;
            left: 0;
            border: 1px solid #ccc;
            /* border-top: none; */
            max-height: 250px;
            overflow-y: auto;
            background: white;
            z-index: 2;
        }

        .autocomplete .dropdown::-webkit-scrollbar {
            background-color: #ffffff;
            width: 3px;
        }

        .autocomplete .dropdown::-webkit-scrollbar-thumb {
            background-color: #bfbfbf;
            border-radius: 10px;
            width: 6px;
        }

        .autocomplete .dropdown div {
            padding: 8px 10px;
            cursor: pointer;
            font-size: 14px;
        }

        .autocomplete .dropdown div:hover {
            background: #f0f0f0;
        }

        .no-results {
            text-align: center;
            padding: 20px;
            color: #dc3545;
            font-weight: bold;
        }

        .select2-container {
            width: 100% !important;
        }

        .reshte-box {
            padding-left: 4px;
            max-height: 40vh;
            overflow-y: scroll;
        }

        .reshte-box::-webkit-scrollbar {
            background-color: #ffffff;
            width: 5px;
        }

        .reshte-box::-webkit-scrollbar-thumb {
            background-color: #bfbfbf;
            border-radius: 10px;
        }

        .swal2-popup {
            margin-top: 78px;
            box-shadow: 0px 5px 10px 0px #868686a6 !important;
        }

        .swal2-title {
            font-size: 24px;
        }

        .swal2-modal {
            background: #ffc7ce;
            color: #9c0006;
        }

        .swal2-timer-progress-bar {
            background: #5e5e5e;
        }
        span.count{
            font-size: 12px;
            color: #3b3b3b;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid" style="padding-top: 78px">
        <div class="row border p-0">
            <div class="col-md-2 p-0"
                style="
                box-shadow: -5px 0px 10px 0px #868686a6 !important;
                z-index: 10;">
                <!-- سایدبار فیلترها -->
                <div class="sidebar pb-1">
                    {{-- <h4 class="text-center mb-4 text-white">فیلتر آموزشگاه‌ها</h4> --}}
                    <!-- بخش جستجو -->
                    <div class="filter-section">
                        <div class="mb-3">
                            {{-- <label for="searchInput" class="form-label">جستجوی آموزشگاه</label>
                            <input type="text" class="form-control" id="searchInput"
                                placeholder="نام آموزشگاه را وارد کنید..."> --}}

                            <div class="autocomplete" id="autocompleteBoxname">
                                <input type="text" id="searchInputname" name="name" oninput="nameinput('name')">
                                <label for="searchInputname" style="right: 15px;">نام آموزشگاه</label>
                                <span class="clear-btn" id="clearBtn_name" onclick="clearInput('name')">×</span>
                            </div>
                        </div>

                        <div class="">
                            <div class="autocomplete filled" id="autocompleteBoxcity">
                                <input type="text" id="searchInputcity" class="only-persian"
                                    oninput="filterOptions('city',1)" onclick="dropdownshow('city')" value="یزد">
                                <label for="searchInputcity">شهرستان</label>
                                <span class="clear-btn" style="display: block !important;" id="clearBtn_city"
                                    onclick="clearInput('city')">×</span>
                                <div class="dropdown" id="dropdownListcity" style="display: none;"></div>
                                <input type="hidden" name="city" id="selectedIdcity" value="یزد">
                            </div>
                        </div>
                    </div>
                    <!-- بخش فیلتر جنسیت -->
                    <div class="filter-section">
                        <div class="border rounded p-2 pt-3 position-relative" style="padding-right: 10px !important">
                            <h6 class="filter-title m-0">جنسیت</h6>
                            {{-- <div class="position-relative"></div> --}}
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="male" id="genderMale" checked>
                                <label class="form-check-label" for="genderMale">
                                    <img src="{{ asset('location-blue.svg') }}" alt="male" width="20"
                                        height="20">
                                    برادران <span class="count" id="countMale">( 0 )</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="female" id="genderFemale" checked>
                                <label class="form-check-label" for="genderFemale">
                                    <img src="{{ asset('location-pink.svg') }}" alt="male" width="20"
                                        height="20">
                                    خواهران <span class="count" id="countFemale">( 0 )</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="both" id="genderBoth" checked>
                                <label class="form-check-label" for="genderBoth">
                                    <img src="{{ asset('location-yellow.svg') }}" alt="male" width="20"
                                        height="20">
                                    برادران، خواهران <span class="count" id="countBoth">( 0 )</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- بخش فیلتر رشته‌ها -->
                    <div class="filter-section">
                        {{-- <h6 class="filter-title">رشته‌ها</h6> --}}
                        <div class="border pt-4 pe-1 pb-2 rounded position-relative" style="">
                            <h6 class="filter-title m-0">عناوین رشته</h6>
                            <div class="autocomplete pe-2 mb-2" id="autocompleteBoxreshte" style="padding-left: 8px">
                                <input type="text" id="searchInputreshte" name="reshte" oninput="nameinput('reshte')">
                                <label for="searchInputreshte">جستجوی رشته...</label>
                                <span class="clear-btn" id="clearBtn_reshte" style="left:18px;"
                                    onclick="clearInput('reshte')">×</span>
                            </div>
                            <div class="p-2 reshte-box" dir="ltr" style="padding-right: 7px !important;">
                                <div class="form-check mb-2 position-sticky top-0 bg-white" dir="rtl">
                                    <input class="form-check-input" type="checkbox" id="selectAllFields" value=""
                                        checked>
                                    <label class="form-check-label text-primary" for="selectAllFields">
                                        {{-- <i class="bi bi-check2-square text-primary"></i> --}}
                                        انتخاب همه <span class="count">({{$groups->count()}})</span>
                                    </label>
                                </div>
                                @foreach ($groups as $group)
                                    <div class="form-check mb-2" dir="rtl">
                                        <input class="form-check-input field-check" type="checkbox"
                                            value="{{ $group->name }}" id="field{{ $group->name }}" checked>
                                        <label class="form-check-label" for="field{{ $group->name }}">
                                            {{ $group->name }} <span class="field-count count" data-field="{{ $group->name }}">0</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>

                    {{-- <button id="applyFilters" class="btn btn-primary w-100">اعمال فیلترها</button>
                    <button id="resetFilters" class="btn btn-outline-secondary w-100 mt-2">بازنشانی فیلترها</button> --}}
                </div>
            </div>
            <div class="col-md-10 p-0">
                <!-- نقشه -->
                <div id="map" class="w-100"></div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // مقداردهی اولیه نقشه
            const map = L.map('map').setView([31.879293, 54.373840], 14); // مختصات تهران
            // تعریف آیکون‌ها
            var blueIcon = L.icon({
                iconUrl: "{{ asset('location-blue.svg') }}", // آیکون آبی
                iconSize: [40, 40], // سایز
                iconAnchor: [15, 30], // نقطه‌ی اتصال
                popupAnchor: [0, -30]
            });

            var pinkIcon = L.icon({
                iconUrl: "{{ asset('location-pink.svg') }}", // آیکون صورتی
                iconSize: [40, 40],
                iconAnchor: [15, 30],
                popupAnchor: [0, -30]
            });

            var orangeIcon = L.icon({
                iconUrl: "{{ asset('location-yellow.svg') }}", // آیکون نارنجی
                iconSize: [40, 40],
                iconAnchor: [15, 30],
                popupAnchor: [0, -30]
            });

            // اضافه کردن لایه نقشه
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // کنترل بزرگنمایی نقشه
            L.control.zoom({
                position: 'topright'
            }).addTo(map);

            // داده‌های نمونه برای آموزشگاه‌ها (در حالت واقعی از JSON استفاده می‌شود)
            const institutes = @json($organns);
            var states = @json($states);

            let markers = [];
            let instituteLabels = [];
            let currentSearchTerm = '';

            // تابع برای نمایش آموزشگاه‌ها روی نقشه
            function displayInstitutes(institutesToShow, searchTerm = '', city = false) {
                // حذف نشانگرهای قبلی
                markers.forEach(marker => map.removeLayer(marker));

                markers = [];

                instituteLabels.forEach(label => map.removeLayer(label));
                instituteLabels = [];

                // ذخیره عبارت جستجو برای هایلایت کردن
                currentSearchTerm = searchTerm.toLowerCase();

                // اضافه کردن نشانگرهای جدید
                institutesToShow.forEach(institute => {
                    let iconType;
                    if (institute.gender === 'male') {
                        iconType = blueIcon;
                    } else if (institute.gender === 'female') {
                        iconType = pinkIcon;
                    } else {
                        iconType = orangeIcon; // برای هر دو
                    }
                    // بررسی آیا این آموزشگاه با عبارت جستجو مطابقت دارد

                    const isSearchMatch = currentSearchTerm &&
                        institute.name.toLowerCase().includes(currentSearchTerm);

                    // ایجاد نشانگر
                    const marker = L.marker([institute.lat, institute.lng], {
                        className: isSearchMatch ? 'search-highlight' : '',
                        icon: iconType,
                    }).addTo(map).bindPopup(`
                        <div class="card rounded-4 border-0 map-card p-1">
                          <div class="card-body border-0 text-start p-1">
                            <h6 class="card-title">${institute.name}</h6>
                            <p class="card-text m-0">جنسیت: ${getGenderName(institute.gender)}</p>
                            <p class="card-text m-0">شهر: ${getCityName(institute.city)}</p>
                            <a href="{{ route('school') }}" class="btn btn-sm btn-primary w-100 mt-3">مشاهده پروفایل</a>
                          </div>
                        </div>
                    `);
                    if (isSearchMatch) {
                        setTimeout(() => {
                            marker._icon.classList.add('marker-animate');
                        }, 100);
                    }

                    // ایجاد برچسب نام آموزشگاه
                    const label = L.marker([institute.lat, institute.lng], {
                        icon: L.divIcon({
                            className: isSearchMatch ? 'search-highlight-label' :
                                'institute-label',
                            html: `<div class="institute-marker">${institute.name}</div>`,
                            iconSize: [120, 20],
                            iconAnchor: [60, 10]
                        })
                    }).addTo(map);

                    markers.push(marker);
                    instituteLabels.push(label);
                });

                // اگر هیچ نتیجه‌ای پیدا نشد
                if (institutesToShow.length === 0) {
                    Swal.fire({
                        // position: "top-end",
                        // icon: "error",
                        text: "هیچ آموزشگاهی با این فیلتر ها پیدا نشد",
                        showConfirmButton: false,
                        width: 400,
                        timer: 3000,
                        timerProgressBar: true,
                        heightAuto: false
                    });

                }

                // تنظیم زوم بر اساس نتایج
                if (searchTerm.length > 0 || city) {
                    adjustZoomToResults(institutesToShow);
                }
            }

            // تابع برای تنظیم زوم بر اساس نتایج
            function adjustZoomToResults(results) {
                if (results.length === 0) {
                    // map.setView([31.879293, 54.373840], 15);
                    return;
                }

                if (results.length === 1) {
                    const institute = results[0];
                    map.setView([institute.lat, institute.lng], 15);

                    // پیدا کردن مارکر مرتبط با این آموزشگاه
                    const marker = markers.find(m => {
                        const latLng = m.getLatLng();
                        return latLng.lat === institute.lat && latLng.lng === institute.lng;
                    });

                    if (marker) {
                        map.setView([institute.lat, institute.lng], 15);
                        marker.openPopup(); // ✅ باز کردن پاپ‌آپ همون مارکر
                    }

                    return;
                }
                // اگه چند نتیجه بود
                const group = new L.featureGroup(markers)
                map.fitBounds(group.getBounds().pad(0.1));
            }

            // تابع برای فیلتر کردن آموزشگاه‌ها
            function filterInstitutes(cityChange = false) {
                const searchText = $('#searchInputname').val().toLowerCase();
                const selectedCity = $('#citySelect').val();
                const selectedCity2 = $('#selectedIdcity').val().toLowerCase();
                const selectedCategories = $('#categorySelect').val() || [];
                const selectedGenders = [];
                const selectedFields = [];

                // جمع‌آوری جنسیت‌های انتخاب شده
                if ($('#genderMale').is(':checked')) selectedGenders.push('male');
                if ($('#genderFemale').is(':checked')) selectedGenders.push('female');
                if ($('#genderBoth').is(':checked')) selectedGenders.push('both');

                $('.reshte-box .form-check-input:checked').each(function() {
                    selectedFields.push($(this).val());
                });

                // ✅ اگر هیچ جنسیت یا هیچ رشته‌ای انتخاب نشده → هیچ نتیجه‌ای نمایش نده
                if (selectedGenders.length === 0 || selectedFields.length === 0) {
                    displayInstitutes([], searchText);
                    return;
                }

                // فیلتر کردن آموزشگاه‌ها
                const filteredInstitutes = institutes.filter(institute => {
                    // فیلتر بر اساس جستجو
                    if (searchText && !institute.name.toLowerCase().includes(searchText)) {
                        return false;
                    }

                    // فیلتر بر اساس شهر
                    if (selectedCity && institute.city !== selectedCity) {
                        return false;
                    }
                    if (selectedCity2 && institute.city !== selectedCity2) {
                        return false;
                    }

                    // فیلتر بر اساس دسته‌بندی
                    if (selectedCategories.length > 0 && !selectedCategories.includes(institute.category)) {
                        return false;
                    }

                    // فیلتر بر اساس جنسیت
                    if (selectedGenders.length > 0 && !selectedGenders.includes(institute.gender)) {
                        return false;
                    }

                    // فیلتر بر اساس رشته‌ها
                    if (selectedFields.length > 0) {
                        const hasField = institute.fields.some(field => selectedFields.includes(field));
                        if (!hasField) return false;
                    }

                    return true;
                });


                // ✅ اگر شهر انتخاب شده باشد، نقشه به آن برود
                // if (cityChange) {
                //     const cityData = states.find(state => state.id == selectedCity);
                //     if (cityData && cityData.latitude && cityData.longitude) {
                //         map.setView([cityData.latitude, cityData.longitude], 12);
                //     }
                // }


                // نمایش آموزشگاه‌های فیلتر شده
                if (cityChange) {
                    displayInstitutes(filteredInstitutes, searchText, true);
                    const cityData = states.find(state => state.title == selectedCity2);
                    // alert(cityData.title);
                    if (cityData && cityData.latitude && cityData.longitude) {
                        map.setView([cityData.latitude, cityData.longitude], 12);
                    }
                } else {
                    displayInstitutes(filteredInstitutes, searchText);
                }
            }

            // تابع بازنشانی فیلترها
            function resetFilters() {
                $('#searchInputname').val('');
                $('#citySelect').val('').trigger('change');
                $('#categorySelect').val(null).trigger('change');
                $('#genderMale, #genderFemale').prop('checked', false);
                $('#genderBoth').prop('checked', true);
                $('input[type="checkbox"][id^="field"]').prop('checked', false);

                // بازگشت به نمای اولیه
                map.setView([35.6892, 51.3890], 12);

                // نمایش همه آموزشگاه‌ها
                displayInstitutes(institutes);
            }

            // توابع کمکی برای نمایش نام‌ها به جای مقادیر
            function getCategoryName(category) {
                const categories = {
                    'lang': 'زبان‌های خارجی',
                    'art': 'هنر',
                    'sport': 'ورزشی',
                    'computer': 'کامپیوتر',
                    'music': 'موسیقی'
                };
                return categories[category] || category;
            }

            function getGenderName(gender) {
                const genders = {
                    'male': 'برادران',
                    'female': 'خواهران',
                    'both': 'برادران، خواهران'
                };
                return genders[gender] || gender;
            }

            function getCityName(city) {
                const cities = {
                    'tehran': 'تهران',
                    'mashhad': 'مشهد',
                    'isfahan': 'اصفهان',
                    'shiraz': 'شیراز',
                    'tabriz': 'تبریز',
                    'yazd': 'یزد',
                    'taft': 'تفت',
                };
                return cities[city] || city;
            }

            // نمایش تعداد هر جنسیت
            function updateGenderCounts() {
                let maleCount = 0;
                let femaleCount = 0;
                let bothCount = 0;

                institutes.forEach(inst => {
                    if (inst.gender === 'male') maleCount++;
                    else if (inst.gender === 'female') femaleCount++;
                    else if (inst.gender === 'both') bothCount++;
                });

                $('#countMale').text('( '+maleCount+' )');
                $('#countFemale').text('( '+femaleCount+' )');
                $('#countBoth').text('( '+bothCount+' )');
            }
            // فراخوانی هنگام لود صفحه
            updateGenderCounts();

            // نمایش تعداد آموزشگاه های هر رشته
            function updateFieldCounts() {
                let fieldCounts = {};

                // شمارش تعداد هر رشته
                institutes.forEach(inst => {
                    inst.fields.forEach(field => {
                        if (!fieldCounts[field]) {
                            fieldCounts[field] = 0;
                        }
                        fieldCounts[field]++;
                    });
                });

                // نمایش تعداد در کنار هر رشته
                $('.field-count').each(function() {
                    let fieldName = $(this).data('field');
                    $(this).text('( '+(fieldCounts[fieldName] || 0)+' )');
                });
            }

            // اجرا در لود اولیه
            updateFieldCounts();

            // رویداد کلیک برای دکمه اعمال فیلترها
            $('#applyFilters').click(() => filterInstitutes());

            // رویداد کلیک برای دکمه بازنشانی فیلترها
            $('#resetFilters').click(resetFilters);

            // رویداد تغییر برای فیلترهای چک‌باکس
            $('input[type="checkbox"]').change(() => filterInstitutes());

            // رویداد تایپ برای جستجو
            $('#searchInputname').on('input', () => filterInstitutes());

            // رویداد تغییر برای سلکت‌باکس
            $('#categorySelect').change(() => filterInstitutes());

            // رویداد تغییر برای انتخاب شهر
            $('#citySelect').change(() => filterInstitutes());
            $('#selectedIdcity').on('input', () => filterInstitutes(true));

            // نمایش اولیه همه آموزشگاه‌ها
            displayInstitutes(institutes);

            $('#searchInputreshte').on('input', function() {
                var searchText = $(this).val().trim().toLowerCase();
                $('.reshte-box .form-check').each(function() {
                    var labelText = $(this).find('label').text().trim().toLowerCase();
                    if (labelText.startsWith(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
            // وقتی دکمه ضربدر کلیک شد
            $('#clearBtn_reshte').on('click', function() {
                $('#searchInputreshte').val(''); // پاک کردن اینپوت
                $('.reshte-box .form-check').show(); // نمایش همه گزینه‌ها
            });
            $('#clearBtn_name').on('click', function() {
                filterInstitutes();
            });
            $('#clearBtn_city').on('click', function() {
                filterInstitutes();
            });
            // وقتی "انتخاب همه" تغییر کند
            $('#selectAllFields').on('change', function() {
                var isChecked = $(this).is(':checked');
                $('.field-check').prop('checked', isChecked);
                filterInstitutes();
            });

            // وقتی یکی از گزینه‌های لیست تغییر کند
            $('.field-check').on('change', function() {
                var allChecked = $('.field-check:checked').length === $('.field-check').length;
                $('#selectAllFields').prop('checked', allChecked);
                filterInstitutes();
            });
        });

        $(document).ready(function() {});
    </script>
    {{-- inputs --}}
    <script>
        var states = @json($states);

        function nameinput(id) {
            const input = document.getElementById("searchInput" + id);
            const box = document.getElementById("autocompleteBox" + id);
            const clearBtn = document.getElementById("clearBtn_" + id);
            if (input.value.length > 0) {
                box.classList.add("filled");
                clearBtn.style.display = 'block';
            } else {
                box.classList.remove("filled");
                clearBtn.style.display = 'none';
            }
        }

        function dropdownshow(id) {
            filterOptions(id, 0);
            const dropdown = document.getElementById("dropdownList" + id);
            dropdown.style.display = 'block';
        }

        function hideDropdown() {
            const dropdown = document.getElementById("dropdownList" + id);

            setTimeout(() => dropdown.style.display = 'none', 150);
        }

        function filterOptions(divId, status) {
            const dropdown = document.getElementById("dropdownList" + divId);
            const input = document.getElementById("searchInput" + divId);
            const box = document.getElementById("autocompleteBox" + divId);
            const value = input.value.toLowerCase();
            if (divId == "city") {
                if (status == 1) {
                    const filtered = states.filter(item => item.title.toLowerCase().startsWith(value));
                    dropdown.innerHTML = filtered.length ?
                        filtered.map(item =>
                            `<div onclick="selectItem('${item.title}', '${item.title}','${divId}')">${item.title}</div>`)
                        .join('') :
                        '<div>نتیجه‌ای یافت نشد</div>';
                } else {
                    const filtered = states;
                    dropdown.innerHTML = filtered.length ?
                        filtered.map(item =>
                            `<div onclick="selectItem('${item.title}', '${item.title}','${divId}')" data-city="${item.title}">${item.title}</div>`
                        )
                        .join('') :
                        '<div>نتیجه‌ای یافت نشد</div>';
                }

                box.classList.toggle("filled", input.value.trim() !== "");
            } else if (divId == "state") {

                if (status == 1) {
                    const filtered = states.filter(item => item.name.toLowerCase().includes(value));
                    dropdown.innerHTML = filtered.length ?
                        filtered.map(item =>
                            `<div onclick="selectItem(${item.id}, '${item.name}','${divId}')">${item.name}</div>`)
                        .join('') :
                        '<div>نتیجه‌ای یافت نشد</div>';
                } else {
                    const filtered = states;
                    dropdown.innerHTML = filtered.length ?
                        filtered.map(item =>
                            `<div onclick="selectItem(${item.id}, '${item.name}','${divId}')">${item.name}</div>`)
                        .join('') :
                        '<div>نتیجه‌ای یافت نشد</div>';
                }
                box.classList.toggle("filled", input.value.trim() !== "");
            } else if (divId == "group") {
                if (status == 1) {
                    const filtered = reshtes.filter(item => item.name.toLowerCase().includes(value));
                    dropdown.innerHTML = filtered.length ?
                        filtered.map(item =>
                            `<div onclick="selectItem(${item.id}, '${item.name}','${divId}')">${item.name}</div>`)
                        .join('') :
                        '<div>نتیجه‌ای یافت نشد</div>';
                } else {
                    const filtered = reshtes;
                    dropdown.innerHTML = filtered.length ?
                        filtered.map(item =>
                            `<div onclick="selectItem(${item.id}, '${item.name}','${divId}')">${item.name}</div>`)
                        .join('') :
                        '<div>نتیجه‌ای یافت نشد</div>';
                }


                box.classList.toggle("filled", input.value.trim() !== "");
            } else if (divId == "herfe") {
                if (status == 1) {
                    const filtered = herves.filter(item => item.name.toLowerCase().includes(value));
                    dropdown.innerHTML = filtered.length ?
                        filtered.map(item =>
                            `<div onclick="selectItem('${item.id}', '${item.name}','${divId}')">${item.name}</div>`)
                        .join('') :
                        '<div>نتیجه‌ای یافت نشد</div>';
                } else {
                    const filtered = herves;
                    dropdown.innerHTML = filtered.length ?
                        filtered.map(item =>
                            `<div onclick="selectItem('${item.id}', '${item.name}','${divId}')">${item.name}</div>`)
                        .join('') :
                        '<div>نتیجه‌ای یافت نشد</div>';
                }
                box.classList.toggle("filled", input.value.trim() !== "");
            }
            const firstOption = dropdown.querySelector("div");
            if (firstOption) firstOption.classList.add("active");
        }

        function selectItem(id, name, divId) {
            const input = document.getElementById("searchInput" + divId);
            const box = document.getElementById("autocompleteBox" + divId);
            const dropdown = document.getElementById("dropdownList" + divId);


            if (divId == "state") {
                $('selectedId').change(function() { // به تغییرات در لیست *استان* گوش میدیم
                    var cityId = $(this).val(); //  مقدار (ID) *استان* انتخاب شده
                    if (cityId) {
                        $.ajax({
                            url: '/states/' + cityId, //  URL جدید
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                const filtered = data.filter(item => item.title.toLowerCase().includes(
                                    value));
                                dropdown.innerHTML = filtered.length ?
                                    filtered.map(item =>
                                        `<div onclick="selectItem(${item.id}, '${item.title}','${divId}')">${item.title}</div>`
                                    )
                                    .join('') :
                                    '<div>نتیجه‌ای یافت نشد</div>';
                                box.classList.toggle("filled", input.value.trim() !== "");
                            }
                        });
                    } else {
                        $('#state').empty();
                        $('#state').append(
                            '<option value="">شهرستان</option>'); //اگر استانی انتخاب *نشد*، شهرستان ها خالی
                    }
                });
                clearInput('city');
            }

            input.value = name;
            const select = document.getElementById("selectedId" + divId);
            select.value = id;
            select.dispatchEvent(new Event('input', {
                bubbles: true
            }));
            box.classList.add("filled");
            dropdown.style.display = 'none';
            const clearBtn = document.getElementById("clearBtn_" + divId);
            clearBtn.style.display = 'block';
        }

        function clearInput(id) {
            if (id == 'name' || id == 'reshte') {
                const box = document.getElementById("autocompleteBox" + id);
                box.classList.remove("filled");
                const input = document.getElementById("searchInput" + id);
                input.value = "";
                const clearBtn = document.getElementById("clearBtn_" + id);
                clearBtn.style.display = 'none';
            } else {
                const box = document.getElementById("autocompleteBox" + id);
                const input = document.getElementById("searchInput" + id);
                input.value = "";
                const select = document.getElementById("selectedId" + id);
                select.value = '';
                select.dispatchEvent(new Event('input', {
                    bubbles: true
                }));
                box.classList.remove("filled");
                if (id == 'state') {
                    const box2 = document.getElementById("autocompleteBoxcity");
                    const input2 = document.getElementById("searchInputcity");
                    input2.value = "";
                    document.getElementById("selectedIdcity").value = "";
                    box2.classList.remove("filled");
                    const clearBtn2 = document.getElementById("clearBtn_city");
                    clearBtn2.style.display = 'none';
                }
                const clearBtn = document.getElementById("clearBtn_" + id);
                clearBtn.style.display = 'none';
                filterOptions(id, 0);
            }
        }

        // بستن لیست با کلیک خارج از آن
        document.addEventListener("click", function(e) {
            const box1 = document.getElementById("autocompleteBoxstate");
            const box2 = document.getElementById("autocompleteBoxcity");
            const box3 = document.getElementById("autocompleteBoxgroup");
            const box4 = document.getElementById("autocompleteBoxherfe");
            const dropdown1 = document.getElementById("dropdownListstate");
            const dropdown2 = document.getElementById("dropdownListcity");
            const dropdown3 = document.getElementById("dropdownListgroup");
            const dropdown4 = document.getElementById("dropdownListherfe");


            if (box1 && !box1.contains(e.target)) {
                dropdown1.style.display = "none";
            }
            if (box2 && !box2.contains(e.target)) {
                dropdown2.style.display = "none";
            }
            if (box3 && !box3.contains(e.target)) {
                dropdown3.style.display = "none";
            }
            if (box4 && !box4.contains(e.target)) {
                dropdown4.style.display = "none";
            }
        });

        document.querySelectorAll("input[id^='searchInput']").forEach(input => {
            if (this.id.replace("searchInput", "") != reshte) {
                input.addEventListener("keydown", function(e) {
                    const id = this.id.replace("searchInput", "");
                    const dropdown = document.getElementById("dropdownList" + id);
                    const items = dropdown.querySelectorAll("div");
                    const active = dropdown.querySelector(".active");
                    let index = Array.from(items).indexOf(active);

                    if (e.key === "ArrowDown") {
                        e.preventDefault();
                        if (index < items.length - 1) {
                            if (active) active.classList.remove("active");
                            items[index + 1].classList.add("active");
                            items[index + 1].scrollIntoView({
                                block: "nearest"
                            });
                        }
                    }

                    if (e.key === "ArrowUp") {
                        e.preventDefault();
                        if (index > 0) {
                            if (active) active.classList.remove("active");
                            items[index - 1].classList.add("active");
                            items[index - 1].scrollIntoView({
                                block: "nearest"
                            });
                        }
                    }

                    if (e.key === "Enter") {
                        e.preventDefault();
                        if (active) {
                            active.click();
                            // const idValue = getIdFromElement(active); // تابع استخراج id
                            // const name = active.textContent.trim();
                            // selectItem(idValue, name, id);
                        }
                    }
                });
            }
        });

        function getIdFromElement(el) {
            // استخراج id از onclick
            const onclick = el.getAttribute("onclick");
            const match = onclick.match(/selectItem\((\d+),/);
            return match ? parseInt(match[1]) : "";
        }
    </script>
@endsection
