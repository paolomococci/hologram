<div>

    <div class="paragraph-grey">
        <form wire:submit="search">
            <x-input placeholder="search in surnames" type="text" wire:model="query" />
            <x-button title="search in surnames" type="submit" class="m-1">Search</x-button>
            <x-button type="reset">Clear</x-button>
        </form>
    </div>

    <ul class="text-basetext-white ">
        @if ($authors->isEmpty())
            <p class="paragraph-empty-items-info">No author is registered with the aforementioned surname!</p>
        @else
            @foreach ($authors as $author)
                <li id="author_{{ $author->id }}" wire:key='{{ $author->id }}'>
                    <span wire:click="showAuthor( @js($author->id) )"
                        class="items-list">
                        {{ $author->name }} {{ $author->surname }}
                        <i class="bi bi-chevron-right icon-1-logged"></i>
                    </span>
                </li>
            @endforeach

            {{ $authors->links() }}
        @endif
    </ul>

</div>
