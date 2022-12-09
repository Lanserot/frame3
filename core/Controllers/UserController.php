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
        if (!$result) {
            echo 'User not found';
            return;
        }
        $this->show('User.index', ['user' => $result, 'title' => 'Список пользователей']);
    }

    public function user(): void
    {
        $users = new UserModel();
        $users = $users->getLimit(10, 'DESC');
        $this->show('User.list', ['users' => $users]);
    }
}
