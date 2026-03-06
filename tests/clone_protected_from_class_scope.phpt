--TEST--
Clone with respects asymmetric visiblity
--FILE--
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use function Kenny1911\CloneWith\clone_with;

abstract class A
{
    protected $a = 'a';
}

final class B extends A
{
    public function clone()
    {
        return clone_with($this, ['a' => 'b']);
    }
}

var_dump((new B)->clone());

?>
--EXPECTF--
object(B)#%d (1) {
  ["a":protected]=>
  string(1) "b"
}
