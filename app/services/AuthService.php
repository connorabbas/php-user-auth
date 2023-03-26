<?php

namespace App\Services;

use App\Core\View;
use App\Interfaces\UserDataInterface;
use App\Validation\ValidateUserLogin;

class AuthService
{
    public $userData;
    public $userValidation;

    public function __construct(UserDataInterface $userData)
    {
        $this->userData = $userData;
    }

    public function attemptLogin($email, $pwd): bool
    {
        $user = $this->userData->getByEmail($email);

        // normally we would handle the validation and throwing errors in the controller
        // making exception here to make the login experience more practical
        $validationErrors = (new ValidateUserLogin($email, $pwd, $user))->handle();
        if ($validationErrors) {
            array_unshift($validationErrors, 'Invalid Login.');
            $_SESSION['flash_error_msg'] = $validationErrors;
            return false;
        }

        $_SESSION['user_id'] = $user->id;

        return true;
    }

    public function userAccessOnly()
    {
        if (!logged_in()) {
            $this->logout();
            http_response_code(403);
            echo View::render('pages.403');
            exit;
        }
    }

    public function guestAccessOnly()
    {
        if (logged_in() && $this->userData->getById($_SESSION['user_id']) !== false) {
            http_response_code(403);
            echo View::render('pages.403');
            exit;
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        session_start();
    }
}
