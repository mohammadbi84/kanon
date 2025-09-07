<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Herfe;

class TuitionHerfe extends Model
{
    use HasFactory;
    protected $table = 'tuition_herves'; // اصلاح نام جدول

    protected $fillable = [
        'tuition_id', // اضافه شد
        'year',
        'City',
        'herfe_id',
        'standard_code',
        'duration',
        'in_person_fee',
        'online_fee',
        'electronic_fee',
    ];

    public function herfe() {
        return $this->belongsTo(Herfe::class, 'herfe_id');
    }
}
