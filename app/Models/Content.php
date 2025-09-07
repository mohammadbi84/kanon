<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = ['title', 'content', 'parent_id'];

    protected $casts = [
        'content' => 'array', // تبدیل فیلد content به آرایه برای ذخیره عنوان و متن
    ];

    // رابطه یک به چند برای زیرمجموعه‌ها
    public function children()
    {
        return $this->hasMany(Content::class, 'parent_id');
    }
}
