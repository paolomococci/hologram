<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy]
class Catalog extends Component
{
    use WithPagination;

    public const TEST_PHASE = true;

    public const ARTICLES_PER_PAGE = 5;

    #[Session]
    public string $filterText = '';

    public $approved = [];

    public $deprecated = [];

    public bool $articleToggle = false;

    #[On('retrieveArticles')]
    public function showArticles(
        $filterText,
        $approved,
        $deprecated,
        $articleToggle
    ) {
        $this->filterText = $filterText;
        $this->approved = $approved;
        $this->deprecated = $deprecated;
        $this->articleToggle = $articleToggle;
    }

    #[Computed]
    public function approvedArticles()
    {
        $articleQuery = Article::query();
        return $articleQuery->where('title', 'LIKE', "%{$this->filterText}%")
            ->where('deprecated', false)
            ->paginate(self::ARTICLES_PER_PAGE);
    }

    #[Computed]
    public function deprecatedArticles()
    {
        $articleQuery = Article::query();
        return $articleQuery->where('title', 'LIKE', "%{$this->filterText}%")
            ->where('deprecated', true)
            ->paginate(self::ARTICLES_PER_PAGE);
    }

    #[Computed]
    public function totalNumberOfRetrievedArticles()
    {
        return Article::where('title', 'LIKE', "%{$this->filterText}%")->count();
    }

    #[Computed]
    public function totalNumberOfApprovedArticles()
    {
        return Article::where('title', 'LIKE', "%{$this->filterText}%")
            ->where('deprecated', false)
            ->count();
    }

    #[Computed]
    public function totalNumberOfDeprecatedArticles()
    {
        return Article::where('title', 'LIKE', "%{$this->filterText}%")
            ->where('deprecated', true)
            ->count();
    }

    public function resetArticles()
    {
        $this->reset(
            'filterText',
            'approved',
            'deprecated',
        );
    }

    public function deprecate(Article $article)
    {
        $article->update([
            'deprecated' => ! $this->articleToggle,
        ]);
        $this->resetArticles();
    }

    public function render()
    {
        return view('livewire.article.catalog');
    }
}
