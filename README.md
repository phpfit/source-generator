# phpfit/source-generator

Generate php source code based on provided configs. This module is not yet completed.

## Installation

```bash
composer require phpfit/source-generator
```

## Usage

```php
<?php

use PhpFit\SourceGenerator\Generator;

$array = [
    'string' => 'string',
    'escape' => 'do\'a',
    'integer' => 12,
    'float' => 12.33
];

$source = Generator::array($array);
```

## TODO

1. Rewrite function
2. Recreate object class
3. Shorten inline array
4. Class writer

## License

The phpfit/source-generator library is licensed under the MIT license.
See [License File](LICENSE.md) for more information.
