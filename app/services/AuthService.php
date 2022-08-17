<?php

namespace App\Services;

use Exception;
use App\Core\DB;
use App\Core\View;
use App\Models\User;

class AuthService
{
    protected $db;
    public $user;

    public function __construct(DB $db)
    {
        $this->db = $db;
        $this->user = new User($this->db);
    }

    public function checkRegisterEmptyInputs($name, $email, $username, $pwd, $pwdR): bool
    {
        if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdR)) {
            return true;
        }

        return false;
    }

    function checkLoginEmptyInputs($username, $pwd): bool
    {
        if (empty($username) || empty($pwd)) {
            return true;
        }
        
        return false;
    }

    public function invalidUsername($username): bool
    {
        if (!preg_match('/^[a-zA-Z0-9]*$/', $username)) {
            return true;
        }
        
        return false;
    }

    public function invalidEmail($email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

    public function pwdMatch($pwd, $pwdR): bool
    {
        if ($pwd !== $pwdR) {
            return true;
        }

        return false;
    }

    public function validateRegisterUser($name, $email, $username, $pwd, $pwdR): array
    {
        $errors = [];
        if ($this->checkRegisterEmptyInputs($name, $email, $username, $pwd, $pwdR) !== false) {
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

        return $errors;
    }

    public function createUser($name, $email, $username, $pwd, $pwdR): bool
    {
        $errors = $this->validateRegisterUser($name, $email, $username, $pwd, $pwdR);

        if (count($errors) > 0) {
            array_unshift($errors , 'Not Registered.');
            $_SESSION['flash_error_msg'] = $errors;
            return false;
        } 

        try {
            $this->user->create($name, $email, $username, $pwd);
            return true;
        } catch (Exception $e) {
            $_SESSION['flash_error_msg'] = 'Something went wrong. Contact support staff. ' . $e;
            return false;
        }
    }

    public function validateLoginUser($username, $pwd, $user): array
    {
        $errors = [];
        if ($this->checkLoginEmptyInputs($username, $pwd) !== false) {
            $errors[] = 'Please fill out all required fields.';
        }
        if (!$user) {
            $errors[] = 'Cannot find user with matching username or email.';
        }
        if ($user !== false && !password_verify($pwd, $user->password)) {
            $errors[] = 'Incorrect password.';
        }

        return $errors;
    }

    public function attemptLogin($username, $pwd): bool
    {
        try {
            $user = $this->user->getByUsername($username, $username);
        } catch (Exception $e) {
            $_SESSION['flash_error_msg'] = 'Something went wrong. Contact support staff. ' . $e;
            return false;
        }
        $errors = $this->validateLoginUser($username, $pwd, $user);

        if (count($errors) > 0) {
            array_unshift($errors , 'Invalid Login.');
            $_SESSION['flash_error_msg'] = $errors;
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
}
