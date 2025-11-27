{{-- The child component that displays the list of matching tasks --}}
<div class="mt-2 p-2 border rounded-md bg-stone-700 border-green-600">

    {{-- Blade Foreach Loop: Iterates over the $results collection. If results are empty, it shows the empty message --}}
    @forelse ($results as $result)
        {{-- Creates a unique container for each result item with Tailwind padding --}}
        <div class="pt-2" wire:key="{{ $result->id }}">
            {{-- Creates a clickable link using AlpineJS (wire:key ensures proper Livewire state management) --}}
            <a
                {{-- Livewire directive for navigation without page refresh on hover --}}
                wire:navigate.hover
                {{-- Standard HTML href attribute pointing to the task detail page --}}
                href="/tasks/{{ $result->id }}"
                {{-- AlpineJS modifiers and Tailwind CSS classes for styling and behavior --}}
                class="no-underline text-green-600 hover:text-green-400">
                {{-- Displays the task's tag --}}
                {{ $result->tag }}
            </a>
        </div>
    @empty
        {{-- Message shown if no matching tasks are found --}}
        <p class="text-center text-gray-400">No tasks found!</p>
    @endforelse

</div>
