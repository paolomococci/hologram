<?php

namespace App\Livewire\Paper;

use App\Models\Paper;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class OverviewPapers extends Component
{
    use WithPagination;

    public Paper $paper;
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
     * showArticle
     *
     * retrieve a specific data of paper by tracking it by identifier
     *
     * @param  int $id
     * @return void
     */
    public function showArticle($id): void
    {
        $this->paper = Paper::find($id);
        $this->dispatch('toModify', $this->paper->id);
    }

    /**
     * render
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.paper.overview-papers', [
            'papers' => Paper::where('title', 'like', '%' . $this->query . '%')->orderBy('created_at', 'DESC')->paginate(22),
        ]);
    }
}
