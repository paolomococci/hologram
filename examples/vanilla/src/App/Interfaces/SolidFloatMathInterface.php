<?php

declare (strict_types = 1); // Enforce strict type checking.

namespace App\Interfaces; // Interface lives in a dedicated namespace

/**
 * Interface definition for floating-point math providers
 *
 * All concrete classes that perform float math must implement this
 * interface, ensuring a consistent API and enabling dependency
 * injection or type-hinting throughout the codebase.
 *
 */
interface SolidFloatMathInterface
{
    /**
     * Add two floating-point numbers.
     *
     * @param  float $a  The first operand.
     * @param  float $b  The second operand.
     *
     * @return float  The sum.
     */
    public function add(float $a, float $b): float;

    /**
     * Subtract one floating-point number from another.
     *
     * @param  float $a  The minuend.
     * @param  float $b  The subtrahend.
     *
     * @return float  The difference.
     */
    public function subtract(float $a, float $b): float;

    /**
     * Multiply two floating-point numbers.
     *
     * @param  float $a  The first factor.
     * @param  float $b  The second factor.
     *
     * @return float  The product.
     */
    public function multiply(float $a, float $b): float;

    /**
     * Divide one floating-point number by another.
     *
     * @param  float $a  The dividend.
     * @param  float $b  The divisor.
     *
     * @return float  The quotient.
     *
     * @throws \DivisionByZeroError if $b is zero.
     */
    public function divide(float $a, float $b): float;
}
