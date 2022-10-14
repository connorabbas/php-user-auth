<?php

namespace App\Controllers\Auth;

use App\Core\DB;
use App\Models\User;
use App\Services\AuthService;

class LogoutController
{
    protected $db;
    private $authService;

    public function __construct()
    {
        $this->db = new DB();
        $this->authService = new AuthService(new User($this->db));
    }

    public function doLogout()
    {
        handleCsrf();
        
        $this->authService->logout();

        redirect('/');
    }
}
