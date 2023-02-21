<?php

namespace App\Http\Livewire;

use App\Models\Skill as SkillModel;
use Livewire\Component;
use Livewire\WithPagination;

class ListSkill extends Component
{
    use WithPagination;

    public $active = true;
    public $search;

    protected $listeners = [
        '$refresh'
    ];

    public function render()
    {
        $model = SkillModel::where('user_id','=',auth()->user()->id)
                            ->where('description','like','%'.$this->search."%");
        if(! $this->active) {
            $model = $model->withTrashed();
        }

        $data = $model->paginate(5);
        return view('livewire.list-skill',[
            'skills' => $data
        ]);
    }
}
