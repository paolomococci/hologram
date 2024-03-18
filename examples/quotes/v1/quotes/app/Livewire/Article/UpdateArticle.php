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

class UpdateArticle extends Component
{
    public $id;

    #[Validate('required|min:10|max:255')]
    public $title;

    #[Validate('required|min:10|max:255')]
    public $subject;

    #[Validate('required|min:10')]
    public $summary;

    #[Validate('required|min:20')]
    public $content;

    public $deprecated;

    public $authorToAdd;

    public ?Article $article;
    public array $relatedAuthors = [];
    public array $authors = [];

    protected $listeners = [
        'toModify' => 'retrieveArticle',
    ];

    /**
     * retrieveArticle
     *
     * retrieves an article's data starting from the identifier,
     * then retrieves all the associated authors collecting them into an array
     *
     * @param  int $referringTo
     * @return void
     */
    public function retrieveArticle($referringTo): void
    {
        $this->article = Article::findOrFail($referringTo);
        $this->relatedAuthors = $this->article->getRelatedAuthors();
        $this->authors = Author::all()->toArray();
        $this->id = $this->article->id;
        $this->title = $this->article->title;
        $this->subject = $this->article->subject;
        $this->summary = $this->article->summary;
        $this->content = $this->article->content;
        $this->deprecated = (boolean) $this->article->deprecated;
    }

    /**
     * update
     *
     * update article data on database and log this action
     *
     * @return RedirectResponse
     */
    public function update(): RedirectResponse | Redirector
    {
        $operator = ['email' => Auth::user()->email];
        try {
            $this->validate();
            $alreadyPresentOrNotIndicated = false;
            $authorToAdd = null;
            if (!is_null($this->authorToAdd)) {
                $authorToAdd = Author::where('email', $this->authorToAdd)->firstOrFail();
                $alreadyPresentOrNotIndicated = (boolean) Contributor::where('author_id', $authorToAdd->id)->where('article_id', $this->article->id)->first();
            }
            $this->article->update([
                /* It must not be possible to change the title of the article */
                // 'title' => $this->title,
                'subject' => $this->subject,
                'summary' => $this->summary,
                'content' => $this->content,
                'deprecated' => $this->deprecated,
            ]);
            if ($alreadyPresentOrNotIndicated) {
                throw new \Exception("There's already a correlation between '{$authorToAdd->email}' to {$this->article->title}!");
            } elseif ($this->deprecated) {
                //throw new \Exception("Article: '{$this->article->title}' appears to be deprecated");
            } elseif (is_null($authorToAdd)) {
                // TODO: write an explanatory message
            } else {
                Contributor::create([
                    // field is_main_author is temporarily set to zero by default
                    'is_main_author' => 0,
                    'article_id' => $this->article->id,
                    'author_id' => $authorToAdd->id,
                ]);
            }
            $jsonArrayDataLog = [
                'operator' => $operator,
                'article' => $this->article,
                'author_to_add' => $authorToAdd ?? '',
                'performed' => 'update',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/article_update_info.log'),
            ])->info(json_encode($jsonArrayDataLog));
            return redirect()->to('/article')->with('status', 'Updated article id: ' . $this->article->id . ' by the operator ' . $operator['email']);
        } catch (\Exception $e) {
            $jsonArrayDataLog = [
                'operator' => $operator,
                'article' => $this->article,
                'author_to_add' => $authorToAdd ?? '',
                'performed' => 'update',
                'error_message' => $e->getMessage(),
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/article_update_error.log'),
            ])->error(json_encode($jsonArrayDataLog));
            session()->flash('status', $e->getMessage());
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
        return view('livewire.article.update-article');
    }
}
