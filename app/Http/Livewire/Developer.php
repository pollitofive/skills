<?php

namespace App\Http\Livewire;

use App\Models\Developer as DeveloperModel;
use App\Models\Skill as SkillAlias;
use App\Models\SkillXDeveloper;
use Livewire\Component;

class Developer extends Component
{
    public $developer_id;
    public $firstname;
    public $nid;
    public $lastname;
    public $email;
    public $birthday;
    public $skills = [];
    public $message;

    protected function rules()
    {
        return [
            'firstname' => 'required',
            'lastname' => 'required',
//            'nid' => 'sometimes|numeric|unique:developers',
            'nid' => 'sometimes',
//            'email' => 'required|email|unique:developers',
            'email' => 'required',
            'birthday' => 'sometimes|date'
        ];
    }

    public function submitForm()
    {
        $developer = $this->validate();
        if($this->developer_id) {
            $model = DeveloperModel::where('id',$this->developer_id)->first();
        } else {
            $model = new DeveloperModel();
        }
        $model->user_id = 1;
        $model->firstname = $developer['firstname'];
        $model->lastname = $developer['lastname'];
        $model->nid = $developer['nid'];
        $model->email = $developer['email'];
        $model->birthday = $developer['birthday'];
        $model->save();

        foreach($this->skills as $skill) {
            $skill_model = new SkillXDeveloper(['skill_id' => $skill]);
            $model->skills_x_developer()->save($skill_model);
        }

        $this->developer_id = '';
        $this->firstname = '';
        $this->lastname = '';
        $this->nid = '';
        $this->email = '';
        $this->birthday = '';
        $this->skills = [];
        $this->message = 'Skill successfully created.';

        $this->dispatchBrowserEvent('contentChanged');
    }

    public function render()
    {
        return view('livewire.developer',[
            'list_skills' => SkillAlias::all()
        ]);
    }
}
