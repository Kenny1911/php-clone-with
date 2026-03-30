--TEST--
Clone with error cases
--FILE--
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use function Kenny1911\CloneWith\clone_with;

$x = new stdClass();

try {
	var_dump(clone_with($x, 1));
} catch (Throwable $e) {
	echo get_class($e), ": ", $e->getMessage(), PHP_EOL;
}

?>
--EXPECTF--
TypeError: %s
