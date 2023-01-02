<?php

namespace App\Controllers\Auth;

use Exception;
use App\Core\View;
use App\Services\AuthService;
use App\Services\UserService;
use App\Validation\ValidateUser;

class RegisterController
{
    public $authService;
    public $userService;
    public $userValidation;

    public function __construct(AuthService $authService, UserService $userService, ValidateUser $userValidation)
    {
        $this->authService = $authService;
        $this->authService->guestAccessOnly();
        $this->userService = $userService;
        $this->userValidation = $userValidation;
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

        $validationErrors = $this->userValidation->validateRegisterUser($name, $email, $username, $pwd, $pwdR);
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
