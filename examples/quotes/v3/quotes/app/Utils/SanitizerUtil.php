<?php

namespace App\Utils;

class SanitizerUtil
{
    /**
     * a first attempt to sanitize user input
     */
    public static function filtrate(string $suspicious): string
    {
        try {
            $trimmed = trim(preg_replace('/\r|\v|\t|\n/', '', $suspicious), ' ');
            $withoutNullCharactersAndHtmlTags = preg_replace(
                '/\x00|<[^>]*>?/',
                '',
                $trimmed
            );
            $allowedCharacters = preg_replace(
                '/^\d|[^\sa-zA-Z]+|\s*$/',
                '',
                $withoutNullCharactersAndHtmlTags
            );
            $withoutRepeatedSpaces = trim(preg_replace(
                '/\s\s+/',
                ' ',
                $allowedCharacters
            ), ' ');

            return $withoutRepeatedSpaces;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * a first attempt to sanitize user input
     */
    public static function sanitize(string $suspicious): string
    {
        try {
            $trimmed = trim(preg_replace('/\r|\v|\t/', '', $suspicious), ' \n');
            $withoutNullCharactersAndHtmlTags = preg_replace(
                '/\x00|<[^>]*>?/',
                '',
                $trimmed
            );
            $translatedIntoEntities = self::dehydrate($withoutNullCharactersAndHtmlTags);

            return $translatedIntoEntities;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * translate from character to html entities
     */
    public static function dehydrate(string $hazy): string
    {
        try {
            return str_replace(
                ["'", '"', '`', '~', '/', '\\', '$', '%', '+', '-', '=', '(', ')', '[', ']', '{', '}', '|', '*', '!', '?', '<', '>'],
                ['&#39;', '&#34;', '&#96;', '&#126;', '&#47;', '&#92;', '&#36;', '&#37;', '&#43;', '&#8722;', '&#61;', '&#40;', '&#41;', '&#91;', '&#93;', '&#123;', '&#125;', '&#124;', '&#42;', '&#33;', '&#63;', '&#60;', '&#62;'],
                $hazy
            );
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    /**
     * translate from html entities to character
     */
    public static function rehydrate(string $dehydrated): string
    {
        try {
            return str_replace(
                ['&#39;', '&#34;', '&#96;', '&#126;', '&#47;', '&#92;', '&#36;', '&#37;', '&#43;', '&#8722;', '&#61;', '&#40;', '&#41;', '&#91;', '&#93;', '&#123;', '&#125;', '&#124;', '&#42;', '&#33;', '&#63;', '&#60;', '&#62;'],
                ["'", '"', '`', '~', '/', '\\', '$', '%', '+', '-', '=', '(', ')', '[', ']', '{', '}', '|', '*', '!', '?', '<', '>'],
                $dehydrated
            );
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }
}
