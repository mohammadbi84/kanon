<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Organ;

class Advertisement extends Model
{
    use HasFactory;
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function visits()
    {
        return $this->morphMany(\App\Models\Visit::class, 'visitable');
    }

    public function status()
    {
        switch ($this->status) {
            case '0':
                return 'داغترین';
            case 1:
                return 'نردبان شده';
            case null:
                return 'معمولی';
            default:
                return '--';
        }
    }
    public function StatusClass()
    {
        switch ($this->status) {
            case '0':
                return 'text-danger';
            case 1:
                return 'text-success';
            case null:
                return 'text-info';
            default:
                return '--';
        }
    }
    public function organ()
    {
        return $this->belongsTo(Organ::class, 'organ_id');
    }
}
