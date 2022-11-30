<?php

namespace Core\Controllers\Default;

class Controller
{
    public function show(string $page): void
    {
        $page = str_replace('.', '/', $page);
        echo require 'public/' . $page . '.php';
    }
}
