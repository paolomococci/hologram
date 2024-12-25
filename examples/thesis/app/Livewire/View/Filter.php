<?php

namespace App\Livewire\View;

use App\Models\Article;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Filter extends Component
{
    #[Validate('required')]
    public $filterText = '';

    public bool $deprecated = false;

    public $articles = [];

    public $placeholder = '';

    public function toggle()
    {
        $this->deprecated = ! ($this->deprecated);
        $this->updatedFilterText($this->filterText);
    }

    public function updatedFilterText($filterText)
    {
        $this->reset('articles');
        $this->validate();
        $filterTerm = "%{$filterText}%";
        $this->articles = Article::where('title', 'LIKE', $filterTerm)
            ->where('deprecated', $this->deprecated)
            ->get();
        $this->dispatch(
            'retrieveArticles',
            articles: $this->articles,
            deprecated: $this->deprecated,
            filterText: $this->filterText,
        );
    }

    #[On('filter:clear-filtered-articles')]
    public function clear()
    {
        $this->reset(
            'articles',
            'filterText',
        );
        $this->dispatch(
            'retrieveArticles',
            articles: $this->articles,
            deprecated: $this->deprecated,
            filterText: $this->filterText,
        );
    }

    public function render()
    {
        return view('livewire.view.filter');
    }
}
