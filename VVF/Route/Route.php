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
            //TODO : if have no route
            return;
        }
        return self::$routeNameList[$route];
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
