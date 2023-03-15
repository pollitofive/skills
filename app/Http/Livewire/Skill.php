<?php

namespace App\Http\Livewire;

use App\Models\Skill as SkillModel;
use App\Rules\UniqueSkillForUser;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Skill extends Component
{
    public string $name = '';

    public int $skill_id = 0;

    public string $message;

    protected $listeners = ['setEditElement' => 'edit', 'deleteElement' => 'delete', 'activateElement' => 'activate'];

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.skill');
    }

    public function submitForm(): void
    {
        $this->name = trim($this->name);
        $skill = $this->validate();
        $model = $this->getModel();

        $model->user_id = auth()->user()->id;
        $model->description = $skill['name'];
        $model->save();
        Cache::forget('skills.'.auth()->user()->id);

        $this->skill_id = 0;
        $this->name = '';
        $this->message = 'Skill successfully saved.';
        $this->emitTo('list-skill', '$refresh');
    }

    public function edit(int $id): void
    {
        $skill = SkillModel::first($id, auth()->user()->id);
        $this->name = $skill->description;
        $this->skill_id = $skill->id;
    }

    public function delete(int $id): void
    {
        $skill = SkillModel::first($id, auth()->user()->id);
        $skill->delete();
        Cache::forget('skills.'.auth()->user()->id);
        $this->emitTo('list-skill', '$refresh');
    }

    public function activate(int $id): void
    {
        $skill = SkillModel::first($id, auth()->user()->id);
        $skill->restore();
        Cache::forget('skills.'.auth()->user()->id);
        $this->emitTo('list-skill', '$refresh');
    }

    public function getModel(): SkillModel
    {
        if ($this->skill_id) {
            return SkillModel::where('id', $this->skill_id)->first();
        }

        return new SkillModel();
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', new UniqueSkillForUser($this->skill_id)],
        ];
    }
}
