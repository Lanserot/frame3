<?php


if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    exit('Необходимо выполнить "composer install"');
}

require_once __DIR__ . '/vendor/autoload.php';

use Core\Controllers\MainController;
use Core\Controllers\Default\Controller;
use Core\Route\RouteSetter;

use Core\Route\Route;

Route::get(
    '/', 'MainController@index'
);
Route::get(
    'test', 'TestController@testMethod'
);
Route::get(
    'user/{id}', 'UserController@index'
);
Route::get(
    'user/{id}/change', 'UserController@index'
);
Route::get(
    'admin', 'Admin\\MainController@index'
);

exit(); 
