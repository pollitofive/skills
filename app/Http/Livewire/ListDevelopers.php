<?php

namespace App\Http\Livewire;

use App\Models\Developer as DeveloperModel;
use Livewire\Component;
use Livewire\WithPagination;

class ListDevelopers extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'bootstrap';

    public bool $active = true;

    public string $search = '';

    protected $listeners = [
        '$refresh',
    ];

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.list-developers', [
            'developers' => DeveloperModel::search($this->search, $this->active, auth()->user()->id)->paginate(5),
        ]);
    }
}
