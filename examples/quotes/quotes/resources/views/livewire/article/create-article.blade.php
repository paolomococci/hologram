<div>

    <form wire:submit="save">
        <x-label for="title" class="mt-3 ml-1">Title:</x-label>
        <x-input required maxlength="255" type="text" id="title" wire:model.blur="title" />
        <div>
            @error('title')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-label for="subject" class="mt-3 ml-1">Subject:</x-label>
        <x-input required maxlength="255" type="text" id="subject" wire:model.blur="subject" />
        <div>
            @error('subject')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-label for="summary" class="mt-3 ml-1">Summary:</x-label>
        <x-input required maxlength="255" type="text" id="summary" wire:model.blur="summary" />
        <div>
            @error('summary')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-label for="content" class="mt-3 ml-1">Content:</x-label>
        <x-textarea id="content" wire:model.blur="content"></x-textarea>
        <div>
            @error('content')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <x-label for="authors" class="mt-3 ml-1">add a correlation to the following
                author:</x-label>
            <x-input list="authors" maxlength="255" type="text" size="35" id="authorToAdd" name="authorToAdd"
                wire:model.blur="authorToAdd" />
            <datalist name="authors" id="authors" class="rounded-xl bg-gray-950 text-slate-50"
                placeholder="Pick an author...">
                @foreach ($authors as $author)
                    <option value="{{ $author['email'] }}" class="text-center rounded-xl"
                        label="{{ $author['name'] }} {{ $author['surname'] }}">
                        {{ $author['email'] }}
                    </option>
                @endforeach
            </datalist>
        </div>

        <x-button type="submit" class="block mt-3">Save</x-button>
    </form>

    @if (session('status'))
        <div class="alert">
            <h3 class="p-1 mt-2 text-base text-center rounded-s" style="border-radius: 0.25rem;background-color: #ff7">
                {{ session('status') }}
            </h3>
        </div>
    @endif

</div>
