<?php

namespace Core\Controllers\Admin;

use VVF\Controllers\Controller;

class MainController extends Controller 
{
    public function index(): void
    {
        $this->render('Admin.index');
    }
}
