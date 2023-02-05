<?php

use PHPUnit\Framework\TestCase;
use VVF\Route\Route;

class RouteTest extends TestCase
{
    public function testRoutePath()
    {   
        $_SERVER['REQUEST_URI'] = 'about-site/documentation';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        Route::$isUnitTest = true;
        Route::setFound(false);
        Route::get('about-site/documentation', 'AboutSite\\DocumentationController@index'); 
        $response = Route::run();
        $this->assertEquals('Core\Controllers\AboutSite\DocumentationController::index', $response['pathMethod']);
    }

    public function testRouteAttr()
    {   
        $_SERVER['REQUEST_URI'] = 'user/10';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        Route::$isUnitTest = true;
        Route::setFound(false);
        Route::get('user/{id}', 'UserController@index'); 
        $response = Route::run();
        $this->assertEquals($response['attr']['id'], 10);
    }
}
