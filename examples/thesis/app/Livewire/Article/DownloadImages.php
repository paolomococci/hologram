<?php

namespace App\Livewire\Article;

use App\Livewire\Forms\ArticleForm;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Layout('components.layouts.download')]
class DownloadImages extends Component
{
    use WithFileUploads;

    public ArticleForm $articleForm;

    public $uriImages = [];

    private function extractFileName(string $path): string
    {
        $reversedFilename = [];
        $splitted = str_split($path);
        $reversed = array_reverse($splitted);
        foreach ($reversed as $char) {
            if ($char != '/') {
                $reversedFilename[] = $char;
            } else {
                break;
            }
        }
        $filename = array_reverse($reversedFilename);
        $implodedFilename = implode($filename);

        return $implodedFilename;
    }

    public function mount(Article $article)
    {
        $this->articleForm->setArticleFields($article);
        $this->uriImages = $this->articleForm->image_path;
    }

    public function downloadImages($path)
    {
        $publicStoragePath = Storage::disk('public')->path($path);
        $downloadCoordinates = [
            'pathToFile' => $publicStoragePath,
            'filename' => self::extractFileName($path),
            'headers' => ['Content-Type: '.mime_content_type($publicStoragePath)],
        ];
        try {
            if (file_exists($downloadCoordinates['pathToFile'])) {
                // FIXME: download the resource without reporting anything from the browser
                // session()->flash('status', 'You should have just downloaded the required image.');
                return response()->download(
                    $downloadCoordinates['pathToFile'],
                    $downloadCoordinates['filename'],
                    $downloadCoordinates['headers']
                );
            }
        } catch (\Exception $e) {
            // throw $th;
        }
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
