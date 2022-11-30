<?php

namespace Core\Controllers\Admin;

use Core\Controllers\Default\Controller;
use Core\Controllers\Default\ControllerInterface;

class MainController extends Controller implements ControllerInterface
{
    public function index(): void
    {
        $this->show('Admin.index');
    }
}
