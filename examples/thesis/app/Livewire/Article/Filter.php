<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;
use Livewire\Attributes\Validate;

class Filter extends Component
{
    #[Session]
    #[Validate('required')]
    public string $filterText = '';

    public string $filterTerm = '';

    public string $placeholder = '';

    public $approved = [];

    public $deprecated = [];

    public bool $articleToggle = false;

    public function updatedFilterText($filterText)
    {
        $this->validate();
        $this->filterTerm = "%{$filterText}%";
        // dd($this->filterTerm);
        $approvedArticle = Article::where('title', 'LIKE', "%{$this->filterTerm}%")
            ->where('deprecated', false)
            ->get();
        // dd($approvedArticle);
        $this->approved = $approvedArticle;
        $deprecatedArticle = Article::where('title', 'LIKE', "%{$this->filterTerm}%")
            ->where('deprecated', true)
            ->get();
        // dd($deprecatedArticle);
        $this->deprecated = $deprecatedArticle;
        $this->dispatch(
            'retrieveArticles',
            approved: $this->approved,
            deprecated: $this->deprecated,
            articleToggle: $this->articleToggle,
            filterText: $this->filterText,
        );
    }

    public function toggle()
    {
        $this->articleToggle = !$this->articleToggle;
        $this->dispatch(
            'retrieveArticles',
            approved: $this->approved,
            deprecated: $this->deprecated,
            articleToggle: $this->articleToggle,
            filterText: $this->filterText,
        );
    }

    #[On('filter:clear-filtered-articles')]
    public function clear()
    {
        $this->reset(
            'approved',
            'deprecated',
            'articleToggle',
            'filterText',
        );
        $this->dispatch(
            'retrieveArticles',
            approved: $this->approved,
            deprecated: $this->deprecated,
            articleToggle: $this->articleToggle,
            filterText: $this->filterText,
        );
    }

    public function render()
    {
        return view('livewire.article.filter');
    }
}
