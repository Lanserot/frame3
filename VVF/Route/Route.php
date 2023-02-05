<?php

namespace VVF\Route;

use VVF\Controllers\ControllerInterface;
use VVF\Interfaces\RouteInterface;
use VVF\ErrorHandler\ErrorHandler;

class Route extends RouteMethods implements RouteInterface
{
    static public function route(string $route)
    {
        if (empty(self::$routeNameList[$route])) {
            throw new ErrorHandler('"'. $route . '" not found route in route list');
        }
        return self::$routeNameList[$route];
    }

    static public function name(string $name): self
    {
        self::$routeNameList[$name] = (self::$url != '/' ? '/' : '') . self::$url;
        return self::getInstance();
    }

    static public function resourses(array $resourses): self
    {
        foreach ($resourses as $url => $class) {
            $exp = explode('\\', $class);
            $class = end($exp);
            self::get($url, $class . '@index')->name('users.index');
            self::post($url, $class . '@post')->name('users.store');
            self::get($url . '/create', $class . '@create')->name('users.create');
            self::get($url . '/{id}', $class . '@show')->name('users.show');
            self::get($url . '/{id}/edit', $class . '@edit')->name('users.edit');
            self::get($url . '/{id}', $class . '@update')->name('users.update');
            self::get($url . '/{id}', $class . '@destroy')->name('users.destroy');
        }

        return self::getInstance();
    }

    static public function post(string $url, string $controller): Route
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return self::getInstance();
        }

        self::requestMethod($url, $controller);

        self::$attr = $_POST;

        return self::getInstance();
    }

    static public function middleware(string $middleware)
    {
        if ('/' . self::$url !== $_SERVER['REQUEST_URI']) return;

        self::$controller = '';
        self::$attr = [];
        self::$found = false;

        return self::getInstance();
    }

    static public function get(string $url, string $controller): Route
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return self::getInstance();
        }

        return self::requestMethod($url, $controller);
    }

    static public function run()
    {
        $controller = explode('@', self::$controller);
        $attr = self::$attr;

        if (self::$controller == '') {
            header("Location: /");
            return;
        }

        $controllerName = array_shift($controller);
        $controllerPath =  'Core\Controllers\\' . $controllerName;
        if (!class_exists($controllerPath)) {
            throw new ErrorHandler($controllerName . ' not found controller path');
        }

        $class = new $controllerPath();

        if (!($class instanceof ControllerInterface)) {
            throw new ErrorHandler($controllerName . ' not inmplements ControllerInterface');
        }

        $class->setRequest($attr);
        $method = current($controller) ?? '';

        if (!method_exists($class, $method)) {
            throw new ErrorHandler('Not found ' . $controllerName . ' method - ' . $method);
        }

        if (self::$isUnitTest) {
            return [
                'pathMethod' => $controllerPath . '::' . $method,
                'attr' => $attr
            ];
        }

        $class->$method();
    }
}
