<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Moases extends Model
{
    use HasFactory;
    use SoftDeletes;
       protected $fillable = [
        'name',  
        'family',
        'national_code',
        'shenasname',
        'gender',
        'father',
        'birthday',
        'sadere',
        'sherkat_name',
        'sherkat_sab',
        'sherkat_modir',
        'sherkat_tarikh',
    ];

}
