<div>

    <form wire:submit="save">
        <x-label for="name" class="ml-1 mt-3">Name:</x-label>
        <x-input required maxlength="255" type="text" id="name" wire:model.blur="name" />
        <div>
            @error('name')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-label for="surname" class="ml-1 mt-3">Surname:</x-label>
        <x-input required maxlength="255" type="text" id="surname" wire:model.blur="surname" />
        <div>
            @error('surname')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-label for="nickname" class="ml-1 mt-3">Nickname:</x-label>
        <x-input required maxlength="255" type="text" id="nickname" wire:model.blur="nickname" />
        <div>
            @error('nickname')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-label for="email" class="ml-1 mt-3">Email:</x-label>
        <x-email required maxlength="255" id="email" wire:model.blur="email" />
        <div>
            @error('email')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-button type="submit" class="mt-3 block">Save</x-button>
    </form>

    @if (session('status'))
        <div class="alert alert-success">
            <h3
                class="mt-2 p-1 text-base bg-amber-200 text-center rounded-s">
                {{ session('status') }}
            </h3>
        </div>
    @endif

</div>
