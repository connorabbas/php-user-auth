<?php

namespace App\Controllers\Auth;

use App\Core\DB;
use App\Services\AuthService;
use App\Controllers\SiteController;

class RegisterController extends SiteController
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
        return view('pages/register');
    }

    public function store()
    {        
        $name = $_POST['name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $pwd = $_POST['password'];
        $pwdR = $_POST['passwordR'];

        if (!$this->auth->createUser($name, $email, $username, $pwd, $pwdR)) {
            header("location: /register");
        } else {
            if (!$this->auth->attemptLogin($username, $pwd)) {
                header("location: /login");
            } else {
                header("location: /");
            }
        }
        exit();
    }
}
