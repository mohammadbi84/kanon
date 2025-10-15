<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Popup extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'text',
        'start_date',
        'end_date',
        'status',
    ];

    // رابطه چندریختی با فایل‌ها
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
