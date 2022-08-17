<?php

namespace App\MVC\Controllers;

use App\Core\DB;
use App\Core\View;
use App\MVC\Models\User;
use App\Services\AuthService;
use App\Services\UserService;

class UserController
{
    protected $db;
    private $auth;

    public function __construct()
    {
        $this->db = new DB();
        $this->auth = new AuthService($this->db);
        $this->auth->userAccessOnly();
    }

    public function index()
    {
        $user = (new User($this->db))->getById($_SESSION['user_id']);
        
        return View::show('pages.account', [
            'user' => $user
        ]);
    }

    public function store()
    {
        handleCsrf();

        // TODO
        // handle input validation

        (new UserService($this->db))->updateName($_SESSION['user_id'], $_POST['name']);
        back();
    }
}
