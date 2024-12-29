<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Forms\ArticleForm;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Layout('components.layouts.editor')]
class UploadImages extends Component
{
    use WithFileUploads;

    public ArticleForm $articleForm;

    public function mount(Article $article)
    {
        $this->articleForm->setArticleFields($article);
    }

    public function uploadImages()
    {
        $this->articleForm->uploadImages();

        // status of feedback send to `resources/views/livewire/view/dashboard.blade.php`
        $feedback = count($this->articleForm->imageObject) > 1 ? 'Related images have been loaded.' : 'The related image has been loaded.';
        session()->flash('status', $feedback);

        // redirection
        $this->redirect('/dashboard', navigate: true);
    }

    public function cancel()
    {
        // status of feedback send to `resources/views/livewire/view/dashboard.blade.php`
        session()->flash('status', 'No images have been loaded.');

        // redirection
        $this->redirect('/dashboard', navigate: false);
    }

    public function render()
    {
        return view('livewire.article.upload-images');
    }
}
