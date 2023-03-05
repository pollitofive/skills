<?php

namespace App\Http\Livewire;

use App\Models\Developer as DeveloperModel;
use App\Models\Skill as SkillAlias;
use App\Models\SkillXDeveloper;
use Illuminate\Support\Facades\Cache;
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

        $model->user_id = auth()->user()->id;
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
        $list_skills = Cache::remember('skills.'.auth()->user()->id,33600, function(){
            return SkillAlias::where('user_id','=',auth()->user()->id)->get();
        });

        return view('livewire.developer',[
            'list_skills' => $list_skills
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
            'skills.required' => 'You should select at least one skill.'
        ];
    }

    public function edit($id)
    {
        $developer = DeveloperModel::whereId($id)
            ->where('user_id','=',auth()->user()->id)
            ->withTrashed()
            ->first();
        $this->firstname = $developer->firstname;
        $this->lastname = $developer->lastname;
        $this->nid = $developer->nid;
        $this->email = $developer->email;
        $this->birthday = $developer->birthday;
        $this->developer_id = $developer->id;
        $this->skills = [];
        $this->message = '';

        $this->dispatchBrowserEvent('scroll-to-top');
    }

    public function delete($id)
    {
        $skill = DeveloperModel::whereId($id)
            ->where('user_id','=',auth()->user()->id)
            ->first();
        $skill->delete();
        $this->emitTo('list-developers', '$refresh');
        $this->message = '';
    }

    public function activate($id)
    {
        $skill = DeveloperModel::whereId($id)
                                ->where('user_id','=',auth()->user()->id)
                                ->withTrashed()
                                ->first();
        $skill->restore();
        $this->emitTo('list-developers', '$refresh');
        $this->message = '';
    }




}
