<?php

namespace App\Livewire;

use App\Models\Developer as DeveloperModel;
use App\Models\Skill as SkillModel;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Developer extends Component
{
    public int $developer_id = 0;

    public string $firstname;

    public string $nid;

    public string $lastname;

    public string $email;

    public string $birthday;

    public array $skills = [];

    public string $message;

    protected $listeners = ['setEditElement' => 'edit', 'deleteElement' => 'delete', 'activateElement' => 'activate'];

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.developer', [
            'list_skills' => Cache::remember('skills.'.auth()->user()->id, 33600, function () {
                return SkillModel::whereUserId(auth()->user()->id)->get();
            }),
        ]);
    }

    public function submitForm(): void
    {
        $developer = $this->validate();
        $model = $this->getModel();
        $developer['user_id'] = auth()->user()->id;
        $model->setData($developer);
        $model->save();
        $model->saveSkills($this->skills);

        $this->clearProperties();
        $this->message = 'Developer successfully saved.';

        $this->dispatch('contentChanged');
        $this->dispatch('scroll-to-list');
        $this->dispatch('hide-message');
        $this->dispatch('$refresh')->to('list-developers');
    }

    public function edit(int $id): void
    {
        $developer = DeveloperModel::first($id, auth()->user()->id);

        $this->firstname = $developer->firstname;
        $this->lastname = $developer->lastname;
        $this->nid = $developer->nid;
        $this->email = $developer->email;
        $this->birthday = $developer->birthday;
        $this->developer_id = $developer->id;

        $this->skills = $developer->skills_x_developer->pluck('skill_id')->toArray();
        $this->message = '';

        $this->dispatch('scroll-to-top');
    }

    public function delete(int $id): void
    {
        $developer = DeveloperModel::first($id, auth()->user()->id);
        $developer->delete();
        $this->dispatch('$refresh')->to('list-developers');
        $this->message = '';
    }

    public function activate(int $id): void
    {
        $developer = DeveloperModel::first($id, auth()->user()->id);
        $developer->restore();
        $this->dispatch('$refresh')->to('list-developers');
        $this->message = '';
    }

    private function getModel(): DeveloperModel
    {
        if ($this->developer_id) {
            return DeveloperModel::first($this->developer_id, auth()->user()->id);
        }

        return new DeveloperModel();
    }

    private function clearProperties(): void
    {
        $this->developer_id = 0;
        $this->firstname = '';
        $this->lastname = '';
        $this->nid = '';
        $this->email = '';
        $this->birthday = '';
        $this->skills = [];
    }

    protected function rules(): array
    {
        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'nid' => 'sometimes|numeric|unique:developers,nid,'.$this->developer_id,
            'email' => 'required|email|unique:developers,email,'.$this->developer_id,
            'birthday' => 'sometimes|date',
            'skills' => 'required',
        ];
    }

    protected function messages(): array
    {
        return [
            'skills.required' => 'You should select at least one skill.',
        ];
    }
}
