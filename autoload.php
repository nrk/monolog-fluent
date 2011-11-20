<?php

require_once __DIR__.'/vendor/fluent-logger-php/src/Fluent/Autoloader.php';

Fluent\Autoloader::register();

$pathFinder = function($class) {
    if (0 === stripos($class, 'Monolog')) {
        return '/vendor/monolog/src/';
    }
    if (0 === stripos($class, 'Nrk\Fluent\Monolog')) {
        return '/src/';
    }

    return false;
};

spl_autoload_register(function($class) use($pathFinder) {
    if (false === $base = $pathFinder($class)) {
        return;
    }

    $file = __DIR__. $base . strtr($class, '\\', '/') . '.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
});
