<?php

namespace App\Livewire\Author;

use App\Models\Author;
use Livewire\Component;

class ReadAuthor extends Component
{
    public ?Author $author;
    public array $articles = [];

    protected $listeners = [
        'referringTo' => 'retrieveAuthor',
    ];

    public function retrieveAuthor($referringTo)
    {
        // dump($referringTo);
        $this->author = Author::findOrFail($referringTo);
        // $articles = [];
        // $articlesOfAuthor = $this->author->articles();
        // foreach ($articlesOfAuthor as $article) {
        //     $article[] = $article;
        // }
        // dump($articles);
        $this->articles = $this->author->getRelatedArticles();
    }

    public function editAuthor($id)
    {
        $this->author = Author::find($id);
        $this->dispatch('toModify', $this->author->id);
    }

    public function render()
    {
        return view('livewire.author.read-author');
    }
}
