<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Herfe;

class Jobtype extends Model
{
    use HasFactory;
    public function professions()
    {
        return $this->hasMany(Profession::class);
    }
}
