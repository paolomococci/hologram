<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Forms\ArticleForm;

#[Layout('components.layouts.editor')]
class Edit extends Component
{
    public ArticleForm $articleForm;

    public function mount(Article $article) {
        $this->articleForm->set($article);
    }

    public function update() {
        $this->articleForm->update();
        $this->redirect('/dashboard', navigate:true);
    }

    public function render()
    {
        return view('livewire.article.edit');
    }
}
