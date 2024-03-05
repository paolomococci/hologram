<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class OverviewArticles extends Component
{
    use WithPagination;

    public Article $article;
    public string $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function showArticle($id)
    {
        $this->article = Article::find($id);
        // $this->dispatch('referringTo', $this->article->id);
        $this->dispatch('toModify', $this->article->id);
    }

    public function render()
    {
        // dump(['email' => Auth::user()->email]);
        return view('livewire.article.overview-articles', [
            'articles' => Article::where('title', 'like', '%' . $this->query . '%')->orderBy('created_at', 'DESC')->paginate(22),
        ]);
    }
}
