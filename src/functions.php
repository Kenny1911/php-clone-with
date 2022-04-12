<?php

declare(strict_types=1);

namespace Kenny1911\CloneWith;

use Kenny1911\CloneWith\Exception\CloneException;

/**
 * @param object $object
 * @param array<string, mixed> $properties
 *
 * @return object
 *
 * @psalm-template T
 * @psalm-param T $object
 *
 * @psalm-return T
 *
 * @psalm-pure
 *
 * @throws CloneException
 */
function clone_with($object, array $properties)
{
    return (new Cloner($object))->cloneWith($properties);
}
