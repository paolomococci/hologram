<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Livewire\Component;

class Read extends Component
{
    public ?Article $article;

    public function mount(Article $article) {
        $this->article = $article;
    }

    public function render()
    {
        return view('livewire.article.read');
    }
}
