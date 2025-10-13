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
    public function kardanesh()
    {
        return $this->belongsTo(Kardanesh::class);
    }
    public function jobtype()
    {
        return $this->belongsTo(Jobtype::class);
    }
    public function tuitions()
    {
        return $this->belongsToMany(Tuition::class,'profession_tuitions')
            ->withPivot(['price_in_person', 'price_virtual', 'price_online'])
            ->withTimestamps();
    }
}
