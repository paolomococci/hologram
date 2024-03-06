<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class OverviewArticles extends Component
{
    use WithPagination;

    public Article $article;
    public string $query = '';

    /**
     * search
     *
     * @return void
     */
    public function search(): void
    {
        $this->resetPage();
    }

    /**
     * showArticle
     *
     * retrieve a specific data of article by tracking it by identifier
     *
     * @param  int $id
     * @return void
     */
    public function showArticle($id): void
    {
        $this->article = Article::find($id);
        // $this->dispatch('referringTo', $this->article->id);
        $this->dispatch('toModify', $this->article->id);
    }

    /**
     * render
     *
     * @return View
     */
    public function render(): View
    {
        // dump(['email' => Auth::user()->email]);
        return view('livewire.article.overview-articles', [
            'articles' => Article::where('title', 'like', '%' . $this->query . '%')->orderBy('created_at', 'DESC')->paginate(22),
        ]);
    }
}
