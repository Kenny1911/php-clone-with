<?php

declare(strict_types=1);

namespace Kenny1911\CloneWith;

use Kenny1911\CloneWith\Exception\CloneException;
use ReflectionClass;
use ReflectionException;

/**
 * @psalm-template T of object
 */
final class Cloner
{
    /**
     * @var object
     *
     * @psalm-var T
     */
    private $object;

    /**
     * @param object $object
     *
     * @psalm-param T $object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }

    /**
     * @param array $properties
     *
     * @return object
     *
     * @psalm-param array<string, mixed> $properties
     *
     * @psalm-return T
     *
     * @psalm-pure
     *
     * @throws CloneException
     */
    public function cloneWith(array $properties)
    {
        try {
            $ref = new ReflectionClass($this->object);

            $clone = $ref->newInstanceWithoutConstructor();

            foreach ($ref->getProperties() as $refProp) {
                $refProp->setAccessible(true);

                $value = $properties[$refProp->getName()] ?? $refProp->getValue($this->object);

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
}
