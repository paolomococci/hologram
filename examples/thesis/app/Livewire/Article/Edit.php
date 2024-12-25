<?php

namespace App\Livewire\Article;

use App\Livewire\Forms\ArticleForm;
use App\Models\Article;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.editor')]
class Edit extends Component
{
    public ArticleForm $articleForm;

    public function mount(Article $article)
    {
        $this->articleForm->set($article);
    }

    public function update()
    {
        $this->articleForm->update();
        $this->redirect('/dashboard', navigate: true);
    }

    public function render()
    {
        return view('livewire.article.edit');
    }
}
