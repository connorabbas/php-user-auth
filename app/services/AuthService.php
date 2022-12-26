<?php

namespace App\Services;

use Exception;
use App\Core\View;
use App\Models\User;
use App\Validation\ValidateUser;

class AuthService
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function attemptLogin($username, $pwd): bool
    {
        try {
            $user = $this->user->getByUsername($username, $username);
        } catch (Exception $e) {
            $_SESSION['flash_error_msg'] = 'Something went wrong. Contact support staff. ' . $e->getMessage();
            return false;
        }

        try {
            (New ValidateUser($this->user))->validateLoginUser($username, $pwd, $user);
        } catch (Exception $e) {
            $_SESSION['flash_error_msg'] = array_merge(['Invalid Login.'], explode(' - ', $e->getMessage()));
            return false;
        }

        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_username'] = $user->username;
        $_SESSION['user_name'] = $user->name;

        return true;
    }

    public function userAccessOnly()
    {
        $validUser = false;
        if (loggedIn()) {
            $validUser = $this->user->getById($_SESSION['user_id']);
        }
        if (!$validUser) {
            $this->logout();
            echo View::render('pages.403');
            exit;
        }
    }

    public function guestAccessOnly()
    {
        if (loggedIn() && $this->user->getById($_SESSION['user_id']) !== false) {
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
