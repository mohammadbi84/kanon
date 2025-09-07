<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Khabar_image extends Model
{
    use HasFactory;
    protected $fillable = [
        'khabar_id',
        'image_path',
    ];
    public function khabar()
    {
        return $this->belongsTo(Khabar::class);
    }
}
