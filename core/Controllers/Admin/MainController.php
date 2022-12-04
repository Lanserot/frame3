<?php

namespace Core\Controllers\Admin;

use Core\Controllers\Default\Controller;

class MainController extends Controller 
{
    public function index(): void
    {
        $this->show('Admin.index');
    }
}
