<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SanadHerfe;

class TuitionSanad extends Model
{
    use HasFactory;
    protected $table = 'tuition_sanads'; // اصلاح نام جدول

    protected $fillable = [
        'tuition_id', // اضافه شد
        'year',
        'City',
        'sanad_id',
        'standard_code',
        'duration',
        'in_person_fee',
        'online_fee',
        'electronic_fee',
    ];
    public function sanad() {
        return $this->belongsTo(SanadHerfe::class, 'sanad_id');
    }
}
