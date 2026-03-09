<?php

declare (strict_types = 1); // Enforce strict type checking.

namespace Test; // Namespace used for tests

use App\UnionFloatMath;   // Import the float-aware math class.
use App\UnionIntegerMath; // Import the integer-aware math class.

/**
 * This simple test script demonstrates that the two concrete
 * implementations of `UnionMathInterface` behave as expected.
 * It uses Pest’s `expect(...)->toBe(...)` syntax to assert that
 * the results match the mathematical truth.
 */

$intMath = new UnionIntegerMath();    // Instantiate the integer-only implementation.
expect($intMath->add(2, 3))->toBe(5); // 2 + 3 should equal 5 (int).

$floatMath = new UnionFloatMath();            // Instantiate the float-aware implementation.
expect($floatMath->add(1.2, 3.4))->toBe(4.6); // 1.2 + 3.4 should equal 4.6 (float).
