<?php

namespace App\Imports;

use App\Models\Profession;
use App\Models\ProfessionTuition;
use App\Models\TuitionImportLog;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class TuitionImport implements
    ToModel,
    WithHeadingRow,
    WithChunkReading,
    WithBatchInserts
{
    protected $rowNumber = 1;

    protected $logFile = 'import_logs/tuition_errors.log';

    public function __construct()
    {

        if (!Storage::exists($this->logFile)) {
            Storage::put($this->logFile, "=== Import Error Log ===\n");
        }
    }
    public function model(array $row)
    {
        $this->rowNumber++;

        if (empty($row['کد_استاندارد_ایسکو'])) {
            $this->logError('عدم درج کد استاندارد ایسکو', $row);
            return null;
        }
        if (empty($row['حضوری'])) {
            $this->logError('عدم درج شهریه حضوری', $row);
            return null;
        }
        if (empty($row['مجازی'])) {
            $this->logError('عدم درج شهریه مجازی', $row);
            return null;
        }
        if (empty($row['الکترونیکی'])) {
            $this->logError('عدم درج شهریه الکترونیکی', $row);
            return null;
        }
        if (empty($row['حرفه'])) {
            $this->logError('عدم درج حرفه', $row);
            return null;
        }

        $profession = Profession::where('new_standard_code', $row['کد_استاندارد_ایسکو'])->first();


        TuitionImportLog::create([
            'tuition_import_id' => session()->get('import_id'),
            'success' => true,
            'row_number' => $this->rowNumber,
            'error_message' => 'با موفقیت وارد شد.',
            'data' => json_encode($row, JSON_UNESCAPED_UNICODE),
        ]);
        return new ProfessionTuition([
            'tuition_id' => session()->get('tuition_id'),
            'profession_id' => $profession->id,
            'price_in_person' => $row['حضوری'],
            'price_virtual' => $row['مجازی'],
            'price_online' => $row['الکترونیکی'],
        ]);
    }

    protected function logError($message, $row)
    {
        TuitionImportLog::create([
            'tuition_import_id' => session()->get('import_id'),
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
        return 6000;
    }

    // هر بار ۵۰۰ رکورد insert
    public function batchSize(): int
    {
        return 1;
    }
}
