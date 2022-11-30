<?php

namespace Core\Route;

use Core\Tools\DebugTool;

class Route
{
    private string $requestUrl = '';

    private string $prepareUrl = '';

    private array $routeConfig = [];

    public function __construct()
    {
        $this->routeConfig = require 'Config.php';
        $this->setRequestUrl($_SERVER['REQUEST_URI']);
        $this->prepareUrl();
    }
    
    protected function prepareUrl(): void
    {
        $requestUrl = $this->getRequestUrl();
        $requestUrl = explode('/', $requestUrl);

        $requestUrl = array_filter($requestUrl, function($k) {
            return !empty($k);
        });
        
        $prepareUrlWithId = $this->prepareUrlCheckId($requestUrl);

        if (!empty($prepareUrlWithId)) {
            $this->setPrepareUrl($prepareUrlWithId);
            return;
        }

        $this->setPrepareUrl(implode('/', $requestUrl));
    }

    private function prepareUrlCheckId(array $requestUrl): string
    {
        $preRequestUrl = $requestUrl;
        $id = array_pop($preRequestUrl);
        $preRequestUrl = array_values($preRequestUrl);

        foreach ($this->routeConfig['routes'] as $route => $val) {
            $preRoute = explode('/', $route);
            if (preg_match('/^\{(.+?)\}$/', end($preRoute))) {
                array_pop($preRoute);
                $preRoute = array_values($preRoute);
                if ($preRoute == $preRequestUrl) {
                    $route = implode('/', $preRequestUrl);
                    $route = $route . '/{' . $id . '}';
                    return $route;
                }
            }
        }

        return '';
    }

    public function getRequestUrl(): string
    {
        return $this->requestUrl;
    }

    public function setRequestUrl(string $requestUrl): void
    {
        $this->requestUrl = $requestUrl;
    }

    public function getPrepareUrl(): string
    {
        return $this->prepareUrl;
    }

    public function setPrepareUrl(string $prepareUrl): void
    {
        $this->prepareUrl = $prepareUrl;
    }

    public function getRouteConfig(): array
    {
        return $this->routeConfig;
    }

    public function setRouteConfig(array $routeConfig): void
    {
        $this->routeConfig = $routeConfig;
    }
}
