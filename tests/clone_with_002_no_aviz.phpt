--TEST--
Clone with respects visiblity (no aviz)
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

class P {
	public $a = 'default';
	protected $b = 'default';
	private $c = 'default';
	private string $d = 'default';

	public function m1() {
		return clone_with($this, [ 'a' => 'updated A', 'b' => 'updated B', 'c' => 'updated C', 'd' => 'updated D' ]);
	}
}

#[AllowDynamicProperties]
class C extends P {
	public function m2() {
		return clone_with($this, [ 'a' => 'updated A', 'b' => 'updated B', 'c' => 'dynamic C' ]);
	}

	public function m3() {
		return clone_with($this, [ 'd' => 'inaccessible' ]);
	}
}

class Unrelated {
	public function m3(P $p) {
		return clone_with($p, [ 'b' => 'inaccessible' ]);
	}
}

$p = new P();

var_dump(clone_with($p, [ 'a' => 'updated A' ]));
var_dump($p->m1());

$c = new C();
var_dump($c->m1());
var_dump($c->m2());
try {
	var_dump($c->m3());
} catch (Error $e) {
	echo get_class($e), ": ", $e->getMessage(), PHP_EOL;
}

try {
	var_dump(clone_with($p, [ 'b' => 'inaccessible' ]));
} catch (Error $e) {
	echo get_class($e), ": ", $e->getMessage(), PHP_EOL;
}

try {
	var_dump(clone_with($p, [ 'd' => 'inaccessible' ]));
} catch (Error $e) {
	echo get_class($e), ": ", $e->getMessage(), PHP_EOL;
}

try {
	var_dump((new Unrelated())->m3($p));
} catch (Error $e) {
	echo get_class($e), ": ", $e->getMessage(), PHP_EOL;
}

?>
--EXPECTF--
object(P)#%d (4) {
  ["a"]=>
  string(9) "updated A"
  ["b":protected]=>
  string(7) "default"
  ["c":"P":private]=>
  string(7) "default"
  ["d":"P":private]=>
  string(7) "default"
}
object(P)#%d (4) {
  ["a"]=>
  string(9) "updated A"
  ["b":protected]=>
  string(9) "updated B"
  ["c":"P":private]=>
  string(9) "updated C"
  ["d":"P":private]=>
  string(9) "updated D"
}
object(C)#%d (4) {
  ["a"]=>
  string(9) "updated A"
  ["b":protected]=>
  string(9) "updated B"
  ["c":"P":private]=>
  string(9) "updated C"
  ["d":"P":private]=>
  string(9) "updated D"
}
object(C)#%d (5) {
  ["a"]=>
  string(9) "updated A"
  ["b":protected]=>
  string(9) "updated B"
  ["c":"P":private]=>
  string(7) "default"
  ["d":"P":private]=>
  string(7) "default"
  ["c"]=>
  string(9) "dynamic C"
}
object(C)#%d (5) {
  ["a"]=>
  string(7) "default"
  ["b":protected]=>
  string(7) "default"
  ["c":"P":private]=>
  string(7) "default"
  ["d":"P":private]=>
  string(7) "default"
  ["d"]=>
  string(12) "inaccessible"
}
Error: Cannot access protected property P::$b
Error: Cannot access private property P::$d
Error: Cannot access protected property P::$b
