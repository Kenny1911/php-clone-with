<?php

declare(strict_types=1);

namespace Kenny1911\CloneWith\Test;

use DateTime;
use PHPUnit\Framework\TestCase;
use function Kenny1911\CloneWith\clone_with;

class FunctionsTest extends TestCase
{
    public function testCloneWith()
    {
        $object = new class {
            public $foo = 123;
            public $bar = 456;
        };

        $clone = clone_with($object, ['bar' => 789]);

        $this->assertSame(get_class($object), get_class($clone));
        $this->assertSame(123, $clone->foo);
        $this->assertSame(789, $clone->bar);
    }

    public function testCloneWithCloneableObject()
    {
        $dateTime = new DateTime();

        $object = new class($dateTime) {
            public $foo = 123;
            public $bar = 456;
            public $dateTime;

            public function __construct(DateTime $dateTime)
            {
                $this->dateTime = $dateTime;
            }

            public function __clone()
            {
                $this->dateTime = clone $this->dateTime;
            }
        };

        $clone = clone_with($object, ['bar' => 789]);
        $this->assertSame(get_class($object), get_class($clone));
        $this->assertSame(123, $clone->foo);
        $this->assertSame(789, $clone->bar);

        // Check, that DateTime is cloned with same value
        $this->assertTrue($dateTime == $clone->dateTime);
        $this->assertTrue($dateTime !== $clone->dateTime);
    }
}
