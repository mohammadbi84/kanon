<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'academy_id',
        'position_id',
        'title',
        'description',
        'image',
        'video',
        'duration',
        'start_at',
        'end_at',
        'extra_data',
        'status',
        'rejected_reason',
        'payment_expires_at'
    ];

    protected $casts = [
        'extra_data' => 'array',
        'payment_expires_at' => 'datetime',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function reservations()
    {
        return $this->hasMany(AdvertisementReservation::class);
    }
}
