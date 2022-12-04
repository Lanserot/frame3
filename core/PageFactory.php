<?php

namespace Core;

use Core\Route\Route;

class PageFactory
{
    private Route $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
        $this->run();
    }

    public function run(): void
    {
        $this->witdrawHead();
        $this->witdrawBody();
        $this->witdrawFooter();
    }

    public function witdrawBody(): void
    {
        $prepareUrl = $this->getRoute()->getPrepareUrl();

        if (empty($prepareUrl)) {
            $controller = new \Core\Controllers\MainController();
            $controller->index();
            return;
        }

        $idFound = preg_match('/^\{(.+?)\}$/', $prepareUrl) !== false;

        if ($idFound) {
            $prepareUrlId = str_replace(['{', '}'], '', end(explode('/', $prepareUrl)));
            $prepareUrl = preg_replace('/\{(.+?)\}/', '{id}', $prepareUrl);
        }

        if (empty($this->getRoute()->getRouteConfig()['routes'][$prepareUrl])) {
            $controller = new \Core\Controllers\Default\Error404Controller();
            $controller->index();
            return;
        }

        $controllerName = $this->getRoute()->getRouteConfig()['routes'][$prepareUrl];
        $controllerPath =  'Core\Controllers\\' . $controllerName;

        if (!class_exists($controllerPath)) {
            echo $controllerName . ' not found';
            return;
        }

        $controller = new $controllerPath();
        if ($idFound) {
            $controller->index($prepareUrlId);
        } else {
            $controller->index();
        }
    }

    public function witdrawHead(): void
    {
        if (file_exists('public/header.php')) {
            require 'public/header.php';
        }
    }

    public function witdrawFooter(): void
    {
        if (file_exists('public/footer.php')) {
            require 'public/footer.php';
        }
    }

    public function getRoute(): Route
    {
        return $this->route;
    }

    public function setRoute(Route $route): void
    {
        $this->route = $route;
    }
}
