<div>

    <form wire:submit="save">
        <x-label for="title" class="ml-1 mt-3">Title:</x-label>
        <x-input required maxlength="255" type="text" id="title" wire:model.blur="title" />
        <div>
            @error('title')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-label for="subject" class="ml-1 mt-3">Subject:</x-label>
        <x-input required maxlength="255" type="text" id="subject" wire:model.blur="subject" />
        <div>
            @error('subject')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-label for="summary" class="ml-1 mt-3">Summary:</x-label>
        <x-input required maxlength="255" type="text" id="summary" wire:model.blur="summary" />
        <div>
            @error('summary')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-label for="content" class="ml-1 mt-3">Content:</x-label>
        <x-textarea id="content" wire:model.blur="content"></x-textarea>
        <div>
            @error('content')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <x-label for="authors" class="ml-1 mt-3">add a correlation to the following
                author:</x-label>
            <x-input list="authors" maxlength="255" type="text" size="35" id="authorToAdd" name="authorToAdd"
                wire:model.blur="authorToAdd" />
            <datalist name="authors" id="authors" class="rounded-xl bg-gray-950 text-slate-50"
                placeholder="Pick an author...">
                @foreach ($authors as $author)
                    <option value="{{ $author['email'] }}" class="rounded-xl text-center"
                        label="{{ $author['name'] }} {{ $author['surname'] }}">
                        {{ $author['email'] }}
                    </option>
                @endforeach
            </datalist>
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
