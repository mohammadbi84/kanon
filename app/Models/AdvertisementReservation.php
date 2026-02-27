<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertisementReservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'advertisement_id',
        'position_id',
        'date',
        'slot_number',
        'price',
        'status',
        'payment_expires_at'
    ];

    protected $casts = [
        'date' => 'date',
        'payment_expires_at' => 'datetime',
    ];

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
