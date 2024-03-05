<div>

    <form wire:submit="save">
        <x-label for="title" style="margin-left: 0.25rem;margin-top: 0.75rem">Title:</x-label>
        <x-input required maxlength="255" type="text" id="title" wire:model.blur="title" />
        <div>
            @error('title')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-label for="subject" style="margin-left: 0.25rem;margin-top: 0.75rem">Subject:</x-label>
        <x-input required maxlength="255" type="text" id="subject" wire:model.blur="subject" />
        <div>
            @error('subject')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-label for="summary" style="margin-left: 0.25rem;margin-top: 0.75rem">Summary:</x-label>
        <x-input required maxlength="255" type="text" id="summary" wire:model.blur="summary" />
        <div>
            @error('summary')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-label for="content" style="margin-left: 0.25rem;margin-top: 0.75rem">Content:</x-label>
        <x-textarea id="content" wire:model.blur="content"></x-textarea>
        <div>
            @error('content')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <x-label for="authors" style="margin-left: 0.25rem;margin-top: 0.75rem">add a correlation to the following
                author:</x-label>
            <x-input list="authors" maxlength="255" type="text" size="35" id="authorToAdd" name="authorToAdd"
                wire:model.blur="authorToAdd" />
            <datalist name="authors" id="authors" style="border-radius: 5px;background-color:#112;color:#fff"
                placeholder="Pick an author...">
                @foreach ($authors as $author)
                    <option value="{{ $author['email'] }}" style="border-radius: 5px;text-align: center"
                        label="{{ $author['name'] }} {{ $author['surname'] }}">
                        {{ $author['email'] }}
                    </option>
                @endforeach
            </datalist>
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
