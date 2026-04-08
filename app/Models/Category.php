<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function clusters()
    {
        return $this->hasMany(Cluster::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
