# Helper function for cloning objects

Function `Kenny1911\CloneWith\clone_with` can set values of properties  during the cloning process.

> In future versions of php, there may be a `clone with` construct that will solve the same problem.

## Usage

```php
use function Kenny1911\CloneWith\clone_with;

class Post
{
    /** @var string */
    private $title;
    
    /** @var string */
    private $author;
    
    public function __construct(string $title, string $author)
    {
        $this->title = $title;
        $this->author = $author;
    }
    
    public function getTitle(): string
    {
        return $this->title;
    }
    
    public function getAuthor(): string
    {
        return $this->author;
    }
}

$post = new Post('Foo', 'Author');

$post2 = clone_with($post, ['title' => 'Bar']);

echo $post2->getTitle(); // Bar
```

## Cloning PHP 8.1 readonly properties


Readonly properties appeared in PHP 8.1.

It values cannot be changed, if use standard way to cloning objects (using `clone` operator).

Function `clone_with` supports override values of readonly object properties.

## Support classes with `__clone()` method

Classes can has `__clone()` method, that contains additional logic of cloning object instance.

Function `clone_with` supports it and clone logic will not be violated.

## Alternatives

- [spatie/php-cloneable](https://github.com/spatie/php-cloneable) - A `Cloneable` trait that allows you to clone
  readonly properties in PHP 8.1.
