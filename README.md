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
the needed dependencies the `vendor` directory:

```bash
$ git clone git://github.com/Seldaek/monolog.git vendor/monolog
$ git clone git://github.com/fluent/fluent-logger-php.git vendor/fluent-logger-php
```

## Dependencies ##

- PHP >= 5.3.0
- [Monolog](http://github.com/Seldaek/monolog) >= 1.0.0
- [fluent-logger-php](http://github.com/fluent/fluent-logger-php) >= 0.1.0

## Author ##

- [Daniele Alessandri](mailto:suppakilla@gmail.com) ([twitter](http://twitter.com/JoL1hAHN))

## License ##

The code for monolog-fluent is distributed under the terms of the MIT license (see LICENSE).
