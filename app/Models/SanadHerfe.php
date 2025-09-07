<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TuitionSanad;

class SanadHerfe extends Model
{
    use HasFactory;
    protected $fillable = [
        'sanad_id',
        'standard_code',
        'duration',
        'in_person_fee',
        'online_fee',
        'electronic_fee',
    ];
    public function tuitionsanads()
    {
        return $this->hasMany(TuitionSanad::class, 'sanad_id');
    }
}
