<div>

    <form wire:submit="resetAllData">
        <x-button type="submit" class="m-1 inline-block">Reset</x-button>
    </form>

    @if (session('clear-data-status'))
        <div class="alert">
            <h3 class="p-1 mt-2 text-base text-center bg-yellow-300 rounded-lg">
                {{ session('clear-data-status') }}
            </h3>
        </div>
    @endif

</div>
