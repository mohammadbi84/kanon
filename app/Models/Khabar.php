<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Khabar extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'text',
        'publish_at',
        'archive_at',
        'user_id',
    ];

    public function images()
    {
        return $this->hasMany(Khabar_image::class);
    }
}
