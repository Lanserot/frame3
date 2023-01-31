<?php

namespace Core\Controllers;

use VVF\Controllers\Controller;

class MainController extends Controller
{
    public function index(): void
    {
        $this->render('Main.index');
    }
}
