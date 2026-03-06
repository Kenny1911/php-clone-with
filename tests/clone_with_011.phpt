--TEST--
Clone with name mangling
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

class Foo {
	private string $bar = 'default';
}

try {
	var_dump(clone_with(new Foo(), ["\0Foo\0bar" => 'updated']));
} catch (Throwable $e) {
	echo get_class($e), ": ", $e->getMessage(), PHP_EOL;
}

?>
--EXPECTREGEX--
Error: Cannot access property start(ing|ed) with ('|")\\0('|")
