<?php

namespace Core\Controllers;

use VVF\Controllers\Controller;
use Core\Models\UserModel;
use VVF\Route\Route;
use VVF\Models\Model;
use VVF\Tools\DebugTool;

class UserController extends Controller
{
    public function show(): void
    {
        $users = new UserModel();
        $user = $users->find($this->request['id']);
        if (!$user) {
            $this->redirect(Route::route('users.index'));
        }

        $groups = $user->belongsTo('groups');

        $this->render('User.index', ['user' => $user, 'groups' => $groups]);
    }

    public function index(): void
    {
        $users = new Model();
        $users = $users->table('users');
        $query = $users->where('id', '>=', 2)->where('id', '<=', 6)->get();
        $this->render('User.list', ['users' => $query]);
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
        $user = $users->db->query("SELECT * FROM users WHERE password = '$pass' AND login = '$login' LIMIT 1;")->fetch(\PDO::FETCH_OBJ);

        if ($user) {
            $this->redirect(Route::route('main'));
        }

        $this->render('User.login');
    }
}