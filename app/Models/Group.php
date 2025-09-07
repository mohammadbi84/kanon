<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    public function courses()
    {
        return $this->hasMany(Course::class, 'group_id');
    }
    public function khoshe()
    {
        return $this->belongsTo(Khoshe::class);
    }
    public function herfeOrgan()
    {
        return $this->hasMany(HerfeOrgan::class, 'herfe_id');
    }
}
