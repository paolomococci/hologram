<div class="z-10 p-4 rounded-md border backdrop-brightness-125 border-slate-900 full-width">
    @if ($article != null)
        <h2 class="text-2xl text-white/70">{{ $article['title'] }}</h2>
        <p class="text-white/85 text-pretty">
            {{ $article['content'] }}
        </p>
    @else
        <p class="text-lg font-normal text-black/85">Waiting for an article to be selected.</p>
    @endif
</div>
