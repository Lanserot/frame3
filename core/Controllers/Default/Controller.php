<?php

namespace Core\Controllers\Default;

class Controller
{
    public function show(string $page): void
    {
        $page = str_replace('.', '/', $page);
        echo require 'public/' . $page . '.php';
    }

    public function setRequest(array $request): void
    {
        $this->request = $request;
    }

    public function __call(string $method, array $arguments): void
    {
        echo $method . ' not foud';
    }
}
