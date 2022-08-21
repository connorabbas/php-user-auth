<?php

namespace App\Controllers;

use App\Core\DB;
use App\Core\View;
use App\Models\User;
use App\Services\AuthService;
use App\Services\UserService;

class UserController
{
    protected $db;
    private $auth;
    private $user;

    public function __construct()
    {
        $this->db = new DB();
        $this->user = new User($this->db);
        $this->auth = new AuthService($this->db, $this->user);
        $this->auth->userAccessOnly();
    }

    public function index()
    {
        $user = $this->user->getById($_SESSION['user_id']);
        
        return View::show('pages.account', [
            'user' => $user
        ]);
    }

    public function store()
    {
        handleCsrf();

        (new UserService($this->db, $this->user))->updateName($_SESSION['user_id'], $_POST['name']);
        
        back();
    }
}
