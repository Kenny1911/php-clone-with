--TEST--
Clone with supports __clone
--SKIPIF--
<?php
if (PHP_VERSION_ID < 70400) {
    echo 'skip';
}
?>
--FILE--
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use function Kenny1911\CloneWith\clone_with;

class Clazz {
    public $foo;
    public $bar;

    public function __construct(
        string $foo,
        string $bar
	) {
        $this->bar = $bar;
        $this->foo = $foo;
    }

    public function __clone() {
        $this->foo = 'foo updated in __clone';
        $this->bar = 'bar updated in __clone';
    }
}

$c = new Clazz('foo', 'bar');

var_dump(clone_with($c, [ 'foo' => 'foo updated in clone-with' ]));

?>
--EXPECTF--
object(Clazz)#%d (2) {
  ["foo"]=>
  string(25) "foo updated in clone-with"
  ["bar"]=>
  string(22) "bar updated in __clone"
}
