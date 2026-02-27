<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'max_slots',
        'is_ordered',
        'settings',
        'is_active'
    ];

    protected $casts = [
        'settings' => 'array',
        'is_ordered' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function prices()
    {
        return $this->hasMany(PositionPrice::class);
    }

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }
}
