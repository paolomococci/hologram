<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Livewire\Component;

class ArticleRead extends Component
{
    public ?Article $article;

    protected $listeners = [
        'showSelectedArticle',
    ];

    public function showSelectedArticle(array $referenceToArticle)
    {
        $article = Article::findOrFail($referenceToArticle)->first();
        $this->article = $article;
    }

    public function render()
    {
        return view('livewire.article.article-read');
    }
}
