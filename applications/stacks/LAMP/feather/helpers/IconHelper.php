<?php
namespace Helpers;

class IconHelper
{
    /**
     * inlineIcon
     *
     * @param  mixed $name
     * @param  mixed $class
     * @param  mixed $ariaLabel
     * @param  mixed $title
     * @return string
     */
    public static function inlineIcon(string $name, string $class = 'h-6 w-6', ?string $ariaLabel = null, ?string $title = null): string
    {
        // Build the absolute path to the requested SVG file
        // The path is set in the .env file
        $path = resource_path(env('ICONS_PATH') . "{$name}.svg");

        // Return a comment if the file does not exist
        if (! file_exists($path)) {
            return '<!-- icon not found: ' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . ' -->';
        }

        // Load the SVG file contents
        $svg = file_get_contents($path);

        // Return a comment if the file could not be read
        if ($svg === false) {
            return '<!-- icon read error: ' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . ' -->';
        }

        // ------------------------------------------------------------------
        // Clean the SVG markup:
        // 1. Remove <script> tags and any inline JavaScript
        // 2. Remove HTML comments
        // 3. Collapse whitespace between tags
        // ------------------------------------------------------------------
        $svg = preg_replace('#<script.*?>.*?</script>#is', '', $svg);
        $svg = preg_replace('/<!--.*?-->/s', '', $svg);
        $svg = preg_replace('/>\s+</s', '><', $svg);

        // ------------------------------------------------------------------
        // Normalize the <svg> element:
        // 1. Remove existing class, role, aria‑*, on* handlers, and aria‑hidden
        // 2. Inject the desired class, ARIA attributes, and optional <title>
        // ------------------------------------------------------------------
        $svg = preg_replace_callback(
            // Match the opening <svg> tag and capture its attributes
            '/<svg\b([^>]*)>/i',
            function ($m) use ($class, $ariaLabel, $title) {
                // Trim any leading/trailing whitespace from the captured attributes
                $attrs = trim($m[1]);

                // Strip out any class, role, aria‑*, on* handlers, and aria‑hidden attributes
                $attrs = preg_replace('/\s*\b(class|role|aria-[a-z-]+)=["\'][^"\']*["\']\s*/i', ' ', $attrs);
                $attrs = preg_replace('#\s*on\w+=(["\']).*?\1#is', ' ', $attrs);
                $attrs = preg_replace('/\s*(aria-hidden)=["\'][^"\']*["\']\s*/i', ' ', $attrs);

                // Sanitize the supplied class string
                $cls      = htmlspecialchars($class, ENT_QUOTES, 'UTF-8');

                // Decide on ARIA attributes: if a label is given, expose as an image; otherwise hide it
                $ariaAttr = $ariaLabel
                    ? ' role="img" aria-label="' . htmlspecialchars($ariaLabel, ENT_QUOTES, 'UTF-8') . '"'
                    : ' aria-hidden="true"';

                // Add a <title> element if one was provided
                $titleTag = $title ? '<title>' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</title>' : '';

                // Re‑add any remaining original attributes (if any)
                $attrs = $attrs ? ' ' . trim($attrs) : '';

                // Return the new opening <svg> tag with the cleaned and injected attributes
                return '<svg' . $attrs . ' class="' . $cls . '"' . $ariaAttr . '>' . $titleTag;
            },
            $svg,
            // Only replace the first <svg> tag to avoid nested <svg> issues
            1
        );

        // Return the fully processed SVG markup
        return $svg;
    }
}
