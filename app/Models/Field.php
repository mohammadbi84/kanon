<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;
    protected $fillable = ['cluster_id', 'name', 'description'];

    public function cluster()
    {
        return $this->belongsTo(Cluster::class);
    }

    public function professions()
    {
        return $this->hasMany(Profession::class);
    }


}
