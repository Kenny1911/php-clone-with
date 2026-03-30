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

#[AllowDynamicProperties]
final class B extends A {}

var_dump(clone_with(new B(), ['a' => 'b']));

?>
--EXPECTF--
object(B)#%d (2) {
  ["a":"A":private]=>
  string(1) "a"
  ["a"]=>
  string(1) "b"
}
