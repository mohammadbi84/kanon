<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    use HasFactory;
    protected $fillable = [
        'field_id',
        'old_standard_code',
        'new_standard_code',
        'name',
        'theory_hour',
        'theory_minute',
        'practice_hour',
        'practice_minute',
        'project_hour',
        'project_minute',
        'internship_hour',
        'internship_minute',
        'total_hour',
        'total_minute',
        'education_level',
        'kardanesh_id',
        'jobtype_id',
        'trainer_qualification',
        'draft_date',
        'image_path',
        'standard_file'
    ];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
