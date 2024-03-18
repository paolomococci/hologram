<div>

    <form wire:submit="renumber">
        <x-button type="submit" class="inline-block m-1">Renumbering</x-button>
    </form>

    @if (session('renumber-status'))
        <div class="alert">
            <h3 class="p-1 mt-2 text-base text-center bg-yellow-300 rounded-lg">
                {{ session('renumber-status') }}
            </h3>
        </div>
    @endif

</div>
