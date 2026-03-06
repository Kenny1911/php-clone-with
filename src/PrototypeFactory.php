<?php

declare(strict_types=1);

namespace Kenny1911\CloneWith;

/**
 * @internal
 * @psalm-internal Kenny1911\CloneWith
 */
final class PrototypeFactory
{
    /**
     * @template T of object
     * @param T $object
     * @param array<string, mixed> $exceptProperties
     * @return T
     */
    public static function create($object, array $exceptProperties)
    {
        $reflObject = new \ReflectionObject($object);

        if ($reflObject->isInternal()) {
            return $object;
        }

        $protype = $reflObject->newInstanceWithoutConstructor();

        foreach ($reflObject->getProperties() as $reflProperty) {
            if (array_key_exists($reflProperty->name, $exceptProperties)) {
                continue;
            }

            if ($reflProperty->getDeclaringClass()->name !== get_class($protype)) {
                continue;
            }

            self::copyProperty($reflProperty, $object, $protype);
        }

        $parent = $reflObject;

        while (false !== $parent = $parent->getParentClass()) {
            foreach ($parent->getProperties(\ReflectionProperty::IS_PRIVATE) as $reflProperty) {
                if ($reflProperty->getDeclaringClass()->name !== $parent->name) {
                    continue;
                }

                self::copyProperty($reflProperty, $object, $protype);
            }
        }

        return $protype;
    }

    /**
     * @template T of object
     * @param T $object
     * @param T $protype
     */
    private static function copyProperty(\ReflectionProperty $property, $object, $protype): void
    {
        if ($property->isStatic()) {
            return;
        }

        if (PHP_VERSION_ID < 80100) {
            $property->setAccessible(true);
        }

        if (PHP_VERSION_ID >= 70400 && !$property->isInitialized($object)) {
            return;
        }

        if (PHP_VERSION_ID >= 80400) {
            if ($property->isVirtual()) {
                return;
            }

            $property->setRawValue($protype, $property->getRawValue($object));

            return;
        }

        $property->setValue($protype, $property->getValue($object));
    }

    public static function hasReferences(array $array): bool
    {
        static $canCheck = null;

        if ($canCheck === null) {
            $canCheck = class_exists(\ReflectionReference::class);
        }

        if (!$canCheck) {
            return false;
        }

        foreach ($array as $key => $value) {
            if (\ReflectionReference::fromArrayElement($array, $key) !== null) {
                return true;
            }
        }

        return false;
    }

    private function __construct()
    {
    }
}
