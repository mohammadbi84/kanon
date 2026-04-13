<?php

namespace App\Imports;

use App\Models\Profession;
use App\Models\Field;
use App\Models\JobType;
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
        $this->jobTypes   = JobType::pluck('id', 'name');
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

        if (empty($row['حرفه'])) {
            $this->logError('نام خالی است', $row);
            return null;
        }

        if (empty($row['کد_استاندارد_ایسکو']) || strlen(trim($row['کد_استاندارد_ایسکو'])) !== 15) {
            $this->logError('کد استاندارد جدید نامعتبر است (باید 15 رقم باشد)', $row);
            return null;
        }

        // رشته اجباری
        $fieldId = $this->fields[trim($row['رشته'])] ?? null;
        if (!$fieldId) {
            $this->logError('رشته ' . $row['رشته'] . ' یافت نشد', $row);
            return null;
        }

        if (
            Profession::where('name', trim($row['حرفه']))->where('new_standard_code', trim($row['کد_استاندارد_ایسکو']))->where('field_id', $fieldId)->first() ||
            Profession::where('name', trim($row['حرفه']))->where('field_id', $fieldId)->first()
        ) {
            $this->logError('حرفه با این نام و رشته وجود دارد.', $row);
            return null;
        }

        // ------------------------------
        // 2) تبدیل ساعت/دقیقه
        // ------------------------------

        $th = (int)($row['تئوری_ساعت'] ?? 0);
        $tm = (int)($row['تئوری_دقیقه'] ?? 0);
        $ph = (int)($row['عملی_ساعت'] ?? 0);
        $pm = (int)($row['عملی_دقیقه'] ?? 0);
        $prh = (int)($row['پروژه_ساعت'] ?? 0);
        $prm = (int)($row['پروژه_دقیقه'] ?? 0);
        $ih = (int)($row['کارورزی_ساعت'] ?? 0);
        $im = (int)($row['کارورزی_دقیقه'] ?? 0);

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
        $kardaneshId = $this->kardanesh[trim($row['نوع_کار_و_دانش'] ?? '')] ?? null;
        $minEduId = $this->minEdu[trim($row['حداقل_تحصیلات'] ?? '')] ?? null;

        if (!$jobtypeId && $row['نوع']) {
            $record = Jobtype::create(['name' => $row['نوع']]);
            $jobtypeId = $record->id;
        }
        if (!$kardaneshId && $row['نوع_کار_و_دانش']) {
            $record = Kardanesh::create(['name' => $row['نوع_کار_و_دانش']]);
            $kardaneshId = $record->id;
        }
        if (!$minEduId && $row['حداقل_تحصیلات']) {
            $newMinEdu = MinEducation::create(['name' => $row['حداقل_تحصیلات']]);
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
        return 1000;
    }

    // هر بار ۵۰۰ رکورد insert
    public function batchSize(): int
    {
        return 500;
    }
}
