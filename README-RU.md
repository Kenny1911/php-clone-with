# Вспомогательная функция для клонирования объектов

Функция `Kenny1911\CloneWith\clone_with` позволяет устанавливать значения свойств во время процесса клонирования.

> В будущих версиях php, возможно, появится конструкция `clone with`, которая будет решать эту же самую задачу.

## Пример использования

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

## Клонирование readonly свойств в PHP 8.1

В PHP 8.1 появились readonly свойства.

Стандартным способом при клонировании объекта их значения нельзя изменить.

Функция `clone_with` поддерживает переопределение значений для readonly свойств.

## Поддержка классов с методом `__clone()`

Классы могут иметь метод `__clone()`, в котором содержится дополнительная логика для клонирования экземпляра объекта.

Функция `clone_with` учитывает это. Поэтому логика клонирования объектов не будет нарушена.

## Альтернативы

- [spatie/php-cloneable](https://github.com/spatie/php-cloneable) - Тейт `Cloneable`, поддерживающий клонирование
  readonly свойств в PHP 8.1.
