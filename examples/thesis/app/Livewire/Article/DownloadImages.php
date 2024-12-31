<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Forms\ArticleForm;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Layout('components.layouts.download')]
class DownloadImages extends Component
{
    use WithFileUploads;

    public ArticleForm $articleForm;

    public $uriImages = [];

    public function mount(Article $article)
    {
        $this->articleForm->setArticleFields($article);
        $this->uriImages = $this->articleForm->image_path;
    }

    public function downloadImages($path)
    {
        // TODO: download directly
    }

    public function cancel()
    {
        // status of feedback send to `resources/views/livewire/view/dashboard.blade.php`
        session()->flash('status', 'You are back to the dashboard.');

        // redirection
        $this->redirect('/dashboard', navigate: false);
    }

    public function render()
    {
        return view('livewire.article.download-images');
    }
}
