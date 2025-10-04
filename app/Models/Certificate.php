<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    protected $fillable = [
        'field_id',
        'standard_code',
        'title',
        'group_title',
        'jobtype_id',
        'duration_hour',
        'duration_minute',
        'is_archived',
        'draft_date',
        'file_path'
    ];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
