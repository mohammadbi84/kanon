<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterAlert extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
        'title',
        'text',
        'color',
    ];
}
