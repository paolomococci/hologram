<?php

namespace App\Livewire\Article;

use App\Livewire\Forms\ArticleForm;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.editor')]
class Create extends Component
{
    public ArticleForm $articleForm;

    public function save()
    {
        $this->articleForm->save();

        // status of feedback
        session()->flash('status', 'The article was created successfully.');

        // redirection by route name
        $this->redirectRoute('dashboard.articles', navigate: true);
    }

    public function render()
    {
        return view('livewire.article.create');
    }
}
