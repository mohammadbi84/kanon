<?php

namespace App\Imports;

use App\Models\Profession;
use App\Models\Field;
use App\Models\Jobtype;
use App\Models\Kardanesh;
use App\Models\MinEducation;
use App\Models\ProfessionImportLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class ProfessionsImport implements
    ToModel,
    WithHeadingRow,
    WithChunkReading,
    WithBatchInserts
{
    protected $rowNumber = 1;

    protected $fields;
    protected $jobTypes;
    protected $kardanesh;
    protected $minEdu;

    protected $logFile = 'import_logs/profession_errors.log';

    public function __construct()
    {
        $this->fields     = Field::pluck('id', 'name');
        $this->jobTypes   = Jobtype::pluck('id', 'name');
        $this->kardanesh  = Kardanesh::pluck('id', 'name');
        $this->minEdu     = MinEducation::pluck('id', 'name');

        if (!Storage::exists($this->logFile)) {
            Storage::put($this->logFile, "=== Import Error Log ===\n");
        }
    }

    public function model(array $row)
    {
        $this->rowNumber++;

        // ------------------------------
        // 1) اعتبارسنجی‌ها
        // ------------------------------

        if (empty($row['حرفه']) and empty($row['رسته']) and empty($row['خوشه']) and empty($row['کد_استاندارد_ایسکو']) and empty($row['رشته']) and empty($row['ساعت_تئوری']) and empty($row['ساعت_عملی'])) {
            $this->logError('عدم درج فیلد های رسته، خوشه، رشته، حرفه، کد استاندارد ایسکو، ساعات تئوری و ساعات عملی.', $row);
            return null;
        }
        if (empty($row['حرفه']) and empty($row['رسته']) and empty($row['خوشه']) and empty($row['کد_استاندارد_ایسکو']) and empty($row['رشته']) and empty($row['ساعت_تئوری'])) {
            $this->logError('عدم درج فیلد های رسته، خوشه، رشته، حرفه، کد استاندارد ایسکو و ساعات تئوری.', $row);
            return null;
        }
        if (empty($row['حرفه']) and empty($row['رسته']) and empty($row['خوشه']) and empty($row['کد_استاندارد_ایسکو']) and empty($row['رشته'])) {
            $this->logError('عدم درج فیلد های رسته، خوشه، رشته، حرفه و کد استاندارد ایسکو.', $row);
            return null;
        }
        if (empty($row['حرفه']) and empty($row['رسته']) and empty($row['خوشه']) and empty($row['کد_استاندارد_ایسکو'])) {
            $this->logError('عدم درج فیلد های رسته، خوشه، حرفه و کد استاندارد ایسکو.', $row);
            return null;
        }
        if (empty($row['حرفه'])) {
            $this->logError('عدم درج نام حرفه', $row);
            return null;
        }
        if (empty($row['رسته'])) {
            $this->logError('عدم درج نام رسته.', $row);
            return null;
        }
        if (empty($row['خوشه'])) {
            $this->logError('عدم درج نام خوشه', $row);
            return null;
        }

        if (empty($row['کد_استاندارد_ایسکو'])) {
            $this->logError('عدم درج کد استاندارد ایسکو', $row);
            return null;
        }
        if (strlen(trim($row['کد_استاندارد_ایسکو'])) !== 15) {
            $this->logError('صحیح نبودن استاندارد ایسکو', $row);
            return null;
        }

        // رشته اجباری
        $fieldId = $this->fields[trim($row['رشته'])] ?? null;
        if (!$fieldId) {
            $this->logError('عدم یافت رشته ' . $row['رشته'], $row);
            return null;
        }

        if (Profession::where('new_standard_code', trim($row['کد_استاندارد_ایسکو']))->first()) {
            $this->logError('تکراری بودن کد ایسکو.', $row);
            return null;
        }

        if (Profession::where('name', trim($row['حرفه']))->where('field_id', $fieldId)->first()) {
            $this->logError('تکراری بودن نام حرفه.', $row);
            return null;
        }

        // ------------------------------
        // 2) تبدیل ساعت/دقیقه
        // ------------------------------

        $th = (int)($row['ساعت_تئوری'] ?? 0);
        if (!isset($row['ساعت_تئوری'])) {
            $this->logError('عدم درج ساعت تئوری.', $row);
            return null;
        }
        $tm = (int)($row['دقیقه_تئوری'] ?? 0);
        if (!isset($row['دقیقه_تئوری'])) {
            $this->logError('عدم درج دقیقه تئوری.', $row);
            return null;
        }
        if ((int)($row['دقیقه_تئوری']) > 59) {
            $this->logError('نامعتبر بودن زمان تئوری وارد شده.', $row);
            return null;
        }
        $ph = (int)($row['ساعت_عملی'] ?? 0);
        if (!isset($row['ساعت_عملی'])) {
            $this->logError('عدم درج ساعت عملی.', $row);
            return null;
        }
        $pm = (int)($row['دقیقه_عملی'] ?? 0);
        if (!isset($row['دقیقه_عملی'])) {
            $this->logError('عدم درج دقیقه عملی.', $row);
            return null;
        }
        if ((int)($row['دقیقه_عملی']) > 59) {
            $this->logError('نامعتبر بودن زمان عملی وارد شده.', $row);
            return null;
        }
        $prh = (int)($row['ساعت_پروژه'] ?? 0);
        $prm = (int)($row['دقیقه_پروژه'] ?? 0);
        if ((int)($row['دقیقه_پروژه']) > 59) {
            $this->logError('نامعتبر بودن زمان پروژه وارد شده.', $row);
            return null;
        }
        $ih = (int)($row['ساعت_کارورزی'] ?? 0);
        $im = (int)($row['دقیقه_کارورزی'] ?? 0);
        if ((int)($row['دقیقه_کارورزی']) > 59) {
            $this->logError('نامعتبر بودن زمان کارورزی وارد شده.', $row);
            return null;
        }

        $totalMinutes =
            ($th * 60 + $tm) +
            ($ph * 60 + $pm) +
            ($prh * 60 + $prm) +
            ($ih * 60 + $im);

        $totalHour = intdiv($totalMinutes, 60);
        $totalMinute = $totalMinutes % 60;

        // ------------------------------
        // 3) lookup بدون query اضافی
        // ------------------------------

        $jobtypeId = $this->jobTypes[trim($row['نوع'] ?? '')] ?? null;
        $kardaneshId = $this->kardanesh[trim($row['نوع_کارودانش'] ?? '')] ?? null;
        $minEduId = $this->minEdu[trim($row['حداقل_تحصیلات'] ?? '')] ?? null;

        if (!$jobtypeId && $row['نوع']) {
            $record = Jobtype::create(['name' => $row['نوع']]);
            $jobtypeId = $record->id;
        }
        if (!$kardaneshId && $row['نوع_کارودانش']) {
            $record = Kardanesh::create(['name' => $row['نوع_کارودانش']]);
            $kardaneshId = $record->id;
        }
        if (!$minEduId && trim($row['حداقل_تحصیلات'])) {
            $newMinEdu = MinEducation::create(['name' => trim($row['حداقل_تحصیلات'])]);
            $minEduId = $newMinEdu->id;
        }

        // ------------------------------
        // 4) ساخت رکورد نهایی
        // ------------------------------

        ProfessionImportLog::create([
            'profession_import_id' => session()->get('import_id'),
            'success' => true,
            'row_number' => $this->rowNumber,
            'error_message' => 'با موفقیت وارد شد.',
            'data' => json_encode($row, JSON_UNESCAPED_UNICODE),
        ]);
        return new Profession([
            'name' => trim($row['حرفه']),
            'field_id' => $fieldId,

            'new_standard_code' => trim($row['کد_استاندارد_ایسکو']),
            'old_standard_code' => trim($row['کد_استاندارد_قدیم'] ?? ''),

            'theory_hour' => $th,
            'theory_minute' => $tm,
            'practice_hour' => $ph,
            'practice_minute' => $pm,
            'project_hour' => $prh,
            'project_minute' => $prm,
            'internship_hour' => $ih,
            'internship_minute' => $im,

            'total_hour' => $totalHour,
            'total_minute' => $totalMinute,

            'trainer_qualification' => $row['صلاحیت_مربی'] ?? null,
            'prerequisites' => $row['پیشنیاز'] ?? null,

            'draft_date' => $row['تاریخ_تدوین'] ?? null,

            'jobtype_id' => $jobtypeId,
            'kardanesh_id' => $kardaneshId,
            'min_education_id' => $minEduId,
        ]);
    }

    // ------------------------------
    // نوشتن لاگ در فایل اختصاصی
    // ------------------------------

    protected function logError($message, $row)
    {
        ProfessionImportLog::create([
            'profession_import_id' => session()->get('import_id'),
            'success' => false,
            'row_number' => $this->rowNumber,
            'error_message' => $message,
            'data' => json_encode($row, JSON_UNESCAPED_UNICODE),
        ]);
        Storage::append(
            $this->logFile,
            "Row {$this->rowNumber}: {$message} | Data: " . json_encode($row, JSON_UNESCAPED_UNICODE)
        );
    }

    // هر بار ۱۰۰۰ ردیف
    public function chunkSize(): int
    {
        return 100000000;
    }

    // هر بار ۵۰۰ رکورد insert
    public function batchSize(): int
    {
        return 1;
    }
}
