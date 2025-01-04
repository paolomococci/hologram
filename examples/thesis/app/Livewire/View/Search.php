<?php

namespace App\Livewire\View;

use App\Models\Article;
use Livewire\Attributes\Isolate;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;

#[Isolate]
class Search extends Component
{
    #[Url(
        as: 'q',
        history: true,
        except: ''
    )]
    public $searchText = '';

    public $placeholder = '';

    #[On('search:clear-results')]
    public function clear()
    {
        $this->reset(
            'searchText',
        );
    }

    public function render()
    {
        return view('livewire.view.search', [
            'results' => Article::where('title', 'LIKE', "%{$this->searchText}%")->get(),
        ]);
    }
}
