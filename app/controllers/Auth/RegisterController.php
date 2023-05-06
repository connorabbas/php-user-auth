<?php

namespace App\Controllers\Auth;

use Exception;
use App\Core\View;
use App\Models\UserModel;
use App\Services\AuthService;
use App\Validation\ValidateUserRegistration;

class RegisterController
{
    public $authService;
    public $userModel;

    public function __construct(AuthService $authService, UserModel $userModel)
    {
        $this->authService = $authService;
        $this->authService->guestAccessOnly();
        $this->userModel = $userModel;
    }

    public function index()
    {
        return View::render('pages.auth.register');
    }

    public function store()
    {
        handle_csrf();

        $request = request();
        $name = $request->input('name');
        $email = $request->input('email');
        $pwd = $request->input('password');
        $pwdR = $request->input('passwordR');

        $validationErrors = (new ValidateUserRegistration($this->userModel, $name, $email, $pwd, $pwdR))->handle();
        if ($validationErrors) {
            $_SESSION['flash_error_msg'] = $validationErrors;
            return back();
        }

        try {
            $this->userModel->create($name, $email, $pwd);
            $this->authService->attemptLogin($email, $pwd);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $_SESSION['flash_error_msg'] = 'Something went wrong. Contact support staff.';
            return back();
        }

        return redirect('/');
    }
}
