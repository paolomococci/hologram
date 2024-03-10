<div>

    @if ($article)
        <div class="flex items-center">
            <i class="bi bi-pencil-square icon-2-logged"></i>
            <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                Update article &#8220;{{ $article->title }}&#8221;
            </h2>
        </div>

        <form wire:submit="update">
            <div
                class="grid grid-cols-1 gap-6 p-6 bg-gray-200 bg-opacity-25 dark:bg-gray-800 md:grid-cols-2 lg:gap-8 lg:p-8">

                <div>
                    <x-label for="title" class="ml-1 mt-3">Title:</x-label>
                    <x-input readonly maxlength="255" type="text" size="35" id="title"
                        wire:model.blur="title" />
                    <div>
                        @error('title')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <x-label for="subject" class="ml-1 mt-3">Subject:</x-label>
                    <x-input required maxlength="255" type="text" size="35" id="subject"
                        wire:model.blur="subject" />
                    <div>
                        @error('subject')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <x-label for="summary" class="ml-1 mt-3">Summary:</x-label>
                    <x-input required maxlength="255" type="text" size="35" id="summary"
                        wire:model.blur="summary" />
                    <div>
                        @error('summary')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <x-label for="deprecated" class="ml-1 mt-3 inline">
                        Deprecated:
                    </x-label>
                    <x-input type="checkbox" id="deprecated" wire:model.blur="deprecated" />
                </div>

                <div>
                    <x-label for="content" class="ml-1 mt-3">Content:</x-label>
                    <x-textarea maxlength="500" id="content"
                        class="border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                        wire:model.blur="content"></x-textarea>
                    <div>
                        @error('content')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <h3 class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                        has received contributions from the following authors:
                    </h3>

                    <div class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        @foreach ($relatedAuthors as $relatedAuthor)
                            <h2>
                                {{ $relatedAuthor->email }}
                            </h2>
                        @endforeach
                    </div>
                </div>

                <div>
                    <x-label for="authors" class="ml-1 mt-3">add a correlation to the
                        following author:</x-label>
                    <x-input list="authors" maxlength="255" type="text" size="35" id="authorToAdd"
                        name="authorToAdd" wire:model.blur="authorToAdd" />
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
            </div>

            <x-button type="submit" class="mt-3 block">Update</x-button>
        </form>

        @if (session('status'))
            <div class="alert alert-success">
                <h3
                    class="mt-2 p-1 text-base bg-amber-200 text-center rounded-s">
                    {{ session('status') }}
                </h3>
            </div>
        @endif
    @endif

</div>
