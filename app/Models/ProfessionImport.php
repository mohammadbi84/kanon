<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionImport extends Model
{
    use HasFactory;
        protected $fillable = [
        'batch_id',
        'file_name',
    ];

    public function logs() {
        return $this->hasMany(ProfessionImportLog::class);
    }
}
