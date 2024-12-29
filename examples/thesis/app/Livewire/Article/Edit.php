<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Livewire\Component;
use App\Utils\CleaningUtility;
use Livewire\Attributes\Layout;
use App\Livewire\Forms\ArticleForm;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Layout('components.layouts.editor')]
class Edit extends Component
{
    use WithFileUploads;

    public ArticleForm $articleForm;

    public function mount(Article $article)
    {
        $article->title = CleaningUtility::cleanTitle($article->title);
        $this->articleForm->setArticleFields($article);
    }

    public function update()
    {
        $this->articleForm->update();

        // status of feedback send to `resources/views/livewire/view/dashboard.blade.php`
        session()->flash('status', 'The article has been successfully updated.');

        // redirection
        $this->redirect('/dashboard', navigate: true);
    }

    public function cancel()
    {
        // status of feedback send to `resources/views/livewire/view/dashboard.blade.php`
        session()->flash('status', 'All changes have been canceled.');

        // redirection
        $this->redirect('/dashboard', navigate: false);
    }

    public function render()
    {
        return view('livewire.article.edit');
    }
}
