<?php
    declare (strict_types = 1);
    // Enforce strict type checking - no implicit coercions

    /**
     * Namespace declaration.  All code in this file belongs to the App namespace,
     * which keeps symbols (classes, functions, constants) isolated from the global scope.
     */
    namespace App;

    /**
     * Import two classes from the same namespace so we can use them without the full
     * namespace prefix.  They are defined in other files that will be autoload.
     */
    use App\Normalize;
    // use App\Utils;

    /**
     * Register a very simple PSR‑0/PSR‑4 style autoloader.  Whenever a class is referenced
     * that hasn't been loaded yet, PHP will call this closure with the fully‑qualified
     * class name (e.g. App\Normalize).  The closure converts namespace separators
     * to directory separators and includes the corresponding PHP file.
     * 
     *   App\Normalize   =>  ../src/App/Normalize.php
     * 
     * This keeps the code in this file free of a bunch of manual require_once statements.
     */
    spl_autoload_register(
        function (string $class) {
            // Convert namespace separators (\) to directory separators (/)
            $path = '../src/' . str_replace('\\', '/', $class) . '.php';
            // Include the class file
            require $path;
        }
    );


    /**
     * Core logic - normalizing a messy string
     * 
     * $strTrash contains a deliberately chaotic string:
     * - Leading/trailing spaces
     * - Mixed Latin & non‑Latin characters
     * - Various punctuation marks
     * - Invisible/zero‑width characters
     * - Multiple consecutive spaces
     * 
     * I want to clean it up so that it can be safely output in HTML.
     * 
     * PHP 8.5 introduced the **pipe operator (|>)** which allows us to
     * pipe the value from left to right through a series of callbacks.
     * 
     * Each stage receives the result of the previous stage, does something,
     * and returns a new value.  The final value is assigned back to $strTrash.
     */
    $strTrash = '  we \n   ©  \x02c  Cìàó ÿ tùdo  æ … "  èl  mùndó! .. ] ??? ,, ™  “  ” \t  a deliberatélý cháøtíc  string  ' 
        // Sanitize the string
        // The ellipsis (…) is left untouched.
        |> Normalize::sanitizeStringEscapes(...)
        // Trim leading/trailing whitespace **and** collapse runs of internal whitespace to a single space.
        |> (fn($v) => Normalize::trimAndCollapseWhitespace($v))
        // Unicode normalization (NFC/NFKC).
        // Problem: Unicode allows multiple ways to represent the same visual character.
        // Objective: convert equivalent text strings into a single canonical form.
        // Forms of normalization:
        // NFC (Normalization Form Canonical Composition)
        // NFD (Normalization Form Canonical Decomposition)
        // NFKC (Normalization Form Compatibility Composition)
        // NFKD (Normalization Form Compatibility Decomposition)
        |> (fn($v) => Normalize::unicodeNormalize($v))
        // Remove characters that are invisible to the user.
        |> (fn($v) => Normalize::removeInvisible($v))
        // Collapse duplicate punctuation.
        |> (fn($v) => Normalize::collapsePunctuation($v))
        // Convert accented Latin letters to HTML entities.
        |> (fn($v) => Normalize::accentedToHtmlEntities($v));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Make the page responsive on mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Normalize</title>
    <!-- Link to an external stylesheet -->
    <link rel="stylesheet" href="./assets/css/app.css">
</head>
<body>
    <main class="box">
        <!-- Output the normalized string inside an h3 element. -->
        <!-- Because $strTrash already contains HTML‑entity‑encoded characters, it is safe to echo it directly. -->
        <h3 class="card"><?= $strTrash ?></h3>
    </main>
</body>
</html>