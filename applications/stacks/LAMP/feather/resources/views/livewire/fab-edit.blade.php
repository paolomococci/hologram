{{-- resources/views/livewire/fab-edit.blade.php --}}
<div {{-- The following code is affected by event interference because request()->route()->getName() returns "livewire.update"
    and request()->routeIs('show-task') will always be false. --}} {{-- @if (!request()->routeIs('show-task')) class="hidden" @endif --}} @if (!$isEditable) class="hidden" @endif>
    {{-- <span>{{ $id }}</span> --}}
    {{-- It goes to the edit form when the button is clicked.  --}}
    <button onclick="window.location.href = '/edit/' + {{ $id }};"
        class="p-2 m-2 lg:p-3 lg:m-3 bg-stone-500 rounded-full hover:bg-stone-300">
        <x-glyph name="pen" class="h-4 w-4 lg:h-8 lg:w-8 text-orange-500" aria-label="Edit orange"
            title="Edit this task" />
    </button>
</div>
