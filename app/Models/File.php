<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
        'url',
        'type',
        'fileable_id',
        'fileable_type',
    ];

    // رابطه معکوس چندریختی
    public function fileable()
    {
        return $this->morphTo();
    }
}
