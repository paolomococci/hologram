{{-- resources/views/livewire/edit-task.blade.php --}}
<div class="container mx-auto px-4 py-4">

    {{-- With redirection, it becomes unnecessary. --}}
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="store" novalidate
        class="max-w-xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 space-y-6">

        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">New Task</h2>

        {{-- Tag --}}
        <div class="space-y-1">
            <label for="tag" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                Tag
            </label>
            <input
                type="text"
                id="tag"
                wire:model.defer="tag"
                required
                autocomplete="off"
                placeholder="new task"
                class="w-full border rounded-md p-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-150"
                aria-describedby="tag-error"
            />
            @error('tag')
                <p id="tag-error" class="text-red-600 text-sm mt-1" role="alert">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div class="space-y-1">
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                Description
            </label>
            <textarea
                id="description"
                rows="3"
                wire:model.defer="description"
                placeholder="type a new description..."
                class="w-full border rounded-md p-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-150"
                aria-describedby="description-error"
            ></textarea>
            @error('description')
                <p id="description-error" class="text-red-600 text-sm mt-1" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full flex justify-center py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            New
        </button>
    </form>
</div>
