<?php

use Core\Route\Route;

Route::get('users', 'UserController@user')->name('users')->middleware('user:auth');

Route::get('/', 'MainController@index')->name('main');
Route::get('test', 'TestController@testMethod')->name('test-page'); 
Route::get('login', 'UserController@login')->name('login');
Route::post('login', 'UserController@loginPost')->name('login');
Route::get('user/{id}', 'UserController@index');
Route::get('about-site/technologies', 'AboutSite\\TechnologiesController@index')->name('technologies');
Route::get('about-site/install', 'AboutSite\\InstallController@index')->name('install');
Route::get('about-site/documentation', 'AboutSite\\DocumentationController@index')->name('documentation');
Route::get('user/{id}/change', 'UserController@index');
Route::get('admin', 'Admin\\MainController@index')->name('admin');

