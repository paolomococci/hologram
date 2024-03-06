<?php

namespace App\Livewire\Article;

use App\Models\Article;
use App\Models\Author;
use App\Models\Contributor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class CreateArticle extends Component
{
    #[Validate('required|min:10|max:255')]
    public $title;

    #[Validate('required|min:10|max:255')]
    public $subject;

    #[Validate('required|min:10')]
    public $summary;

    #[Validate('required|min:20')]
    public $content;

    public $authorToAdd;
    public array $authors = [];

    public function mount()
    {
        $this->authors = Author::all()->toArray();
    }

    /**
     * resetFields
     *
     * @return void
     */
    public function resetFields(): void
    {
        $this->title = '';
        $this->subject = '';
        $this->summary = '';
        $this->content = '';
    }

    /**
     * save
     *
     * saves article data in the database and log this action
     *
     * @return RedirectResponse
     */
    public function save(): RedirectResponse | Redirector
    {
        $operator = ['email' => Auth::user()->email];
        try {
            $this->validate();
            $authorToAdd = null;
            if (!is_null($this->authorToAdd)) {
                $authorToAdd = Author::where('email', $this->authorToAdd)->firstOrFail();
            }
            $article = Article::create([
                'title' => $this->title,
                'subject' => $this->subject,
                'summary' => $this->summary,
                'content' => $this->content,
            ]);
            // dd($article->id, $authorToAdd->id);
            if (is_null($authorToAdd)) {
                // TODO: write an explanatory message
            } else {
                Contributor::create([
                    // field is_main_author is temporarily set to zero by default
                    'is_main_author' => 0,
                    'article_id' => $article->id,
                    'author_id' => $authorToAdd->id,
                ]);
            }
            $jsonArrayDataLog = [
                'operator' => $operator,
                'article' => $article,
                'performed' => 'creation',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/article_create_info.log'),
            ])->info(json_encode($jsonArrayDataLog));
            return redirect()->to('/article')->with('status', 'Added a new article');
        } catch (\Exception $e) {
            $jsonArrayDataLog = [
                'operator' => $operator,
                'performed' => 'creation',
                'error_message' => $e->getMessage(),
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/article_create_error.log'),
            ])->error(json_encode($jsonArrayDataLog));
            session()->flash('status', $e->getMessage());
            $this->resetFields();
            return redirect()->to('/article')->with('status', $e->getMessage());
        }
    }

    /**
     * render
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.article.create-article');
    }
}
