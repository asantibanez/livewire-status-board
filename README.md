# Livewire Status Board

Livewire component to show records/data according to their current status

### Preview

![preview](https://github.com/asantibanez/livewire-status-board/raw/master/preview.gif)

### Installation

You can install the package via composer:

```bash
composer require asantibanez/livewire-status-board
```

### Requirements

This package uses `livewire/livewire` (https://laravel-livewire.com/) under the hood.

It also uses TailwindCSS (https://tailwindcss.com/) for base styling. 

Please make sure you include both of this dependencies before using this component. 

### Usage

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

In this class, you must override the following methods to display data
```php
public function statuses() : Collection 
{
    //
}

public function records() : Collection 
{
    //
}
```

As you may have noticed, both methods return a collection. `statuses()` refers to all the different status values
your data may have in different points of time. `records()` on the other hand, stand for the data you want to show
that could be in any of those previously defined `statuses()` collection.

To show how these two methods work together, let's discuss an example of Sales Orders and their different status
along the sales process: Registered, Awaiting Confirmation, Confirmed, Delivered. Each Sales Order might be in a different
status at specific times. For this example, we might define the following collection for `statuses()`

```php
public function statuses() : Collection
{
    return collect([
        [
            'id' => 'registered',
            'title' => 'Registered',
        ],
        [
            'id' => 'awaiting_confirmation',
            'title' => 'Awaiting Confirmation',
        ],
        [
            'id' => 'confirmed',
            'title' => 'Confirmed',
        ],
        [
            'id' => 'delivered',
            'title' => 'Delivered',
        ],
    ]);
}
```

For each `status` we define, we must return an array with at least 2 keys: `id` and `title`.

Now, for `records()` we may define a list of Sales Orders that come from an Eloquent model in our project

```php
public function records() : Collection
{
    return SalesOrder::query()
        ->map(function (SalesOrder $salesOrder) {
            return [
                'id' => $salesOrder->id,
                'title' => $salesOrder->client,
                'status' => $salesOrder->status,
            ];
        });
}
```

As you might see in the above snippet, we must return a collection of array items where each item must have at least
3 keys: `id`, `title` and `status`. The last one is of most importance since it is going to be used to match to which
`status` the `record` belongs to. For this matter, the component matches `status` and `records` with the following 
comparison

```php
$status['id'] === $record['status'];
``` 

To render the component in a view, just use the Livewire tag or include syntax

```blade
<livewire:sales-orders-status-board />
```  

Populate the Sales Order model and you should have something similar to the following screenshot

![basic](https://github.com/asantibanez/livewire-status-board/raw/master/basic.jpg)

You can render any render and statuses of your project using this approach 👍

### Sorting and Dragging

By default, sorting and dragging between statuses is disabled. To enable it, you must include the following
props when using the view: `sortable` and `sortable-between-statuses` 

```blade
<livewire:sales-orders-status-board 
    :sortable="true"
    :sortable-between-statuses="true"
/>
```

`sortable` enables sorting withing each status and `sortable-between-statuses` allow drag and drop from one status 
to the other. Adding these two properties, allow you to have drag and drop in place.

You must also install the following JS dependencies in your project to enable sorting and dragging.
```bash
npm install jquery
npm install sortablejs
```

Once installed, make them available globally in the window object. This can be done in the `bootstrap.js` file that 
ships with your Laravel app.

```javascript
window.$ = require('jquery');
window.Sortable = require('sortablejs').default;
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
