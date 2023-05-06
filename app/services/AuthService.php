<?php

namespace App\Services;

use App\Core\View;
use App\Models\UserModel;
use App\Validation\ValidateUserLogin;

class AuthService
{
    public $userModel;
    public $userValidation;
    private $currentUser;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
        $this->currentUser = isset($_SESSION['user_id'])
            ? $this->userModel->getById($_SESSION['user_id'])
            : null;
    }

    public function getCurrentUser()
    {
        return $this->currentUser;
    }

    public function attemptLogin($email, $pwd): bool
    {
        $user = $this->userModel->getByEmail($email);

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
        if (logged_in() && $this->userModel->getById($_SESSION['user_id']) !== false) {
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
