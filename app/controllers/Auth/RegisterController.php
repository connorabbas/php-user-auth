<?php

namespace App\Controllers\Auth;

use App\Core\DB;
use App\Core\View;
use App\Services\AuthService;

class RegisterController
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
        return View::show('pages.register');
    }

    public function store()
    {        
        $name = $_POST['name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $pwd = $_POST['password'];
        $pwdR = $_POST['passwordR'];

        // TODO
        // setup validation with https://github.com/MarwanAlsoltany/mighty

        if (!csrfValid()) {
            $_SESSION['flash_error_msg'] = 'Invalid user registration. Possible cross site request forgery detected.';
            back();
        }
        if (!$this->auth->createUser($name, $email, $username, $pwd, $pwdR)) {
            back();
        } 
        if (!$this->auth->attemptLogin($username, $pwd)) {
            redirect('/login');
        }

        redirect('/');
    }
}
