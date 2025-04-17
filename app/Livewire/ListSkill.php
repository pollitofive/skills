<?php

namespace App\Livewire;

use App\Models\Skill as SkillModel;
use Livewire\Component;
use Livewire\WithPagination;

class ListSkill extends Component
{
    use WithPagination;

    public bool $active = true;

    public string $search = '';

    protected $listeners = [
        '$refresh',
    ];

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.list-skill', [
            'skills' => SkillModel::search($this->search, $this->active, auth()->user()->id)->paginate(5),
        ]);
    }
}
