<?php

namespace App\Traits;

trait TraitMethodFirst
{
    public static function first(int $id, int $user_id)
    {
        return self::whereId($id)
            ->whereUserId($user_id)
            ->withTrashed()
            ->first();
    }
}
