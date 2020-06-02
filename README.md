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

### Behavior and Interactions

When sorting and dragging is enabled, your component can be notified when any of these events occur. The callbacks
triggered by these two events are `onStatusSorted` and `onStatusChanged`

On `onStatusSorted` you are notified about which `record` has changed position within it's `status`. You are also
given a `$orderedIds` array which holds the ids of the `records` after being sorted. You must override the following
method to get notified on this change.

```php
public function onStatusSorted($recordId, $statusId, $orderedIds)
{
    //   
}
```

On `onStatusChanged` gets triggered when a `record` is moved to another `status`. In this scenario, you get notified
about the `record` that was changed, the new `status`, the ordered ids from the previous status and the ordered ids
of the new status the record in entering. To be notified about this event, you must override the following method:

```php
public function onStatusChanged($recordId, $statusId, $fromOrderedIds, $toOrderedIds)
{
    //
}
``` 

`onStatusSorted` and `onStatusChanged` are never triggered simultaneously. You'll get notified of one or the other
when an interaction occurs. 

### Styling

To modify the look and feel of the component, you can override the `styles` method and modify the base styles returned 
by this method to the view. `styles()` returns a keyed array with Tailwind CSS classes used to render each one of the components.
These base keys and styles are:

```php
return [
    'wrapper' => 'w-full h-full flex space-x-4 overflow-x-auto', // component wrapper
    'statusWrapper' => 'h-full flex-1', // statuses wrapper
    'status' => 'bg-blue-200 rounded px-2 flex flex-col h-full', // status column wrapper 
    'statusHeader' => 'p-2 text-sm text-gray-700', // status header
    'statusFooter' => '', // status footer
    'statusRecords' => 'space-y-2 p-2 flex-1 overflow-y-auto', // status records wrapper 
    'record' => 'shadow bg-white p-2 rounded border', // record
    'ghost' => 'bg-indigo-200', // ghost class used when sorting/dragging. Must be only 1
]; 
```

An example of overriding the `styles()` method can be seen below

```php
public function styles()
{
    $baseStyles = parent::styles();

    $baseStyles['wrapper'] = 'w-full flex space-x-4 overflow-x-auto bg-blue-500 px-4 py-8';

    $baseStyles['statusWrapper'] = 'flex-1';

    $baseStyles['status'] = 'bg-gray-200 rounded px-2 flex flex-col flex-1';

    $baseStyles['record'] = 'shadow bg-white p-2 rounded border text-sm text-gray-800';

    $baseStyles['statusRecords'] = 'space-y-2 px-1 pt-2 pb-2';

    $baseStyles['statusHeader'] = 'text-sm font-medium py-2 text-gray-700';

    $baseStyles['ghost'] = 'bg-gray-400';

    return $baseStyles;
}
```

With these new styles, your component should look like the screenshot below

![basic](https://github.com/asantibanez/livewire-status-board/raw/master/styles.jpg)

Looks like Trello, right? 😅

### Advanced Styling

Base views of the component can be customized as needed by exporting them to your project. To do this, run the
`php artisan vendor:publish` command and export the `livewire-status-board-views` tag. The command will publish
the base views under `/resources/views/vendor/livewire-status-board`. You can modify these base components as
needed keeping in mind to maintain the `data` attributes and `ids` along the way.

Another approach is copying the base view files into your own view files and pass them directly to your component

```blade
<livewire:sales-orders-status-board 
    status-board-view="path/to/your/status-board-view"
    status-view="path/to/your/status-view"
    status-header-view="path/to/your/status-header-view"
    status-footer-view="path/to/your/status-footer-view"
    record-view="path/to/your/record-view"
/>
```

### Adding Extra Views

The component let's you add a view before and/or after the status board has been rendered. These two placeholders can
be used to add extra functionality to your component like a search input or toolbar of actions. To use them, just pass
along the views you want to use in the `before-status-board-view` and `after-status-board-view` props when displaying 
the component.

```blade
<livewire:sales-orders-status-board 
    before-status-board-view="path/to/your/before-status-board-view"
    after-status-board-view="path/to/your/after-status-board-view"  
/>
```

Note: These views are optional.

In the following example, a `before-status-board-view` has been specified to add a search text box and a button

![extra-views](https://github.com/asantibanez/livewire-status-board/raw/master/extra-views.jpg)

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
