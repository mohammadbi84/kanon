<!DOCTYPE html>
<html lang="fa">
<head>
 @include('dashboard.layout.head')
</head>
<body>




@include('dashboard.layout.notification')
<!-- BEGIN LOADER -->
<div id="load_screen"> <div class="loader"> <div class="loader-content">
            <div class="spinner-grow align-self-center"></div>
        </div></div></div>
<!--  END LOADER -->

<!--  BEGIN NAVBAR  -->
@include('dashboard.layout.navbr')
<!--  END NAVBAR  -->

<!--  BEGIN NAVBAR  -->
@include('dashboard.layout.navbar2')
<!--  END NAVBAR  -->

<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">

    <div class="overlay"></div>
    <div class="search-overlay"></div>

    <!--  BEGIN SIDEBAR  -->
    @include('dashboard.layout.sidebar')
    <!--  END SIDEBAR  -->

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="row layout-top-spacing">

                @yield('content')

            </div>

        </div>

@include('dashboard.layout.footer')

    </div>
    <!--  END CONTENT AREA  -->

</div>
<!-- END MAIN CONTAINER -->

@include('dashboard.layout.end')

<script>
    // تابع برای افزودن جداکننده هزارگان
    function formatNumber(number) {
        if (!number || isNaN(number)) return '';
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    // تابع برای حذف جداکننده‌ها
    function unformatNumber(number) {
        if (!number) return '';
        return number.toString().replace(/,/g, '');
    }

    // فرمت کردن تمام اینپوت‌ها
    function formatAllInputs() {
        document.querySelectorAll('.price-input').forEach(input => {
            let rawValue = input.value;
            if (rawValue) {
                input.value = formatNumber(unformatNumber(rawValue));
            }
        });
    }

    // فرمت کردن هنگام بارگذاری صفحه
    document.addEventListener('DOMContentLoaded', function() {
        formatAllInputs();
    });

    // فرمت کردن هنگام تایپ و محدود کردن به اعداد
    document.querySelectorAll('.price-input').forEach(input => {
        input.addEventListener('input', function() {
            let value = unformatNumber(this.value);
            if (!isNaN(value) && value !== '') {
                this.value = formatNumber(value);
            } else {
                this.value = '';
            }
        });

        // جلوگیری از ورود غیرعدد
        input.addEventListener('keypress', function(event) {
            const charCode = event.which || event.keyCode;
            if (charCode < 48 || charCode > 57) {
                event.preventDefault();
            }
        });
    });

    // حذف کاماها قبل از ارسال فرم
    document.querySelector('form').addEventListener('submit', function() {
        document.querySelectorAll('.price-input').forEach(input => {
            input.value = unformatNumber(input.value);
        });
    });
</script>

@yield('script')
</body>
</html>
