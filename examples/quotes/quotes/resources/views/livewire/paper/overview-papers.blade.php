<div>

    <div class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
        <form wire:submit="search">
            <x-input placeholder="search in titles" type="text" wire:model="query" />
            <x-button title="search in titles" type="submit" class="m-1">Search</x-button>
            <x-button type="reset" class="m-1">Clear</x-button>
        </form>
    </div>

    <ul class="text-basetext-white ">
        @if ($papers->isEmpty())
            <p>There are no papers registered in the system.</p>
        @else
            @foreach ($papers as $paper)
                <li id="paper_{{ $paper->id }}" wire:key='{{ $paper->id }}'>
                    <span wire:click="showPaper( @js($paper->id) )"
                        class="inline-flex items-center font-semibold text-indigo-700 cursor-pointer dark:text-indigo-300">
                        {{ $paper->title }}
                        <i class="bi bi-chevron-right icon-1-logged"></i>
                    </span>
                </li>
            @endforeach

            {{ $papers->links() }}
        @endif
    </ul>

</div>
