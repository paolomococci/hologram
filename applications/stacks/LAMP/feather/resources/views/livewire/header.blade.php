{{-- resources/views/livewire/header.blade.php --}}
{{-- Wrapper that pins the header in the viewport and centers it horizontally --}}
<div class="fixed top-2 sm:top-4 md:top-8 left-1/2 transform -translate-x-1/2 z-50">
    {{-- Main navigation link that leads back to the home page --}}
    <a href="/" {{-- Conditionally apply classes if the current route is named "home" --}}
        @if (request()->routeIs('home')) class="pointer-events-none opacity-50 cursor-not-allowed flex justify-center items-center" @endif
        {{-- Base styling for the link (text colors, background, padding, rounded bottom, flex alignment, font size) --}}
        class="text-stone-800 dark:text-stone-100 bg-stone-400 dark:bg-stone-800 px-6 py-4 md:px-8 md:py-6 rounded-b-full flex justify-center items-center text-base sm:text-2xl lg:text-3xl">
        {{-- Blade component that renders an SVG glyph named "feather" using the <x-glyph> component --}}
        <x-glyph name="feather" class="h-8 w-8 lg:h-12 lg:w-12 text-green-500" aria-label="Feather green" title="Back to home page" />
        {{-- Inline rendering of the same "feather" icon using the IconHelper helper with custom class, ARIA label, and <title> for accessibility --}}
        {!! \Helpers\IconHelper::inlineIcon('feather', 'h-8 w-8 lg:h-12 lg:w-12 text-white', 'Feather white', 'Back to home page') !!}
        {{-- Another inline icon rendered via a custom service (Lithos) that presumably provides the same functionality
            as IconHelper but perhaps with additional processing or caching --}}
        {!! app(\App\Lithos::class)('feather', 'h-8 w-8 lg:h-12 lg:w-12 text-red-500', 'Feather red', 'Back to home page') !!}
    </a>
    {{-- Hidden container that sits just below the navigation link.
        It can hold a background component or decorative element that will be positioned
        behind the link (z-index 0) --}}
    <div class="absolute top-full left-1/2 transform -translate-x-1/2 z-0">
        {{-- any background component should be inserted here --}}
    </div>
</div>
