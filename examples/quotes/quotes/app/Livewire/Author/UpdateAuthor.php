<?php

namespace App\Livewire\Author;

use App\Models\Article;
use App\Models\Author;
use App\Models\Contributor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UpdateAuthor extends Component
{
    public int $id;

    #[Validate('required|min:2|max:255')]
    public $name;

    #[Validate('required|min:2|max:255')]
    public $surname;

    #[Validate('required|min:1|max:255')]
    public $nickname;

    #[Validate('required|max:255')]
    public $email;

    public $suspended;

    public $articleToBeRelated;

    public ?Author $author;
    public array $relatedArticles = [];
    public array $articles = [];
    public array $removeCorrelations = [];

    protected $listeners = [
        'toModify' => 'retrieveAuthor',
    ];

    /**
     * removeCorrelation
     *
     * @return RedirectResponse
     */
    public function removeCorrelation(): RedirectResponse
    {
        try {
            $operator = ['email' => Auth::user()->email];
            if (!empty($this->removeCorrelations)) {
                $contrib = Contributor::where('author_id', $this->id)->where('article_id', $this->removeCorrelations[0])->first();
                if (!is_null($contrib->id)) {
                    Contributor::findOrFail($contrib->id)->delete();
                }
                $jsonArrayDataLog = [
                    'operator' => $operator,
                    'author' => $this->author,
                    'performed' => 'update',
                ];
                Log::build([
                    'driver' => 'single',
                    'path' => storage_path('logs/author_update_info.log'),
                ])->info(json_encode($jsonArrayDataLog));
                return redirect()->to('/author')->with('status', 'Updated author id: ' . $this->author->id . ' by the operator ' . $operator['email']);
            }
        } catch (\Exception $e) {
            $jsonArrayDataLog = [
                'operator' => $operator,
                'author' => $this->author,
                'performed' => 'update',
                'error_message' => $e->getMessage(),
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/author_update_error.log'),
            ])->error(json_encode($jsonArrayDataLog));
            session()->flash('status', $e->getMessage());
            return redirect()->to('/author')->with('status', $e->getMessage());
        }
    }

    /**
     * retrieveAuthor
     *
     * retrieves an author's data starting from the identifier,
     * then retrieves all the associated articles collecting them into an array
     *
     * @param  int $referringTo
     * @return void
     */
    public function retrieveAuthor($referringTo): void
    {
        $this->author = Author::findOrFail($referringTo);
        $this->relatedArticles = $this->author->getRelatedArticles();
        $this->articles = Article::all()->toArray();
        $this->id = $this->author->id;
        $this->name = $this->author->name;
        $this->surname = $this->author->surname;
        $this->nickname = $this->author->nickname;
        $this->email = $this->author->email;
        //dd((boolean)$this->author->suspended);
        $this->suspended = (boolean) $this->author->suspended;
    }

    /**
     * update
     *
     * update author data on database and log this action
     *
     * @return RedirectResponse
     */
    public function update(): RedirectResponse
    {
        $operator = ['email' => Auth::user()->email];
        try {
            $this->validate();
            $alreadyPresentOrNotIndicated = false;
            $articleToBeRelated = null;
            if (!is_null($this->articleToBeRelated)) {
                $articleToBeRelated = Article::where('title', $this->articleToBeRelated)->first();
                $alreadyPresentOrNotIndicated = (boolean) Contributor::where('author_id', $this->author->id)->where('article_id', $articleToBeRelated->id)->first();
            }
            $this->author->update([
                'name' => $this->name,
                'surname' => $this->surname,
                'nickname' => $this->nickname,
                /* It must not be possible to change the email of the author */
                // 'email' => $this->email,
                'suspended' => $this->suspended,
            ]);
            if ($alreadyPresentOrNotIndicated) {
                throw new \Exception("There's already a correlation between '{$this->author->email}' to {$articleToBeRelated->id}!");
            } elseif ($this->suspended) {
                //throw new \Exception("Author '{$this->author->email}' appears to be suspended!");
            } elseif (is_null($articleToBeRelated)) {
                // TODO: write an explanatory message
            } else {
                Contributor::create([
                    // field is_main_author is temporarily set to zero by default
                    'is_main_author' => 0,
                    'article_id' => $articleToBeRelated->id,
                    'author_id' => $this->author->id,
                ]);
            }
            $jsonArrayDataLog = [
                'operator' => $operator,
                'author' => $this->author,
                'article_to_be_related' => $articleToBeRelated ?? '',
                'performed' => 'update',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/author_update_info.log'),
            ])->info(json_encode($jsonArrayDataLog));
            return redirect()->to('/author')->with('status', 'Updated author id: ' . $this->author->id . ' by the operator ' . $operator['email']);
        } catch (\Exception $e) {
            $jsonArrayDataLog = [
                'operator' => $operator,
                'author' => $this->author,
                'article_to_be_related' => $articleToBeRelated ?? '',
                'performed' => 'update',
                'error_message' => $e->getMessage(),
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/author_update_error.log'),
            ])->error(json_encode($jsonArrayDataLog));
            session()->flash('status', $e->getMessage());
            return redirect()->to('/author')->with('status', $e->getMessage());
        }
    }

    /**
     * render
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.author.update-author');
    }
}
