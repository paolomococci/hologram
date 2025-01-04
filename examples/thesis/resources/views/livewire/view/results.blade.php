@php
    use App\Utils\CleaningUtility;
@endphp
<div class="{{ $show ? 'block' : 'hidden' }} mt-4">
    <div
        class="absolute z-50 p-4 mt-4 bg-gray-400 rounded-b-md border border-green-300 dark:bg-gray-700 dark:border-green-600">

        <div class="absolute top-0 right-0 pt-1 pr-3 mt-2 ml-4">
            <button type="button" wire:click="dispatch('search:clear-results')">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="text-green-300 hover:text-red-300 size-5 sm:size-4 lg:size-6 lucide lucide-x">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>

        @if (count($results) == 0)
            <div wire:transition.delay.100ms.duration.1000ms.opacity.duration.500ms>
                <p class="mr-8 text-sm/relaxed">
                    no results were found
                </p>
            </div>
        @else
            @foreach ($results as $result)
                <p class="mr-8 text-sm/relaxed" wire:key="{{ $result->id }}">
                    <a wire:navigate.hover
                        href="/articles/{{ $result->id }}">{{ CleaningUtility::cleanTitle($result->title) }}</a>
                </p>
            @endforeach
        @endif
    </div>
</div>
