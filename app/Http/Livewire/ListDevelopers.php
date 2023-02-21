<?php

namespace App\Http\Livewire;

use App\Models\Developer as DeveloperModel;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ListDevelopers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $active = true;
    public $search;

    protected $listeners = [
        '$refresh'
    ];

    public function render()
    {
        $model = DeveloperModel::select(DB::raw("developers.*,GROUP_CONCAT(skills.description SEPARATOR ',') as skills_string"))
            ->join('skill_x_developers','developers.id','=','skill_x_developers.developer_id')
            ->join('skills','skill_x_developers.skill_id','=','skills.id')->where('skills.user_id','=',auth()->user()->id)
            ->with('skills')
            ->groupBy('developers.id')
            ->havingRaw("firstname LIKE '%".$this->search."%' or
                    lastname like '%".$this->search."%' or
                    nid like '%".$this->search."%' or
                    birthday like '%".$this->search."%' or
                    email like '%".$this->search."%' or
                    skills_string like '%".$this->search."%'");

        if(! $this->active) {
            $model = $model->withTrashed();
        }

        $data = $model->paginate(5);
        return view('livewire.list-developers',[
            'developers' => $data
        ]);
    }
}
