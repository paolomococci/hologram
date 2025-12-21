<?php
/**
 * App\Normalize
 *
 * Static methods class used for "cleaning" a string and replacing
 * special characters with their HTML entities.
 *
 * @package App
 */
namespace App;

/**
 * Normalize
 *
 * The normalization process transforms characters and sequences into a formally-defined underlying representation.
 * This is crucial for text comparison, sorting, searching, and storing to ensure consistency.
 */
class Normalize
{
    /** Normalization Unicode (NFC)  */
    private const NFC = \Normalizer::FORM_C;

    /** The use of this class is "stateless".  */
    private function __construct()
    {
    }

    /**
     * Sanitize a string by expanding or stripping common escape sequences.
     *
     * 1. Converts literal escape sequences (\\n, \\r, \\t, \\f, \\v,
     *    \\xNN, …) into their real character equivalents or removes them.
     * 2. Finally removes any remaining control/whitespace characters that
     *    survived the first pass (CR, LF, TAB, form‑feed, vertical‑tab).
     *
     * @param string $temp The input string that may contain escape sequences.
     * @return string      The cleaned‑up string.  Returns an empty string on error.
     */
    public static function sanitizeStringEscapes(string $temp): string
    {
        // Replace literal escape patterns with the actual
        // characters (or an empty string if we want to drop them)
        $temp = preg_replace(
            [
                '/\\\\n/',                              // literal \n => new‑line
                '/\\\\r/',                              // literal \r => carriage‑return
                '/\\\\t/',                              // literal \t => tab
                '/\\\\f/',                              // literal \f => form‑feed
                '/\\\\v/',                              // literal \v => vertical‑tab
                '/\\\\x[0-9A-Fa-f]{2,}|[\r\n\t\f\v]+/', // \xNN (hex) or any real whitespace
            ],
            [
                "",     // keep \n as a real line‑break
                "\n",   // keep \r as a real carriage‑return
                "\t",   // keep \t as a real tab
                "\f",   // keep \f as a real form‑feed
                "\v",   // keep \v as a real vertical‑tab
                ""      // drop any remaining literal \xNN or any real whitespace
            ],
            $temp
        );

        // Strip any control or whitespace characters that were still present after the first replacement.
        // This includes CR/LF/TAB/FF/VT sequences that we chose to remove.
        $temp = preg_replace('/[\r\n\t\f\v]+/', '', $temp);

        // In theory preg_replace should never return null because $temp is typed as string, but we guard against that just in case.
        return $temp ?? '';
    }

    /**
     * Removes white space outside and replaces any sequence of white space with a single space.
     *
     * @param string $temp The string to normalize.
     * @return string
     */
    public static function trimAndCollapseWhitespace(string $temp): string
    {

        // Remove white space outside
        $temp = trim($temp);

        // Replace all Unicode white space sequences with a single space
        $temp = preg_replace('/\s+/u', ' ', $temp);

        // In theory preg_replace should never return null because $temp is typed as string, but we guard against that just in case.
        return $temp ?? '';
    }

    /**
     * Normalizes the string to Unicode NFC. If the intl extension is not available,
     * the string is returned as is.
     *
     * @param string $temp The string to normalize.
     * @return string
     */
    public static function unicodeNormalize(string $temp): string
    {
        return function_exists('normalizer_normalize')
            ? normalizer_normalize($temp, self::NFC) ?: $temp
            : $temp;
    }

    /**
     * Removes all control characters, including zero-width and non-printable.
     *
     * @param string $temp The string to normalize.
     * @return string
     */
    public static function removeInvisible(string $temp): string
    {
        $temp = preg_replace('/[\p{C}]+/u', '', $temp);

        // In theory preg_replace should never return null because $temp is typed as string, but we guard against that just in case.
        return $temp ?? '';
    }

    /**
     * Collapses multiple consecutive occurrences of the same punctuation character.
     *
     * Examples:
     *    "!!!"             =>  "!"
     *    "???"             =>  "?"
     *    "Hello---world"   =>  "Hello-world"
     *
     * @param string $temp The string to normalize.
     * @return string The string with punctuation reduced to a single character.
     */
    public static function collapsePunctuation(string $temp): string
    {
        // \p{P} = all punctuation characters (Unicode)
        // \1+ = the same occurrence repeated at least once
        // $1 = replace with the same character
        return preg_replace('/([\p{P}])\1+/u', '$1', $temp) ?? $temp;
    }

