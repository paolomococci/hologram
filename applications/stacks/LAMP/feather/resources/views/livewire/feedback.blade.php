{{-- resources/views/livewire/feedback-message.blade.php --}}
@php
    $bgColor = match ($type) {
        'success' => 'bg-green-100',
        'error' => 'bg-red-100',
        'warning' => 'bg-yellow-100',
        'info' => 'bg-blue-100',
        default => 'bg-gray-100',
    };

    $borderColor = match ($type) {
        'success' => 'border-green-500',
        'error' => 'border-red-500',
        'warning' => 'border-yellow-500',
        'info' => 'border-blue-500',
        default => 'border-gray-500',
    };

    $textColor = match ($type) {
        'success' => 'text-green-800',
        'error' => 'text-red-800',
        'warning' => 'text-yellow-800',
        'info' => 'text-blue-800',
        default => 'text-gray-800',
    };
@endphp

@if ($message)
    <div
        x-data="{
            show:true,
            autoDismiss:null,
            startTimer() {
                // set the 5s timer
                this.autoDismiss = setTimeout(() => { this.show = false; }, 5000);
            },
            pauseTimer() {
                clearTimeout(this.autoDismiss);
            }
        }"
        x-init="startTimer()"                {{-- Starts immediately. --}}
        @mouseenter="pauseTimer()"           {{-- Pauses when the user's mouse pointer is hovered over the component. --}}
        @mouseleave="startTimer()"           {{-- Resumes when the mouse pointer leaves the component. --}}
        @click="show = false; pauseTimer()"  {{-- Closes and cancels the timer. --}}
        x-show="show"
        x-transition.duration.300ms
        class="relative rounded-md p-4 mb-4 {{ $bgColor }} {{ $borderColor }} {{ $textColor }}"
        role="alert"
        wire:ignore>

        <span class="block">{{ $message }}</span>

        {{-- button (inline‑Alpine) --}}
        <button type="button"
            class="absolute top-2 right-2 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-{{ $type }} rounded"
            aria-label="Close message" @click="show = false; clearTimeout(autoDismiss);">
            <x-glyph name="message-circle-x" class="w-6 h-6 text-green-800 lg:h-10 lg:w-10" aria-label="Dismiss button" title="Dismiss button" />
        </button>
    </div>
@endif
