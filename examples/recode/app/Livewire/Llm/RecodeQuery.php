<?php

namespace App\Livewire\Llm;

use Livewire\Component;
use Livewire\Attributes\Validate;

class RecodeQuery extends Component
{
    #[Validate('required')]
    public string $query = '';

    public bool $queryInProgress = false;

    public function clear() {
        $this->query = '';
        $this->queryInProgress = false;
        $this->dispatch('clearResponse');
    }

    public function submitQuery() {
        $this->queryInProgress = true;
        $this->dispatch('sendQuery', query: $this->query);
    }

    public function render()
    {
        return view('livewire.llm.recode-query');
    }
}
