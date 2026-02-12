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
        'link',
        'sort',
    ];

    // رابطه چندریختی با فایل‌ها
    public function files()
    {
        return $this->morphMany(File::class, 'fileable'); 
    }
    /**
     * پاپ‌آپ فعال و در بازه زمانی معتبر
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1)
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', jdate()->now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', jdate()->now());
            });
    }
}
