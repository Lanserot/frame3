<?php

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    exit('Необходимо выполнить "composer install"');
}

require_once __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/VVF/ErrorHandler/ErrorSetter.php';

use VVF\Route\Route;

require __DIR__ . '/core/Route/web.php';

Route::run();
