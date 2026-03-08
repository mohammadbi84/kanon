<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Khabar extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'status',
        'body',
        'cover',
        'user_id',
        'start_at',
        'end_at',
    ];

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
    
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
