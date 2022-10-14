<?php

namespace App\Controllers\Auth;

use App\Core\DB;
use App\Core\View;
use App\Models\User;
use App\Services\AuthService;

class LoginController
{
    protected $db;
    private $authService;

    public function __construct()
    {
        $this->db = new DB();
        $this->authService = new AuthService(new User($this->db));
        $this->authService->guestAccessOnly();
    }

    public function index()
    {
        return View::render('pages.auth.login');
    }

    public function doLogin()
    {
        handleCsrf();
        
        if (!$this->authService->attemptLogin($_POST['username'], $_POST['password'])) {
            back();
        }

        redirect('/');
    }
}
