<?php

namespace App\Livewire\Author;

use App\Models\Author;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ReadAuthor extends Component
{
    public ?Author $author;
    public array $articles = [];

    protected $listeners = [
        'referringTo' => 'retrieveAuthor',
    ];

    /**
     * retrieveAuthor
     *
     * retrieves an author's data starting from the identifier,
     * then retrieves all the associated articles
     *
     * @param  int $referringTo
     * @return void
     */
    public function retrieveAuthor($referringTo): void
    {
        // dump($referringTo);
        $this->author = Author::findOrFail($referringTo);
        $this->articles = $this->author->getRelatedArticles();
    }

    /**
     * editAuthor
     *
     * @param  int $id
     * @return void
     */
    public function editAuthor($id): void
    {
        $this->author = Author::find($id);
        $this->dispatch('toModify', $this->author->id);
    }

    /**
     * render
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.author.read-author');
    }
}
