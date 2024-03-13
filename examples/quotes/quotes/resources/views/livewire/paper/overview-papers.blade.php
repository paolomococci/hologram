<div>

    <div class="paragraph-grey">
        <form wire:submit="search">
            <x-input placeholder="search in titles" type="text" wire:model="query" />
            <x-button title="search in titles" type="submit">Search</x-button>
            <x-button type="reset">Clear</x-button>
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
