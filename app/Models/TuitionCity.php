<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuitionCity extends Model
{
    use HasFactory;

    protected $fillable = [
        'tuition_id',
        'city_id',
    ];
}
