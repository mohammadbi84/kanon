<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;
    protected $fillable = ['ip', 'user_agent', 'user_id'];

    public function visitable()
    {
        return $this->morphTo();
    }
}
