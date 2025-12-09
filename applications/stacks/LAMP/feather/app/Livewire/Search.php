<?php
namespace App\Livewire;

use App\Models\Task;
use Livewire\Attributes\On;
use Livewire\Component;

class Search extends Component
{
    /**
     * The current search string.  It is bound to the input field.
     *
     * @var string
     */
    public string $searchText = '';

    /** @var string  Placeholder text for the input field. */
    public string $placeholder = 'Search tasks…';

    /* Validation */
    protected array $rules = [
        'searchText' => 'nullable|string|min:3|max:32|regex:/^[\pL\s\-\'\.]+$/u',
    ];

    /**
     * Current filter for the `is_done` column.
     * By default we only show unfinished tasks (`is_done = false`).
     *
     * @var bool
     */
    public bool $isDoneFilter = false;

    /**
     * Bootstrap the component.
     *
     * The component will dispatch the initial filter state so that the
     * Toggle component can initialize its visual indicator.
     */
    public function mount(): void
    {
        // Inform Toggle of the default state (false).
        // The Toggle component will listen for this event and set its own state.
        $this->dispatch('toggle-filter', $this->isDoneFilter);
        // The toggle component becomes visible.
        $this->dispatch('show-toggle', true);
    }

    /**
     * Listen to the `toggle-filter` event fired by the Toggle component.
     *
     * Whenever the Toggle component dispatch this event we update the
     * internal filter flag so that the query automatically re‑runs
     * and the view re‑renders with the appropriate task set.
     *
     * @On registers this method as an event handler.
     *
     * @param bool $value Either false (show unfinished) or true (show finished).
     */
    #[On('toggle-filter')]
    public function setIsDoneFilter(bool $value): void
    {
        $this->isDoneFilter = $value;
    }

    /**
     * Validate the search text on every change.  Only the `searchText`
     * field is validated because this component uses a single input.
     */
    public function updatedSearchText(): void
    {
        // Livewire helper that only validates the field that changed.
        $this->validateOnly('searchText');
    }

    /**
     * Erase the search query when the component receives the
     * `search:erase-results` event.  This helper is invoked from the
     * input “X” button in the Blade view.
     */
    #[On('search:erase-results')]
    public function erase(): void
    {
        $this->reset('searchText');
    }

    /**
     * Render the component.  The query is only performed when the user
     * has entered more than two characters.  Additionally the query
     * is filtered by the `is_done` flag which is controlled by the
     * Toggle component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // We only perform a database query if the user has typed > 2 characters.
        // Otherwise we return an empty collection – the UI stays clean.
        if (strlen($this->searchText) > 2) {
            $results = Task::where('tag', 'LIKE', "%{$this->searchText}%")
                ->where('is_done', $this->isDoneFilter) // <-- filter by Toggle
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            return view('livewire.search', ['results' => collect()]);
        }

        return view('livewire.search', compact('results'));
    }
}
