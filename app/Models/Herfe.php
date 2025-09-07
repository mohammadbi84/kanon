<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TuitionHerfe;
use App\Models\Jobtype;

class Herfe extends Model
{
    use HasFactory;
     public function courses()
    {
        return $this->hasMany(Course::class, 'herfe_id');
    }
     public function tuitionHerfes()
    {
        return $this->hasMany(TuitionHerfe::class, 'herfe_id');
    }
   
}
