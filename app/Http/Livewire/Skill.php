<?php

namespace App\Http\Livewire;

use App\Models\Skill as SkillModel;
use App\Rules\UniqueSkillForUser;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Skill extends Component
{
    public $name;
    public $skill_id;
    public $message;
    protected $listeners = ['setEditElement' => 'edit','deleteElement' => 'delete','activateElement' => 'activate'];

    protected function rules()
    {
        return [
            'name' => ['required',new UniqueSkillForUser($this->skill_id)]
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

        $model->user_id = auth()->user()->id;
        $model->description = $skill['name'];
        $model->save();
        Cache::forget('skills.'.auth()->user()->id);

        $this->skill_id = '';
        $this->name = '';
        $this->message = 'Skill successfully saved.';
        $this->emitTo('list-skill', '$refresh');
    }

    public function edit($id)
    {
        $skill = SkillModel::whereId($id)
                            ->where('user_id','=',auth()->user()->id)
                            ->withTrashed()
                            ->first();
        $this->name = $skill->description;
        $this->skill_id = $skill->id;
    }

    public function delete($id)
    {
        $skill = SkillModel::whereId($id)
                            ->where('user_id','=',auth()->user()->id)
                            ->first();
        $skill->delete();
        Cache::forget('skills.'.auth()->user()->id);
        $this->emitTo('list-skill', '$refresh');
    }

    public function activate($id)
    {
        $skill = SkillModel::whereId($id)
                            ->where('user_id','=',auth()->user()->id)
                            ->withTrashed()
                            ->first();
        $skill->restore();
        Cache::forget('skills.'.auth()->user()->id);
        $this->emitTo('list-skill', '$refresh');
    }
}
