<?php

namespace App\Models;

use App\Traits\TraitMethodFirst;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Developer extends Model
{
    use HasFactory, SoftDeletes, TraitMethodFirst;

    public function skills_x_developer(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SkillXDeveloper::class);
    }

    public function skills(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Skill::class, SkillXDeveloper::class);
    }

    public function setData(array $developer): void
    {
        $this->user_id = $developer['user_id'];
        $this->firstname = $developer['firstname'];
        $this->lastname = $developer['lastname'];
        $this->nid = $developer['nid'];
        $this->email = $developer['email'];
        $this->birthday = $developer['birthday'];
    }

    public function saveSkills(array $skills): void
    {
        DB::table('skill_x_developers')->where('developer_id', '=', $this->id)->delete();
        foreach ($skills as $skill) {
            $skill_model = new SkillXDeveloper(['skill_id' => $skill]);
            $this->skills_x_developer()->save($skill_model);
        }
    }

    public static function search(string $value, bool $active, int $user_id): \Illuminate\Database\Eloquent\Builder
    {
        $model = self::select(DB::raw("developers.*,GROUP_CONCAT(skills.description SEPARATOR ',') as skills_string"))
            ->join('skill_x_developers', 'developers.id', '=', 'skill_x_developers.developer_id')
            ->join('skills', 'skill_x_developers.skill_id', '=', 'skills.id')->where('skills.user_id', '=', $user_id)
            ->with('skills')
            ->groupBy('developers.id')
            ->havingRaw("firstname LIKE '%".$value."%' or
                    lastname like '%".$value."%' or
                    nid like '%".$value."%' or
                    birthday like '%".$value."%' or
                    email like '%".$value."%' or
                    skills_string like '%".$value."%'");

        if (! $active) {
            $model = $model->withTrashed();
        }

        return $model;
    }
}
