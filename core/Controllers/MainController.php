<?php

namespace Core\Controllers;

use Core\Controllers\Default\Controller;

class MainController extends Controller
{
    public function index(): void
    {
        $this->show('Main.index');
    }
}
