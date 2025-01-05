<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Livewire\Component;

class ArticleList extends Component
{
    public $articles = [];

    public $searchTerm = '';

    public $articleId = 0;

    protected $listeners = [
        'showArticleList',
        'clearArticleList',
    ];

    public function showArticleList($searchText)
    {
        $this->searchTerm = "%{$searchText['searchText']}%";
        $this->articles = Article::where('title', 'LIKE', $this->searchTerm)->get();
    }

    public function clearArticleList()
    {
        $this->reset(
            'articles'
        );
    }

    public function showArticle($id)
    {
        $this->articleId = $id;
        $this->dispatch('showSelectedArticle', ['articleId' => $this->articleId]);
        $this->clearArticleList();
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            <div class="p-4 mt-4 mb-8 rounded-md border backdrop-brightness-125 border-slate-900 full-width">
                @if (count($articles) == 0)
                    <p class="text-lg font-normal text-black/85">Type the words you are looking for in the search field.</p>
                @else
                <div>
                    <div class="absolute top-0 right-0 pt-1 pr-3">
                        <button wire:click="dispatch('search:clearResults')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="mt-2 lucide lucide-circle-x size-6">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="m15 9-6 6"/><path d="m9 9 6 6"/>
                            </svg>
                        </button>
                    </div>
                    <section class="m-4">
                        @foreach ($articles as $article)
                            <article class="p-8" wire:key="{{ $article->id }}">
                                <h3 class="text-xl font-semibold text-purple-500">
                                    {{-- <a wire:navigate.hover href="/articles/{{ $article->id }}">{{ $article->title }}</a> --}}
                                    <button wire:click.prevent="showArticle({{ $article->id }})"
                                        class="bg-transparent">{{ $article->title }}</button>
                                </h3>
                                <p class="text-lg font-normal text-slate-300">
                                    {{ str($article->content)->words(15) }}
                                </p>
                            </article>
                        @endforeach
                    </section>
                </div>
                @endif
            </div>
        </div>
        HTML;
    }
}
