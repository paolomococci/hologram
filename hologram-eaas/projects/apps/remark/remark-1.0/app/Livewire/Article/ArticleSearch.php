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
            <div class="flex justify-center mt-4">
                    <input type="text" class="p-2 my-4 mt-4 mr-0 w-full text-lg rounded-l-lg border bg-slate-300 size-16 border-slate-400 text-slate-800 focus:border-indigo-400"
                        wire:model.live.debounce="searchText" placeholder="{{ $placeholder }}">
                    <button class="p-2 mt-4 ml-0 text-lg bg-indigo-400 rounded-r-lg text-slate-700 size-16" wire:click.prevent="clear()"
                        {{ empty($searchText) ? "disabled" : "" }}>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-x size-10">
                            <title>clear</title>
                                <path d="M18 6 6 18"/>
                                <path d="m6 6 12 12"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
        HTML;
    }
}
