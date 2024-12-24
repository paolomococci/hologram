<div class="m-auto w-5/6">
    <div class="mt-4 w-full text-slate-400">
        {{ $articles->links() }}
    </div>
    @foreach ($articles as $article)
        <div class="p-3 mt-5" wire:key="{{ $article->id }}">
            <h3 class="font-semibold text-green-900 text-md-center dark:text-green-400">
                <a href="/articles/{{ $article->id }}">{{ $article->title }}</a>
            </h3>
            <h5 class="mt-2 text-xs text-green-700 dark:text-green-100">
                {{ $article->subject }}
            </h5>
            <p class="mt-4 text-sm/relaxed">
                {{ str($article->content)->words(15) }}
            </p>
        </div>
    @endforeach
</div>
