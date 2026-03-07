<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Academy extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'manager_id',
        'slug',
        'phone',
        'email',
        'logo',
        'cover_image',
        'description',
        'status',
        'rejected_reason',
        'extra_data',

        'id_number',
        'export_number',
        'export_start',
        'export_end',
        'license',
        'first_license_date',
        'gender',
        'tabsare_34',
        // اطلاعات موسس=============================================================
        // حقیقی
        'natural_name',
        'natural_family',
        'natural_father',
        'natural_birth_date',
        'national_code',
        'national_id_number',
        'natural_issue',
        // حقوقی
        'legal_company_name',
        'legal_register_number',
        'register_date',
        'legal_manager',
        // فیلد های مشترک موسس
        'founder_phone',
        'founder_mobile',
        'founder_email',
        'founder_address',
        // اطلاعات تماس ==========================================================
        'state_id',
        'city_id',
        'postal_code',
        'fax',
        'mobile',
        'address',

        'creator_id',
        'license_file_front',
        'license_file_back',
    ];

    protected $casts = [
        'extra_data' => 'array',
    ];

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }

    public function fields()
    {
        return $this->belongsToMany(Field::class, 'academy_fields')->withTimestamps();
    }

    // رابطه چندریختی با فایل‌ها
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function state()
    {
        return $this->belongsTo(City::class, 'state_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
