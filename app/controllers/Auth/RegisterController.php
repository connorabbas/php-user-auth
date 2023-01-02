<?php

namespace App\Controllers\Auth;

use Exception;
use App\Core\View;
use App\Services\AuthService;
use App\Services\UserService;
use App\Interfaces\UserDataInterface;
use App\Validation\ValidateUserRegistration;

class RegisterController
{
    public $authService;
    public $userService;

    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->authService->guestAccessOnly();
        $this->userService = $userService;
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

        $validationErrors = (new ValidateUserRegistration(
            container(UserDataInterface::class),
            $name,
            $email,
            $username,
            $pwd,
            $pwdR
        ))->handle();
        if ($validationErrors) {
            $_SESSION['flash_error_msg'] = $validationErrors;
            return back();
        }

        try {
            $this->userService->createUser($name, $email, $username, $pwd);
            $this->authService->attemptLogin($username, $pwd);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $_SESSION['flash_error_msg'] = 'Something went wrong. Contact support staff.';
            return back();
        }

        return redirect('/');
    }
}
