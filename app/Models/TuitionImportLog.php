<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuitionImportLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'tuition_import_id',
        'success',
        'row_number',
        'error_message',
        'data',
    ];

    protected $casts = [
        'success' => 'boolean',
    ];
    public function import()
    {
        return $this->belongsTo(TuitionImport::class);
    }
}
