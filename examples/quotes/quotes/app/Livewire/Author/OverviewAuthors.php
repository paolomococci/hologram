<?php

namespace App\Livewire\Author;

use App\Models\Author;
use Livewire\Component;
use Livewire\WithPagination;

class OverviewAuthors extends Component
{
    use WithPagination;

    public Author $author;
    public string $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function showAuthor($id)
    {
        $this->author = Author::find($id);
        // $this->dispatch('referringTo', $this->author->id);
        $this->dispatch('toModify', $this->author->id);
    }

    public function render()
    {
        // dump(['email' => Auth::user()->email]);
        return view('livewire.author.overview-authors', [
            'authors' => Author::where('surname', 'like', '%' . $this->query . '%')->orderBy('created_at', 'DESC')->paginate(22),
        ]);
    }
}
