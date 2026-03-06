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
                if (PrototypeFactory::hasReferences($withProperties)) {
                    throw new \Error('Cannot assign by reference when cloning with updated properties');
                }

                $prototype = PrototypeFactory::create(clone $object, $withProperties);

                foreach ($withProperties as $name => $value) {
                    $prototype->{$name} = $value;
                }

                return $prototype;
            };
    }

    $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);

    if (isset($trace[1]['class'])) {
        return $clone->bindTo(null, $trace[1]['class'])($object, $withProperties);
    }

    return $clone($object, $withProperties);
}
