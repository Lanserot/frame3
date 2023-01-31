<?php

namespace VVF\Controllers;

use VVF\Controllers\Controller;

class Error404Controller extends Controller
{
    public function index(): void
    {
        $this->render('Errors.404');
    }
}
