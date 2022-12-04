<?php

namespace Core\Controllers;

use Core\Controllers\Default\Controller;
use Core\Models\UserModel;

class UserController extends Controller
{
    public function index(int|string $id): void
    {
        $user = new UserModel();
        $result = $user->find($id);
        if (!isset($result->mail)) {
            echo 'Your email not found';
        } else {
            echo 'Your email ' . $result->mail;
        }
    }
}
