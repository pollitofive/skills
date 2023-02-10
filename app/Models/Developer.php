<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    use HasFactory;

    public function skills_x_developer()
    {
        return $this->hasMany(SkillXDeveloper::class);
    }
}
