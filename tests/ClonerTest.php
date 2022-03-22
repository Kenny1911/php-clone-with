<?php

declare(strict_types=1);

namespace Kenny1911\CloneWith\Test;

use Kenny1911\CloneWith\Cloner;

class ClonerTest extends CloneTestCase
{
    protected function cloneWith($object, array $properties)
    {
        return (new Cloner($object))->cloneWith($properties);
    }
}
