<?php

use Core\Controllers\UserController;
use VVF\Route\Route;

Route::get('/', 'MainController@index')->name('main');
Route::resourses(['users' => UserController::class]);
Route::get('login', 'UserController@login')->name('login');
Route::post('login', 'UserController@loginPost')->name('login');
Route::get('about-site/technologies', 'AboutSite\\TechnologiesController@index')->name('technologies');
Route::get('about-site/install', 'AboutSite\\InstallController@index')->name('install');
Route::get('about-site/documentation', 'AboutSite\\DocumentationController@index')->name('documentation');
Route::get('admin', 'Admin\\MainController@index')->name('admin')->middleware('user:auth');

