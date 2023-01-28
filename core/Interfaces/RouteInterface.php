<?php

namespace Core\Interfaces;

interface RouteInterface
{
    public static function getInstance(): RouteInterface;
    public static function middleware(string $middleware);
}
