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

    public const TEST_PHASE = false;

    public const ARTICLES_PER_PAGE = 5;

    #[Session]
    public string $filterText = '';

    public $approvedArticlesDispatched = [];

    public $deprecatedArticlesDispatched = [];

    public bool $articleToggle = false;

    #[On('retrieveArticles')]
    public function showArticles(
        $filterText,
        $approvedArticlesDispatched,
        $deprecatedArticlesDispatched,
        $articleToggle
    ) {
        $this->filterText = $filterText;
        $this->approvedArticlesDispatched = $approvedArticlesDispatched;
        $this->deprecatedArticlesDispatched = $deprecatedArticlesDispatched;
        $this->articleToggle = $articleToggle;
    }

    #[Computed]
    public function approvedArticlesComputed()
    {
        $articleQuery = Article::query();

        return $articleQuery->where('title', 'LIKE', "%{$this->filterText}%")
            ->where('isDeprecated', false)
            ->paginate(self::ARTICLES_PER_PAGE);
    }

    #[Computed]
    public function deprecatedArticlesComputed()
    {
        $articleQuery = Article::query();

        return $articleQuery->where('title', 'LIKE', "%{$this->filterText}%")
            ->where('isDeprecated', true)
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
            ->where('isDeprecated', false)
            ->count();
    }

    #[Computed]
    public function totalNumberOfDeprecatedArticles()
    {
        return Article::where('title', 'LIKE', "%{$this->filterText}%")
            ->where('isDeprecated', true)
            ->count();
    }

    public function resetArticles()
    {
        $this->reset(
            'filterText',
            'approvedArticlesDispatched',
            'deprecatedArticlesDispatched',
        );
    }

    public function deprecate(Article $article)
    {
        $article->update([
            'isDeprecated' => ! $this->articleToggle,
        ]);
        $this->resetArticles();
    }

    public function render()
    {
        return view('livewire.article.catalog');
    }
}
