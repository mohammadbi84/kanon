<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    public function organ()
    {
        return $this->belongsTo(Organ::class, 'organ_id');
    }
    public function herfe()
    {
        return $this->belongsTo(Herfe::class, 'herfe_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
