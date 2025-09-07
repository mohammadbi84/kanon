<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Khoshe extends Model
{
    use HasFactory;
    public function herfes()
    {
        return $this->hasMany(Group::class);
    }
}
