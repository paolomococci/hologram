{{-- resources/views/livewire/fab-done.blade.php --}}
{{-- The button is visible only if the task has been loaded and is_done is false. --}}
<div>
    @if ($task && ! $task->is_done)
        <button
            type="button"
            wire:click="done"
            class="p-2 m-2 lg:p-3 lg:m-3 bg-stone-500 rounded-full hover:bg-stone-300"
        >
            <x-glyph
                name="check"
                class="h-4 w-4 lg:h-8 lg:w-8 text-yellow-500"
                aria-label="Done yellow"
                title="Mark is done"
            />
        </button>
    @endif
</div>

<script>
    // Livewire 3 emits custom events to `window`.
    document.addEventListener('livewire:initialized', () => {
        window.addEventListener('fab-done-console-log', event => {
            const detail = Array.isArray(event.detail) ? event.detail[0] : event.detail;
            console.log(detail.msg);
        });
    });
</script>
