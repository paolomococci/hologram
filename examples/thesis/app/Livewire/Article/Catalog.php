<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Catalog extends Component
{
    use WithPagination;

    public const ARTICLES_PER_PAGE = 5;

    public bool $deprecated = false;

    public string $filterText = '';

    #[On('retrieveArticles')]
    public function showArticles(
        $deprecated,
        $filterText
    ) {
        $this->deprecated = $deprecated;
        $this->filterText = $filterText;
    }

    public function resetArticles()
    {
        $this->reset(
            'deprecated',
            'filterText',
        );
    }

    public function deprecate(Article $article)
    {
        $article->update([
            'deprecated' => !$this->deprecated,
        ]);
        $this->resetArticles();
    }

    public function render()
    {
        return view('livewire.article.catalog', [
            'articles' => Article::where('title', 'LIKE', '%' . $this->filterText . '%')
                ->where('deprecated', $this->deprecated)
                ->cursorPaginate(self::ARTICLES_PER_PAGE),
            'numberOfArticles' => Article::where('title', 'LIKE', '%' . $this->filterText . '%')
            ->where('deprecated', $this->deprecated)
            ->get(),
        ]);
    }
}
