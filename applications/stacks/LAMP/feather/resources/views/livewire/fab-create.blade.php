{{-- resources/views/livewire/fab-create.blade.php --}}
<div @if (request()->routeIs('create-task') || request()->routeIs('edit-task')) class="hidden" @endif>
    <button class="p-2 m-2 lg:p-3 lg:m-3 bg-stone-500 rounded-full hover:bg-stone-300"
        onclick="window.location.href = '/create';" aria-label="Add cyan" title="Create a new task">
        <x-glyph name="plus" class="h-4 w-4 lg:h-8 lg:w-8 text-cyan-500" />
    </button>
</div>
