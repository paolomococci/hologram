<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Livewire\Component;

class ReadArticle extends Component
{
    public ?Article $article;
    public array $authors = [];

    protected $listeners = [
        'referringTo' => 'retrieveArticle',
    ];

    public function retrieveArticle($referringTo)
    {
        $this->article = Article::findOrFail($referringTo);
        $this->authors = $this->article->getRelatedAuthors();
    }

    public function editArticle($id)
    {
        $this->article = Article::find($id);
        $this->dispatch('toModify', $this->article->id);
    }

    public function render()
    {
        return view(
            'livewire.article.read-article'
        );
    }
}
