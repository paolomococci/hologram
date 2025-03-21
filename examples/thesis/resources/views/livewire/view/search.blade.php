<div class="m-4">

    <x-alerts.offline />

    <form class="flex justify-center w-9/12">
        <input type="text"
            class="p-4 my-0 text-lg rounded-l-md border dark:bg-slate-700 dark:text-slate-50 bg-slate-50 text-slate-700"
            wire:model.live.debounce="searchText" placeholder="{{ $placeholder }}" wire:keydown.escape="clear()"
            wire:offline.attr="disabled">
        <button class="p-4 my-0 text-white bg-green-600 rounded-r-md border disabled:bg-slate-400 hover:bg-red-600"
            wire:click.prevent="clear()" {{ empty($searchText) ? 'disabled' : '' }} wire:offline.attr="disabled">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="text-green-300 size-5 sm:size-4 lg:size-6 lucide lucide-circle-x">
                <title>clear</title>
                <circle cx="12" cy="12" r="10" />
                <path d="m15 9-6 6" />
                <path d="m9 9 6 6" />
            </svg>
        </button>
    </form>
    <livewire:view.results :results="$results" :show="!empty($searchText)" />
</div>
