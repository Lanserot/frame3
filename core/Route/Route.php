<?php

namespace Core\Route;

use BaseException;
use Core\Controllers\Default\ControllerInterface;
use Core\Interfaces\RouteInterface;
use Core\Tools\DebugTool;
use ErrorException;
use Exception;

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

    static public function run(): void
    {
        $controller = explode('@', self::$controller);
        $attr = self::$attr;

        if (self::$controller == '') {
            header("Location: /");
            return;
        }

        $controllerClass = current($controller);
        $controllerPath =  'Core\Controllers\\' . $controllerClass;
        if (!class_exists($controllerPath)) {
            throw new BaseException($controllerClass . ' not found controller path');
        }

        $controllerClass = new $controllerPath();

        if (!($controllerClass instanceof ControllerInterface)) {
            echo $controllerClass . ' not inmplements ControllerInterface';
            return;
        }

        $controllerClass->setRequest($attr);
        if (empty($controller[1])) {
            echo 'Not found init method';
            return;
        }

        $controllerMethod = $controller[1];
        $controllerClass->$controllerMethod();
    }

}
