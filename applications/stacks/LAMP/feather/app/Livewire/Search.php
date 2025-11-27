<?php
namespace App\Livewire;

use App\Models\Task;
use Livewire\Attributes\Isolate;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

/**
 * Search
 * A lightweight, isolated Livewire component that provides a
 * search box for Task records.  The component keeps the search
 * term in the URL (`?q=...`) so the page can be bookmarked or
 * shared with the query already applied.
 *
 * This attribute marks the component as **isolated**:
 * It gets its own DOM scope (no CSS bleed);
 * It does not share state with other Livewire components on the page.
 */
#[Isolate]
class Search extends Component
{
    /**
     * @var string The search query typed by the user.
     *
     * This property is bound to the query string via the
     * @Url attribute so that the URL automatically contains
     * `?q=<search text>`.  The `except: ''` option means that an empty
     * string is omitted from the URL (so `?q=` is not shown).
     */
    #[Url( as : 'q', except: '')]
    public string $searchText = '';

    /**
     * @var string The placeholder text shown inside the <input>.
     */
    public string $placeholder = 'Search tasks…';

    /**
     * erase
     *
     * Event listeners / helpers
     * Reset the search query when the component receives the `search:erase-results` event.
     *
     * @On registers this method as an event handler.
     * When any component emits `search:erase-results`, this method will be called and
     * will clear the `$searchText` property (which in turn updates the input field).
     */
    #[On('search:erase-results')]
    public function erase(): void
    {
        // Livewire helper that sets $searchText to its default
        $this->reset('searchText');
    }

    /**
     * render
     *
     * Render the component.
     * The view receives a `$results` collection that is
     * automatically refreshed whenever `$searchText` changes.
     * This is because Livewire automatically re‑runs the `render()` method on any property mutation.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // Build the results collection based on the current query,
        // We perform a case‑insensitive LIKE search on the `tag` column
        // and the results are ordered by creation date (newest first).
        $results = Task::where('tag', 'LIKE', "%{$this->searchText}%")
            ->orderBy('created_at', 'desc')
            ->get();

        // Render the Blade view and pass the `$results` variable.
        return view('livewire.search', compact('results'));
    }
}
