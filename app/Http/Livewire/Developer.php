<?php

namespace App\Http\Livewire;

use App\Models\Developer as DeveloperModel;
use App\Models\Skill as SkillAlias;
use App\Models\SkillXDeveloper;
use Illuminate\Support\Facades\DB;
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
    protected $listeners = ['setEditElement' => 'edit','deleteElement' => 'delete','activateElement' => 'activate'];

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

        DB::table('skill_x_developers')->where('developer_id','=',$model->id)->delete();
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
        $this->message = 'Developer successfully saved.';

        $this->dispatchBrowserEvent('contentChanged');
        $this->dispatchBrowserEvent('scroll-to-list');
        $this->dispatchBrowserEvent('hide-message');
        $this->emitTo('list-developers', '$refresh');
    }

    public function render()
    {
        return view('livewire.developer',[
            'list_skills' => SkillAlias::all()
        ]);
    }

    protected function rules()
    {
        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'nid' => 'sometimes|numeric|unique:developers,nid,'.$this->developer_id,
            'email' => 'required|email|unique:developers,email,'.$this->developer_id,
            'birthday' => 'sometimes|date',
            'skills' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'skills.required' => 'You should select at least one skill'
        ];
    }

    public function activate($id)
    {
        $skill = DeveloperModel::whereId($id)->withTrashed()->first();
        $skill->restore();
        $this->emitTo('list-developers', '$refresh');
        $this->message = '';
    }


    public function delete($id)
    {
        $skill = DeveloperModel::whereId($id)->first();
        $skill->delete();
        $this->emitTo('list-developers', '$refresh');
        $this->message = '';
    }


    public function edit($id)
    {
        $developer = DeveloperModel::whereId($id)->withTrashed()->first();
        $this->firstname = $developer->firstname;
        $this->lastname = $developer->lastname;
        $this->nid = $developer->nid;
        $this->email = $developer->email;
        $this->birthday = $developer->birthday;
        $this->skills = $developer->skills;
        $this->developer_id = $developer->id;
        $this->message = '';

        $this->dispatchBrowserEvent('scroll-to-top');
    }



}
