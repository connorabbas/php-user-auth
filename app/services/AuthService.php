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

    public function attemptLogin($username, $pwd): bool
    {
        $user = $this->userData->getByUsername($username, $username);

        // normally we would handle the validation and throwing errors in the controller
        // making exception here to make the login experience more practical
        $validationErrors = (new ValidateUserLogin($username, $pwd, $user))->handle();
        if ($validationErrors) {
            array_unshift($validationErrors, 'Invalid Login.');
            $_SESSION['flash_error_msg'] = $validationErrors;
            return false;
        }

        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_username'] = $user->username;

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
