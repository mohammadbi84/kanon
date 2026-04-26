<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuitionImport extends Model
{
    use HasFactory;

    protected $fillable = [
        'tuition_id',
        'batch_id',
        'file_name',
    ];
    public function logs()
    {
        return $this->hasMany(TuitionImportLog::class);
    }
}
