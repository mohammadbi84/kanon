<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'position_id',
        'start_date',
        'end_date',
        'price_per_day',
        'price_per_second',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
