<?php
// app/Helpers/WordSegmenter.php

namespace PersianNLP;

class WordSegmenter
{
    /**
     * ورودی را پردازش می‌کند تا حروف جدا شده را به یک کلمه تبدیل کند.
     *
     * @param string $input
     * @return string
     */
    public function segment($input)
    {
        // حذف فاصله‌های ابتدا و انتها
        $input = trim($input);

        // تقسیم رشته به توکن‌ها بر اساس یک یا چند فاصله
        $tokens = preg_split('/\s+/u', $input);

        $words = [];
        $i = 0;

        while ($i < count($tokens)) {
            // اگر توکن فعلی تنها یک حرف است
            if (mb_strlen($tokens[$i], 'UTF-8') == 1) {
                $group = $tokens[$i];
                $i++;
                // تا زمانی که توکن‌های متوالی تک حرفی باشند، به هم بچسبانید
                while ($i < count($tokens) && mb_strlen($tokens[$i], 'UTF-8') == 1) {
                    $group .= $tokens[$i];
                    $i++;
                }
                $words[] = $group;
            } else {
                // اگر توکن چند حرفی است، آن را به عنوان یک کلمه جداگانه قرار دهید
                $words[] = $tokens[$i];
                $i++;
            }
        }

        // توکن‌ها (کلمات) را با یک فاصله به هم متصل کنید
        return implode(' ', $words);
    }
}
