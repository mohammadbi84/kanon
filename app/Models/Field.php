<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;
    protected $fillable = ['cluster_id', 'name', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function cluster()
    {
        return $this->belongsTo(Cluster::class);
    }

    public function professions()
    {
        return $this->hasMany(Profession::class);
    }
    public function academies()
    {
        return $this->belongsToMany(Academy::class, 'academy_fields')->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('active', true)
            ->whereHas('cluster', function ($query) {
                $query->where('active', true)
                    ->whereHas('category', function ($query) {
                        $query->where('active', true);
                    });
            });
    }
}
