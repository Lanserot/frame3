<?php

namespace Core\Controllers\Default;

use Core\Controllers\Default\Controller;

class Error404Controller extends Controller
{
    public function index(): void
    {
        $this->render('Errors.404');
    }
}
