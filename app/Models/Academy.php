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
    ];

    protected $casts = [
        'extra_data' => 'array',
    ];

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }
}
