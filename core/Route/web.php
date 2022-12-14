<?php

use Core\Route\Route;

Route::get(
    '/', 'MainController@index'
)->name('main');

Route::get(
    'test', 'TestController@testMethod'
)->name('test-page'); 

Route::get(
    'users', 'UserController@user'
)->name('users');

Route::get(
    'user/{id}', 'UserController@index'
);
Route::get(
    'user/{id}/change', 'UserController@index'
);
Route::get(
    'admin', 'Admin\\MainController@index'
)->name('admin');

