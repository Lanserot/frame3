<?php


if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    exit('Необходимо выполнить "composer install"');
}

require_once __DIR__ . '/vendor/autoload.php';

use Core\Route\Route;

Route::get(
    '/', 'MainController@index'
)->name('main');
Route::get(
    'test', 'TestController@testMethod'
)->name('test-page');
Route::get(
    'user/{id}', 'UserController@index'
);
Route::get(
    'user/{id}/change', 'UserController@index'
);
Route::get(
    'admin', 'Admin\\MainController@index'
)->name('admin');

Route::run();
