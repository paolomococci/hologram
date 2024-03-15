<div>

    @if ($paper)
        <div class="flex items-center">
            <i class="bi bi-pencil-square icon-2-logged"></i>
            <h2 class="app-anchor-grey">
                Update paper &#8220;{{ $paper->title }}&#8221;
            </h2>
        </div>

        <form wire:submit="update" enctype="multipart/form-data">

            <x-label for="title" class="mt-3 ml-1">Title:</x-label>
            <x-input maxlength="255" type="text" id="title" wire:model.blur="title" />
            <div>
                @error('title')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <x-label for="name" class="mt-3 ml-1">Name:</x-label>
            <x-input readonly type="text" id="name" wire:model="name" />
            <div>
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label for="content" class="mt-3 ml-1">Content:</x-label>
                <x-textarea maxlength="500" id="content"
                    class="border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                    wire:model.blur="content"></x-textarea>
                <div>
                    @error('content')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <x-button type="submit" class="block mt-3">Update</x-button>

        </form>

        @if (session('status'))
            <div class="alert">
                <h3 class="p-1 mt-2 text-base text-center bg-yellow-300 rounded-lg">
                    {{ session('status') }}
                </h3>
            </div>
        @endif
    @endif

</div>
