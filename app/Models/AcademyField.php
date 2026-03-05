<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademyField extends Model
{
    use HasFactory;
    protected $fillable = ['academy_id', 'field_id'];

}
