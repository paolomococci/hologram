<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Forms\ArticleForm;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Layout('components.layouts.editor')]
class DownloadImages extends Component
{
    use WithFileUploads;

    public ArticleForm $articleForm;

    public $uriImages = [];

    public function mount(Article $article)
    {
        $this->articleForm->setArticleFields($article);
    }

    public function downloadImages()
    {
        // TODO: download directly

        // status of feedback send to `resources/views/livewire/view/dashboard.blade.php`
        $feedback = count($this->articleForm->imageObject) > 1 ? 'Some related images have been downloaded.' : 'A related image has been downloaded.';
        session()->flash('status', $feedback);

        // redirection
        $this->redirect('/dashboard', navigate: true);
    }

    public function cancel()
    {
        // status of feedback send to `resources/views/livewire/view/dashboard.blade.php`
        session()->flash('status', 'No images have been downloaded.');

        // redirection
        $this->redirect('/dashboard', navigate: false);
    }

    public function render()
    {
        return view('livewire.article.download-images');
    }
}
