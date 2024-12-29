<?php

namespace App\Livewire\Article;

use App\Livewire\Forms\ArticleForm;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Layout('components.layouts.editor')]
class Create extends Component
{
    use WithFileUploads;

    public ArticleForm $articleForm;

    public function save()
    {
        $this->articleForm->save();

        // status of feedback send to `resources/views/livewire/view/dashboard.blade.php`
        session()->flash('status', 'The article was created successfully.');

        // redirection by route name
        $this->redirectRoute('dashboard.articles', navigate: true);
    }

    public function cancel()
    {
        // status of feedback send to `resources/views/livewire/view/dashboard.blade.php`
        session()->flash('status', 'As requested, the new article was not saved.');

        // redirection by route name
        $this->redirectRoute('dashboard.articles', navigate: false);
    }

    public function render()
    {
        return view('livewire.article.create');
    }
}
