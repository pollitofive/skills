<?php

namespace App\Models;

use App\Traits\TraitMethodFirst;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    protected $fillable = ['user_id', 'description'];

    use HasFactory, SoftDeletes, TraitMethodFirst;

    public static function search(string $search, bool $active, int $user_id): \Illuminate\Database\Eloquent\Builder
    {
        $model = self::where('user_id', '=', $user_id)
            ->where('description', 'like', '%'.$search.'%');

        if (! $active) {
            $model = $model->withTrashed();
        }

        return $model;
    }
}
