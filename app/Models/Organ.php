<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Course;
use App\Models\OrganUser;
use App\Models\HerfeOrgan;
use App\Models\OrganSocial;
use App\Models\Moases;
use App\Models\City;

class Organ extends Model
{
    use HasFactory;
    // Organ.php
    public function courses()
    {
        return $this->hasMany(Course::class, 'organ_id');
    }

    public function cityRelation()
    {
        return $this->belongsTo(City::class, 'city');
    }

    public function moases()
    {
        return $this->hasOne(Moases::class, 'organ_id');
    }

    public function herfes()
    {
        return $this->hasManyThrough(Herfe::class, HerfeOrgan::class, 'organ_id', 'id', 'id', 'herfe_id');
    }

    public function socials()
    {
        return $this->hasMany(Organsocial::class, 'organ_id');
    }



    public function advertisements()  // Optional, for the reverse relationship
    {
        return $this->hasMany(Advertisement::class, 'organ_id');
    }

    public function StatusText()
    {

        switch ($this->status) {
            case '0':
                return 'در حال انتظار تایید مدیر ...';
            case '1':
                return ' تایید شده در انتظار پرداخت حق عضویت';
            case '2':
                return 'رد شده';
            case '3':
                return 'ارجاع به آموزشگاه';
            case '4':
                return 'بروزرسانی توسط مدیر';
            case '5':
                return 'حق عضویت پرداخت شده';
            default:
                return '_';
        }
    }
    public function ClassStatusText()
    {

        switch ($this->status) {
            case '0':
                return 'text-primary';
            case '1':
                return 'text-success';
            case '2':
                return 'text-danger';
            case '3':
                return 'text-dark';
            case '4':
                return 'text-success';
            case '5':
                return 'text-success';
            default:
                return '_';
        }
    }

    public function like($ip)
    {
        $liked = cache()->get("like_{$this->id}_{$ip}");

        if (!$liked) {
            $this->increment('like_count'); // افزایش تعداد لایک در دیتابیس
            cache()->put("like_{$this->id}_{$ip}", true, now()->addYear()); // ذخیره در کش برای جلوگیری از لایک مجدد
            return true;
        }

        return false; // کاربر قبلاً لایک کرده
    }

    // ثبت ویو (فقط یک‌بار در روز برای هر IP)
    public function view($ip)
    {
        $today = now()->toDateString();
        $viewed = cache()->get("view_{$this->id}_{$ip}_{$today}");

        if (!$viewed) {
            $this->increment('view_count'); // افزایش تعداد بازدید در دیتابیس
            cache()->put("view_{$this->id}_{$ip}_{$today}", true, now()->endOfDay()); // ذخیره در کش تا پایان روز
            return true;
        }

        return false; // امروز قبلاً بازدید ثبت شده
    }
}
