@props([
    // icon file name without extension
    'name',
    // predefined CSS classes
    'class' => 'h-5 w-5',
    // accessibility label
    'ariaLabel' => null,
    // title text
    'title' => null,
    // If true, it in-lines the SVG; otherwise, it includes it via <img>
    'inline' => true,
])

@php
    // Lucide icons
    $iconPath = resource_path(env('ICONS_PATH') . "{$name}.svg");
    if (!file_exists($iconPath)) {
        // fallback: it can return an empty string or a placeholder
        $svg = '';
    } else {
        $svg = file_get_contents($iconPath);

        // Removes unnecessary comments and spaces
        $svg = preg_replace('/<!--.*?-->/s', '', $svg);
        $svg = preg_replace('/\s+/', ' ', $svg);

        // Add/merge classes on the <svg> tag
        $svg = preg_replace_callback(
            '/<svg\b([^>]*)>/i',
            function ($m) use ($class, $ariaLabel, $title) {
                $attrs = $m[1];

                // Removes any existing class to replace it
                $attrs = preg_replace('/\bclass=["\'][^"\']*["\']\s*/i', '', $attrs);

                // Adds role and aria-label if provided, or aria-hidden if no label
                if ($ariaLabel) {
                    $ariaAttr = ' role="img" aria-label="' . e($ariaLabel) . '"';
                } else {
                    $ariaAttr = ' aria-hidden="true"';
                }

                // Adds <title> if required, avoids duplicates if already present
                $titleTag = '';
                if ($title) {
                    $titleTag = '<title>' . e($title) . '</title>';
                }

                return '<svg' . $attrs . ' class="' . e($class) . '"' . $ariaAttr . '>' . $titleTag;
            },
            $svg,
            1,
        );
    }
@endphp

@if ($svg)
    {{-- Inline SVG, allows styling with currentColor and class modification --}}
    {!! $svg !!}
@else
    {{-- Fallback: external image if not found --}}
    <img src="{{ asset("icons/{$name}.svg") }}" class="{{ $class }}" alt="{{ $ariaLabel ?? $name }}">
@endif
