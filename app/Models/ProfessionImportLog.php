<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionImportLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'profession_import_id',
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
        return $this->belongsTo(ProfessionImport::class);
    }
}
