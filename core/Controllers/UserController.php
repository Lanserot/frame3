<?php

namespace Core\Controllers;

use Core\Controllers\Default\Controller;
use Core\Models\UserModel;

class UserController extends Controller
{
    public function index(): void
    {
        $user = new UserModel();
        $result = $user->find($this->request['id']);
        $this->show('User.index', ['user' => $result]);
    }
}
