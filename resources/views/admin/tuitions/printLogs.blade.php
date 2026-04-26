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
            // تقسیم به موفق و خطادار
            logs = @json($logs);

            // تقسیم به موفق و خطادار
            // جدا کردن موفق و ناموفق
            const successLogs = [];
            const errorLogs = [];

            logs.forEach(log => {
                let rowData = typeof log.data === 'string' ? JSON
                    .parse(log.data) : log.data;
                if (log.success) {
                    successLogs.push({
                        ...log,
                        rowData
                    });
                } else {
                    errorLogs.push({
                        ...log,
                        rowData
                    });
                }
            });

            let logsHtml = '';

            // 🟥 بخش خطاها
            if (errorLogs.length > 0) {
                logsHtml += `
                                            <ul class="list-group list-group-flush">
                                    `;

                errorLogs.forEach((log, i) => {
                    logsHtml += `
                                            <li class="list-group-item list-group-item-danger">
                                                <div>${i + 1}</div>
                                                <strong>ردیف ${log.row_number}</strong>
                                                <div>شهریه درج نگردید.</div>
                                                <div>دلیل: ${log.error_message || '—'}</div>
                                            </li>
                                        `;
                });

                logsHtml += '</ul>';
            }

            // 🟩 بخش موفق‌ها
            if (successLogs.length > 0) {
                logsHtml += `

                                            <ul class="list-group list-group-flush">
                                    `;

                successLogs.forEach((log, i) => {
                    logsHtml += `
                                            <li class="list-group-item list-group-item-success">
                                                <div>${i + 1}</div>
                                                <strong>ردیف ${log.row_number}</strong>
                                                <div>شهریه با موفقیت درج گردید.</div>
                                            </li>
                                        `;
                });

                logsHtml += '</ul>';
            }

            document.getElementById('contentToPrint').innerHTML = logsHtml;



            // window.print();

        });

        // ایونت برای بستن پنجره بعد از اتمام عملیات پرینت
        window.onafterprint = function() {
            setTimeout(() => {
                window.close();
            }, 500);
        };
    </script>
</body>

</html>
