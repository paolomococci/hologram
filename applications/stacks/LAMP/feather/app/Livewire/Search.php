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
     * Rules used by Livewire when validating `searchText`.
     */
    protected array $rules = [
        'searchText' => [
            'required',
            'string',
            'min:3',
            'max:30',
            /**
             * Regex:
             * prevents the insertion of numbers, unwanted punctuation, and special characters;
             * ensures that text fields contain only letters from any language, spaces, hyphens, apostrophes, and periods;
             * reduces the risk of XSS or injection by limiting the characters that can reach the backend or database.
             */
            'regex:/^[\pL\s\-\'\.]+$/u',
        ],
    ];

    /**
     * Trigger validation every time the user types (debounced).
     * This method is automatically called by Livewire when a
     * property marked with `wire:model` changes.
     */
    public function updatedSearchText(string $value): void
    {
        // Only validate the field that changed
        $this->validateOnly('searchText');
    }

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
        /**
         * We only perform a database query if the user has typed more than
         * two characters; this prevents unnecessary queries for very short
         * or empty input.
         * The query searches the `tag` column using a case‑insensitive
         * LIKE operator (`%{$this->searchText}%`).  This means any record
         * that contains the search text anywhere in its tag will be
         * returned.
         * Results are sorted by `created_at` in descending order so that
         * the newest tasks appear first.
         */
        if (strlen($this->searchText) > 2) {
            $results = Task::where('tag', 'LIKE', "%{$this->searchText}%")
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            /**
             * If the search string is 2 characters or fewer, we skip the
             * database query and simply return an empty collection.  This
             * keeps the UI clean (no results displayed) and reduces load.
             */
            return view('livewire.search', ['results' => collect()]);
        }

        // Render the Blade view and pass the `$results` variable.
        return view('livewire.search', compact('results'));
    }
}
