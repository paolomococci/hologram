<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.article.index', [
            'articles' => Article::where('deprecated', false)->cursorPaginate(3),
        ]);
    }
}
