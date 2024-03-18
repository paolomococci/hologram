<div>

    <form wire:submit="save">
        <x-label for="name" class="mt-3 ml-1">Name:</x-label>
        <x-input required maxlength="255" type="text" id="name" wire:model.blur="name" />
        <div>
            @error('name')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-label for="surname" class="mt-3 ml-1">Surname:</x-label>
        <x-input required maxlength="255" type="text" id="surname" wire:model.blur="surname" />
        <div>
            @error('surname')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-label for="nickname" class="mt-3 ml-1">Nickname:</x-label>
        <x-input required maxlength="255" type="text" id="nickname" wire:model.blur="nickname" />
        <div>
            @error('nickname')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-label for="email" class="mt-3 ml-1">Email:</x-label>
        <x-email required maxlength="255" id="email" wire:model.blur="email" />
        <div>
            @error('email')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-button type="submit" class="block mt-3">Save</x-button>
    </form>

    @if (session('status'))
        <div class="alert">
            <h3 class="p-1 mt-2 text-base text-center bg-yellow-300 rounded-lg">
                {{ session('status') }}
            </h3>
        </div>
    @endif

</div>
