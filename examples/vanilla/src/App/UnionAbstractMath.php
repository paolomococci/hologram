<?php

declare (strict_types = 1); // Enforce strict type checking.

namespace App; // Class lives in the App namespace.

use App\Interfaces\UnionMathInterface; // The concrete classes implement this interface.
use DivisionByZeroError;

/**
 * UnionAbstractMath
 *
 * Abstract base class that provides a single protected utility
 * - `checkZero()` shared by both integer and float-aware
 * subclasses.  This keeps the code DRY by centralize the
 * division-by-zero guard.
 */
abstract class UnionAbstractMath implements UnionMathInterface
{
    // Utility shared by all concrete subclasses
    /**
     * checkZero
     *
     * Throws a DivisionByZeroError if $b is zero (either integer or float).
     *
     * @param  int|float $b Denominator candidate
     * @return void
     */
    protected function checkZero(int | float $b): void
    {
        // Typical tolerance for scientific applications.
        $epsilonScientific = 1e-12;
        // Relative tolerance.
        $epsilonRelative = $epsilonScientific * max(1.0, abs($b));
        if (abs($b) < $epsilonRelative) {
            // Throw a built-in error so the caller can catch it if desired.
            throw new DivisionByZeroError("Division by zero error!");
        }
    }
}
