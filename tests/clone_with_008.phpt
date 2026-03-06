--TEST--
Clone with readonly
--SKIPIF--
<?php
if (PHP_VERSION_ID < 80400) {
    echo 'skip';
}
?>
--FILE--
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use function Kenny1911\CloneWith\clone_with;

readonly class Clazz {
	public function __construct(
		public public(set) string $a,
		public public(set) string $b,
	) { }

	public function __clone() {
		$this->b = '__clone';
	}
}

$c = new Clazz('default', 'default');

var_dump(clone_with($c, [ 'a' => "with" ]));

try {
	var_dump(clone_with($c, [ 'b' => "with" ]));
} catch (Throwable $e) {
	echo $e::class, ": ", $e->getMessage(), PHP_EOL;
}

?>
--EXPECTF--
object(Clazz)#%d (2) {
  ["a"]=>
  string(4) "with"
  ["b"]=>
  string(7) "__clone"
}
object(Clazz)#%d (2) {
  ["a"]=>
  string(7) "default"
  ["b"]=>
  string(4) "with"
}
