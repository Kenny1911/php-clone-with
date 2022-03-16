<?php

declare(strict_types=1);

namespace Kenny1911\CloneWith;

use Kenny1911\CloneWith\Exception\CloneException;
use ReflectionClass;
use ReflectionException;

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
 * @throws CloneException
 */
function clone_with($object, array $properties)
{
    try {
        $ref = new ReflectionClass($object);

        $clone = $ref->newInstanceWithoutConstructor();

        foreach ($ref->getProperties() as $refProp) {
            $refProp->setAccessible(true);

            $value = $properties[$refProp->getName()] ?? $refProp->getValue($object);

            $refProp->setValue($clone, $value);
        }

        if (method_exists($clone, '__clone')) {
            $clone = clone $clone;
        }

        return $clone;
    } catch (ReflectionException $e) {
        throw new CloneException($e->getMessage(), $e->getCode(), $e);
    }
}