    /**
     * Translates accented characters (and others) to their corresponding HTML entities.
     * For characters not present in the map, htmlentities is used as a fallback.
     *
     * @param string $temp The string to normalize.
     * @return string
     */
    public static function accentedToHtmlEntities(string $temp): string
    {
        // Normalize to be sure we have correct composed forms
        $temp = self::unicodeNormalize($temp);

        static $map = null;
        if ($map === null) {
            // Map of accented characters (base + European specials)
            $map = [
                // A
                "À"  => "&Agrave;", "Á" => "&Aacute;", "Â" => "&Acirc;",
                "Ã"  => "&Atilde;", "Ä" => "&Auml;", "Å"   => "&Aring;",
                "à"  => "&agrave;", "á" => "&aacute;", "â" => "&acirc;",
                "ã"  => "&atilde;", "ä" => "&auml;", "å"   => "&aring;",

                // E
                "È"  => "&Egrave;", "É" => "&Eacute;", "Ê" => "&Ecirc;",
                "Ë"  => "&Euml;", "è"   => "&egrave;", "é" => "&eacute;",
                "ê"  => "&ecirc;", "ë"  => "&euml;",

                // I
                "Ì"  => "&Igrave;", "Í" => "&Iacute;", "Î" => "&Icirc;",
                "Ï"  => "&Iuml;", "ì"   => "&igrave;", "í" => "&iacute;",
                "î"  => "&icirc;", "ï"  => "&iuml;",

                // O
                "Ò"  => "&Ograve;", "Ó" => "&Oacute;", "Ô" => "&Ocirc;",
                "Õ"  => "&Otilde;", "Ö" => "&Ouml;", "Ø"   => "&Oslash;",
                "ò"  => "&ograve;", "ó" => "&oacute;", "ô" => "&ocirc;",
                "õ"  => "&otilde;", "ö" => "&ouml;", "ø"   => "&oslash;",

                // U
                "Ù"  => "&Ugrave;", "Ú" => "&Uacute;", "Û" => "&Ucirc;",
                "Ü"  => "&Uuml;", "ù"   => "&ugrave;", "ú" => "&uacute;",
                "û"  => "&ucirc;", "ü"  => "&uuml;",

                // C and N
                "Ç"  => "&Ccedil;", "ç" => "&ccedil;", "Ñ" => "&Ntilde;",
                "ñ"  => "&ntilde;",

                // Y
                "ý" => "&yacute;", "ÿ" => "&yuml;", 

                // Addition of special characters
                "Æ"  => "&AElig;", "æ"  => "&aelig;", "Ø"  => "&Oslash;",
                "ø"  => "&oslash;", "Œ" => "&OElig;", "œ"  => "&oelig;",
                "©"  => "&copy;", "™"   => "&trade;", "…"  => "&hellip;",
                "®"  => "&reg;",

                // Quotation mark
                "\"" => "&quot;", "'"   => "&apos;", "‘"   => "&lsquo;",
                "’"  => "&rsquo;", "“"  => "&ldquo;", "”"  => "&rdquo;",

                // Parenthesis
                "("  => "&lpar;", ")"   => "&rpar;", "["   => "&lbrack;",
                "]"  => "&rbrack;", "{" => "&lbrace;", "}" => "&rbrace;",
            ];
        }

        // Fast replacement with the map
        $temp = strtr($temp, $map);

        // Fallback with htmlentities for remaining non-ASCII characters
        if (preg_match('/[^\x00-\x7F]/', $temp) && function_exists('htmlentities')) {
            $encoding = mb_detect_encoding($temp, mb_detect_order(), true) ?: 'UTF-8';
            $temp     = htmlentities($temp, ENT_QUOTES | ENT_SUBSTITUTE, $encoding);
        }

        return $temp;
    }

    /**
     * Converts the string to an slug in ASCII, removing everything that is not alphanumeric,
     * hyphen, or space, and replacing spaces with hyphens.
     * It's useful if the string will be used in an URL.
     * 
     * It would be good to remember that a slug is the part of a URL that's readable and descriptive.
     *
     * @param string $temp The string to normalize.
     * @return string
     */
    public static function toSlugSafe(string $temp): string
    {
        // iconv + transliteration
        $temp = @iconv('UTF-8', 'ASCII//TRANSLIT', $temp) ?: $temp;

        // Remove non-alphanumeric characters (except hyphens and spaces)
        $temp = preg_replace('/[^A-Za-z0-9\- ]+/', '', $temp) ?? $temp;

        // 3) Spaces, hyphens, collapse double hyphen, trim
        $temp = preg_replace('/\s+/', '-', $temp) ?? $temp;
        $temp = preg_replace('/-+/', '-', $temp) ?? $temp;
        $temp = trim($temp, '-');

        return strtolower($temp);
    }
}
