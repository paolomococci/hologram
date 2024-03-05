<div>

    <div class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
        <form wire:submit="search">
            <x-input placeholder="search in surnames" type="text" wire:model="query" />
            <x-button title="search in surnames" type="submit" style="margin: 0.25rem">Search</x-button>
            <x-button type="reset" style="margin: 0.25rem">Clear</x-button>
        </form>
    </div>

    <ul style="font-size: 1rem; color: #fff">
        @if ($authors->isEmpty())
            <p>No author is registered with the aforementioned surname!</p>
        @else
            @foreach ($authors as $author)
                <li id="author_{{ $author->id }}" wire:key='{{ $author->id }}'>
                    <span wire:click="showAuthor( @js($author->id) )"
                        class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300"
                        style="cursor: pointer">
                        {{ $author->name }} {{ $author->surname }}
                        <i class="bi bi-chevron-right icon-1-logged"></i>
                    </span>
                </li>
            @endforeach

            {{ $authors->links() }}
        @endif
    </ul>

</div>
