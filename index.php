<?php


if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    exit('Необходимо выполнить "composer install"');
}

require_once __DIR__ . '/vendor/autoload.php';

use Core\Route\Route;

require __DIR__ . '/core/Route/web.php';

Route::run();
