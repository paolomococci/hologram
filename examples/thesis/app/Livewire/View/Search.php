<?php

namespace App\Livewire\View;

use App\Models\Article;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Lazy;

#[Lazy]
class Search extends Component
{
    public $searchText = '';

    public $placeholder = '';

    #[On('search:clear-results')]
    public function clear()
    {
        $this->reset(
            'searchText',
        );
    }

    protected function queryString()
    {
        return [
            'searchText' => [
                'as' => 'q',
                'history' => true,
                'except' => '',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.view.search', [
            'results' => Article::where('title', 'LIKE', "%{$this->searchText}%")->get(),
        ]);
    }
}
