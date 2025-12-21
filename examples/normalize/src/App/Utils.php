<?php
namespace App;

use InvalidArgumentException;
use RuntimeException;
use Throwable;

/**
 * App\Utils
 * 
 * Utility class providing a flexible string‑processing pipeline.
 *
 * The pipeline() method accepts a string $value, an array of callables
 * that each receive the current string and return a new string.
 * It also accepts an optional $options array that controls validation,
 *
 */
class Utils
{
    /**
     *
     * Applies a sequence of callables to a string with configurable validation and error handling.
     *
     * Options:
     *   - 'strict' (bool) default true: Throws an exception if a callable does not return a string.
     *   - 'cast'   (bool) default false: Automatically casts to string when the return is not a string.
     *   - 'onError' (callable|null) default null: Fallback in case of exception 
     *
     * @param string     $value         The initial string to process.
     * @param array      $callables     Array of callables to apply sequentially.
     * @param array|null $options       Optional configuration array.
     * @return string                   The resulting string after all callables.
     * @throws InvalidArgumentException If an element in $callables is not callable.
     * @throws RuntimeException         If a callable fails or violates the strict rules.
     */
    public static function pipeline(string $value, array $callables, ?array $options = null): string
    {
        // Merge user options with the defaults.
        // array_replace() gives precedence to $options values.
        $opts = array_replace([
            'strict'  => true,
            'cast'    => false,
            'onError' => null,
        ], $options ?? []);

        // Iterate over each callable in the pipeline.
        foreach ($callables as $index => $c) {
            // Verify that the current element is indeed callable.
            if (! is_callable($c)) {
                throw new InvalidArgumentException(sprintf(
                    'Element %d of the pipeline is not callable (type: %s).',
                    $index,
                    gettype($c)
                ));
            }

            // Execute the callable within a try/catch to handle runtime errors.
            try {
                $result = $c($value);
            } catch (Throwable $e) {
                // If an onError handler is defined, use it to recover.
                if (is_callable($opts['onError'])) {
                    $fallback = $opts['onError'];
                    // The handler receives the exception, the current value, the original callable and its index.
                    $value    = $fallback($e, $value, $c, $index);
                    // Ensure the handler returns a string.
                    if (! is_string($value)) {
                        if ($opts['cast']) {
                            // Cast the fallback result to string and continue.
                            $value = (string) $value;
                            continue;
                        }
                        if ($opts['strict']) {
                            // In strict mode the fallback must return a string.
                            throw new RuntimeException('onError did not return a recovery string.');
                        }
                        // Non‑strict mode: force cast.
                        $value = (string) $value;
                    }
                    // Skip to the next callable.
                    continue;
                }

                throw new RuntimeException(
                    sprintf('Error executing callable at position %d: %s', $index, $e->getMessage()),
                    0,
                    $e
                );
            }

            // After successful execution, validate the returned value.
            if (! is_string($result)) {
                if ($opts['cast']) {
                    // Automatic casting in non‑strict mode.
                    $value = (string) $result;
                    continue;
                }
                if ($opts['strict']) {
                    // In strict mode a non‑string return is an error.
                    throw new RuntimeException(sprintf(
                        'Callable at position %d returned type %s instead of string.',
                        $index,
                        gettype($result)
                    ));
                }
                // Non‑strict mode - force cast and continue.
                $value = (string) $result;
                continue;
            }

            // If everything is fine, use the returned string for the next step.
            $value = $result;
        }

        // All callables processed - return the final string.
        return $value;
    }
}
