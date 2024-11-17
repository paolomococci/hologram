<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Livewire\Component;

class ArticleStats extends Component
{
    public ?Article $article;

    public int $numberOfWords = 0;

    public int $numberOfParagraphs = 0;

    protected $listeners = [
        'showSelectedArticle',
    ];

    public function showSelectedArticle(array $referenceToArticle)
    {
        $article = Article::findOrFail($referenceToArticle)->first();
        $this->article = $article;
        $this->numberOfWords = count(explode(' ', $this->article['content']));
        $paragraphs = preg_match_all('/(\.\s)/', $this->article['content']);
        $paragraphs += preg_match_all('/(\.)$/', $this->article['content']);
        $paragraphs += preg_match_all('/(\!\s)/', $this->article['content']);
        $paragraphs += preg_match_all('/(\!)$/', $this->article['content']);
        $paragraphs += preg_match_all('/(\?\s)/', $this->article['content']);
        $paragraphs += preg_match_all('/(\?)$/', $this->article['content']);
        $this->numberOfParagraphs = $paragraphs;
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            <div class="z-10 p-4 rounded-md border backdrop-brightness-125 border-slate-900 full-width">
                @if ($article != null)
                    <h2 class="mb-2 text-2xl text-white/70">Article statistics</h2>
                    <dl class="uppercase text-white/85">
                        <dt>Number of words:</dt>
                        <dd>{{ $numberOfWords }}</dd>
                        <dt>Number of paragraphs:</dt>
                        <dd class="">{{ $numberOfParagraphs }}</dd>
                    </dl>
                @else
                    <p class="text-lg font-normal text-black/85">Waiting for an article to be selected.</p>
                @endif
            </div>
        </div>
        HTML;
    }
}
