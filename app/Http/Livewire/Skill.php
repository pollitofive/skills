<?php

namespace App\Http\Livewire;

use App\Models\Skill as SkillModel;
use Livewire\Component;

class Skill extends Component
{
    public $name;
    public $message;
    protected $rules = [
        'name' => 'required|unique:skills,description'
    ];
    protected $messages = [
        'name.unique' => 'The skill already exist'
    ];

    public function render()
    {
        return view('livewire.skill');
    }

    public function submitForm()
    {
        $skill = $this->validate();
        SkillModel::create(['user_id' => 1,'description' => $skill['name']]);

        $this->name = '';
        $this->message = 'Skill successfully created.';

    }
}
