<?php

namespace App\Controllers;

use App\Core\DB;
use App\Models\User;
use App\Services\AuthService;

class UserController extends SiteController
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
        
        return view('pages/user', [
            'user' => $user
        ]);
    }
}
