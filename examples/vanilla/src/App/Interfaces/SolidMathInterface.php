<?php

declare (strict_types = 1); // Enforce strict type checking.

namespace App\Interfaces; // Interface lives in a dedicated namespace

/**
 * SolidMathInterface
 *
 * This interface represents a *generic* mathematical service that can
 * perform operations on both integers and floating-point numbers.
 *
 * It extends the two more specific interfaces:
 *
 *   - SolidIntegerMathInterface, methods that work exclusively with
 *     integer operands.
 *   - SolidFloatMathInterface, methods that work exclusively with
 *     floating-point operands.
 *
 * By inheriting from both, any concrete class that implements
 * SolidMathInterface is guaranteed to provide the complete set of
 * operations defined in the integer and float contracts.  This is
 * useful when you want to type-hint a dependency on the combined
 * capabilities without caring whether the underlying implementation
 * prefers integers, floats, or a mix of both.
 */
interface SolidMathInterface extends SolidIntegerMathInterface, SolidFloatMathInterface
{
    // No additional methods, the full contract is inherited from the parent interfaces.
}
