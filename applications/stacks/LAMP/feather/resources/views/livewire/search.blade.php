{{-- The main search form and conditional display of results --}}
<div class="fixed top-[20%] left-1/2 transform -translate-x-1/2 w-full max-w-xl px-4 py-4 z-50">
    {{-- Centered container that keeps the search box within a maximum width --}}
    <div class="mx-auto w-full max-w-xl">
        {{-- Search wrapper that gives visual styling --}}
        <div role="search"
            class="flex items-center w-full rounded-md border shadow-sm focus-within:ring-2 focus-within:ring-green-500">

            {{-- The search input field --}}
            <input type="search" {{-- Custom placeholder text passed from the component --}} placeholder="{{ $placeholder }}" {{-- Accessibility label for screen readers --}}
                aria-label="Search" {{-- Livewire validation hook, hen the Livewire component validates $searchText and encounters an error, Blade injects border-red-500 at runtime, adding a red border to the input. --}}
                class="flex-1 w-full px-4 py-2 border-0 focus:outline-none focus:ring-0 @error('searchText') border-red-500 @enderror"
                {{-- Prevent browser autocomplete --}} autocomplete="off" wire:model.live.debounce="searchText" {{-- Disable the input when the browser is offline so no network request can be triggered accidentally.  --}}
                wire:offline.attr="disabled" />

            {{-- Eraser button – clear the input text search --}}
            <button type="button" {{-- Calls the "erase" method on the Livewire component when clicked --}} wire:click="erase" {{-- Accessibility label --}} aria-label="Clear"
                {{-- Dynamically disable the button when the searchText variable is empty --}} @disabled(empty($searchText))
                class="p-3 text-red-600 rounded-r-md hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500 disabled:text-gray-400 disabled:hover:bg-transparent disabled:cursor-not-allowed">
                {{-- Small SVG glyph component that displays an eraser icon --}}
                <x-glyph name="eraser" title="To clear the search field" />
            </button>
        </div>
        {{-- Error message below the input --}}
        @error('searchText')
            <div class="mt-1 text-sm text-red-600">
                {{ $message }}
            </div>
        @enderror


        {{-- Only show the results component when there is a query --}}
        @unless (empty($searchText))
            {{-- Wrapper for the results list – Livewire transition for a smooth fade effect on removal (when the query becomes empty).  --}}
            <div wire:transition.fade.out.duration.200ms class="mx-auto mt-4 w-full max-w-xl">
                {{-- Livewire component that actually renders the list of results.
                    The :results prop passes the current results array.
                    The key attribute ensures Livewire reset the component
                    whenever the query changes, preventing stale data. --}}
                <livewire:search-results :results="$results" key="search-results-{{ $searchText }}" />
            </div>
        @endunless
        {{-- End of centered container --}}
    </div>
    {{-- End of the outer fixed container --}}
</div>
