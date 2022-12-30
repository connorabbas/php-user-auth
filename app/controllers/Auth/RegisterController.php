<?php

namespace App\Controllers\Auth;

use App\Core\View;
use App\Services\AuthService;
use App\Services\UserService;

class RegisterController
{
    private $authService;
    private $userService;

    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
        $this->authService->guestAccessOnly();
    }

    public function index()
    {
        return View::render('pages.auth.register');
    }

    public function store()
    {
        handle_csrf();

        $name = $_POST['name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $pwd = $_POST['password'];
        $pwdR = $_POST['passwordR'];

        if (!$this->userService->createUser($name, $email, $username, $pwd, $pwdR)) {
            back();
        } 
        if (!$this->authService->attemptLogin($username, $pwd)) {
            redirect('/login');
        }

        redirect('/');
    }
}
