<?php

namespace Core\Route;

use Closure;
use Core\Controllers\MainController;
use Core\Controllers\Default\ControllerInterface;
use Core\Controllers\Default\Error404Controller;
use Core\Controllers\MainController as ControllersMainController;

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
        if (empty(self::$routeNameList[$route])) {
            return;
        }
        return self::$routeNameList[$route];
    }

    static private function requestMethod(string $url, string $controller): Route
    {
        self::$url = $url;

        //Already found page
        if (self::$found) return self::getInstance();

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

    static public function post(string $url, string $controller): Route
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return self::getInstance();
        }

        self::requestMethod($url, $controller);

        self::$attr = $_POST;

        return self::getInstance();
    }

    static public function get(string $url, string $controller): Route
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return self::getInstance();
        }

        return self::requestMethod($url, $controller);
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

        if (self::$controller == '') {
            $main = new MainController();
            $main->index();
            return;
        }

        $controllerClass = current($controller);
        $controllerPath =  'Core\Controllers\\' . $controllerClass;
        if (!class_exists($controllerPath)) {
            echo $controllerClass . ' not found controller path';
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

    static public function middleware(string $middleware)
    {
        self::$controller = '';
        self::$attr = [];
        self::$found = false;

        return self::getInstance();
    }
}
