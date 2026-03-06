--TEST--
Clone with basic
--FILE--
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use function Kenny1911\CloneWith\clone_with;

abstract class A
{
    private $a = 'a';
}

final class B extends A {}

var_dump(clone_with(new B()));

?>
--EXPECTF--
object(B)#%d (1) {
  ["a":"A":private]=>
  string(1) "a"
}
