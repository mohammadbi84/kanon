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
            const successLogs = [];
            const errorLogs = [];

            logs.forEach(log => {
                let rowData = typeof log.data === 'string' ? JSON
                    .parse(log.data) : log.data;
                if (log.success)
                    successLogs.push({
                        ...log,
                        rowData
                    });
                else
                    errorLogs.push({
                        ...log,
                        rowData
                    });
            });

            // تابع گروه‌بندی بر اساس رشته
            function groupByReshte(arr) {
                const grouped = {};
                arr.forEach(item => {
                    let reshte = item.rowData.رشته ?? 'نامشخص';
                    if (!grouped[reshte]) grouped[reshte] = [];
                    grouped[reshte].push(item);
                });
                return grouped;
            }

            const groupedSuccess = groupByReshte(successLogs);
            const groupedError = groupByReshte(errorLogs);

            // ساخت HTML خروجی
            let logsHtml = '';
            // بخش خطادارها
            if (errorLogs.length > 0) {
                logsHtml += `
                                        <div class="border rounded p-3 bg-white">
                                            <h6 class="text-danger mb-3">
                                                ثبت های ناموفق — ${errorLogs.length} مورد
                                            </h6>
                                    `;

                Object.keys(groupedError).forEach(reshte => {
                    const group = groupedError[reshte];
                    logsHtml += `
                                            <div class="mb-3 border rounded p-2 bg-light">
                                                <strong>رسته ${group[0].rowData.رسته ?? group[1].rowData.رسته ?? 'نامشخص'} / خوشه ${group[0].rowData.خوشه ?? group[0].rowData.خوشه ?? 'نامشخص'} / رشته ${reshte} ( ${group.length} مورد )</strong>
                                                <ul class="list-group list-group-flush mt-2">
                                        `;
                    group.forEach((log, i) => {
                        logsHtml += `
                                                <li class="list-group-item list-group-item-danger">
                                                    <div>${i + 1}</div>
                                                    <strong>️ردیف ${log.row_number}</strong>
                                                    <div>
                                                        حرفه ${log.rowData.حرفه} با کد ایسکو ${log.rowData.کد_استاندارد_ایسکو} درج نگردید.
                                                    </div>
                                                    <div>دلیل: ${log.error_message || '—'}</div>
                                                </li>
                                            `;
                    });
                    logsHtml += '</ul></div>';
                });
                logsHtml += '</div>';
            }
            // ✅ بخش موفق‌ها
            if (successLogs.length > 0) {
                logsHtml += `
                                        <div class="border rounded p-3 mb-3 bg-white">
                                            <h6 class="text-success mb-3">
                                                ثبت های موفق — ${successLogs.length} مورد
                                            </h6>
                                    `;

                Object.keys(groupedSuccess).forEach(reshte => {
                    const group = groupedSuccess[reshte];
                    logsHtml += `
                                            <div class="mb-3 ps-3">
                                                <strong>رسته ${group[0].rowData.رسته} / خوشه ${group[0].rowData.خوشه} / رشته ${reshte} ( ${group.length} مورد )</strong>
                                                <ul class="list-group list-group-flush mt-2">
                                        `;
                    group.forEach((log, i) => {
                        logsHtml += `
                                            <li class="list-group-item list-group-item-success">
                                                    <div>${i + 1}</div>
                                                    <strong>ردیف ${log.row_number}</strong>
                                                    <div>
                                                        حرفه ${log.rowData.حرفه} با کد ایسکو ${log.rowData.کد_استاندارد_ایسکو} با موفقیت درج گردید.
                                                    </div>
                                                </li>
                                            `;
                    });
                    logsHtml += '</ul></div>';
                });

                logsHtml += '</div>';
            }
            // نمایش نهایی
            document.getElementById('contentToPrint').innerHTML = logsHtml;



            // window.print();

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
