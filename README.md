monolog-fluent
==============

A simple [Monolog](http://github.com/Seldaek/monolog) handler for [Fluent](http://fluentd.org).

[Read more](http://blog.treasure-data.com/post/13047440992/fluentd-the-missing-log-collector) about Fluent.

## Usage ##

```php
<?php
use Nrk\Fluent\Monolog\FluentHandler;

$log = new Monolog\Logger('debug.monolog');

$log->pushHandler(new FluentHandler('http://127.0.0.1'));
$log->pushHandler(new FluentHandler('tcp://127.0.0.1'));

$log->addError("OH NOES!!11!1!");
```

In order to be able to run the examples in the `examples` directory, you must first download
the needed dependencies the `vendor` directory using [Composer](http://packagist.org/about-composer)
by typing `composer install` in a shell. If Composer is not installed or globally available on
your system then you can download its phar package and use it to install the dependencies:

```bash
  $ wget http://getcomposer.org/composer.phar
  $ php composer.phar install
```

## Dependencies ##

- PHP >= 5.3.0
- [Monolog](http://github.com/Seldaek/monolog) >= 1.0.0
- [fluent-logger-php](http://github.com/fluent/fluent-logger-php) >= 0.1.0

## Author ##

- [Daniele Alessandri](mailto:suppakilla@gmail.com) ([twitter](http://twitter.com/JoL1hAHN))

## License ##

The code for monolog-fluent is distributed under the terms of the MIT license (see LICENSE).
