<?php

namespace App\Controllers\Auth;

use App\Core\DB;
use App\Models\User;
use App\Services\AuthService;

class LogoutController
{
    protected $db;
    private $auth;

    public function __construct()
    {
        $this->db = new DB();
        $this->auth = new AuthService($this->db, new User($this->db));
    }

    public function doLogout()
    {
        handleCsrf();
        
        $this->auth->logout();

        redirect('/');
    }
}
