<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'phone',
        'email',
        'logo',
        'cover_image',
        'description',
        'status',
        'rejected_reason',
        'extra_data'
    ];

    protected $casts = [
        'extra_data' => 'array',
    ];

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }
}
