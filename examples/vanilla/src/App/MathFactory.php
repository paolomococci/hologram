<?php

declare (strict_types = 1); // Enforce strict typing.

namespace App; // The factory lives in the App namespace.

use App\FloatSampleMath;                    // Concrete class implementing float math.
use App\IntegerSampleMath;                  // Concrete class implementing integer math.
use App\Interfaces\FloatMathInterface;      // Interface that FloatSampleMath must satisfy.
use App\Interfaces\IntegerMathInterface;    // Interface that IntegerSampleMath must satisfy.

/**
 * MathFactory
 *
 * A simple service‑factory that returns concrete math implementations.
 * Each method is static and returns an object that implements the corresponding interface.
 */
class MathFactory
{
    /**
     * integer
     *
     * @return IntegerMathInterface
     *
     * Returns a new instance of IntegerSampleMath.
     * The static method can be called from anywhere, so the factory is simply a thin wrapper.
     */
    public static function integer(): IntegerMathInterface
    {
        return new IntegerSampleMath(); // static, but it returns an instance
    }

    /**
     * float
     *
     * @return FloatMathInterface
     *
     * Returns a new instance of FloatSampleMath, analogous to the integer version.
     */
    public static function float(): FloatMathInterface
    {
        return new FloatSampleMath();
    }
}
