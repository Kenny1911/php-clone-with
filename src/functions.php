<?php

declare(strict_types=1);

namespace Kenny1911\CloneWith;

/**
 * @api
 *
 * @template T of object
 * @param T $object
 * @return T
 */
function clone_with($object, array $withProperties = [])
{
    static $clone = null;

    if ($clone === null) {
        $clone = function_exists('clone')
            ? static function ($object, array $withProperties) {
                return ('clone')($object, $withProperties);
            }
            : static function ($object, array $withProperties) {
                if (References::arrayHasReferences($withProperties)) {
                    throw new \Error('Cannot assign by reference when cloning with updated properties');
                }

                $copy = ObjectCopier::copy(clone $object, $withProperties);

                foreach ($withProperties as $name => $value) {
                    $copy->{$name} = $value;
                }

                return $copy;
            };
    }

    $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);

    if (isset($trace[1]['class'])) {
        return $clone->bindTo(null, $trace[1]['class'])($object, $withProperties);
    }

    return $clone($object, $withProperties);
}
