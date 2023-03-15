<?php

namespace App\Rules;

use App\Models\Skill;
use Illuminate\Contracts\Validation\Rule;

class UniqueSkillForUser implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($skill_id)
    {
        $this->skill_id = $skill_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Skill::where('description', '=', $value)
                ->where('id', '<>', $this->skill_id)
                ->where('user_id', '=', auth()->user()->id)
                ->withTrashed()
                ->first() === null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The skill already exist.';
    }
}
