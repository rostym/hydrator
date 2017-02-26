# Hydrator library
This is a simple library which provide you possibility to hydrate an object with private, protected properties without using reflection.

## Requirements
- PHP 7 and higher

## Installation

Install the latest version with

```bash
$ composer require krifollk/hydrator
```

## Usage Example

```php
<?php

class User 
{
    private $name;
    protected $surname;
}

$hydrator = new Krifollk\Hydrator();
$user = new User();

$hydrator->hydrate($user, ['name' => 'John', 'surname' => 'Doe']);

print_r($user);

```
Output:

```
User Object
(
    [name:User:private] => John
    [surname:protected] => Doe
)

```
