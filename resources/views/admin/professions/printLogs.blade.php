<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>گزارش آپلود های انجام شده</title>
    <style>
        /* استایل‌های مهم برای حذف margin و padding اضافی */
        @page {
            margin: 0 !important;
            size: A4;
            /* یا هر سایز دلخواه دیگر */
        }

        body {
            margin: 0 !important;
            padding: 0 !important;
            font-family: 'Arial', sans-serif;
            /* یا هر فونت دلخواه */
            direction: rtl;
            /* اگر محتوا فارسی است */
            text-align: right;
            /* اگر محتوا فارسی است */
        }

        /* اینجا استایل‌های مربوط به خود محتوای پرینتی رو اضافه کن */
        .printable-section {
            padding: 20px;
            /* یک padding داخلی برای فاصله از لبه‌ها */
        }

        .printable-section h1 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        .printable-section p {
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        /* ... بقیه استایل‌های مورد نیاز ... */

        /* کلاس‌هایی که در پرینت لازم نیستند را پنهان کن */
        .no-print {
            display: none !important;
        }
    </style>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/rtl/core.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/rtl/theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/rtl/rtl.css') }}">
</head>

<body onload="window.print()">
    <!-- اینجا محتوای واقعی پرینت قرار می‌گیرد -->
    <!-- این محتوا باید از طریق پارامتر URL به این صفحه ارسال شود -->
    <div class="printable-section" id="contentToPrint">
        <!-- محتوای داینامیک اینجا قرار می‌گیرد -->
    </div>

    <script>
        // دریافت محتوا از URL و قرار دادن در صفحه
        document.addEventListener('DOMContentLoaded', (event) => {
            const urlParams = new URLSearchParams(window.location.search);
            const content = urlParams.get('data'); // فرض می‌کنیم پارامتر 'data' نام دارد

            if (content) {
                document.getElementById('contentToPrint').innerHTML = decodeURIComponent(content);
                // بعد از قرار دادن محتوا، پرینت را آغاز کن
                window.print();
            } else {
                document.getElementById('contentToPrint').innerHTML = '<p>خطا: محتوایی برای پرینت یافت نشد.</p>';
                // اگر محتوا نبود، بلافاصله صفحه را ببند
                setTimeout(() => {
                    window.close();
                }, 1000); // یک ثانیه صبر کن و ببند
            }
        });

        // ایونت برای بستن پنجره بعد از اتمام عملیات پرینت
        window.onafterprint = function() {
            // یک تأخیر کوتاه برای اطمینان از اینکه همه عملیات مرورگر کامل شده
            setTimeout(() => {
                window.close();
            }, 500); // نیم ثانیه صبر کن و بعد ببند
        };
    </script>
</body>

</html>
