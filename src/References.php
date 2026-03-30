<?php

declare(strict_types=1);

namespace Kenny1911\CloneWith;

/**
 * @internal
 * @psalm-internal Kenny1911\CloneWith
 */
final class References
{
    public static function arrayHasReferences(array $array): bool
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
