<?php

namespace App\Livewire\Author;

use App\Models\Author;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class OverviewAuthors extends Component
{
    use WithPagination;

    public Author $author;
    public string $query = '';

    /**
     * search
     *
     * @return void
     */
    public function search(): void
    {
        $this->resetPage();
    }

    /**
     * showAuthor
     *
     * retrieve a data of author by identifier
     *
     * @param  mixed $id
     * @return void
     */
    public function showAuthor($id): void
    {
        $this->author = Author::find($id);
        // $this->dispatch('referringTo', $this->author->id);
        $this->dispatch('toModify', $this->author->id);
    }

    /**
     * render
     *
     * @return View
     */
    public function render(): View
    {
        // dump(['email' => Auth::user()->email]);
        return view('livewire.author.overview-authors', [
            'authors' => Author::where('surname', 'like', '%' . $this->query . '%')->orderBy('created_at', 'DESC')->paginate(22),
        ]);
    }
}
