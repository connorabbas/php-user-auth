<?php

namespace App\Controllers\Auth;

use App\Core\DB;
use App\Core\View;
use App\Models\User;
use App\Services\AuthService;

class LoginController
{
    protected $db;
    private $auth;

    public function __construct()
    {
        $this->db = new DB();
        $this->auth = new AuthService(new User($this->db));
        $this->auth->guestAccessOnly();
    }

    public function index()
    {
        return View::show('pages.auth.login');
    }

    public function doLogin()
    {
        handleCsrf();
        
        if (!$this->auth->attemptLogin($_POST['username'], $_POST['password'])) {
            back();
        }

        redirect('/');
    }
}
