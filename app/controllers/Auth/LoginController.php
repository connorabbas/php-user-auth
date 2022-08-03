<?php

namespace App\Controllers\Auth;

use App\Core\DB;
use App\Services\AuthService;
use App\Controllers\SiteController;

class LoginController extends SiteController
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
        return view('pages/login');
    }

    public function doLogin()
    {
        $username = $_POST['username'];
        $pwd = $_POST['password'];

        $loggedIn = $this->auth->attemptLogin($username, $pwd);

        if (!$loggedIn) {
            header("location: /login");
        } else {
            header("location: /");
        }
        exit();
    }
}