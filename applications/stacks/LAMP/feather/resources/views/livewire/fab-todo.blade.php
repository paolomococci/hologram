{{-- resources/views/livewire/fab-todo.blade.php --}}
{{-- The button is visible only if the task has been loaded and is_done is true. --}}
<div>
    @if ($task && ! !$task->is_done)
        <button
            type="button"
            wire:click="todo"
            class="p-2 m-2 lg:p-3 lg:m-3 bg-stone-500 rounded-full hover:bg-stone-300"
        >
            <x-glyph
                name="calendar-clock"
                class="h-4 w-4 lg:h-8 lg:w-8 text-green-500"
                aria-label="Todo green"
                title="Mark is todo"
            />
        </button>
    @endif
</div>

<script>
    // Livewire 3 emits custom events to `window`.
    document.addEventListener('livewire:initialized', () => {
        window.addEventListener('fab-todo-console-log', event => {
            const detail = Array.isArray(event.detail) ? event.detail[0] : event.detail;
            console.log(detail.msg);
        });
    });
</script>
