<?php

declare(strict_types=1);

namespace Kenny1911\CloneWith\Test;

use PHPUnit\Framework\TestCase;
use function Kenny1911\CloneWith\clone_with;

class CloneReadonlyPhp81Test extends TestCase
{
    public function test()
    {
        // Skip test for all php versions < 8.1, that not supports readonly properties
        if (version_compare(PHP_VERSION, '8.1', '<')) {
            $this->assertTrue(true);
            return;
        }

        // Create PHP8 code by eval
        $code = <<<'PHP'
$object = new class(123, 456) {
    public readonly int $foo;
    public readonly int $bar;
    
    public function __construct(int $foo, int $bar) {
        $this->foo = $foo;
        $this->bar = $bar;
    }
};
PHP;
        eval($code);

        /** @var object $object */
        $clone = clone_with($object, ['foo' => 789]);

        $this->assertSame(789, $clone->foo);
        $this->assertSame(456, $clone->bar);
    }
}
