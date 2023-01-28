<?php

namespace Core\Route;

use Core\Interfaces\RouteInterface;

class RouteMethods implements RouteInterface
{
    protected static bool $found = false;
    protected static ?Route $_instance = null;
    protected static string $url = '';
    protected static string $controller = '';
    protected static array $attr = [];
    protected static array $routeNameList = [];

    static public function getInstance(): RouteInterface
    {
        if (static::$_instance === null) {
            static::$_instance = new static;
        }

        return static::$_instance;
    }

    static public function name(string $name): self
    {
        self::$routeNameList[$name] = (self::$url != '/' ? '/' : '') . self::$url;
        return self::getInstance();
    }

    static protected function requestMethod(string $url, string $controller): Route
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

    static protected function checkUrlAttr(array $urlMy, array $requestUrl): array
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

    static public function middleware(string $middleware)
    {
        if ('/' . self::$url !== $_SERVER['REQUEST_URI']) return;

        self::$controller = '';
        self::$attr = [];
        self::$found = false;

        return self::getInstance();
    }
}
