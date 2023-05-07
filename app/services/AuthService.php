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
        $this->currentUser = current_user();
    }

    public function getCurrentUser()
    {
        return $this->currentUser;
    }

    public function attemptLogin($email, $pwd): bool
    {
        $user = $this->userModel->getByEmail($email);
        $validationErrors = (new ValidateUserLogin($email, $pwd, $user))->handle();
        if ($validationErrors) {
            array_unshift($validationErrors, 'Invalid Login.');
            session()->set('flash_error_msg', $validationErrors);
            return false;
        }
        session()->set('user_id', $user->id);

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
        if (logged_in() && !is_null($this->currentUser)) {
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
