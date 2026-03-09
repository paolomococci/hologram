<?php

declare (strict_types = 1); // Enforce strict type checking.

namespace Test; // Namespace used for tests

use App\FloatSampleMath;    // Concrete float-math implementation.
use App\IntegerSampleMath;  // Concrete integer-math implementation.

/**
 * Dataset that lists the two math provider classes we want to test.
 *
 * Each element of the array contains:
 *   0 => Fully-qualified class name of the math provider
 *   1 => A string that tells us whether the provider deals with integers or floats
 */
dataset('mathProviders', [
    [IntegerSampleMath::class, 'int'],
    [FloatSampleMath::class, 'float'],
]);

/**
 * Generic math operations test.
 *
 * This test runs once for each row in the 'mathProviders' dataset.
 *
 * Parameters:
 *   $class - the class name to instantiate (e.g. IntegerSampleMath or FloatSampleMath)
 *   $type  - a string that tells us which type of numbers this provider handles
 */
it('generic math operations', function ($class, string $type) {
    // Dynamically create an instance of the provider class.
    $calculator = new $class();

    // Example parameters:
    //   - For integer providers use integer values.
    //   - For float providers use floating-point values.
    $a = ($type === 'int') ? 5 : 5.5;
    $b = ($type === 'int') ? 3 : 2.2;

    // Call the static add() method on the provider’s class and
    // assert that the result matches the expected arithmetic result.
    expect($calculator::add($a, $b))->toBe($a + $b);
})->with('mathProviders');
