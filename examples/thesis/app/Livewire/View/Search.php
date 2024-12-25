<?php

namespace App\Livewire\View;

use App\Models\Article;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Search extends Component
{
    #[Validate('required')]
    public $searchText = '';

    public $results = [];

    public $placeholder = '';

    public function updatedSearchText($searchText)
    {
        $this->reset('results');
        $this->validate();
        $searchTerm = "%{$searchText}%";
        $this->results = Article::where('title', 'LIKE', $searchTerm)->get();
    }

    #[On('search:clear-results')]
    public function clear()
    {
        $this->reset(
            'results',
            'searchText',
        );
    }

    public function render()
    {
        return view('livewire.view.search');
    }
}
