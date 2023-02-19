<?php

namespace VVF\Route;

use VVF\Interfaces\RouteInterface;
use VVF\Tools\DebugTool;

class RouteMethods implements RouteInterface
{
    protected static bool $found = false;
    public static bool $isUnitTest = false;
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

    static private function replaceAttributesUrl(array $urlExp): array
    {
        $attr = self::$attr;

        return array_map(function ($val) use ($attr) {
            $valReplace = str_replace(['{', '}'], '', $val);
            if (key_exists($valReplace, $attr)) {
                return $attr[$valReplace];
            }

            return $val;
        }, $urlExp);
    }

    static private function comparisonUrl(string $url): bool
    {
        $urlExp = explode('/', $url);

        $requestUrl = array_filter(explode('/', $_SERVER['REDIRECT_URL']), function ($k) {
            return !empty($k);
        });

        $requestUrl = array_values($requestUrl);

        self::prepareUrlAttr($urlExp, $requestUrl);

        //change attr like {id} on found attr
        $urlChange = self::replaceAttributesUrl($urlExp);

        $requestUrl = implode('/', $requestUrl);
        $url = implode('/', $urlChange);

        return $requestUrl === $url;
    }

    static private function isFoundRoute(): bool
    {
        $url = $_SERVER['REDIRECT_URL'] ?? $_SERVER['REQUEST_URI'];
        return $url != '/' && self::comparisonUrl(self::$url)
            || $url == '/' && $url  == self::$url;
    }

    static protected function requestMethod(string $url, string $controller): Route
    {
        self::$url = $url;

        //Already found page
        if (self::$found) return self::getInstance();

        if (self::isFoundRoute()) {
            self::$controller = $controller;
            self::$found = true;
        }

        return self::getInstance();
    }


    static private function prepareUrlAttr(array $urlMy, array $requestUrl): void
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

        self::$attr = $attr;
    }



    static public function setFound($found): void
    {
        self::$found = $found;
    }
}
