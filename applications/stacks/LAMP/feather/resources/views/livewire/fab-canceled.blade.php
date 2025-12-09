{{-- resources/views/livewire/fab-cancelled.blade.php --}}
<div @if (!request()->routeIs('show-task')) class="hidden" @endif>
    <button type="button" wire:click="delete('{{ request()->url() }}')"
        class="p-2 m-2 lg:p-3 lg:m-3 bg-stone-500 rounded-full hover:bg-stone-300">
        <x-glyph name="pen-off" class="h-4 w-4 lg:h-8 lg:w-8 text-red-500" aria-label="Canceled red"
            title="Delete this task" />
    </button>
</div>
