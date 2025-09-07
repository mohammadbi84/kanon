<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganLogChanges extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'organ_id',
        'changes',
    ];
}
