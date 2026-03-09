<?php

declare (strict_types = 1); // Enforce strict type checking.

namespace App; // Class lives in the App namespace.

use App\Interfaces\SolidFloatMathInterface;
use App\Interfaces\SolidIntegerMathInterface;
use InvalidArgumentException;

/**
 * SolidMathFactory
 */
class SolidMathFactory
{
    private static array $instances = [];

    /**
     * create
     *
     * @param  mixed $type
     * @return SolidIntegerMathInterface
     */
    public static function create(string $type): SolidIntegerMathInterface | SolidFloatMathInterface
    {
        return match ($type) {
            'int'   => self::getIntegerMath(),
            'float' => self::getFloatMath(),
            default => throw new InvalidArgumentException(
                "Unknown math type: $type. Use 'int' or 'float'."
            )
        };
    }

    /**
     * getIntegerMath
     *
     * @return SolidIntegerMathInterface
     */
    private static function getIntegerMath(): SolidIntegerMathInterface
    {
        if (! isset(self::$instances['int'])) {
            self::$instances['int'] = new SolidIntegerMath();
        }
        return self::$instances['int'];
    }

    /**
     * getFloatMath
     *
     * @return SolidFloatMathInterface
     */
    private static function getFloatMath(): SolidFloatMathInterface
    {
        if (! isset(self::$instances['float'])) {
            self::$instances['float'] = new SolidFloatMath();
        }
        return self::$instances['float'];
    }
}
