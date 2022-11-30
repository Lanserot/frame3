<?php

namespace Core\Controllers;

use Core\Controllers\Default\Controller;

class UserController extends Controller
{
    public function index(int|string $id): void
    {
        echo $id;
    }
}
