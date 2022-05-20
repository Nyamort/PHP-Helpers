# PHP-Helpers
## Overview
ArrayHelpers is a collection of helper functions.
## Usage
### ArrayHelpers
#### first
Returns the first element of an array.
```php
$array = [1, 2, 3];
ArrayHelpers::first($array) // ['1']
```

### get
Get a value from the array using "dot" notation, asterisks and regex.
```php
$array = [
    'tar' => [
        'bar' => [
            'qux' => 'foo1',
        ],
        'baz' => [
            'foo' => 'bar',
            'qux' => 'foo3',
            'baz' => 'foo4',
        ],
    ],
];
ArrayHelpers::get($array, 'tar.*.qux') // ['foo1','foo3']
```
