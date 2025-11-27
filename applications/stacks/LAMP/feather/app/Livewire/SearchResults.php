<?php
namespace App\Livewire;

use Livewire\Attributes\Reactive;
use Livewire\Component;

/**
 * SearchResults
 */
class SearchResults extends Component
{
    /**
     * @var array The collection passed from the parent component
     *
     * Marks the property as reactive,
     * Livewire will automatically re-render the component when this changes
     */
    #[Reactive]
    public $results = [];

    /**
     * render
     *
     * Standard Livewire Method: Required for all components
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.search-results');
    }
}
