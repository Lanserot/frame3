<?php

namespace Core\Route;

use Core\Controllers\Default\ControllerInterface;

class Route
{
    private static ?Route $_instance = null;
    private static bool $found = false;
    private static string $url = '';
    private static string $controller = '';
    private static array $attr = [];
    private static array $routeNameList = [];

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    static public function route(string $route)
    {
        return self::$routeNameList[$route];
    }

    static public function get(string $url, string $controller): Route
    {
        self::$url = $url;

        if(self::$found) return self::getInstance();

        $requestUrl = $_SERVER['REQUEST_URI'];
        $attr = [];
        if ($requestUrl != '/') {
            $requestUrl = explode('/', $requestUrl);
            $urlExp = explode('/', $url);

            $requestUrl = array_filter($requestUrl, function ($k) {
                return !empty($k);
            });

            $requestUrl = array_values($requestUrl);

            $attr = self::checkUrlAttr($urlExp, $requestUrl);

            $urlChange = array_map(function ($val) use ($attr) {
                $valReplace = str_replace(['{', '}'], '', $val);
                if (key_exists($valReplace, $attr)) {
                    return $attr[$valReplace];
                }

                return $val;
            }, $urlExp);

            $requestUrl = implode('/', $requestUrl);
            $url = implode('/', $urlChange);
        }

        if ($requestUrl !== $url) {
            return self::getInstance();
        }

        self::$controller = $controller;
        self::$attr = $attr;
        self::$found = true;

        return self::getInstance();
    }

    static public function name(string $name): self
    {
        self::$routeNameList[$name] = (self::$url != '/' ? '/' : '') . self::$url;
        return self::getInstance();
    }

    static private function checkUrlAttr(array $urlMy, array $requestUrl): array
    {
        $attr = [];
        if (count($urlMy) == count($requestUrl)) {
            for ($i = 0; $i < count($urlMy); $i++) {
                if (empty($requestUrl[$i]) || $urlMy[$i] == $requestUrl[$i]) continue;
                if (preg_match('/^\{(.+?)\}$/', $urlMy[$i]) == true) {
                    $attr[str_replace(['{', '}'], '', $urlMy[$i])] = $requestUrl[$i];
                }
            }
        }
        return $attr;
    }

    static public function run(): void
    {
        $controller = explode('@', self::$controller);
        $attr = self::$attr;

        $controllerClass = current($controller);
        $controllerPath =  'Core\Controllers\\' . $controllerClass;
        if (!class_exists($controllerPath)) {
            echo $controllerClass . ' not found';
            return;
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
