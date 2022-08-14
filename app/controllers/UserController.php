<?php

namespace App\Controllers;

use App\Core\DB;
use App\Core\View;
use App\Models\User;
use App\Services\AuthService;

class UserController
{
    protected $db;
    private $auth;
    private $user;

    public function __construct()
    {
        $this->db = new DB();
        $this->auth = new AuthService($this->db);
        $this->auth->userAccessOnly();
        $this->user = new User($this->db);
    }

    public function index()
    {
        $user = $this->user->getById($_SESSION['user_id']);
        
        View::show('pages/user', [
            'user' => $user
        ]);
    }
}
