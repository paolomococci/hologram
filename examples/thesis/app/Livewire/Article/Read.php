<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Read extends Component
{
    public ?Article $article;

    public function mount(Article $article)
    {
        $this->article = $article;
    }

    public function render()
    {
        return view('livewire.article.read');
    }
}
