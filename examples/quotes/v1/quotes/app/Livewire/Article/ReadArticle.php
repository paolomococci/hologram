<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ReadArticle extends Component
{
    public ?Article $article;
    public array $authors = [];

    protected $listeners = [
        'referringTo' => 'retrieveArticle',
    ];

    /**
     * retrieveArticle
     *
     * retrieves an article's data starting from the identifier,
     * then retrieves all the associated authors
     *
     * @param  mixed $referringTo
     * @return void
     */
    public function retrieveArticle($referringTo): void
    {
        $this->article = Article::findOrFail($referringTo);
        $this->authors = $this->article->getRelatedAuthors();
    }

    /**
     * editArticle
     *
     * edit a specific article by tracking it by identifier
     *
     * @param  mixed $id
     * @return void
     */
    public function editArticle($id): void
    {
        $this->article = Article::find($id);
        $this->dispatch('toModify', $this->article->id);
    }

    /**
     * render
     *
     * @return View
     */
    public function render(): View
    {
        return view(
            'livewire.article.read-article'
        );
    }
}
