<?php

namespace App\Services;

use Exception;
use App\Core\View;
use App\Models\User;
use App\Validation\ValidateUser;

class AuthService
{
    public $userData;
    public $userValidation;

    public function __construct(User $user, ValidateUser $userValidation)
    {
        $this->userData = $user;
        $this->userValidation = $userValidation;
    }

    public function attemptLogin($username, $pwd): bool
    {
        $user = $this->userData->getByUsername($username, $username);

        // normally we would handle the validation and throwing errors in the controller
        // making exception here to make the login experience more practical
        $validationErrors = $this->userValidation->validateLoginUser($username, $pwd, $user);
        if ($validationErrors) {
            array_unshift($validationErrors, 'Invalid Login.');
            $_SESSION['flash_error_msg'] = $validationErrors;
            return false;
        }

        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_username'] = $user->username;

        return true;
    }

    public function userAccessOnly($user)
    {
        $validUser = false;
        if (logged_in()) {
            $validUser = $user;
        }
        if (!$validUser) {
            $this->logout();
            echo View::render('pages.403');
            exit;
        }
    }

    public function guestAccessOnly()
    {
        if (logged_in() && $this->userData->getById($_SESSION['user_id']) !== false) {
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
