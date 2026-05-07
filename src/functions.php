<?php

declare(strict_types=1);

namespace Kenny1911\CloneWith;

/**
 * @api
 *
 * @template T of object
 * @param T $object
 * @param array<string, mixed> $withProperties
 * @return T
 */
function clone_with($object, array $withProperties = [])
{
    static $clone = null;

    if ($clone === null) {
        /**
         * @var \Closure(T, array): T $clone Guaranteed type is defined, not null at this line
         *
         * @psalm-suppress MissingClosureReturnType,MissingClosureParamType Guaranteed type of $clone
         */
        $clone = function_exists('clone')
            ? static function ($object, array $withProperties) {
                return ('clone')($object, $withProperties);
            }
            : static function ($object, array $withProperties) {
                if (References::arrayHasReferences($withProperties)) {
                    throw new \Error('Cannot assign by reference when cloning with updated properties');
                }

                /** @psalm-suppress MixedClone Guaranteed, that type of $object is object */
                $copy = ObjectCopier::copy(clone $object, $withProperties);

                foreach ($withProperties as $name => $value) {
                    $copy->{$name} = $value;
                }

                return $copy;
            };
    }

    $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);

    if (isset($trace[1]['class'])) {
        /** @psalm-suppress PossiblyNullFunctionCall Type of $clone is not null */
        return $clone->bindTo(null, $trace[1]['class'])($object, $withProperties);
    }

    return $clone($object, $withProperties);
}
