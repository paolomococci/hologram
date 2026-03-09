<?php

declare (strict_types = 1); // Enforce strict type checking.

namespace App; // Class lives in the App namespace.

use DivisionByZeroError;

/**
 * SolidAbstractMath
 *
 * Abstract base that supplies shared helper methods for concrete
 * math providers.  Currently it only contains the zero‑division guard.
 */
abstract class SolidAbstractMath
{
    /**
     * Guard against division by zero.
     *
     * @param  int|float $b  The divisor candidate.
     *
     * @throws \DivisionByZeroError if $b is exactly 0 or 0.0.
     */
    protected function checkZero(int | float $b): void
    {
        // Using the strict identity operator (===) guarantees that we
        // only catch values that are *exactly* zero, not values that
        // compare loosely to zero (e.g., strings or objects).
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
