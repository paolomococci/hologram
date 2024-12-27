<div class="m-4">
    <form class="flex justify-center w-9/12">
        <button
            class="p-4 my-0 text-white rounded-l-md border disabled:bg-slate-400 {{ $articleToggle ? 'bg-green-600 hover:bg-green-800' : 'bg-red-600 hover:bg-red-800' }}"
            wire:click.prevent="toggle()" {{ empty($filterText) ? 'disabled' : '' }}>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="text-red-300 lucide lucide-circle-minus size-5 sm:size-4 lg:size-6">
                <title>{{ !$articleToggle ? 'toggle deprecated' : 'toggle approved' }}</title>
                <circle cx="12" cy="12" r="10" />
                <path d="M8 12h8" />
            </svg>
        </button>
        <input type="text" class="p-4 my-0 text-lg border bg-slate-700 text-slate-50"
            wire:model.live.debounce="filterText" placeholder="{{ $placeholder }}" wire:keydown.escape="clear()">
        <button class="p-4 my-0 text-white bg-green-600 rounded-r-md border disabled:bg-slate-400 hover:bg-red-600"
            wire:click.prevent="clear()" {{ empty($filterText) ? 'disabled' : '' }}>
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
</div>
