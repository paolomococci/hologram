<?php

namespace App\Livewire\Article;

use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ArticleSearch extends Component
{
    #[Validate('required')]
    public $searchText = '';

    public string $placeholder = 'type the words to find';

    public function updatedSearchText(string $title)
    {
        $this->validate();

        $searchTerm = "%{$title}%";
        $this->dispatch('showArticleList', ['searchText' => $this->searchText]);
    }

    public function clear()
    {
        $this->dispatch('clearArticleList');
        $this->reset(
            'searchText'
        );
    }

    #[On('search:clearResults')]
    public function clearResults()
    {
        $this->clear();
    }

    public function searchForm()
    {
        //
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            <form wire:submit.prevent="searchForm" onkeydown="return event.key != 'Enter';" class="mt-2">
                <input type="text" class="p-2 my-4 w-9/12 text-lg rounded-lg border text-slate-700 bg-slate-300 size-16"
                    wire:model.live.debounce="searchText" placeholder="{{ $placeholder }}">
                <button class="p-2 ml-2 text-lg rounded-lg text-slate-700 bg-slate-300 size-16" wire:click.prevent="clear()"
                    {{ empty($searchText) ? "disabled" : "" }}>
                    clear
                </button>
            </form>
        </div>
        HTML;
    }
}
