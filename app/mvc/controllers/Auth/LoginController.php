<?php

namespace App\MVC\Controllers\Auth;

use App\Core\DB;
use App\Core\View;
use App\Services\AuthService;

class LoginController
{
    protected $db;
    private $auth;

    public function __construct()
    {
        $this->db = new DB();
        $this->auth = new AuthService($this->db);
        $this->auth->guestAccessOnly();
    }

    public function index()
    {
        return View::show('pages.login');
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
