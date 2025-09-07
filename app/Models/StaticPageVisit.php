<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticPageVisit extends Model
{
    use HasFactory;
    protected $fillable = ['slug'];

    public function visits()
    {
        return $this->morphMany(Visit::class, 'visitable');
    }
}
