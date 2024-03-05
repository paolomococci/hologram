<div>

    @if ($author)
        <div class="flex items-center">
            <i class="bi bi-bookmark icon-2-logged"></i>
            <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                Read
            </h2>
        </div>

        <div>

            <div>
                <h1 style="font-size: 1.2rem;color:azure;text-align:center">&#8220;{{ $author->nickname }}&#8221;</h1>
            </div>
            <div>
                <h3 style="font-size: 1.0rem;color:azure;text-align:center">{{ $author->name }}</h3>
            </div>
            <div>
                <h5 style="font-size: 0.8rem;color:azure;text-align:center">{{ $author->surname }}</h5>
            </div>
            <div class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                <p style="text-align: center">{{ $author->email }}</p>
            </div>
            <div class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                @foreach ($articles as $article)
                    <p style="text-align: center"> {{ $article->title }}</p>
                @endforeach
            </div>

        </div>

        <p class="mt-4 text-sm">
            <span wire:click="editAuthor( @js($author->id) )"
                class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300"
                style="cursor: pointer">
                Update
                <i class="bi bi-pencil-square icon-1-logged"></i>
            </span>
            {{-- <span wire:click="deprecateAuthor( @js($author->id) )"
                class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300"
                style="cursor: pointer">
                Deprecate
                <i class="bi bi-shield-x icon-1-logged"></i>
            </span> --}}
        </p>

        <p class="mt-4 text-sm">
        </p>
    @endif

</div>
