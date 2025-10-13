<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuition extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'city_id', 'start_date', 'end_date'
    ];

    // شهر مربوطه
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    // حرفه‌ها
    public function professions()
    {
        return $this->belongsToMany(Profession::class, 'profession_tuitions')
            ->withPivot(['price_in_person', 'price_virtual', 'price_online'])
            ->withTimestamps();
    }

    // گواهی‌نامه‌ها
    public function certificates()
    {
        return $this->belongsToMany(Certificate::class, 'certificate_tuitions')
            ->withPivot(['price_in_person', 'price_virtual', 'price_online'])
            ->withTimestamps();
    }
}
