<?php

namespace App\Http\Livewire;

use App\Models\Skill as SkillModel;
use Livewire\Component;

class Skill extends Component
{
    public $name;
    public $skill_id;
    public $message;
    protected $listeners = ['setEditElement' => 'edit','deleteElement' => 'delete','activateElement' => 'activate'];
    protected $messages = [
        'name.unique' => 'The skill already exist'
    ];

    protected function rules()
    {
        return [
            'name' => 'required|unique:skills,description,'.$this->skill_id
        ];
    }


    public function render()
    {
        return view('livewire.skill');
    }

    public function submitForm()
    {
        $this->name = trim($this->name);
        $skill = $this->validate();
        if($this->skill_id) {
            $model = SkillModel::where('id',$this->skill_id)->first();
        } else {
            $model = new SkillModel();
        }

        $model->user_id = 1;
        $model->description = $skill['name'];
        $model->save();

        $this->skill_id = '';
        $this->name = '';
        $this->message = 'Skill successfully created.';
        $this->emitTo('list-skill', '$refresh');
    }

    public function edit($id)
    {
        $skill = SkillModel::whereId($id)->withTrashed()->first();
        $this->name = $skill->description;
        $this->skill_id = $skill->id;
    }

    public function delete($id)
    {
        $skill = SkillModel::whereId($id)->first();
        $skill->delete();
        $this->emitTo('list-skill', '$refresh');
    }

    public function activate($id)
    {
        $skill = SkillModel::whereId($id)->withTrashed()->first();
        $skill->restore();
        $this->emitTo('list-skill', '$refresh');
    }
}
