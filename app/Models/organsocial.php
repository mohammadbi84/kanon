<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class organsocial extends Model
{
    use HasFactory;
    use SoftDeletes;
        protected $fillable = [
        'social_id',
        'organ_id',
        'address',  
    ];

}
