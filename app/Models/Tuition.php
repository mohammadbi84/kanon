<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuition extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'state_id',
        'start_date',
        'end_date'
    ];

    // شهر مربوطه
    public function state()
    {
        return $this->belongsTo(City::class,'state_id');
    }
    public function cities()
    {
        return $this->belongsToMany(City::class, 'tuition_cities');
    }

    // حرفه‌ها
    public function professions()
    {
        return $this->belongsToMany(Profession::class, 'profession_tuitions')
            ->withPivot(['price_in_person', 'price_virtual', 'price_online'])
            ->withTimestamps();
    }
}
