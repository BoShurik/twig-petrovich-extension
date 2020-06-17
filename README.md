# Petrovich Twig Extension

![Petrovich](https://raw.github.com/rocsci/petrovich/master/petrovich.png)

## Installation

```bash
composer req boshurik/twig-petrovich-extension
```

```php
$petrovich = new \Staticall\Petrovich\Petrovich(new \Staticall\Petrovich\Petrovich\Ruleset('/path/to/rules.json'));
$extension = new \BoShurik\Petrovich\Twig\Extension\PetrovichExtension($petrovich);
$twig = new \Twig\Environment($loader);
$twig->addExtension($extension);
```

You can use callable to lazy loading `Petrovich` instance
```php
$factory = function () {
    return new \Staticall\Petrovich\Petrovich(new \Staticall\Petrovich\Petrovich\Ruleset('/path/to/rules.json'));
};
$extension = new \BoShurik\Petrovich\Twig\Extension\PetrovichExtension($factory);
```

## Usage

```twig
{{ 'Тестов Тест Тестович' | inflect_full_name('genitive', 'male') }}
{{ 'Тестов Тест Тестович' | inflect_full_name('dative') }}
{{ 'Тестов Тест Тестович' | inflect_full_name_accusative }}
{{ 'Тестов Тест Тестович' | inflect_full_name_instrumental_male }}

{{ inflect_full_name('Тестов Тест Тестович', 'genitive', 'male') }}
{{ inflect_full_name('Тестов Тест Тестович', 'dative') }}
{{ inflect_full_name_accusative('Тестов Тест Тестович') }}
{{ inflect_full_name_instrumental_male('Тестов Тест Тестович') }}
```