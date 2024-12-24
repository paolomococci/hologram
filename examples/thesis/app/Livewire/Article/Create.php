<?php

namespace App\Livewire\Article;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use App\Livewire\Forms\ArticleForm;

#[Layout('components.layouts.editor')]
class Create extends Component
{
    public ArticleForm $articleForm;

    public function save() {
        $this->articleForm->save();
        $this->redirect('/dashboard', navigate:true);
    }

    public function render()
    {
        return view('livewire.article.create');
    }
}
