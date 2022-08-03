<?php

namespace App\Controllers\Auth;

use App\Core\DB;
use App\Services\AuthService;
use App\Controllers\SiteController;

class RegisterController extends SiteController
{
    protected $db;

    public function __construct()
    {
        $this->db = new DB();
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

        $auth = new AuthService($this->db);
        $userCreated = $auth->createUser($name, $email, $username, $pwd, $pwdR);

        if (!$userCreated) {
            header("location: /register");
        } else {
            header("location: /");
        }
        exit();
    }
}