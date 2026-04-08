<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    use HasFactory;
    protected $fillable = ['category_id', 'name', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true)
            ->whereHas('category', function ($query) {
                $query->where('active', true);
            });
    }
}
