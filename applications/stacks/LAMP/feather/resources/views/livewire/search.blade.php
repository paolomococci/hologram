{{-- resources/views/livewire/search.blade.php --}}
{{-- search.blade.php – main search form and results handling --}}
@php
    // Remember that before you can use $headerBagConsoleLog, it needs to be converted into an array.
    $headerBagConsoleLog = request()->headers;
@endphp

<div class="fixed top-[20%] left-1/2 transform -translate-x-1/2 w-full max-w-xl px-4 py-4 z-50">
    <div class="w-full max-w-xl mx-auto">

        @if (session('success'))
            {{-- Feedback component --}}
            <livewire:feedback message="{{ session('success') }}" type="success" />
        @endif

        <div role="search"
            class="flex items-center border rounded-md shadow-sm focus-within:ring-2 focus-within:ring-green-500 w-full">
            <input type="search" placeholder="{{ $placeholder }}" aria-label="Search"
                class="flex-1 w-full px-4 py-2 border-0 focus:outline-none focus:ring-0 @error('searchText') border-red-500 @enderror"
                autocomplete="off" wire:model.live.debounce="searchText" wire:offline.attr="disabled" />

            <button type="button" wire:click="erase" aria-label="Clear" @disabled(empty($searchText))
                class="p-3 text-red-600 rounded-r-md hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500 disabled:text-gray-400 disabled:hover:bg-transparent disabled:cursor-not-allowed">
                <x-glyph name="eraser" title="To clear the search field" />
            </button>
        </div>

        @error('searchText')
            <div class="mt-1 text-sm text-red-600">
                {{ $message }}
            </div>
        @enderror

        @unless (empty($searchText))
            <div wire:transition.fade.out.duration.200ms class="mt-4 w-full max-w-xl mx-auto">
                <livewire:search-results :results="$results" key="search-results-{{ $searchText }}" />
            </div>
        @endunless
    </div>
</div>

<script>
    {{-- Laravel provides the Blade directive @json, which handles json_encode with safety, such as character escaping. --}}
    const headersMsg = @json($headerBagConsoleLog->all());
    console.log('Header bag: ', headersMsg);
</script>
