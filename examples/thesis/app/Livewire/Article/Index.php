<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Lazy;

#[Lazy]
class Index extends Component
{
    use WithPagination;

    public const ARTICLES_PER_PAGE = 3;

    public int $numberOfArticles = 0;

    public function mount()
    {
        $this->numberOfArticles = Article::count();
    }

    public function render()
    {
        return view('livewire.article.index', [
            'articles' => Article::where('deprecated', false)->simplePaginate(self::ARTICLES_PER_PAGE),
        ]);
    }
}
