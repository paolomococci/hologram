<?php

namespace App\Livewire\Article;

use App\Livewire\Forms\ArticleForm;
use App\Models\Article;
use App\Utils\CleaningUtility;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.editor')]
class Edit extends Component
{
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
