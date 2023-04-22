<?php

namespace App\Controllers\Auth;

use Exception;
use App\Core\View;
use App\Services\AuthService;
use App\Interfaces\UserDataInterface;
use App\Validation\ValidateUserRegistration;

class RegisterController
{
    public $authService;
    public $userData;

    public function __construct(AuthService $authService, UserDataInterface $userData)
    {
        $this->authService = $authService;
        $this->authService->guestAccessOnly();
        $this->userData = $userData;
    }

    public function index()
    {
        return View::render('pages.auth.register');
    }

    public function store()
    {
        handle_csrf();

        $name = $_POST['name'];
        $email = $_POST['email'];
        $pwd = $_POST['password'];
        $pwdR = $_POST['passwordR'];

        $validationErrors = (new ValidateUserRegistration($this->userData, $name, $email, $pwd, $pwdR))->handle();
        if ($validationErrors) {
            $_SESSION['flash_error_msg'] = $validationErrors;
            return back();
        }

        try {
            $this->userData->create($name, $email, $pwd);
            $this->authService->attemptLogin($email, $pwd);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $_SESSION['flash_error_msg'] = 'Something went wrong. Contact support staff.';
            return back();
        }

        return redirect('/');
    }
}
