# Livewire Status Board

Livewire component to show records/data according to their current status

## Preview

![preview](https://github.com/asantibanez/livewire-status-board/raw/master/preview.gif)

## Installation

You can install the package via composer:

```bash
composer require asantibanez/livewire-status-board
```

## Requirements

This package uses `livewire/livewire` (https://laravel-livewire.com/) under the hood.

It also uses TailwindCSS (https://tailwindcss.com/) for base styling. 

Please make sure you include both of this dependencies before using this component. 

## Usage

In order to use this component, you must create a new Livewire component that extends from 
`LivewireStatusBoard`

You can use `make:livewire` to create a new component. For example.
``` bash
php artisan make:livewire SalesOrdersStatusBoard
```

In the `SalesOrdersStatusBoard` class, instead of extending from the base Livewire `Component` class, 
extend from `LivewireStatusBoard`. Also, remove the `render` method. 
You'll have a class similar to this snippet.
 
``` php
class SalesOrdersStatusBoard extends LivewireCalendar
{
    //
}
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email santibanez.andres@gmail.com instead of using the issue tracker.

## Credits

- [Andrés Santibáñez](https://github.com/asantibanez)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
