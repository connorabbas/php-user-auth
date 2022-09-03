<?php

namespace App\Controllers\Auth;

use App\Core\DB;
use App\Core\View;
use App\Models\User;
use App\Services\AuthService;

class RegisterController
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
        return View::render('pages.auth.register');
    }

    public function store()
    {
        handleCsrf();

        $name = $_POST['name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $pwd = $_POST['password'];
        $pwdR = $_POST['passwordR'];

        if (!$this->auth->createUser($name, $email, $username, $pwd, $pwdR)) {
            back();
        } 
        if (!$this->auth->attemptLogin($username, $pwd)) {
            redirect('/login');
        }

        redirect('/');
    }
}
