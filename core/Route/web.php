<?php

use VVF\Route\Route;

Route::get('/', 'MainController@index')->name('main');
Route::get('appTopCategory', 'MainController@appTopCategory');
 
