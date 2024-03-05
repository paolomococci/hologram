<div>

    <form wire:submit="save">
        <x-label for="name" style="margin-left: 0.25rem;margin-top: 0.75rem">Name:</x-label>
        <x-input required maxlength="255" type="text" id="name" wire:model.blur="name" />
        <div>
            @error('name')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-label for="surname" style="margin-left: 0.25rem;margin-top: 0.75rem">Surname:</x-label>
        <x-input required maxlength="255" type="text" id="surname" wire:model.blur="surname" />
        <div>
            @error('surname')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-label for="nickname" style="margin-left: 0.25rem;margin-top: 0.75rem">Nickname:</x-label>
        <x-input required maxlength="255" type="text" id="nickname" wire:model.blur="nickname" />
        <div>
            @error('nickname')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-label for="email" style="margin-left: 0.25rem;margin-top: 0.75rem">Email:</x-label>
        <x-email required maxlength="255" id="email" wire:model.blur="email" />
        <div>
            @error('email')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-button type="submit" style="margin-top: 0.75rem; display: block">Save</x-button>
    </form>

    @if (session('status'))
        <div class="alert alert-success">
            <h3
                style="font-size: 1rem;background-color: yellow;text-align: center;margin-top: 0.5rem;padding: 0.25rem;border-radius: 0.25rem">
                {{ session('status') }}
            </h3>
        </div>
    @endif

</div>
