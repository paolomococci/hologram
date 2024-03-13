<div>

    <div class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
        <form wire:submit="search">
            <x-input placeholder="search in titles" type="text" wire:model="query" />
            <x-button title="search in titles" type="submit">Search</x-button>
            <x-button type="reset">Clear</x-button>
        </form>
    </div>

    <ul class="text-basetext-white ">
        @if ($articles->isEmpty())
            <p>There are no articles registered in the system.</p>
        @else
            @foreach ($articles as $article)
                <li id="article_{{ $article->id }}" wire:key='{{ $article->id }}'>
                    <span wire:click="showArticle( @js($article->id) )"
                        class="inline-flex items-center font-semibold text-indigo-700 cursor-pointer dark:text-indigo-300">
                        {{ $article->title }}
                        <i class="bi bi-chevron-right icon-1-logged"></i>
                    </span>
                </li>
            @endforeach

            {{ $articles->links() }}
        @endif
    </ul>

</div>
