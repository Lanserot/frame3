<?php

namespace Core\Route;

class Route
{
    static public function get(string $url, string $controller): void
    {
        $requestUrl = $_SERVER['REQUEST_URI'];
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
            return;
        }

        $controller = explode('@', $controller);
        self::withdrowPage($controller, $attr);
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

    static protected function withdrowPage(array $controller, array $ids): void
    {
        $controllerClass = current($controller);
        $controllerPath =  'Core\Controllers\\' . $controllerClass;
        if (!class_exists($controllerPath)) {
            echo $controllerClass . ' not found';
            return;
        }
        $controllerClass = new $controllerPath();

        $controllerClass->setRequest($ids);
        self::witdrawHead();
        if (empty($controller[1])) {
            echo 'Not found method';
        } else {
            $controllerMethod = $controller[1];
            $controllerClass->$controllerMethod();
        }
        self::witdrawFooter();
    }

    static public function witdrawHead(): void
    {
        if (file_exists('public/header.php')) {
            require 'public/header.php';
        }
    }

    static function witdrawFooter(): void
    {
        if (file_exists('public/footer.php')) {
            require 'public/footer.php';
        }
    }
}
