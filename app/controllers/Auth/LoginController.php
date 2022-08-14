<?php

namespace App\Controllers\Auth;

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
        View::show('pages/login');
    }

    public function doLogin()
    {
        $username = $_POST['username'];
        $pwd = $_POST['password'];

        if (csrfValid()) {
            if (!$this->auth->attemptLogin($username, $pwd)) {
                header("location: /login");
            } else {
                header("location: /");
            }
        } else {
            $_SESSION['flash_error_msg'] = 'Invalid login. Possible cross site request forgery detected.';
            header("location: /login");
        }

        exit();
    }
}
