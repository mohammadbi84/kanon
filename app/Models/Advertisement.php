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
        return $this->belongsTo(Position::class,'position_id');
    }
    public function academy()
    {
        return $this->belongsTo(Academy::class,'academy_id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class,'creator_id');
    }

    public function reservations()
    {
        return $this->hasMany(AdvertisementReservation::class);
    }
}
