--TEST--
Clone with references
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

$x = new stdClass();

$ref = 'reference';
$with = ['x' => &$ref];

try {
	var_dump(clone_with($x, $with));
} catch (Throwable $e) {
	echo get_class($e), ": ", $e->getMessage(), PHP_EOL;
}

unset($ref);

try {
	var_dump(clone_with($x, $with));
} catch (Throwable $e) {
	echo get_class($e), ": ", $e->getMessage(), PHP_EOL;
}

?>
--EXPECTF--
Error: Cannot assign by reference when cloning with updated properties
object(stdClass)#%d (1) {
  ["x"]=>
  string(9) "reference"
}
