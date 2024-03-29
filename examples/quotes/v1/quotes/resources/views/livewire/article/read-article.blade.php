<div>

    @if ($article)
        <div class="flex items-center">
            <i class="bi bi-bookmark icon-2-logged"></i>
            <h2 class="app-anchor-grey">
                Read
            </h2>
        </div>

        <div>

            <div>
                <h1 class="text-base text-center text-slate-50">&#8220;{{ $article->title }}&#8221;</h1>
            </div>
            <div>
                <h3 class="text-sm text-center text-slate-50">{{ $article->subject }}</h3>
            </div>
            <div>
                <h5 class="text-xs text-center text-slate-200">{{ $article->summary }}</h5>
            </div>
            <div class="paragraph-grey">
                <p class="text-center">{{ $article->content }}</p>
            </div>
            <div class="paragraph-grey">
                @foreach ($authors as $author)
                    <p class="text-center"> {{ $author->email }}</p>
                @endforeach
            </div>

        </div>

        <p class="mt-4 text-sm">
            <span wire:click="editArticle( @js($article->id) )"
                class="items-list">
                Update
                <i class="bi bi-pencil-square icon-1-logged"></i>
            </span>
            {{-- <span wire:click="deprecateArticle( @js($article->id) )"
                class="items-list">
                Deprecate
                <i class="bi bi-shield-x icon-1-logged"></i>
            </span> --}}
        </p>

        <p class="mt-4 text-sm">
        </p>
    @endif

</div>
