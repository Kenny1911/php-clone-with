<?php

declare(strict_types=1);

namespace Kenny1911\CloneWith\Test;

use function Kenny1911\CloneWith\clone_with;

class FunctionsTest extends CloneTestCase
{
    protected function cloneWith($object, array $properties)
    {
        return clone_with($object, $properties);
    }
}
