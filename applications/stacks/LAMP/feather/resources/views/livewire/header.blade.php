{{-- Wrapper that pins the header in the viewport and centers it horizontally --}}
<div class="fixed top-2 left-1/2 z-50 transform -translate-x-1/2 sm:top-4 md:top-8">
    {{-- Main navigation link that leads back to the home page --}}
    <a href="/" {{-- Conditionally apply classes if the current route is named "home" --}}
        @if (request()->routeIs('home')) class="flex justify-center items-center opacity-50 cursor-not-allowed pointer-events-none" @endif
        {{-- Base styling for the link (text colors, background, padding, rounded bottom, flex alignment, font size) --}}
        class="flex justify-center items-center px-6 py-4 text-base rounded-b-full text-stone-800 dark:text-stone-100 bg-stone-400 dark:bg-stone-800 md:px-8 md:py-6 sm:text-2xl lg:text-3xl">
        {{-- Blade component that renders an SVG glyph named "icon_name" using the <x-glyph> component --}}
        {{-- remember to replace the icon_name placeholder with the correct name of your SVG file --}}
        <x-glyph name="icon_name" class="w-8 h-8 text-green-500 lg:h-12 lg:w-12" aria-label="descriptive_text_label" title="visual_tooltip" />
        {{-- Inline rendering of the same "icon_name" icon using the IconHelper helper with custom class, ARIA label, and <title> for accessibility --}}
        {{-- remember to replace the icon_name placeholder with the correct name of your SVG file --}}
        {!! \Helpers\IconHelper::inlineIcon('icon_name', 'h-8 w-8 lg:h-12 lg:w-12 text-white', 'descriptive_text_label', 'visual_tooltip') !!}
        {{-- Another inline icon rendered via a custom service (Lithos) that presumably provides the same functionality
            as IconHelper but perhaps with additional processing or caching --}}
        {{-- remember to replace the icon_name placeholder with the correct name of your SVG file --}}
        {!! app(\App\Lithos::class)('icon_name', 'h-8 w-8 lg:h-12 lg:w-12 text-red-500', 'descriptive_text_label', 'visual_tooltip') !!}
    </a>
    {{-- Hidden container that sits just below the navigation link.
        It can hold a background component or decorative element that will be positioned
        behind the link (z-index 0) --}}
    <div class="absolute top-full left-1/2 z-0 transform -translate-x-1/2">
        {{-- any background component should be inserted here --}}
    </div>
</div>
