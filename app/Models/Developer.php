<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Developer extends Model
{
    use HasFactory, SoftDeletes;

    public function skills_x_developer()
    {
        return $this->hasMany(SkillXDeveloper::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class,SkillXDeveloper::class);
    }
}
