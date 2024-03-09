<div>

    <div class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
        <form wire:submit="search">
            <x-input placeholder="search in titles" type="text" wire:model="query" />
            <x-button title="search in titles" type="submit" style="margin: 0.25rem">Search</x-button>
            <x-button type="reset" style="margin: 0.25rem">Clear</x-button>
        </form>
    </div>

    <ul style="font-size: 1rem; color: #fff">
        @if ($papers->isEmpty())
            <p>There are no papers registered in the system.</p>
        @else
            @foreach ($papers as $paper)
                <li id="paper_{{ $paper->id }}" wire:key='{{ $paper->id }}'>
                    <span wire:click="showPaper( @js($paper->id) )"
                        class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300"
                        style="cursor: pointer">
                        {{ $paper->title }}
                        <i class="bi bi-chevron-right icon-1-logged"></i>
                    </span>
                </li>
            @endforeach

            {{ $papers->links() }}
        @endif
    </ul>

</div>
