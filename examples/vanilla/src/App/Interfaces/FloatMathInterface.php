<?php

declare (strict_types = 1); // Strict type mode enabled.

namespace App\Interfaces; // Interface lives in the App\Interfaces namespace.

/**
 * FloatMathInterface
 *
 * Declares a set of static methods that perform basic arithmetic on floats.
 * All methods receive float arguments and return a float result.
 */
interface FloatMathInterface
{
    /**
     * add
     *
     * @param  float $a
     * @param  float $b
     * @return float
     */
    public static function add(float $a, float $b): float;

    /**
     * subtract
     *
     * @param  float $a
     * @param  float $b
     * @return float
     */
    public static function subtract(float $a, float $b): float;

    /**
     * multiply
     *
     * @param  float $a
     * @param  float $b
     * @return float
     */
    public static function multiply(float $a, float $b): float;

    /**
     * divide
     *
     * @param  float $a
     * @param  float $b
     * @return float
     */
    public static function divide(float $a, float $b): float;
}
