{{-- resources/views/livewire/toggle.blade.php --}}
{{-- toggle.blade.php – Button that shows a different glyph depending on the current state --}}
<div @if (!$isVisible) hidden @endif>
    <button wire:click="toggle"
        class="p-2 m-2 lg:p-3 lg:m-3 bg-stone-500 rounded-full hover:bg-stone-300 focus:outline-none focus:ring-2 focus:ring-stone-400">
        @if ($isOn)
            {{-- Icon for todo mode --}}
            <x-glyph name="toggle-left" title="Show tasks that have been completed" class="w-5 h-5 text-amber-500" />
        @else
            {{-- Icon for done mode --}}
            <x-glyph name="toggle-right" title="Show tasks that are still to be done" class="w-5 h-5 text-green-700" />
        @endif
    </button>
</div>
