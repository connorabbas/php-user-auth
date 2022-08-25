<?php

namespace App\Services;

use Exception;
use App\Core\View;
use App\Models\User;

class AuthService
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    function checkEmptyInputs(array $values): bool
    {
        foreach ($values as $value) {
            if (empty($value)) {
                return true;
            }
        }

        return false;
    }

    public function invalidUsername($username): bool
    {
        return (!preg_match('/^[a-zA-Z0-9]*$/', $username)) ? true : false;
    }

    public function invalidEmail($email): bool
    {
        return (!filter_var($email, FILTER_VALIDATE_EMAIL)) ? true : false;
    }

    public function pwdMatch($pwd, $pwdR): bool
    {
        return ($pwd !== $pwdR) ? true : false;
    }

    public function validateRegisterUser($name, $email, $username, $pwd, $pwdR): void
    {
        $errors = [];
        if ($this->checkEmptyInputs([$name, $email, $username, $pwd, $pwdR]) !== false) {
            $errors[] = 'Please fill out all required fields.';
        }
        if ($this->invalidUsername($username) !== false) {
            $errors[] = 'Invalid username.';
        }
        if ($this->pwdMatch($pwd, $pwdR) !== false) {
            $errors[] = 'Passwords must match.';
        }
        if ($this->user->getByUsername($username, $email) !== false) {
            $errors[] = 'This username or email already exists.';
        }
        if (count($errors)) {
            throw new Exception(implode(' - ', $errors));
        }
    }

    public function createUser($name, $email, $username, $pwd, $pwdR): bool
    {
        try {
            $this->validateRegisterUser($name, $email, $username, $pwd, $pwdR);
        } catch (Exception $e) {
            $_SESSION['flash_error_msg'] = array_merge(['Not Registered.'], explode(' - ', $e->getMessage()));
            return false;
        }

        try {
            $this->user->create($name, $email, $username, $pwd);
            return true;
        } catch (Exception $e) {
            $_SESSION['flash_error_msg'] = 'Something went wrong. Contact support staff. ' . $e->getMessage();
            return false;
        }
    }

    public function validateLoginUser($username, $pwd, $user): void
    {
        $errors = [];
        if ($this->checkEmptyInputs([$username, $pwd]) !== false) {
            $errors[] = 'Please fill out all required fields.';
        }
        if (!$user) {
            $errors[] = 'Cannot find user with matching username or email.';
        }
        if ($user !== false && !password_verify($pwd, $user->password)) {
            $errors[] = 'Incorrect password.';
        }
        if (count($errors)) {
            throw new Exception(implode(' - ', $errors));
        }
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
            $this->validateLoginUser($username, $pwd, $user);
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
            View::show('pages.403');
            exit();
        }
    }

    public function guestAccessOnly()
    {
        if (loggedIn() && $this->user->getById($_SESSION['user_id']) !== false) {
            View::show('pages.403');
            exit();
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        session_start();
    }
}
