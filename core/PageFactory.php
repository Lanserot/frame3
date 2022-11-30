<?php

namespace Core;

use Core\Route\Route;
use Core\Tools\DebugTool;

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
        
        if($idFound){
            $prepareUrlId = str_replace(['{', '}'], '', end(explode('/', $prepareUrl)));
            $prepareUrl = preg_replace('/\{(.+?)\}/', '{id}', $prepareUrl);
        }

        if (!empty($this->getRoute()->getRouteConfig()['routes'][$prepareUrl])) {
            $controllerName =  'Core\Controllers\\' . $this->getRoute()->getRouteConfig()['routes'][$prepareUrl];
       
            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                if ($idFound) {
                    $controller->index($prepareUrlId);
                    return;
                }
                $controller->index();
            }
        } else {
            $controller = new \Core\Controllers\Default\Error404Controller();
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
