<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    public function cities()
    {
        return $this->hasMany(City::class, 'parent');
    }
    public function organs()
    {
        return $this->hasMany(Organ::class, 'parent');
    }
}
