<?php

namespace Core\Controllers;

use Core\Controllers\Default\Controller;
use Core\Models\UserModel;
use Core\Tools\DebugTool;

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
        $this->render('User.index', ['user' => $result]);
    }

    public function user(): void
    {
        $users = new UserModel();
        $users = $users->getLimit(10, 'DESC');
        $this->render('User.list', ['users' => $users]);
    }

    public function login(): void
    {
        $this->render('User.login');
    }

    public function loginPost(): void
    {
        $users = new UserModel();

        $pass = md5($this->request['pass']);
        $login = $this->request['login'];
        $user = $users->db->query("SELECT * FROM `users` WHERE `password` = '$pass' AND `login` = '$login' LIMIT 1;")->fetch(\PDO::FETCH_OBJ);

        if($user){
            $this->render('Main.index');
            return;
        }

        $this->render('User.login');
    }
}
