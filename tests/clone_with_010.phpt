--TEST--
Clone with native classes
--SKIPIF--
<?php
if (PHP_VERSION_ID < 80200) {
    echo 'skip';
}
?>
--FILE--
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use function Kenny1911\CloneWith\clone_with;

try {
	var_dump(clone_with(new \Random\Engine\Secure(), [ 'with' => "something" ]));
} catch (Throwable $e) {
	echo get_class($e), ": ", $e->getMessage(), PHP_EOL;
}

try {
	var_dump(clone_with(new \Random\Engine\Xoshiro256StarStar(), [ 'with' => "something" ]));
} catch (Throwable $e) {
	echo get_class($e), ": ", $e->getMessage(), PHP_EOL;
}

?>
--EXPECTF--
Error: Trying to clone an uncloneable object of class Random\Engine\Secure
Error: Cannot create dynamic property Random\Engine\Xoshiro256StarStar::$with
