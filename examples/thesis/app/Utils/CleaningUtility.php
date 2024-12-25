<?php

namespace App\Utils;

class CleaningUtility
{
    public static function cleanTitle(string $title): string {
        return substr($title, 0, strpos($title, " ("));
    }
}
