<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Filter extends Component
{
    #[Session]
    #[Validate('required')]
    public string $filterText = '';

    public string $filterTerm = '';

    public string $placeholder = '';

    public $approvedArticlesDispatched = [];

    public $deprecatedArticlesDispatched = [];

    public bool $articleToggle = false;

    public function updatedFilterText($filterText)
    {
        $this->validate();
        $this->filterTerm = "%{$filterText}%";
        // dd($this->filterTerm);
        $approvedArticles = Article::where('title', 'LIKE', "%{$this->filterTerm}%")
            ->where('isDeprecated', false)
            ->get();
        // dd($approvedArticles);
        $this->approvedArticlesDispatched = $approvedArticles;
        $deprecatedArticles = Article::where('title', 'LIKE', "%{$this->filterTerm}%")
            ->where('isDeprecated', true)
            ->get();
        // dd($deprecatedArticles);
        $this->deprecatedArticlesDispatched = $deprecatedArticles;
        $this->dispatch(
            'retrieveArticles',
            approvedArticlesDispatched: $this->approvedArticlesDispatched,
            deprecatedArticlesDispatched: $this->deprecatedArticlesDispatched,
            articleToggle: $this->articleToggle,
            filterText: $this->filterText,
        );
    }

    public function toggle()
    {
        $this->articleToggle = ! $this->articleToggle;
        $this->dispatch(
            'retrieveArticles',
            approvedArticlesDispatched: $this->approvedArticlesDispatched,
            deprecatedArticlesDispatched: $this->deprecatedArticlesDispatched,
            articleToggle: $this->articleToggle,
            filterText: $this->filterText,
        );
    }

    #[On('filter:clear-filtered-articles')]
    public function clear()
    {
        $this->reset(
            'approvedArticlesDispatched',
            'deprecatedArticlesDispatched',
            'articleToggle',
            'filterText',
        );
        $this->dispatch(
            'retrieveArticles',
            approvedArticlesDispatched: $this->approvedArticlesDispatched,
            deprecatedArticlesDispatched: $this->deprecatedArticlesDispatched,
            articleToggle: $this->articleToggle,
            filterText: $this->filterText,
        );
    }

    public function render()
    {
        return view('livewire.article.filter');
    }
}
