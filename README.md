# Irontec Data Validation bundle for Symfony

## Installation

### Requirements / Tested on

- PHP 8.0
- Symfony 5.4

### Add the Github VCS repository to project composer

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/irontec/data-validator-bundle"
    }
  ]
}
```

### Add the dependency pointing to master branch

 ```json
{
  "require": {
    "irontec/data-validator": "dev-master"
  }
}
```

### Install the dependency
```shell
composer install
```

## Usage

Add the required validations to entity properties using attributes

```php
use Irontec\DataValidator\Validators\Dni\Dni;

class Person {

    #[Dni(['nullable' => true])]
    private ?string $dni;
}
```