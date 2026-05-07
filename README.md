# Clone With

English | [Русский](./README-RU.md)

**PHP 8.5** introduces the ability to override object properties during cloning by passing an associative array to the
`clone` operator (function):

```php
$copy = clone($object, ['property' => 'new value']);
```

This provides straightforward support for the "wither" pattern, especially for immutable and read-only classes.

The `Kenny1911\CloneWith\clone_with` function does the same thing, but starting from **PHP 7.1**:

```php
use function Kenny1911\CloneWith\clone_with;

$copy = clone_with($object, ['property' => 'new value']);
```

It works with **public**, **protected**, and **private** properties, correctly invokes the `__clone()` method in the
target class (if defined), and requires no additional boilerplate code. This allows you to write immutable code today
— maintaining compatibility with modern PHP versions and making future migration to native syntax easy.

## Installation

```bash
composer require kenny1911/php-clone-with
```

## PHP 8.5 Compatibility

Starting from version `2.0.0`, the function is fully compatible with the native PHP 8.5 `clone` function.
