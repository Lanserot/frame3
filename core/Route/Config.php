<?php
/** 
 * 
 * {id} - id marker string|int
 * 
*/
return [
    'routes' => [
        '/' => 'MainController',
        'test' => 'TestController',
        'user/{id}' => 'UserController',
        'admin' => 'Admin\\MainController'
    ]
];
