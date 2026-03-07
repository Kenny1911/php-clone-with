<?php

declare(strict_types=1);

namespace Kenny1911\CloneWith;

/**
 * @internal
 * @psalm-internal Kenny1911\CloneWith
 */
final class ObjectCopier
{
    /**
     * @template T of object
     * @param T $object
     * @param array<string, mixed> $exceptProperties
     * @return T
     */
    public static function copy($object, array $exceptProperties)
    {
        $class = new \ReflectionObject($object);

        if ($class->isInternal()) {
            return $object;
        }

        $protype = $class->newInstanceWithoutConstructor();

        foreach (self::ownPropertiesOf(get_class($object), $class) as $property) {
            if (!array_key_exists($property->name, $exceptProperties)) {
                self::copyProperty($property, $object, $protype);
            }
        }

        while (false !== $class = $class->getParentClass()) {
            foreach (self::ownPropertiesOf($class->name, $class) as $property) {
                if ($property->isPrivate()){
                    self::copyProperty($property, $object, $protype);
                }
            }
        }

        return $protype;
    }

    /**
     * @template T of object
     * @param T $from
     * @param T $to
     */
    private static function copyProperty(\ReflectionProperty $property, $from, $to): void
    {
        if (PHP_VERSION_ID < 80100) {
            $property->setAccessible(true);
        }

        if (PHP_VERSION_ID >= 70400 && !$property->isInitialized($from)) {
            return;
        }

        if (PHP_VERSION_ID >= 80400) {
            if ($property->isVirtual()) {
                return;
            }

            $property->setRawValue($to, $property->getRawValue($from));

            return;
        }

        $property->setValue($to, $property->getValue($from));
    }

    /**
     * @param class-string $class
     * @return \Generator<int, \ReflectionProperty>
     */
    private static function ownPropertiesOf(string $class, \ReflectionClass $reflection): \Generator
    {
        foreach ($reflection->getProperties() as $property) {
            if ($property->isStatic()) {
                continue;
            }

            if ($property->getDeclaringClass()->name !== $class) {
                continue;
            }

            yield $property;
        }
    }

    private function __construct()
    {
    }
}
